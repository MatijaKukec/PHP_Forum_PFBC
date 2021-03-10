<?php

session_start();
$title = "Početna";
require_once('header.php');
include ('navbar.php');
require_once('baza.php');
require_once('PFBC/Form.php');

echo "<script> document.getElementById('index').classList.add('active'); 
</script>"; 

if(isset($_SESSION['korisnikId'])) {
  if(isset($_GET['login'])){
    if($_GET['login']=='success'){
      echo $_SESSION['loginPoruka'];
    }
  }
  echo 'Dobrodošao, '.$_SESSION['korisnikIdUid'].'!';
} else header("Location: ./login.php?logged=false");
  

$poc_upit=("SELECT forum_id, forum_naziv FROM forum");
if($upit=$veza->prepare($poc_upit)){

  $upit->bind_result($f_id, $f_naziv);

  $upit->execute();
  $upit->store_result();
  
} else echo $veza->error;

echo '<table align="center" width="80%">';
if($upit->num_rows !==0){
  while($row = $upit->fetch()){
    echo '
    <tr>
      <td><a href="forum.php?id='. $f_id .'">'. $f_naziv .'</a></td>
    </tr>';
  }
}

require_once("footer.php");
?>
