<?php

session_start();
$title = "Početna";
require_once('header.php');
require_once('baza.php');
require_once('PFBC/Form.php');

# Java script za promjenu fonta u aktiv na elemntu 'index'
echo "<script> document.getElementById('index').classList.add('active'); 
</script>"; 


  
include ('navbar.php');

# Ispis poruke dobrodošlice
if(isset($_SESSION['korisnikId'])) {
  echo'
                <header class="major">
                    <h2>Dobrodošli, '.$_SESSION['korisnikIdUid'].'</h2>
                </header>';
} //else header("Location: ./login.php?logged=false");


# Dohvaćanje svih postojećih foruma
$poc_upit=("SELECT forum_id, forum_naziv FROM forum"); 
if($upit=$veza->prepare($poc_upit)){

  $upit->bind_result($f_id, $f_naziv);

  $upit->execute();
  $upit->store_result();
  
} else echo $veza->error;

# Ispisivanje dohvaćenih foruma u obliku tablice
echo '<table align="center" width="80%">';
if($upit->num_rows !==0){ // provjera da li forumi postoje
  while($row = $upit->fetch()){
    echo '
    <tr>
      <td><a href="forum.php?id='. $f_id .'">'. $f_naziv .'</a></td>
    </tr>';
  }
}
echo "</table>";

require_once("footer.php");
?>
