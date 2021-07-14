<?php

//error.php

$error = $_SERVER["REDIRECT_STATUS"];

$error_title = '';
$error_message = '';

if($error == 401){
    $error_title = '401 Neovlašten pristup.';
    $error_message = 'Pristup ovoj stranici je odbijen.';
}

if($error == 404){
    $error_title = '404 Stranica ne postoji';
    $error_message = 'URL ne valja.';

}if($error == 500){
    $error_title = '500 Server greška';
    $error_message = 'Radimo na tome da Vam se vratimo uskoro :).';
}

echo '

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>'. $error_title .'</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <div id="layoutError">
            <div id="layoutError_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-6">
                                <div class="text-center mt-4">
                                    <h1 class="display-1">'. $error .'</h1>
                                    <p class="lead">'. $error_title .'</p>
                                    <p>'. $error_message . '</p>
                                    <a href="index.php">
                                        <i class="fas fa-arrow-left mr-1"></i>
                                        Povratak na glavnu stranicu
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutError_footer">
            
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Moja Web stranica '.date("Y").'</div>
                            <div class="align-center">Danas je '. date("d.m.Y") .'</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
                
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>'
;
?>