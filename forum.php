<?php

session_start();

$pag_el ="forum_post";
$brojPoStranici=8;

require_once('PFBC/Form.php');
require_once('baza.php');
include ('paginacija.php');

//Provjera ID-a
if(isset($_GET['id'])&&is_numeric($_GET['id'])){
    $id = $_GET['id'];
} else {
    die("Nije dobro odabran forum :/");
}

$idProvjera = $veza->query("SELECT * FROM forum WHERE forum_id = '$id'");
if($idProvjera->num_rows !==1){
    die("Error, forum nije dobar :/");
} else{
    $row = $idProvjera->fetch_assoc();
    //Postavljanje naslova
    $title=$row['forum_naziv'];
}

require_once('header.php');
include ('navbar.php');

//Ispisivanje naslova
echo '<h2>Forum</h2></br>';

echo "<script> document.getElementById('index').classList.add('active'); 
</script>"; 

if(isset($_SESSION['korisnikId'])) {
  echo 'Dobrodošao, '.$_SESSION['korisnikId'].'!</br>';
} else header("Location: ./login.php?logged=false");

echo '<h3>'.$title.'</h3>';

echo  $_GET['id'];

$redak = $idProvjera->fetch_object();
$sql = "SELECT post_id, post_naslov, post_vrijeme FROM forum_post WHERE forum_id=? AND post_tip='o'";
if($query = $veza->prepare($sql)){
    $query->bind_param('i',$id);
    $query->bind_result($post_id, $post_naslov, $post_vrijeme);
    $query->execute();
    $query->store_result();
} else echo $veza->error;

echo'
<div id="container">
    <table style="margin-left:30px; width="80%">';
    if($query->num_rows !==0){
        while($query->fetch()){
        echo'
        <tr>
            <td><a href="view_post.php?pid='. $post_id .'&id=' .$id.'">' . $post_naslov . '</td><td>'.$post_vrijeme.'</td>
        </tr>';
        }
    }
    else {
    echo '
    <tr>
        <td><h2>Nema pronađenih postova</h2></td>
    </tr>';
    }
    echo'
    </table>
</div>';

require_once("footer.php");
?>
