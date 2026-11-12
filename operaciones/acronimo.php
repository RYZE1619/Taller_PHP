<?php
class Acronimo
{
    private string $textoingr;

    public function __construct(string $textoingr)
    {
        // Guarda el texto recibido en la propie del objeto
        $this->textoingr = $textoingr;
    }

    public function genera(): string
    {
        // quita los espacios I y F corta el texto en pedazos PS y el PSNE descarta pedazos vacios res es un arreglo
        $listaPalabras = preg_split('/[\s-]+/', trim($this->textoingr), -1, PREG_SPLIT_NO_EMPTY);

        $resultado = '';
        foreach ($listaPalabras as $palabra) { // Array que toca pa primera letra y luego le pone en mayuscula MSPPER
            $resultado .= mb_strtoupper(mb_substr($palabra, 0, 1));
        }
        return $resultado;
    }
}
//llega lo que envio el formulario, elimina los espacios externos y condicional de vacio
$entradaFrase = trim($_POST['textoingr'] ?? '');
$acronimoFinal = '';

if ($entradaFrase !== '') {
    $acronimoFinal = (new Acronimo($entradaFrase))->genera(); //genera
}
