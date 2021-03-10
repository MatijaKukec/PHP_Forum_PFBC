
<?php
session_start();
if (!isset($_SESSION['korisnikId'])) {	header('Location: login.php'); }
$title="Svi korisnici";
$pag_el ="korisnici";
$forma = 'svi_korisnici';

include ('header.php');
include ('navbar.php');
require_once ('PFBC/Form.php');
require_once ('baza.php');
require_once ('crop.php');
include ('paginacija.php');

if(isset($_GET['obrisano'])){
  if($_GET['obrisano']=='da'){
      echo "<div class='alert alert-success'>Korisnik je izbrisan iz baze podataka.</div>";
  }
  else{
      echo "<div class='alert alert-danger'>Korisnik nije izbrisan.</div>";
  }
}

echo '<div class="forma"><h2>Svi korisnici sustava</h2>';
require_once('baza.php');
if ($rezultat){
  $x=0;
  echo '
  
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="index.php">Doma</a></li>
    <li class="breadcrumb-item active">Svi korisnici</li>
  </ol>
  <div class="card mb-4">
    <div class="card-body">
      Ovo je popis svih registriranih korisnika na ovoj stranici.
    </div>
  </div>
  <div class="card mb-4">
    <div class="card-header">
      <i class="fas fa-table mr-1"></i>
      Lista korisnika
    </div>
    <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Slika</th>
            <th>Ime</th>
            <th>Vrijeme</br>registracije</th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th>Slika</th>
            <th>Ime</th>
            <th>Vrijeme</br>registracije</th>
            <th></th>
            <th></th>
          </tr>
        </tfoot>
      <tbody>';
  while ($redak=$rezultat->fetch_assoc()) {
    $x++;
    echo "<tr><td><img width='50' height='50' src='slike/" .$redak['avatar']."' /></td>
    <td>" . $redak['korisnik'] . "</td>
    <td>" . $redak['vrijeme_reg'] . "</td>";
    
    if(isset($_SESSION['korisnikId'])&&isset($_SESSION['prava'])){
      if($_SESSION['prava']!=NULL&&$SESSION['prava']=11111111111){
        if($redak['korisnik']=="admin") {
          echo "<td></td><td></td>"; 
          goto a;
        }
        echo"
        <td>
          <form action='uredi_korisnik.php' method='post'>
            <input type='hidden' name='id' value=' " .$redak['id'] . " ' />
            <input type='submit' value='Uredi'></input>
          </form>
        </td>";
      
        echo"
        <td>
          <form>
          <input type='button' class='btn btn-danger'
          name='Obriši'
          onClick='izbrisiMe(".$redak['id'].")'
          value='Obriši'>

          </form>
        </td>";
      }
    } else{
      echo"<td></td>";
      if($redak['id']==$_SESSION['korisnikId']){
        echo"
        <td>
          <form action='uredi_korisnik.php' method='post'>
            <input type='hidden' name='id' value=' " .$redak['id'] . " ' />
            <input type='submit' value='Uredi'></input>
          </form>
        </td>";
      }else echo "<td></td>";
    }

    a: 

  }
  echo "
  </tr>
  ";
  echo '
  </tbody>
  </table>
  </div>
  </div>';
  
} else Form::setError("Došlo je do pogreške pri čitanju podataka iz baze");


paginacija($forma);


include('footer.php');
echo "<script>


function izbrisiMe(delid)
{
  if(confirm('Želite li obrisati korisnika?')){
    window.location.href='obrisi.php?id='+delid+'';
    return true;
  }
    
}

$('[data-toggle=confirmation]').confirmation({
	rootSelector: '[data-toggle=confirmation]',
	onConfirm: function() {
		location.href='obrisi.php?id=' + $(this).attr('id');
	}
});

document.getElementById('svi_korisnici').classList.add('active'); 
document.getElementById('navbardrop').classList.add('active'); 
</script>";

$veza->close();

?>
