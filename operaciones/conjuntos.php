<?php
class conjuntos
{
    private array $eleA;
    private array $eleB;

    public function __construct(array $eleA, array $eleB)
    {
        // elimina copiasreorganiza los índices y guarda el resultado
        $this->eleA = array_values(array_unique($eleA));
        $this->eleB = array_values(array_unique($eleB));
    }

    public function obtenerUnion(): array
    {
        return array_values(array_unique(array_merge($this->eleA, $this->eleB)));
    }

    public function obtenerInterseccion(): array
    {
        return array_values(array_intersect($this->eleA, $this->eleB));
    }

    // A-B
    public function obtenerDiferenciaAB(): array
    {
        return array_values(array_diff($this->eleA, $this->eleB));
    }

    public function obtenerDiferenciaBA(): array
    {
        return array_values(array_diff($this->eleB, $this->eleA));
    }
}

// de texto a lista, corta el texto en , trim de cada pedaxo y quita los espacios vacios
function convertirALista(string $texto): array
{
    return array_values(array_filter(array_map('trim', explode(',', $texto)), 'strlen'));
}

// 
function formatearConjunto(array $elementos): string
{
    //array entexto y separa las comas
    return empty($elementos) ? "Vacio" : "{ " . implode(", ", $elementos) . " }";
}

$entradaA = trim($_POST['conjuntoA'] ?? '');
$entradaB = trim($_POST['conjuntoB'] ?? '');
$mensajeError = "";
$operaciones = null;

if ($entradaA !== '' || $entradaB !== '') {
    $listaA = convertirALista($entradaA);
    $listaB = convertirALista($entradaB);

    if (empty($listaA) && empty($listaB)) {
        $mensajeError = "Ingrese elementos separados por comas en al menos un conjunto.";
    } else {
        $calculo = new conjuntos($listaA, $listaB); //arma el array 
        $operaciones = [
            "Unión (A ∪ B)" => $calculo->obtenerUnion(),
            "Intersección (A ∩ B)" => $calculo->obtenerInterseccion(),
            "Diferencia (A - B)" => $calculo->obtenerDiferenciaAB(),
            "Diferencia (B - A)" => $calculo->obtenerDiferenciaBA(),
        ];
    }
}
