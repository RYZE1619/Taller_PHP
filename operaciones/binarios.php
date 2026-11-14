<?php
class convertidorNumeros
{
    public function enteroABinario(int $numeroDecimal): string //recibe enter, binario a texto
    {
        if ($numeroDecimal === 0) return "0"; //caso especial 0

        $cadenaBinaria = "";
        $valorRestante = abs($numeroDecimal); //valor absoluto

        while ($valorRestante > 0) {
            $bit = $valorRestante % 2;
            $cadenaBinaria = $bit . $cadenaBinaria; //guarda reciduo y lo pone al inicio de la cadena
            $valorRestante = intdiv($valorRestante, 2);
        }

        return $numeroDecimal < 0 ? "-" . $cadenaBinaria : $cadenaBinaria;
    }
}
// quita los espacios toma el numero enviado funcion trim si no llego

$entradaNumero = trim($_POST['numero'] ?? '');
$entradaNumero = trim($_POST['numero'] ?? '');
$resultadoBinario = "";
$mensajeError = "";

if ($entradaNumero !== '') {
    // comprueba si es un entero
    $numeroValido = filter_var($entradaNumero, FILTER_VALIDATE_INT, [
        'options' => ['min_range' => -900000, 'max_range' => 900000]
    ]);

    if ($numeroValido === false) {
        $mensajeError = "Ingrese un numero entero";
    } else {
        $resultadoBinario = (new convertidorNumeros())->enteroABinario($numeroValido);
        // Crea el objeto y guarda el numero en binario
    }
}
