<?php
class estadistica
{
    private array $datos;

    public function __construct(array $datos)
    {
        $this->datos = $datos; // propiedad
    }

    public function promedio(): float //evita la divicion por cero
    {
        if (empty($this->datos)) return 0;
        return array_sum($this->datos) / count($this->datos); //suma y cuenta cuantos tiene
    }

    public function mediana(): float
    {
        if (empty($this->datos)) return 0;

        $datosOrdenados = $this->datos;
        sort($datosOrdenados); // ordena de m a M y cuenta,copia
        $cantidadDatos = count($datosOrdenados);

        // pocicion que se asemeja a busqueda que empieza de 0 redondea
        $indiceMedio = (int) floor(($cantidadDatos - 1) / 2);

        if ($cantidadDatos % 2 == 0) {
            return ($datosOrdenados[$indiceMedio] + $datosOrdenados[$indiceMedio + 1]) / 2.0;
        }
        return $datosOrdenados[$indiceMedio];
    }

    public function moda(): array
    {
        if (empty($this->datos)) return [];

        // convertir de numero a texto y luego cuenta cuantas veces aparece
        $frecuencias = array_count_values(array_map('strval', $this->datos));
        $mayorFrecuencia = max($frecuencias);

        // condicional si no se revite valor
        if ($mayorFrecuencia === 1) return [];

        $listaModas = [];
        foreach ($frecuencias as $valor => $repeticiones) { //recorre frecuencias y guarda los valores >
            if ($repeticiones === $mayorFrecuencia) {
                $listaModas[] = $valor; // Puede haber más de una moda (bimoda)
            }
        }
        return $listaModas;
    }
}

$entradaDatos = trim($_POST['datos'] ?? '');
$listaDatos = [];
$mensajeError = "";

if ($entradaDatos !== '') {
    //E corta text(,) A quita espacios y luego descarta pedazo
    $partes = array_filter(array_map('trim', explode(',', $entradaDatos)), 'strlen');

    foreach ($partes as $parte) { //guarda temporalmente los elementos
        if (!is_numeric($parte)) { // comprovacion y convierte texto a numero
            $mensajeError = "Solo se permiten números separados por comas (use punto para decimales).";
            $listaDatos = [];
            break;
        }
        $listaDatos[] = $parte + 0;
    }

    if ($mensajeError === "" && empty($listaDatos)) {
        $mensajeError = "Ingrese al menos un número.";
    }
}

$resultadoPromedio = null;
$resultadoMediana = null;
$resultadoModa = [];

if (!empty($listaDatos)) { // se crea el objeto y se guarda , redondea, se guarda el objeto en una variable
    $calculo = new estadistica($listaDatos);
    $resultadoPromedio = round($calculo->promedio(), 2);
    $resultadoMediana = round($calculo->mediana(), 2);
    $resultadoModa = $calculo->moda();
}
