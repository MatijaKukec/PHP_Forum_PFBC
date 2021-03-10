<?php

session_start();

$title = "Registracija";

require_once ('uredi_sliku.php');
require_once ('header.php');
require_once ('navbar_1.0.php');
require_once ('PFBC/Form.php');
require_once 'baza.php';
$forma = 'novi_korisnik';

echo '<h1 style="text-align: center;">Registriraj se</h1>';
echo "Danas je " . date("Y-m-d") ;

if(isset($_POST['provjera'])){
    if(Form::isValid($forma, false)){

        if($_POST['lozinka']==$_POST['ponovljeno']){
            $pass = $_POST['lozinka'];

            $lozinka = password_hash($pass, PASSWORD_DEFAULT);
            $korisnik=htmlentities(trim($_POST['korisnik']));

            $query=$veza->prepare('SELECT*FROM korisnici WHERE korisnik=? LIMIT 1');
                
            $query->bind_param('s', $korisnik);
            $query->execute();
            $postoji = $query->fetch();

            $slika=$_FILES['slika'];

            //ako ne postoji upisujemo korisnika
            if(!$postoji){
                $dat=uredi_sliku_fun($slika,$forma);
                $danas=date("d.m.Y");
                if(isset($_POST['dob'])){
                    $dob=$_POST['dob'];
                    echo "Vaš datum rođenja je ".$dob;
                    $izjava=$veza->prepare("INSERT INTO korisnici SET korisnik=?, lozinka=?, avatar=?, vrijeme_reg=?, dob=?");
                    $izjava->bind_param('sssss', $korisnik, $lozinka, $dat, $danas, $dob);
                    $dob=$_POST['dob'];
                } else{
                    $izjava=$veza->prepare("INSERT INTO korisnici SET korisnik=?, lozinka=?, avatar=?, vrijeme_reg=?");
                    $izjava->bind_param('ssss', $korisnik, $lozinka, $dat, $danas);
                }
                
                if($izjava->execute()){
                    echo '<div class="alert alert-success">
                    <strong>Korisnik je uspješno upisan u bazu podataka</strong>
                    </div>';
                    // odmah se postavljaju login parametri za registriranog korisnika
                    $_SESSION['korisnikId'] = $row['id'];
                    $_SESSION['korisnikIdUid'] = $row['korisnik'];
                } else {    
                    Form::setError($forma, "Pogreška s upisivanjem u bazu podataka");
                }
            }
            else{
                Form::setError("unos", "Korisnik već postoji u bazi podataka");
                }
            }
        }
        else{Form::setError($forma, "Lozinke se ne podudaraju");
    }
}
else Form::clearErrors($forma);


/* $query="SELECT * FROM korisnici";
$redci=$veza->query($query);
echo "<table><tr><td>Ime</td><td>Lozinka</td><td>id</td></tr>";
while ($rez=$redci->fetch_object()) {
    echo "<tr><td>" . $rez->korisnik ."</td><td>" . $rez->lozinka."</td><td>" . $rez->id ;
}
echo "</table>"; */

if(!isset($_POST['provjera'])) Form::clearErrors($forma); 
echo '<legend>Kreiraj novog korisnika</legend>';
//Form::open('novi_korisnik', '', array('view'=>'SideBySide4'));
Form::open($forma, '', array("enctype" => "multipart/form-data"));
Form::File('Avatar', 'slika', array("required" => 1));
Form::Hidden('provjera','provjereno');
Form::Textbox('Korisnik:', 'korisnik', array('required'=>1, 'validation'=>new Validation_RegExp('/^(?=[a-žA-Ž0-9._\.\-\ ]{3,20}$).*$/i',
"%element% mora sadržavati ispravne znakove.
Koriste se samo slova... Ostali znakovi interpunkcije nisu dozvoljeni.")));
Form::Date('Dob','dob');
Form::Password('Lozinka:', 'lozinka', array('required'=>1, 'validation'=>new Validation_RegExp('/^[a-žA-Ž\d\-_\.]{6,30}$/i',
"%element% mora sadržavati minimalno 6 znakova.")));
Form::Password('Ponovite lozinku:', 'ponovljeno', array('required'=>1));
Form::Button('Napravi korisnika');
Form::close(false);


echo "<script> document.getElementById('reg').classList.add('active'); 
</script>"; 

require_once("footer.php");
?>