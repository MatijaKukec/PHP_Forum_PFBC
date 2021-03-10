<?php 

require_once ('PFBC/Form.php');
require_once ('baza.php');

//provjera da li se nalazi u bazi
//odredivanje trenutačne stranice
//ukoliko ništa nemamo zapisano u URL -u, stranica se postavlja na 1,
//a ukoliko imamo zapisan broj u $_GET pos stavljamo ga u varijablu stranica
$stranica = (empty($_GET['stranica'])) ? 1 : (int) $_GET['stranica'];
//broj članaka koji će se prikazivati po stranici
$brojPoStranici=(empty($brojPoStranici)) ? 3 : $brojPoStranici;
//brojanje koliko je stavki u bazi
$query = "SELECT COUNT(*) FROM $pag_el";
$rezultat=$veza->query($query);
if ($rezultat) {
  $polje=$rezultat->fetch_row();
  $ukupno_korisnika=$polje[0];

  //odredivanje koliko ukupno imamo stranica
  $brojStranica=ceil($ukupno_korisnika/$brojPoStranici);
  //ukolko korisnik upiše u URL broj stranice koji ne postoji
  if ($stranica<1) $stranica=1;
  else if ($stranica>$brojStranica-1) $stranica=$brojStranica;
  //Odedivanje koji $pag_el će se dohvatiti
  $odmak=$brojPoStranici*($stranica-1);
  //dohvaćanje korisnika ovisno o stranici na kojoj smo,
  //poredamo ih ASC, ukoliko želimo da idu od mladeg prema starijem stavimo DESC
  $query="SELECT*FROM $pag_el ORDER BY id ASC LIMIT $brojPoStranici OFFSET $odmak" ;
  $rezultat=$veza->query($query, MYSQLI_STORE_RESULT);

}
else echo "Nije bilo moguće pročitati bazu";

function paginacija($forma){
global $brojStranica, $x, $stranica, $ukupno_korisnika;
//paginaciju budemo ispisivali jedino ukoliko imamo više od jedne stranice
if ($brojStranica>1) {
  echo '
      
  <div class="row">
    <div class="col-sm-12 col-md-5">
      <div class="dataTables_info" id="dataTable_info" role="status" aria-live="polite">Prikazuju se '.$x.' od ukupno '.$ukupno_korisnika.' korisnika</div>
      </div>
      <div class="col-sm-12 col-md-7">
        <div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
      ';

    //ukoliko nismo na prvoj stranici ispisujemo prethodna,
    //kad bi bili na prvoj stranici ne bi ispisali prethodna
    echo '<ul class="pagination pagination-sm">';

    if ($stranica>1){
      //prethodna je promjenjivi link i ovisi o stranici
      //na kojoj se trenutačno nalazimo --> $stranica - 1
      echo'<li class="paginate_button page-item previous active">';
    }else echo'<li class="paginate_button page-item previous disabled">';
    echo '
    <a  href= "'.$forma.'.php?stranica= '. ($stranica-1).'" class="page-link">
    &laquo Prethodna </a></li>';
    for ($i=1; $i<=$brojStranica; $i++) {
      if ($i==$stranica) echo '<li class=paginate_button page-item active"> <a';
      else echo'<li class="paginate_button page-item"> <a href="'.$forma.'.php?stranica='.$i.'"';
      echo ' aria-controls="dataTable" class="page-link">'.$i.'</a>
      </li>';
    }
    if ($stranica<$brojStranica){
      echo '<li class="paginate_button page-item next">';
    }
    else echo '<li class="paginate_button page-item next disabled">';
    echo '<a href="'.$forma.'.php?stranica='. ($stranica+1) .'" class="page-link">Sljedeća &raquo </a></li></ul>';

  echo "
        </div>
      </div>
    </div>
  </div>
  ";
}

}

?>