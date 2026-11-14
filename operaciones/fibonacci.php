<?php
class secuenciaFibonacci
{
    // metodo que recibe y devulve el arrglo genera la serie de fibonacci 
    public function genera(int $cantidad): array
    {
        //casos especiales de0 y 1
        if ($cantidad <= 0) return [];
        if ($cantidad === 1) return [0];

        $secuencia = [0, 1];
        for ($posicion = 2; $posicion < $cantidad; $posicion++) {
            //empieza la suma de terminos de los dos anteriores
            $secuencia[] = $secuencia[$posicion - 1] + $secuencia[$posicion - 2];
        }
        return $secuencia;
    }
}
//n de formulario y prepara dos variables vacias una la serie y otra para posible error
$entradaCantidad = trim($_POST['cantidad'] ?? '');
$serieFinal = [];
$mensajeError = "";

if ($entradaCantidad !== '') {
    // valida la entrada, comprueba que sea un entero(1 a 99) 
    $cantidadValida = filter_var($entradaCantidad, FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1, 'max_range' => 90]
    ]);

    if ($cantidadValida === false) { //condicional de si falla la validacion / mismo dato y mismo tipo de variable
        $mensajeError = "Ingrese un número entero entre 1 y 90.";
    } else {
        $serieFinal = (new secuenciaFibonacci())->genera($cantidadValida);
        //calcula la serie con la cantidad de terminos y guarda el arreglo que luego se imprime
    }
}
