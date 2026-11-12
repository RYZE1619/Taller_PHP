<?php
class convertidorNumeros
{
    public function enteroABinario(int $numeroDecimal): string
    {
        if ($numeroDecimal === 0) return "0";

        $cadenaBinaria = "";
        $valorRestante = abs($numeroDecimal);

        while ($valorRestante > 0) {
            $bit = $valorRestante % 2; // El residuo de dividir entre 2 es el siguiente bit
            $cadenaBinaria = $bit . $cadenaBinaria; // Se antepone: los bits salen de derecha a izquierda
            $valorRestante = intdiv($valorRestante, 2);
        }

        return $numeroDecimal < 0 ? "-" . $cadenaBinaria : $cadenaBinaria;
    }
}
// quita los espacios toma el numero enviado funcion trim 

$entradaNumero = trim($_POST['numero'] ?? '');
$entradaNumero = trim($_POST['numero'] ?? '');
$resultadoBinario = "";
$mensajeError = "";

if ($entradaNumero !== '') {

    // Devuelve el entero, o false si no es un entero válido =z
    $numeroValido = filter_var($entradaNumero, FILTER_VALIDATE_INT, [
        'options' => ['min_range' => -900000, 'max_range' => 900000]
    ]);

    if ($numeroValido === false) {
        $mensajeError = "Ingrese un numero entero";
    } else {
        $resultadoBinario = (new convertidorNumeros())->enteroABinario($numeroValido);
        // Crea el convertidor y guarda el número en binario
    }
}
