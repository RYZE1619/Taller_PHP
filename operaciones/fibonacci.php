<?php
class secuenciaFibonacci
{
    // Genera la serie de Fibonacci con la cantidad de términos pedida
    public function generar(int $cantidad): array
    {
        if ($cantidad <= 0) return [];
        if ($cantidad === 1) return [0];

        $secuencia = [0, 1];
        for ($posicion = 2; $posicion < $cantidad; $posicion++) {
            // Cada término es la suma de los dos anteriores
            $secuencia[] = $secuencia[$posicion - 1] + $secuencia[$posicion - 2];
        }
        return $secuencia;
    }
}

$entradaCantidad = trim($_POST['cantidad'] ?? '');
$serieFinal = [];
$mensajeError = "";

if ($entradaCantidad !== '') {
    // filter_var devuelve false si no es un entero válido dentro del rango
    $cantidadValida = filter_var($entradaCantidad, FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1, 'max_range' => 90]
    ]);

    if ($cantidadValida === false) {
        $mensajeError = "Ingrese un número entero entre 1 y 90.";
    } else {
        $serieFinal = (new secuenciaFibonacci())->generar($cantidadValida);
    }
}
