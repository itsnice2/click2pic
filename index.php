<?php
    /* * * * * * * * * * * * * * * * * * *
     * Settings:
     * * * * * * * * * * * * * * * * * * */
    $image_path     = "./assets/images/";
    $ending         = "/";
    $animals        = $image_path . "animnals"      . $ending;
    $backgrounds    = $image_path . "backgrounds"   . $ending;
    $buildings      = $image_path . "buildings"     . $ending;
    $people         = $image_path . "people"        . $ending;
    $plants         = $image_path . "plants"        . $ending;
    $things         = $image_path . "things"        . $ending;

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
    <link rel="stylesheet" href="assets/css/click2pic.css">
</head>
<body>

<!-- HEADER ------------------------------------------------------------------- -->

<h1>click2pic (working title)</h1>
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
<button id="saveImage" class="buttons">Bild speichern</button>
<hr>

<!-- CONTENT ------------------------------------------------------------------ -->

<div class="container">
    <div class="row">
        <div class="col-8">
            <div style="text-align: left">Hier entsteht dein Bild <button id="imageAreaPlus" class="buttons-bildflaeche">+</button><button id="imageAreaMinus" class="buttons-bildflaeche">-</button><button id="removeimgbtn" class="buttons-bildflaeche">X</button></div>
            <div id="malbereich"">...</div>
        </div>
        <div class="col-4" id="bildbereich">
            <div>Hier kannst du dir Bilder aussuchen</div>
                <div class="row">
                    <div class="row">
                        <div class="list-group" id="list-tab" role="tablist">
                            <a class="list-group-item list-group-item-action active" id="list-home-list" data-bs-toggle="list" href="#list-backgrounds" role="tab" aria-controls="list-home">Hintergrund</a>
                            <a class="list-group-item list-group-item-action" id="list-profile-list" data-bs-toggle="list" href="#list-buildings" role="tab" aria-controls="list-profile">Gebäude</a>
                            <a class="list-group-item list-group-item-action" id="list-messages-list" data-bs-toggle="list" href="#list-people" role="tab" aria-controls="list-messages">Personen</a>
                            <a class="list-group-item list-group-item-action" id="list-settings-list" data-bs-toggle="list" href="#list-plants" role="tab" aria-controls="list-settings">Pflanzen</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="list-backgrounds" role="tabpanel" aria-labelledby="list-home-list">
                                <!-- BACKGROUNDS -->
                                <?php
                                    $dateien = getFileList($backgrounds);
                                    foreach($dateien as $file){
                                        echo "<img class=\"image-thumbnail\" id=\"" . $file . "\" src=\"" . $backgrounds . $file . "\">\n\t\t\t\t\t\t\t\t";
                                    }
                                ?>
                            </div>
                            <div class="tab-pane fade" id="list-buildings" role="tabpanel" aria-labelledby="list-profile-list">
                                <!-- BUILDINGS -->
                                <?php
                                $dateien = getFileList($buildings);
                                foreach($dateien as $file){
                                    echo "<img class=\"image-thumbnail\" id=\"" . $file . "\" src=\"" . $buildings . $file . "\">\n\t\t\t\t\t\t\t\t";
                                }
                                ?>
                            </div>
                            <div class="tab-pane fade" id="list-people" role="tabpanel" aria-labelledby="list-messages-list">
                                <!-- PEOPLE -->
                                <?php
                                $dateien = getFileList($people);
                                foreach($dateien as $file){
                                    echo "<img class=\"image-thumbnail\" id=\"" . $file . "\" src=\"" . $people . $file . "\">\n\t\t\t\t\t\t\t\t";
                                }
                                ?>
                            </div>
                            <div class="tab-pane fade" id="list-plants" role="tabpanel" aria-labelledby="list-settings-list">
                                <!-- PLANTS -->
                                <?php
                                $dateien = getFileList($plants);
                                foreach($dateien as $file){
                                    echo "<img class=\"image-thumbnail\" id=\"" . $file . "\" src=\"" . $plants . $file . "\">\n\t\t\t\t\t\t\t\t";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>

<!-- FOOTER ------------------------------------------------------------------- -->

<div><img id="savedImage" src="" style="display: none"></div>

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="assets/js/click2pic.js"></script>
<script src="assets/js/html2canvas.js"></script>
</body>
</html>

<?php
function getFileList($path)
{
    $handle = opendir($path);
    while (($file = readdir($handle)) !== false)
    {
        if(str_ends_with($file, ".") != true){
            $dateien[] = $file;
        }
    }
    closedir($handle);

    arsort($dateien);

    return $dateien;
}


?>