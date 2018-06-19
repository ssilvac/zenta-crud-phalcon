<?php



$OUTPUT = "output/";

$BUSINESS       = "templates/business/MaestroBSN";
$CONTROLLERS    = "templates/controllers/MaestroController";
$JS             = "templates/js/maestro";
$VIEWS = [
    "_table"    =>"templates/views/_table",
    "index"     => "templates/views/index",
    "main_form" => "templates/views/main_form",
    "search"    => "templates/views/search"
];

echo "> STARTING CRUD GENERATION.".PHP_EOL;


if(!is_dir($OUTPUT)){

    mkdir($OUTPUT);

}

clearDir($OUTPUT);
echo "Cleaning Directory !" .PHP_EOL;

$data_tags = json_decode(file_get_contents("config.json"), true);


echo "> Generation business ...".PHP_EOL;
$_FILE_STRING_BUSINESS = process($BUSINESS,$data_tags);
file_put_contents($OUTPUT.$data_tags["<<MAESTRO_CLASS_NAME>>"]."BSN.php",$_FILE_STRING_BUSINESS);

echo "> Generation controllers ...".PHP_EOL;
$_FILE_STRING_CONTROLLERS = process($CONTROLLERS,$data_tags);
file_put_contents($OUTPUT.ucfirst(strtolower($data_tags["<<MAESTRO_CLASS_NAME>>"]))."Controller.php",$_FILE_STRING_CONTROLLERS);

echo "> Generation javascript ...".PHP_EOL;
$_FILE_STRING_JS = process($JS,$data_tags);
file_put_contents($OUTPUT.$data_tags["<<MAESTRO_CLASS_NAME_LOWER>>"].".js",$_FILE_STRING_JS);

echo "> Generation views ...".PHP_EOL;
foreach ($VIEWS as $key => $view) {
    $_FILE_STRING_VIEW = process($view,$data_tags);
    file_put_contents($OUTPUT.$key.".volt",$_FILE_STRING_VIEW);
}

echo "> END CRUD GENERATION.";


/**
 *
 * process
 *
 * @author jasilva - Jorge Silva Aguilera - jorge.silva@zentagroup.com
 * @title process
 * @param $file
 * @param $data_tags
 * @return bool|mixed|string
 */
function process($file,$data_tags) {

    $FILE_STRING = file_get_contents($file);
    $FILE_STRING = str_replace(array_keys($data_tags),array_values($data_tags), $FILE_STRING);

    return $FILE_STRING;
}

/**
 *
 * clearDir
 *
 * @author jasilva - Jorge Silva Aguilera - jorge.silva@zentagroup.com
 * @title clearDir
 */
function clearDir($dir) {
    $files = glob($dir.'*'); // get all file names
    foreach($files as $file){ // iterate files
        if(is_file($file))
            unlink($file); // delete file
    }
}


?>