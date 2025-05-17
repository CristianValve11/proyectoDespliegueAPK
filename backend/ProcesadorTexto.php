<?php
// backend/ProcesadorTexto.php

class ProcesadorTexto
{
    private array $stopWords;

    public function __construct(array $stopWords)
    {
        $this->stopWords = $stopWords;
    }

    public function quitarTildes(string $texto): string
    {
        $map = [
            'Á'=>'A','É'=>'E','Í'=>'I','Ó'=>'O','Ú'=>'U',
            'á'=>'a','é'=>'e','í'=>'i','ó'=>'o','ú'=>'u',
            'Ñ'=>'N','ñ'=>'n'
        ];
        // Devuelve siempre cadena
        return strtr($texto, $map);
    }

    public function normalizar(string $texto): string
    {
        return mb_strtolower($texto, 'UTF-8');
    }

    public function limpiar(string $texto): string
    {
        return preg_replace('/[^a-z\s]+/i', ' ', $texto);
    }

    public function tokenizar(string $texto): array
    {
        return preg_split('/\s+/', trim($texto), -1, PREG_SPLIT_NO_EMPTY);
    }

    public function filtrar(array $tokens): array
    {
        // Devuelve un array vacío si no hay tokens
        $res = array_values(array_filter(
            $tokens,
            fn(string $pal) => $pal !== '' && !in_array($pal, $this->stopWords, true)
        ));
        return $res;
    }

    public function contar(array $tokens): array
    {
        $freq = [];
        foreach ($tokens as $t) {
            $freq[$t] = ($freq[$t] ?? 0) + 1;
        }
        arsort($freq);
        return $freq;
    }

    public function procesar(string $texto): array
    {
        $texto = $this->quitarTildes($texto);
        $texto = $this->normalizar($texto);
        $texto = $this->limpiar($texto);
        $tokens = $this->tokenizar($texto);
        $tokens = $this->filtrar($tokens);
        return $this->contar($tokens);
    }
}
