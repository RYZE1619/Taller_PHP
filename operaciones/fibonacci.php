<?php
class secuenciaFibonacci
{
    // Genera la serie de Fibonacci hasta la cantidad requrida
    public function fibonacci(int $n): array
    {
        if ($n <= 0) return [];
        if ($n === 1) return [0];

        $serie = [0, 1];
        for ($i = 2; $i < $n; $i++) {
            $serie[] = $serie[$i - 1] + $serie[$i - 2];
        }
        return $serie;
    }
}
