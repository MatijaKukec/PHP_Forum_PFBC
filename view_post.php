<?php

session_start();

require_once('PFBC/Form.php');
require_once('baza.php');


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

if(!isset($_SESSION['korisnikId'])) header("Location: ./login.php?logged=false");

include ('navbar.php');
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

Form::open('Post', '', array("view"=>"sidebyside4"));
Form::Textarea("Komentar:","komentar");
/*Form::Search("Search", "search");
Form::Url("Url", "url");
Form::Date("Date", "date");
Form::DateTime("DateTime", "datetime", array ('shared' => 'col-md-4'));
Form::DateTimeLocal("", "DateTimeLocal", array ('shared' => 'col-md-4', 'placeholder' => 'DateTime-Local'));
Form::DateTime("DateTime", "datetime", array ('shared' => 'col-xs-12 col-md-4'));
Form::DateTimeLocal("", "DateTimeLocal", array ('shared' => 'col-xs-12 col-md-4', 'placeholder' => 'DateTime-Local'));
Form::Month("Month", "month");
Form::Week("Week", "week");
Form::Time("Time", "time");
Form::Number("Number", "Number");
Form::Range("Range", "Range");
Form::Color("Color", "Color");*/
Form::close(false);

require_once("footer.php");
?>
