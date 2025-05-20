<?php
// backend/ProcesadorTexto.php

/**
 * Clase ProcesadorTexto: contiene todas las funciones de procesado y actua en modo API cuando se accede via HTTP
 */
class ProcesadorTexto
{
    private array $stopWords;

    /**
     * Constructor recibe array de stop words
     */
    public function __construct(array $stopWords)
    {
        $this->stopWords = $stopWords;
    }

    /**
     * Quita tildes y dieresis del texto
     */
    public function quitarTildes(string $texto): string
    {
        $map = [
            'Á'=>'A','É'=>'E','Í'=>'I','Ó'=>'O','Ú'=>'U',
            'á'=>'a','é'=>'e','í'=>'i','ó'=>'o','ú'=>'u',
            'Ñ'=>'N','ñ'=>'n'
        ];
        return strtr($texto, $map);
    }

    /**
     * Convierte a minusculas UTF-8
     */
    public function normalizar(string $texto): string
    {
        return mb_strtolower($texto, 'UTF-8');
    }

    /**
     * Elimina todo lo que no sea letra o espacio (descarta numeros y signos)
     */
    public function limpiar(string $texto): string
    {
        return preg_replace('/[^a-z\s]+/i', ' ', $texto);
    }

    /**
     * Separa el texto en tokens (palabras)
     */
    public function tokenizar(string $texto): array
    {
        return preg_split('/\s+/', trim($texto), -1, PREG_SPLIT_NO_EMPTY);
    }

    /**
     * Filtra stop words tras quitar tildes y normalizar
     */
    public function filtrar(array $tokens): array
    {
        $resultado = [];
        foreach ($tokens as $t) {
            $sin = $this->quitarTildes($t);
            $norm = $this->normalizar($sin);
            if ($norm !== '' && !in_array($norm, $this->stopWords, true)) {
                $resultado[] = $norm;
            }
        }
        return $resultado;
    }

    /**
     * Cuenta la frecuencia de cada token
     */
    public function contar(array $tokens): array
    {
        $freq = [];
        foreach ($tokens as $t) {
            $freq[$t] = ($freq[$t] ?? 0) + 1;
        }
        arsort($freq);
        return $freq;
    }

    /**
     * Orquesta todo el pipeline de procesado
     */
    public function procesar(string $texto): array
    {
        $t = $this->quitarTildes($texto);
        $t = $this->normalizar($t);
        $t = $this->limpiar($t);
        $tokens = $this->tokenizar($t);
        $tokens = $this->filtrar($tokens);
        return $this->contar($tokens);
    }
}

// Si se accede via web (no CLI), actuamos como API REST
if (php_sapi_name() !== 'cli') {
    header('Content-Type: application/json; charset=UTF-8');

    $textoOriginal = $_POST['texto'] ?? '';
    if (trim($textoOriginal) === '') {
        echo json_encode(['error' => 'No se proporciono texto']);
        exit;
    }

    // definicion de stop words
    $sw = [
        'de','la','que','el','en','y','a','los','del','se','las','por','un','para','con',
        'no','una','su','al','lo','como','mas','pero','sus','le','ya','o','este','es','si',
        'porque','esta','entre','cuando','muy','sin','sobre','tambien','me','hasta','hay',
        'donde','quien','desde','todo','nos','durante','todos','uno','les','ni','contra',
        'otros','ese','esa','eso','ante','ellos','e','esto','mi','antes','algunos','que',
        'unos','yo','otro','otras','otra','el','tanto','esa','estos','mucho','quienes',
        'nada','muchos','cuales','poco','ella','estar','estas','algo','nosotros','mi','mis',
        'tu','te','ti','tus','ellas','nosotras','vosotros','vosotras','si','cierto'
    ];

    $proc = new ProcesadorTexto($sw);
    $freq = $proc->procesar($textoOriginal);

    // formateo de respuesta
    $out = [];
    foreach ($freq as $pal => $cnt) {
        $out[] = ['palabra' => $pal, 'frecuencia' => $cnt];
    }

    echo json_encode($out);
}
