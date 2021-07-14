<?php


require_once 'PFBC/Form.php';
require_once 'baza.php';
session_start();

if(!isset($_SESSION['korisnikId'])) header("Location: ./login.php?logged=false");

//if (!isset($_SESSION['korisnikId'])) header('Location: ./index.php '.$_SESSION['korisnikIdUid']);

$title = "Uređivanje"; require_once('header.php'); include ('navbar.php');
echo'
  <h1 >Uredi korisnika</h1>
';


if(Form::IsValid('uredi_korisnik',false))
{
    $ime=htmlentities($_POST['ime']);
    $hashlozinka=password_hash($_POST["lozinka"],PASSWORD_DEFAULT);
    if($_POST["lozinka"]!=$_POST["ponovljeno"])
    {
        Form::setError("uredi_korisnik","Lozinke se ne podudaraju!");
    }
   
    else{

        if($hashlozinka==NULL)
        {
            $prep=$veza->prepare("UPDATE korisnici SET korisnik=? WHERE id=?");
            $prep->bind_param("si",$ime,$id);
            izvrši($prep);
        }
        else
        {
            $prep=$veza->prepare("UPDATE korisnici SET korisnik=?, lozinka=? WHERE id=?");
            $prep->bind_param("ssi",$ime,$hashlozinka,$id);
            print_r(izvrši($prep));
        }
    }
}


if(!isset($_POST['uredeno'])) {
    Form::clearErrors('uredi_korisnik');
    if(isset($_POST["id"])) $id=$_POST["id"];
    else $id=$_SESSION['korisnikId']; 
    // vade se podaci za korisnika kojemu je id zadani preko $POST
    $vadiId=$veza->prepare('SELECT korisnik, avatar, vrijeme_reg, dob FROM korisnici WHERE id=?');
    $vadiId->bind_param('i', $id);
    $vadiId->execute();
    $rez = $vadiId->get_result();
    $rezultat = $rez -> fetch_assoc();
    $korisnik=$rezultat['korisnik'];
    $slika=$rezultat['avatar'];
    $dob = $rezultat['dob'];
    $vrij_reg = $rezultat['vrijeme_reg'];
    echo '<legend>Uredi korisnika - '. $korisnik .'</legend>';
    echo"<p><img src='slike/" . $slika . "' /></p>";
        
    echo
    "<form action= 'slika_korisnik.php' method= 'post'>
	<input type='hidden' name='id' value='" .$id."'/>
	<input type='submit' value='Uredi sliku' class= 'btn btn-primary '></input>
	</form> </td><td>";

    $_SESSION['IDuredi']=$id;
    
}
else echo '<legend>Uredi korisnika </legend>';

Form::open('uredi_korisnik', '', array('view'=>'SideBySide4'));
Form::Hidden('uredeno','uredivanje');
Form::Textbox('Korisnik: ', 'ime', array("required"=>1, "validation"=>new Validation_RegExp('/^(?=[a-žA-Ž\d\-_\.]{3,30}).*$/i',"%element% mora sadržavati minimalno 3 znakova. Koriste se samo slova... Ostali znakovi interpunkcije nisu dozvoljeni")));
Form::Password('Lozinka:', 'lozinka', array("validation"=>new Validation_RegExp('/^(?=[a-žA-Ž\d\-_\.]{6,30}).*$/i',"%element% mora sadržavati minimalno 6 znakova. Koriste se samo slova i brojke te _, - i .. Ostali znakovi interpunkcije nisu dozvoljeni.")));
Form::Password('Ponovite lozinku:', 'ponovljeno');
echo '<div>';
    echo $dob;    Form::Date('Dob','dob');
echo '</div>';

if (isset($vrij_reg)){
    echo "<div>Vrijeme registracije - ".$vrij_reg. "\t \t \t</div>";
}

Form::Button('Uredi');
Form::Button ("Reset", "reset", array("onclick" => 'document.getElementById("myForm").reset();'));
Form::Button ('Odustani', 'button', array("onclick"=>"location.href='svi_korisnici.php';"));
Form::close(false);

function izvrši($query){
    if($query->execute()){
        echo '<div class="alert alert-success">Uspješno uređivanje korisnika!</div>';
        Form::clearValues('uredi_korisnik');
        return $query->affected_rows;
        $query->close();
    }
    else Form::setError("uredi_korisnik","Neuspješno uređivanje!");
}

include ("footer.php");
?>