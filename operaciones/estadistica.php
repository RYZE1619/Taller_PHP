<?php
class estadistica
{
    private array $datos;

    public function __construct(array $datos)
    {
        $this->datos = $datos;
    }

    public function promedio(): float
    {
        if (empty($this->datos)) return 0;
        return array_sum($this->datos) / count($this->datos);
    }

    public function mediana(): float
    {
        if (empty($this->datos)) return 0;

        $datosOrdenados = $this->datos;
        sort($datosOrdenados);
        $cantidadDatos = count($datosOrdenados);

        // (int) evita que el índice llegue como decimal en PHP 8+
        $indiceMedio = (int) floor(($cantidadDatos - 1) / 2);

        if ($cantidadDatos % 2 == 0) {
            // Cantidad par: promedio de los dos valores centrales
            return ($datosOrdenados[$indiceMedio] + $datosOrdenados[$indiceMedio + 1]) / 2.0;
        }
        return $datosOrdenados[$indiceMedio];
    }

    public function moda(): array
    {
        if (empty($this->datos)) return [];

        // array_count_values solo cuenta int o string, por eso se pasan los decimales a texto
        $frecuencias = array_count_values(array_map('strval', $this->datos));
        $mayorFrecuencia = max($frecuencias);

        // Si ningún valor se repite, no hay moda
        if ($mayorFrecuencia === 1) return [];

        $listaModas = [];
        foreach ($frecuencias as $valor => $repeticiones) {
            if ($repeticiones === $mayorFrecuencia) {
                $listaModas[] = $valor; // Puede haber más de una moda (bimodal)
            }
        }
        return $listaModas;
    }
}

$entradaDatos = trim($_POST['datos'] ?? '');
$listaDatos = [];
$mensajeError = "";

if ($entradaDatos !== '') {
    // Separa por comas, quita espacios y descarta los vacíos (por ejemplo "1,2,")
    $partes = array_filter(array_map('trim', explode(',', $entradaDatos)), 'strlen');

    foreach ($partes as $parte) {
        if (!is_numeric($parte)) {
            $mensajeError = "Solo se permiten números separados por comas (use punto para decimales).";
            $listaDatos = [];
            break;
        }
        $listaDatos[] = $parte + 0; // "5" pasa a int y "2.5" pasa a float
    }

    if ($mensajeError === "" && empty($listaDatos)) {
        $mensajeError = "Ingrese al menos un número.";
    }
}

$resultadoPromedio = null;
$resultadoMediana = null;
$resultadoModa = [];

if (!empty($listaDatos)) {
    $calculo = new estadistica($listaDatos);
    $resultadoPromedio = round($calculo->promedio(), 2);
    $resultadoMediana = round($calculo->mediana(), 2);
    $resultadoModa = $calculo->moda();
}
