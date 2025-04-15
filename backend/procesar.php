<?php
// Permitir acceso desde cualquier origen
header("Access-Control-Allow-Origin: *");

// Si necesitas admitir otros métodos o cabeceras, puedes añadir también:
// header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
// header("Access-Control-Allow-Headers: Content-Type, Authorization");

// procesar.php - Backend PHP para procesar texto y contar frecuencia de palabras

// 1. Obtener el texto enviado por POST
$textoOriginal = $_POST['texto'] ?? '';  // Usa el parámetro 'texto' del POST, o cadena vacía si no existe

// Opcional: comprobar que no esté vacío
if (trim($textoOriginal) === '') {
    // Si no hay texto, devolvemos un JSON con error (o podríamos devolver simplemente nada)
    $respuestaError = ["error" => "No se proporcionó texto"];
    header('Content-Type: application/json');
    echo json_encode($respuestaError);
    exit; // terminamos la ejecución
}

// 2. Normalizar el texto: convertir a minúsculas y eliminar puntuación
$minusculas = mb_strtolower($textoOriginal, 'UTF-8');  // convierte a minúsculas (compatible UTF-8 para Ñ, acentos, etc.)

// Eliminar signos de puntuación usando una expresión regular:
// Reemplazamos cualquier carácter que NO sea letra (\p{L}), número (\p{N}) o espacio (\s) por un espacio.
$textoLimpio = preg_replace('/[^\p{L}\p{N}\s]+/u', ' ', $minusculas);

// 3. Separar el texto en palabras individuales (tokenización)
$palabras = preg_split('/\s+/', $textoLimpio, -1, PREG_SPLIT_NO_EMPTY);
// Ahora $palabras es un array de todas las palabras (separadas por espacios) en el texto, en minúsculas y sin puntuación.

// 4. Filtrar las stop words (palabras vacías comunes que no interesan en el conteo)
$stopwords = [
    "de","la","que","el","en","y","a","los","del","se","las","por","un","para","con",
    "no","una","su","al","lo","como","más","pero","sus","le","ya","o","este","es","sí",
    "porque","esta","entre","cuando","muy","sin","sobre","también","me","hasta","hay",
    "donde","quien","desde","todo","nos","durante","todos","uno","les","ni","contra",
    "otros","ese","esa","eso","ante","ellos","e","esto","mí","antes","algunos","qué",
    "unos","yo","otro","otras","otra","él","tanto","esa","estos","mucho","quienes",
    "nada","muchos","cuales","poco","ella","estar","estas","algo","nosotros","mi",
    "mis","tú","te","ti","tu","tus","ellas","nosotras","vosotros","vosotras","si",
    "cierto"
];
// Nota: Esta es una lista parcial de stop words en español basada en fuentes comunes&#8203;:contentReference[oaicite:9]{index=9}.
// Se pueden agregar más palabras a la lista según el enlace proporcionado u otras listas reconocidas de palabras vacías.

$palabrasFiltradas = [];
foreach ($palabras as $palabra) {
    if ($palabra === '' || in_array($palabra, $stopwords)) {
        // Si la palabra está vacía (cadena vacía) o es una stop word, la saltamos
        continue;
    }
    $palabrasFiltradas[] = $palabra;
}

// 5. Contar la frecuencia de cada palabra en $palabrasFiltradas
$frecuencias = [];  // array asociativo: palabra -> conteo
foreach ($palabrasFiltradas as $palabra) {
    if (isset($frecuencias[$palabra])) {
        $frecuencias[$palabra]++;       // si ya existe en el array, incrementar contador
    } else {
        $frecuencias[$palabra] = 1;     // si no existe, iniciarlo en 1
    }
}

// 6. Ordenar las palabras por frecuencia de mayor a menor
arsort($frecuencias);  // ordena el array asociativo por valores en orden descendente, manteniendo la asociación con la palabra

// 7. Preparar el resultado en formato JSON
$resultado = [];  // será un array de objetos con palabra y frecuencia
foreach ($frecuencias as $palabra => $count) {
    $resultado[] = ["palabra" => $palabra, "frecuencia" => $count];
}

// 8. Devolver el JSON resultante
header('Content-Type: application/json');            // indicar al cliente que se responde con JSON
echo json_encode($resultado);
?>