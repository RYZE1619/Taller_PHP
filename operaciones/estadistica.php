<?php
class estadistica
{
    private array $numeros;

    public function __construct(array $numeros)
    {
        $this->numeros = $numeros;
    }

    public function promedio(): float
    {
        if (empty($this->numeros)) return 0;
        return array_sum($this->numeros) / count($this->numeros);
    }

    public function mediana(): float
    {
        if (empty($this->numeros)) return 0;

        $ordenados = $this->numeros;
        sort($ordenados);
        $cantidad = count($ordenados);

        // El (int) fuerza a que el resultado sea un número entero, evitando errores en PHP 8+
        $mitad = (int) floor(($cantidad - 1) / 2);

        if ($cantidad % 2 == 0) {
            return ($ordenados[$mitad] + $ordenados[$mitad + 1]) / 2.0;
        } else {
            return $ordenados[$mitad];
        }
    }

    public function moda(): array
    {
        if (empty($this->numeros)) return [];
        $conteos = array_count_values($this->numeros); // Cuenta cuántas veces se repite cada número
        $maxRepeticiones = max($conteos);
        $modas = [];

        foreach ($conteos as $numero => $cantidad) {
            if ($cantidad === $maxRepeticiones) {
                $modas[] = $numero; // Puede haber más de una moda (bimodal)
            }
        }
        return $modas;
    }
}
