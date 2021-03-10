<?php

require_once("baza.php");
require_once("crop.php");

function uredi_sliku_fun($slika, $forma){

$dozvoljeni_MIME=array("image/jpeg", "image/gif", "image/png","image/bmp");
if(!empty ($slika['type'])&&!in_array ($slika['type'], $dozvoljeni_MIME)) {
    Form::setError("$forma", "Niste odabrali ispravan tip datoteke !!! (gif, jpeg ili png) ");
    }else {
        $greska=$slika['error'];
            $upload_greske = array(
            UPLOAD_ERR_OK => "Datoteka je uspješno predana",
            UPLOAD_ERR_INI_SIZE => "Datoteka je prevelika",
            UPLOAD_ERR_FORM_SIZE => "Datoteka je prevelika",
            UPLOAD_ERR_PARTIAL => "Partial upload. ",
            UPLOAD_ERR_NO_FILE => "Niste predali datoteku",
            UPLOAD_ERR_NO_TMP_DIR => "Greška sa serverom",
            UPLOAD_ERR_CANT_WRITE => "Greška sa serverom",
            UPLOAD_ERR_EXTENSION=> "Greška vezana uz ekstenziju datoteke. "
        );
    if ($greska>0) {
        Form::setError ($forma, $upload_greske [$greska]);
    } else {
        $privremena_datoteka=$slika['tmp_name'];
        $datoteka_spremanja=basename($slika['name']);
        $datoteka_spremanja=basename($slika['name']);
        $posljednjaTocka = strrpos ($datoteka_spremanja, ".");
        $ekstenzija= substr ($datoteka_spremanja,$posljednjaTocka);
        $datoteka_spremanja= str_replace(".", "", substr($datoteka_spremanja, 0,$posljednjaTocka));
        $datoteka_spremanja= str_replace(" ", "", $datoteka_spremanja) ;
        if (strlen ($datoteka_spremanja) >50) $datoteka_spremanja= substr($datoteka_spremanja, 0, 50);
        $datoteka_spremanja.=$ekstenzija;
        $upload_dir="slike";
        $i=0;
        while (file_exists ($upload_dir. "/". $datoteka_spremanja)){
            list ($naziv, $ekstenzija) =explode (".", $datoteka_spremanja) ;
            $datoteka_spremanja=rtrim ($naziv, strval($i-1)) . $i. "." . $ekstenzija;
            $i++;
        }
        $slika=$upload_dir. "/" . $datoteka_spremanja;
        if (move_uploaded_file($privremena_datoteka, $slika)){
            if(true == ($greska_sa_slikom= image_resize($slika, $slika, 200, 200, 1))){

                return $datoteka_spremanja;

            } else {
                unlink($slika);
            }
        } else {
            Form::setError($forma, "Slika nije prebačena u folder na serveru");
        }
    }
}
}


?>