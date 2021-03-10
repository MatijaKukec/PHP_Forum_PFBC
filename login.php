<?php 


require_once 'PFBC/Form.php';
require_once 'baza.php';

session_start();

if (isset($_SESSION['korisnikId'])) header('Location: ./index.php'); 
$title = "Logiranje"; require_once('header.php'); require_once ('navbar_1.0.php');

if(Form::isValid("login", false)) {
        $lozinka = htmlentities(trim($_POST['lozinka']));
        $korisnik = htmlentities(trim($_POST['korisnik']));
        
        $query= $veza->prepare("SELECT * FROM korisnici WHERE korisnik=? LIMIT 1");
        $query->bind_param('s', $korisnik);
        if ($query->execute()){
            $result = $query->get_result();
            if ($result->num_rows) {
                if($row = $result->fetch_assoc()) {
                    if(password_verify($lozinka, $row['lozinka'])){
                        $_SESSION['korisnikId'] = $row['id'];
                        $_SESSION['korisnikIdUid'] = $row['korisnik'];
                        if($row['prava']!=NULL&&$row['prava']=11111111111){
                            $_SESSION['prava']= $row['prava'];
                        }
                        $_SESSION["loginPoruka"] = '<div class="alert alert-success">
                        <strong>Uspješna prijava! </br></strong>
                        </div>';
                        header("Location: ./index.php?login=success");
                        exit();
                    }
                    else {
                        Form::setError("login", "Lozinke se ne podudaraju!");
                    }
                }
            }   
        else {
            Form::setError("login", "Korisnik ne postoji u bazi!");
        }
    }
}

    
echo "<script> document.getElementById('login').classList.add( 'active'); 
</script>";

echo '    
<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                <div class="card-body">
';
                            
if(!isset($_POST['predano'])) Form::clearErrors('login');
Form::open('login', '', array("view"=>"sidebyside4"));
Form::Hidden('predano', 'predavanje');
Form::Textbox('Korisnik: ', 'korisnik', array('required'=>1, 'validation'=>new Validation_RegExp('/^(?=[a-žA-Ž0-9._\.\-\ ]{3,20}$).*$/i',
"%element% mora sadržavati ispravne znakove.
Koriste se samo slova... Ostali znakovi interpunkcije nisu dozvoljeni."),
'class' => ''));
Form::Password('Lozinka: ', 'lozinka', array('required'=>1, 'validation'=>new Validation_RegExp('/^(?=[a-žA-Ž\d\-_\.]{3,30}).*$/i',
"%element% mora sadržavati minimalno 6 znakova.")));
Form::Checkbox("", "Remember", array("1" => "Zapamti me"));
Form::Button("Ulogiraj se",'', array('class' => 'class="w3-button w3-black'));
Form::close(false);

echo '                          
                                </div>
                                <div class="card-footer text-center">
                                    <div><a href="novi_korisnik.php">Nemaš račun? Registriraj se!</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
';
require_once('footer.php');
?>