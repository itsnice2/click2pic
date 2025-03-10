<?php
session_start();

$session_id = $_POST['user'];
$custom_uploads = $_POST['cu'];
$img_name = $_FILES['bild']['name'];
$img_full_path = $_FILES['bild']['full_path'];
$img_type = $_FILES['bild']['type'];
$img_tmp_name = $_FILES['bild']['tmp_name'];
$img_error = $_FILES['bild']['error'];
$img_size = $_FILES['bild']['size'];
$img_directory = "custom-uploads/" . $session_id;

if($img_error === 0 && $img_size <= 30000000 && ($img_type === "image/jpeg" || $img_type === "image/png" || $img_type === "image/svg+xml")){
    echo "ok";

    if( is_dir( $custom_uploads . "/" . $session_id) ){
        move_uploaded_file($img_tmp_name, $img_directory . "/" . $img_name);
        echo "<img src='" . $img_directory . "/" . $img_name . "' width='500'>";
    }
    else{
        mkdir($img_directory . "/", 0755);
        move_uploaded_file($img_tmp_name, $img_directory . "/" . $img_name);
        echo "<img src='" . $img_directory . "/" . $img_name . "' width='500'>";
    }
    //header( "refresh:5;url=index.php" );
}
else{
    if($img_error !== 0){
        echo "Fehler";
        return;
    }

    if($img_size > 30000000){
        echo "Datei zu groß";
        return;
    }


    echo "Keine gültige Bilddatei";
    //header( "refresh:5;url=index.php" );
}

echo "<a href='index.php'>Zurück</a>";


##### TESTBEREICH ######################################################################################################
echo "<br><hr><br>";
echo "<pre>";
var_dump($_POST);
echo "<br><hr><br>";
var_dump($_FILES);
echo "</pre>";
