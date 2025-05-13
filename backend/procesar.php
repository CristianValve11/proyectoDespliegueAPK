<?php
// backend/procesar.php

// ----------------------------------------------------------------------------
// Cabeceras CORS y salida JSON
// ----------------------------------------------------------------------------
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

/**
 * Clase ProcesadorTexto:
 * Procesa un texto: quita tildes, pasa a minúsculas, elimina no-letras,
 * tokeniza, filtra stop words y cuenta la frecuencia de palabras.
 */
class ProcesadorTexto
{
    private array $stopWords;

    /**
     * Constructor: recibe lista de stop words en minúsculas.
     */
    public function __construct(array $stopWords)
    {
        $this->stopWords = $stopWords;
    }

    /**
     * Sustituye caracteres acentuados por sus equivalentes sin tilde.
     */
    private function quitarTildes(string $texto): string
    {
        $map = [
            'Á'=>'A','É'=>'E','Í'=>'I','Ó'=>'O','Ú'=>'U',
            'á'=>'a','é'=>'e','í'=>'i','ó'=>'o','ú'=>'u',
            'Ñ'=>'N','ñ'=>'n'
        ];
        return strtr($texto, $map);
    }

    /**
     * Convierte todo a minúsculas UTF-8.
     */
    private function normalizar(string $texto): string
    {
        return mb_strtolower($texto, 'UTF-8');
    }

    /**
     * Elimina cualquier carácter que no sea letra (a-z) o espacio.
     * Así se descartan números y signos de puntuación.
     */
    private function limpiar(string $texto): string
    {
        // /i ignora mayúsculas/minúsculas; reemplaza todo lo que no sea [a-z ] por espacio
        return preg_replace('/[^a-z\s]+/i', ' ', $texto);
    }

    /**
     * Divide el texto en palabras separadas por espacios.
     */
    private function tokenizar(string $texto): array
    {
        return preg_split('/\s+/', trim($texto), -1, PREG_SPLIT_NO_EMPTY);
    }

    /**
     * Filtra las stop words de la lista de tokens.
     */
    private function filtrar(array $tokens): array
    {
        return array_values(array_filter(
            $tokens,
            fn(string $palabra): bool =>
                $palabra !== '' && !in_array($palabra, $this->stopWords, true)
        ));
    }

    /**
     * Cuenta la frecuencia de cada palabra y devuelve
     * un array asociativo ordenado descendentemente.
     */
    private function contar(array $tokens): array
    {
        $frecuencias = [];
        foreach ($tokens as $t) {
            $frecuencias[$t] = ($frecuencias[$t] ?? 0) + 1;
        }
        arsort($frecuencias);
        return $frecuencias;
    }

    /**
     * Pipeline completo: tildes → minúsculas → limpiar → tokenizar → filtrar → contar.
     */
    public function procesar(string $textoOriginal): array
    {
        $texto = $this->quitarTildes($textoOriginal);
        $texto = $this->normalizar($texto);
        $texto = $this->limpiar($texto);
        $tokens = $this->tokenizar($texto);
        $tokens = $this->filtrar($tokens);
        return $this->contar($tokens);
    }
}

// ----------------------------------------------------------------------------
// 1. Recoger texto desde POST
// ----------------------------------------------------------------------------
$textoOriginal = $_POST['texto'] ?? '';
if (trim($textoOriginal) === '') {
    echo json_encode(["error" => "No se proporcionó texto"]);
    exit;
}

// ----------------------------------------------------------------------------
// 2. Definir stop words
// ----------------------------------------------------------------------------
$stopWords = [
    'de','la','que','el','en','y','a','los','del','se','las','por','un','para','con',
    'no','una','su','al','lo','como','mas','pero','sus','le','ya','o','este','es','si',
    'porque','esta','entre','cuando','muy','sin','sobre','tambien','me','hasta','hay',
    'donde','quien','desde','todo','nos','durante','todos','uno','les','ni','contra',
    'otros','ese','esa','eso','ante','ellos','e','esto','mi','antes','algunos','que',
    'unos','yo','otro','otras','otra','el','tanto','esa','estos','mucho','quienes',
    'nada','muchos','cuales','poco','ella','estar','estas','algo','nosotros','mi',
    'mis','tu','te','ti','tus','ellas','nosotras','vosotros','vosotras','si','cierto'
];

// ----------------------------------------------------------------------------
// 3. Procesar y obtener frecuencias
// ----------------------------------------------------------------------------
$procesador = new ProcesadorTexto($stopWords);
$frecuencias = $procesador->procesar($textoOriginal);

// ----------------------------------------------------------------------------
// 4. Formatear resultados
// ----------------------------------------------------------------------------
$salida = [];
foreach ($frecuencias as $palabra => $conteo) {
    $salida[] = ['palabra' => $palabra, 'frecuencia' => $conteo];
}

// ----------------------------------------------------------------------------
// 5. Enviar JSON al cliente
// ----------------------------------------------------------------------------
echo json_encode($salida);
