
<?php
session_start();
if (!isset($_SESSION['korisnikId'])) {	header('Location: login.php'); }
$title="Svi korisnici";
$pag_el ="korisnici";

include ('header.php');
include ('navbar.php');
require_once ('PFBC/Form.php');
require_once ('baza.php');
require_once ('crop.php');
include ('paginacija.php');

echo '<div class="forma"><h2>Svi korisnici sustava</h2>';
require_once('baza.php');

if ($rezultat){
  echo '
  
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Doma</a></li>
                            <li class="breadcrumb-item active">Svi korisnici</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">
                                DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the
                                <a target="_blank" href="https://datatables.net/">official DataTables documentation</a>
                                .
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table mr-1"></i>
                                Lista korisnika
                            </div>
                            <div class="card-body">
                            <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Ime</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th>Ime</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                        <tbody>';
  while ($redak=$rezultat->fetch_assoc()) {
    
    echo "<tr><td><img width='50' height='50' src='slike/" .$redak['avatar']."' /></td>
    <td>" . $redak['korisnik'] . "</td>";
    
    if(isset($_SESSION['korisnikId'])&&isset($_SESSION['prava'])){
      if($_SESSION['prava']!=NULL&&$SESSION['prava']=11111111111){
        if($redak['korisnik']=="admin") goto a;
        echo"
        <td>
        <form action='uredi_korisnik.php' method='post'>
        <input type='hidden' name='id' value=' " .$redak['id'] . " ' />
        <input type='submit' value='Uredi'></input>
        </form></td>";
      
        echo"
        <td>
        <button class='btn btn-danger'
        id=' ". $redak['id'] . " ' data-btn-ok-label='Da'
        title='Želite li obrisati korisnika?'
        data-btn-cancel-label='Ne' data-toggle='confirmation'
        data-singleton='true'>Obriši</button>
        </td>";
      }
    } else{
    if($redak['id']==$_SESSION['korisnikId']){
      echo"
        <td>
        <form action='uredi_korisnik.php' method='post'>
        <input type='hidden' name='id' value=' " .$redak['id'] . " ' />
        <input type='submit' value='Uredi'></input>
        </form></td>";
      }
    }

    a:

  }
  echo "
  </tr>
  ";
  echo '
  <tbody>
  </table>';
  
} else Form::setError("Došlo je do pogreške pri čitanju podataka iz baze");

//paginaciju budemo ispisivali jedino ukoliko imamo više od jedne stranice
if ($brojStranica>1) {
    echo "<div style='clear: left; '>";
    //ukoliko nismo na prvoj stranici ispisujemo prethodna,
    //kad bi bili na prvoj stranici ne bi ispisali prethodna
    echo "<ul class='pagination pagination-sm'>";
    if ($stranica>1){
      //prethodna je promjenjivi link i ovisi o stranici
      //na kojoj se trenutačno nalazimo --> $stranica - 1

      echo "<li><a href= 'svi_korisnici.php?stranica= ". ($stranica-1)."'>&laquo Prethodna </a></li>";
    }
    for ($i=1; $i<=$brojStranica; $i++) {
      if ($i==$stranica) echo "<li class= 'active '><span> $i </span></li>";
      else echo "<li><a href='svi_korisnici.php?stranica=$i'> $i </a></li> ";
    }
    if ($stranica<$brojStranica){
      echo "<li><a href='svi_korisnici.php?stranica=" . ($stranica+1) . " '>
      Sljedeća&raquo </a></li>";
    }
    echo "</ul>";
    echo "</div> ";
}

echo "</div>";

include('footer.php');
echo "<script>
$('[data-toggle=confirmation]').confirmation({
	rootSelector: '[data-toggle=confirmation]',
	onConfirm: function() {
		location.href='obrisi.php?id=' + $(this).attr('id');
	}
});
document.getElementById('sviKor').classList.add('active'); 
document.getElementById('navbardrop').classList.add('active'); 
</script>";

$veza->close();

?>


