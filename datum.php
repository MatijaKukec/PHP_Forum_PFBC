<?php

session_start();

$title = "Registracija";

require_once ('header.php');
require_once ('navbar.php');
require_once ('PFBC/Form.php');
require_once 'baza.php';
$forma = 'Datum';

echo '<h1 style="text-align: center;">Promjena datuma rođenja</h1>';

if(isset($_POST['provjera'])){
    if(Form::isValid($forma, false)){

                $danas=date("Y/m/d");
                if(isset($_POST['dob'])){
                    $dob=$_POST['dob'];
                    echo "Vaš datum rođenja je ".$dob;
                    $izjava=$veza->prepare("UPDATE korisnici SET vrijeme_reg=?, dob=? WHERE id=?");
                    $izjava->bind_param('ssi', $danas, $dob, 6);
                } else{
                    $izjava=$veza->prepare("UPDATE korisnici SET vrijeme_reg=? WHERE id=?");
                    $izjava->bind_param('si', $danas, 6);
                echo "Danas je " . $danas ;
                }
                
                if($izjava->execute()){
                    echo '<div class="alert alert-success">
                    <strong>Korisnik je uspješno izmjenjen</strong>
                    </div>';
                } else {    
                    Form::setError($forma, "Pogreška s upisivanjem u bazu podataka");
                }
                
            }

}
else Form::clearErrors($forma);


$query="SELECT * FROM korisnici";
$redci=$veza->query($query);
echo "<table><tr><td>Ime</td><td>ID</td><td>Vrijeme registracije</td><td>DoB</td></tr>";
while ($rez=$redci->fetch_object()) {
    echo "<tr><td>" . $rez->korisnik ."</td><td>" . $rez->id ."</td><td>" . $rez->vrijeme_reg."</td><td>" . $rez->dob."</td></tr>" ;
}
echo "</table>";

if(!isset($_POST['provjera'])) Form::clearErrors($forma); 
echo '<legend>Kreiraj novog korisnika</legend>';
//Form::open('novi_korisnik', '', array('view'=>'SideBySide4'));
Form::open($forma, '', array("enctype" => "multipart/form-data"));
Form::Date('Dob','dob');
Form::Button('Napravi korisnika');
Form::close(false);


echo "<script> document.getElementById('reg').classList.add('active'); 
</script>"; 

require_once("footer.php");

?>