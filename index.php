<?php
    session_start();
    include "app/settings/inc.php";
    #var_dump($category);
?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>click2pic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://jqueryui.com/wp-content/themes/jqueryui.com/style.css">
    <link rel="stylesheet" href="app/assets/css/click2pic.css">
</head>
<body>

<!-- HEADER ------------------------------------------------------------------- -->

<h1>click2pic</h1>
<hr>
<select name="auswahl">
    <option value="0">Größe wählen (16x9)</option>
    <option value="1">16:9</option>
    <option value="2">9:16</option>
    <option value="3">4:3</option>
    <option value="4">3:4</option>
    <option value="5">Papier (Querformat)</option>
    <option value="6">Papier (Hochformat)</option>
</select>
<button id="newImage" class="buttons">Neues Bild</button>
<button id="saveImage" class="buttons">Bild fertigstellen</button>
<hr>

<!-- CONTENT ------------------------------------------------------------------ -->

<div class="container">
    <div class="row">
<!-- ##### BILDBEREICH ############################################################################################# -->
        <div class="col-8">
            <div style="text-align: left" id="malbereich-text">Bildbereich
                <button id="imageAreaPlus" class="buttons-bildflaeche">+</button>
                <button id="imageAreaMinus" class="buttons-bildflaeche">-</button>
                <button id="removeimgbtn" class="buttons-bildflaeche">X</button>
            </div>
            <div id="malbereich"">...</div>
        </div>
<!-- ##### REIHENFOLGE ############################################################################################# -->
        <div class="col-2">
            <div>Reihenfolge</div>
            <div>
                <ul id="layerbereich"></ul>
            </div>
        </div>
<!-- ##### AUSWAHL ################################################################################################# -->
        <div class="col-2" id="bildbereich">
            <div class="row">
                <div>Auswahl</div>
                <div class="row">
                    <div class="row">
                        <div class="list-group" id="list-tab" role="tablist">
                            <?php $i = 1 ?>
                            <?php foreach($category as $cat): ?>

                                <a class="list-group-item list-group-item-action <?php if($i == 1) echo "active"; ?>" id="list-backgrounds-list" data-bs-toggle="list" href="#list-<?php echo $cat['name'] ?>" role="tab" aria-controls="list-<?php echo $cat['name'] ?>"><?php echo $cat['displayname'] ?></a>
                                <?php $i++ ?>
                            <?php endforeach; ?>
                            <a class="list-group-item list-group-item-action" id="list-things-list" data-bs-toggle="list" href="#list-own" role="tab" aria-controls="list-things">Eigene Bilder</a>
                            <!--
                            <a class="list-group-item list-group-item-action active" id="list-backgrounds-list" data-bs-toggle="list" href="#list-backgrounds" role="tab" aria-controls="list-backgrounds">Hintergrund</a>
                            <a class="list-group-item list-group-item-action" id="list-buildings-list" data-bs-toggle="list" href="#list-buildings" role="tab" aria-controls="list-buildings">Gebäude</a>
                            <a class="list-group-item list-group-item-action" id="list-people-list" data-bs-toggle="list" href="#list-people" role="tab" aria-controls="list-people">Personen</a>
                            <a class="list-group-item list-group-item-action" id="list-plants-list" data-bs-toggle="list" href="#list-plants" role="tab" aria-controls="list-plants">Pflanzen</a>
                            <a class="list-group-item list-group-item-action" id="list-animals-list" data-bs-toggle="list" href="#list-animals" role="tab" aria-controls="list-animals">Tiere</a>
                            <a class="list-group-item list-group-item-action" id="list-things-list" data-bs-toggle="list" href="#list-things" role="tab" aria-controls="list-things">Dinge</a>
                            <a class="list-group-item list-group-item-action" id="list-things-list" data-bs-toggle="list" href="#list-own" role="tab" aria-controls="list-things">Eigene Bilder</a>
                            -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="tab-content" id="nav-tabContent">
                            <?php $i = 1; ?>
                            <?php foreach($category as $cat): ?>

                                <div class="tab-pane fade show <?php if($i == 1) echo "active"; ?>" id="list-<?php echo $cat['name'] ?>" role="tabpanel" aria-labelledby="list-<?php echo $cat['name'] ?>-list">
                                    <!-- BACKGROUNDS -->
                                    <?php
                                    $dateien = getFileList($cat['path']);
                                    foreach($dateien as $file){
                                        echo "<img class=\"image-thumbnail\" id=\"" . $file . "\" src=\"" . $cat['path'] . $file . "\">\n\t\t\t\t\t\t\t\t";
                                    }
                                    $i++;
                                    ?>
                                </div>

                            <?php endforeach; ?>

                            <div class="tab-pane fade" id="list-own" role="tabpanel" aria-labelledby="list-things-list">
                                <!-- YOUR OWN PICTURES -->
                                <form enctype="multipart/form-data" action="app/upload.php" method="POST">
                                    <label class="btn btn-default btn-sm center-block btn-file">
                                        <img src="https://openmoji.org/data/color/svg/E142.svg" height="30px">
                                        <label class="bildname">Bild auswählen</label>
                                        <input type="file" style="display: none;" name="bild">
                                    </label>
                                    <input type="hidden" name="user" value="<?php echo session_id() ?>">
                                    <input type="hidden" name="cu" value="<?php echo $custom ?>">
                                    <input id="ordner-auflisten" class="buttons ordnerbutton" type="Submit" value="Hochladen">
                                    <label class="infotext">Erlaubt sind JPG-/JPEG-, PNG-, und SVG-Bilder.</label>
                                    <?php if($delete['delete']): ?>
                                        <label class="infotext">Eigene Bilder werden nach <?php echo $delete['time_value'] . " " . $delete['time_value']; ?> automatisch gelöscht.</label>
                                    <?php endif; ?>
                                </form>
                                <?php
                                    if(is_dir($custom)){
                                        $dateien = getFileList($custom);
                                        foreach($dateien as $file){
                                            echo "<img class=\"image-thumbnail\" id=\"" . $file . "\" src=\"" . $custom . $file . "\">\n\t\t\t\t\t\t\t\t";
                                        }
                                    }
                                ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <div class="footer">
        Erstellt mithilfe von <a href="https://jquery.com" target="_blank">jQuery</a>, <a href="https://getbootstrap.com" target="_blank">Bootstrap</a> und <a href="https://html2canvas.hertzen.com" target="_blank">html2canvas</a>
    </div>
</div>

<!-- FOOTER ------------------------------------------------------------------- -->

<!-- <div><img id="savedImage" src=""></div> -->


<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="app/assets/js/html2canvas.js"></script>
<script src="app/assets/js/click2pic.js"></script>
</body>
</html>
