<?php


if ($_GET['ext'] == 'png') {
    $ext = 'png';
} elseif ($_GET['ext'] == 'jpg') {
    $ext = 'jpg';
}

header('Content-disposition: attachment; filename=Name-of-Image.' . $ext);
header('Content-type: image/' . $ext);
//readfile('http://m.com/hello.' . $ext);
//readfile($_GET['img'] . $ext);
print_r(base64_decode($_GET['img']));



