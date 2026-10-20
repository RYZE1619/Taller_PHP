<?php
class conjuntos
{
    private array $conjuntoA;
    private array $conjuntoB;

    public function __construct(array $conjuntoA, array $conjuntoB)
    {
        // array_unique garantiza que no haya duplicados
        $this->conjuntoA = array_unique($conjuntoA);
        $this->conjuntoB = array_unique($conjuntoB);
    }

    public function obtenerUnion(): array
    {
        return array_unique(array_merge($this->conjuntoA, $this->conjuntoB));
    }

    public function obtenerInterseccion(): array
    {
        return array_intersect($this->conjuntoA, $this->conjuntoB);
    }

    public function obtenerDiferenciaAB(): array
    {
        return array_diff($this->conjuntoA, $this->conjuntoB);
    }

    public function obtenerDiferenciaBA(): array
    {
        return array_diff($this->conjuntoB, $this->conjuntoA);
    }
}
