<?php

session_start();

require_once('PFBC/Form.php');
require_once('baza.php');


if(!isset($_SESSION['korisnikId']) OR $_SESSION['korisnikId'] == 0)
{
    $_SESSION['message'] = "Prvo se morate prijaviti.";
    header("Location: ./login.php?logged=false");
}

if(isset($_GET['pid'])&&is_numeric($_GET['pid'])&&isset($_GET['id'])&&is_numeric($_GET['id'])){
    $id = $_GET['id'];
    $pid = $_GET['pid'];
} else {
    die("Error!");
}

#dohvačanje svih postova
$postProvjera = $veza->prepare("SELECT * FROM forum_post WHERE post_id=? AND forum_id = ? AND post_tip='o'");
$postProvjera->bind_param('ii',$pid,$id);

if ($postProvjera->execute()){
    $postProvjera = $postProvjera->get_result();
    if($postProvjera===0){
        die("Error: Oprostite, nema takvog posta na forumu.");
    } else if($postProvjera->num_rows ==1){
        $row = $postProvjera->fetch_assoc();
        //Postavljanje naslova
        $title=$row['post_naslov'];
        $body=$row['post_body'];
        $autor=$row['post_autor'];
        $vrijeme=$row['post_vrijeme'];
    }else {
        echo "Error, forum nije dobar :/". $veza->error;
        exit();
    }
}

require_once('header.php');
include ('navbar.php');

if(!isset($_SESSION['korisnikId'])) header("Location: ./login.php?logged=false");

echo '
<div id="container" class="gridContainer clearfix">
    <div id="header">
        <h2>Forum</h2>
    </div>
    <div id="primary">
        <div id="topic_post" class="post">
            <header>
                <h3>'.$title.'</h3>
            </header>
            <article>'
                .$body.'
            </article>
            <footer>
                <h4>'.$autor.'</h4>
            </footer>
            <small>
                '.$vrijeme.'
            </small>
        </div>
    </div>
</div>';

echo "<script> document.getElementById('index').classList.add('active'); 
</script>"; 

echo 'Post ID:'.$_GET['pid'].'</br>';

echo 'ID: ' .$_GET['id'];

require_once("footer.php");
?>

<section id="main" class="wrapper">
				<div class="inner">
					<div class="container" style="width: 70%">
					<div class="row uniform">
						<div class="9u 12u$(small)">

						</div>
						<div class="3u 12u$(small)">
							<a href="objaviPost.php" class="button special fit"><span class="glyphicon glyphicon-pencil"></span> Write a Blog</a>
						</div>
					</div>
					<br />
					<?php
						while($row = $result->fetch_array()) :
							$id = $row['blogId'];
							$sql = "SELECT * FROM blogfeedback WHERE blogId = '$id'";
							$result1 = mysqli_query($conn, $sql);
							$numComment = mysqli_num_rows($result1);
					?>
					<div class="box">
						<h2><?= $row['blogTitle']; ?></h2>
						<blockquote>
							<?= $row['blogContent']; ?>
							<p>--- <?= $row['blogUser']; ?></p>
							<p><?= $row['blogTime']; ?></p>
						</blockquote>

						<form method="post" action="blogView.php">
							<div class="row">
								<div class="6u 12u$(xsmall)">
									<button class = "button special small" name="<?php echo 'like'.$id; ?>">
									<span class="glyphicon glyphicon-thumbs-up"></span> Like</button>
									<span><?= $row['likes']?></span>
								</div>
								<div class="6u 12u$(xsmall)">
									<span class="glyphicon glyphicon-pencil"></span> Comments : <?= $numComment ?></button>
								</div>
								<div class="12u$">
									<br>
									<textarea name="comment" id="comment" rows="1" placeholder="Write a Comment!"></textarea>
								</div>
								<div class="12u$">
									<center>
									<br>
									<input type="submit" name="<?php echo 'submit'.$id; ?>" class="button special small" value="Submit"/>
									</center>
								</div>
							</div>
						</form>

						<?php
							if($result1) :
								while($row1 = $result1->fetch_array()) :
						?>
							<div class="con darker">
								<img src="<?php echo 'images/profileImages/'.$row1['commentPic']?>" alt="Avatar"><span><em><?= $row1['commentUser']; ?></em></span>
								<br>
								<?= $row1['comment']; ?>
								<span class="time-right"><?= formatDate($row1['commentTime']); ?></span>
							</div>

							<?php endwhile; ?>
						<?php endif; ?>
					</div>

					<?php endwhile; ?>

				</div>
			</section>

		<script>

		/*	function ajax()
			{
				var req = new XMLHttpRequest();
				req.onreadystatechange = function()
				{
					if(req.readyState == 4 && req.status == 200)
					{
						document.getElementById('liked').innerHTML = req.responseText;
					}
				}
				req.open('POST', 'Blog/blogViewProcess.php', 'true');
				req.send();
			}
			setInterval(function(){ajax()}, 1000);*/

		</script>


		<script src="jquery/jquery-3.2.1.min.js"></script>
		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>
