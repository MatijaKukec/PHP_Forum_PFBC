<?php
session_start();
if(!isset($_SESSION['korisnikId'])){
    header('Location:login.php');
} else if (!isset($_POST['id'])){
    header('Location:svi_korisnici.php');
}
    
$title="Izmjena slike";
include('header.php');
include('navbar.php');

$forma ='slikaKorisnik';
require_once 'PFBC/Form.php';

echo "<script>
    document.getElementById('korisnici').classList.add('active);
    </script>";
echo '<div class="forma"><h2>Izmijeni sliku korisnika</h2>';

if (isset($_POST['predano'])){
    $id=$_POST['id'];
    $staraSlika=$_POST['avatar'];
    $korisnik=$_POST['korisnik'];

    if(Form::isValid($forma, false)){
        require_once('baza.php');
        require_once('uredi_sliku.php');
        $slika=$_FILES['slika'];
        $dat=uredi_sliku_fun($slika,$forma);
        $izjava=$veza->prepare("UPDATE korisnici SET avatar=? WHERE id=?");
        $izjava->bind_param('si', $dat, $id);
        
        if($izjava->execute()){
            echo '<div class="alert alert-success">
            <strong>Uspješno izmjenjena slika!</strong>
            </div>';
            unlink('slike/'.$staraSlika);
            $staraSlika=$dat;
            Form::clearErrors($forma);
            Form::clearValues($forma);
        } else {    
            Form::setError($forma, "Pogreška s upisivanjem u bazu podataka");
        }
    }

} else {
    $id=$_POST['id'];
    require_once('baza.php');
    $izjava=$veza->prepare('SELECT * FROM korisnici WHERE id=? LIMIT 1');
    $izjava->bind_param('i',$id);
    if($izjava->execute()){
        $rezultat=$izjava->get_result();
        $redak=$rezultat->fetch_assoc();
        $korisnik=$redak['korisnik'];
        $staraSlika=$redak['avatar'];
    }
    Form::clearErrors($forma);
    Form::clearValues($forma);
}

echo"<p>Izmjena slike korisnika: " . $korisnik . "<p>";
echo"<p><img src='slike/" . $staraSlika . "' /></p>";

Form::open ($forma, '', array("enctype"=>"multipart/form-data"));
Form::Hidden ('predano', 'da');
Form::Hidden ('id',$id);
Form::Hidden ('korisnik',$korisnik);
Form::Hidden ('avatar',$staraSlika);
Form::File ("Avatar","slika",array("required"=>1));
Form::Button ('Izmijeni sliku korisnika');
Form::Button ('Odustani', 'button', array("onclick"=>"location.href='svi_korisnici.php';"));
Form::close (false);
echo"</div>";
include('footer.php');

?>