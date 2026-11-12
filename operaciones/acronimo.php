<?php
class Acronimo
{
    private string $textoingr;

    public function __construct(string $textoingr)
    {
        // Guarda el texto recibido en la propie del objeto
        $this->textoingr = $textoingr;
    }

    public function generar(): string
    {
        // Separa por espacios o guiones; NO_EMPTY ignora separadores repetidos (Hola--Mundo)
        $listaPalabras = preg_split('/[\s-]+/', trim($this->textoingr), -1, PREG_SPLIT_NO_EMPTY);

        $resultado = '';

        foreach ($listaPalabras as $palabra) {
            // mb_ funciona bien con tildes y ñ (Árbol, Ñandú)
            $resultado .= mb_strtoupper(mb_substr($palabra, 0, 1));
        }

        return $resultado;
    }
}

// Operador de coalescencia nula: si no llega 'frase', usa cadena vacía
$entradaFrase = trim($_POST['textoingr'] ?? '');
$acronimoFinal = '';

if ($entradaFrase !== '') {
    $acronimoFinal = (new Acronimo($entradaFrase))->generar();
}
