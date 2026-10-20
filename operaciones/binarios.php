<?php
class convertidorNumeros
{

    public function enteroABinario(int $numero): string
    {
        if ($numero === 0) return "0";

        $binario = "";
        $temporal = abs($numero);

        while ($temporal > 0) {
            $residuo = $temporal % 2;
            $binario = $residuo . $binario; // Concatena el residuo al inicio
            $temporal = floor($temporal / 2);
        }

        return $numero < 0 ? "-" . $binario : $binario;
    }
}
