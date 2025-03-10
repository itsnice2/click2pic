<?php

########## C O N F I G #################################################################################################

$image_path     = "images/";
$ending         = "/";
$custom         = $image_path . "custom-uploads/" . session_id() . $ending;
$i = 1;
$delete = [
    "delete" => true,
    "time_value" => 24,
    "time_unit" => "Stunden"
];

########## C O N F I G : S E T   C A T E G O R I E S ###################################################################

if (($handle = fopen("app/config-files/categories.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 2000, ",", "\"")) !== FALSE) {
        $category[] = [
            "name" => $data[0],
            "displayname" => $data[1],
            "path" => $image_path . $data[0] . $ending
        ];
    }
    fclose($handle);
}

########## F U N C T I O N S ###########################################################################################

function getFileList($path)
{
    $handle = opendir($path);
    while (($file = readdir($handle)) !== false)
    {
        if(!str_ends_with($file, ".") && !str_ends_with($file, "pic") && !str_ends_with($file, "thumbnail")){
            $dateien[] = $file;
        }
    }
    closedir($handle);

    arsort($dateien);

    return $dateien;
}