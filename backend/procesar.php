<?php
// backend/procesar.php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once __DIR__ . '/ProcesadorTexto.php';

// Leer POST
$textoOriginal = $_POST['texto'] ?? '';
if (trim($textoOriginal) === '') {
    echo json_encode(["error" => "No se proporcionó texto"]);
    exit;
}

// Stop words en minúsculas
$stopWords = [
    'de','la','que','el','en','y','a','los','del','se','las',
    'por','un','para','con','no','una','su','al','lo','como',
    'mas','pero','sus','le','ya','o','este','es','si','porque',
    'esta','entre','cuando','muy','sin','sobre','tambien','me',
    'hasta','hay','donde','quien','desde','todo','nos','durante',
    'todos','uno','les','ni','contra','otros','ese','esa','eso',
    'ante','ellos','e','esto','mi','antes','algunos','que','unos',
    'yo','otro','otras','otra','el','tanto','esa','estos','mucho',
    'quienes','nada','muchos','cuales','poco','ella','estar','estas',
    'algo','nosotros','mi','mis','tu','te','ti','tus','ellas','nosotras',
    'vosotros','vosotras','si','cierto'
];

$procesador = new ProcesadorTexto($stopWords);
$frecuencias = $procesador->procesar($textoOriginal);

// Convertir a array de objetos {palabra, frecuencia}
$respuesta = [];
foreach ($frecuencias as $palabra => $conteo) {
    $respuesta[] = ['palabra'=>$palabra,'frecuencia'=>$conteo];
}

echo json_encode($respuesta);
