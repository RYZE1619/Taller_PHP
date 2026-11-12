<?php
class conjuntos
{
    private array $elementosA;
    private array $elementosB;

    public function __construct(array $elementosA, array $elementosB)
    {
        // array_unique elimina los repetidos; array_values reinicia los índices
        $this->elementosA = array_values(array_unique($elementosA));
        $this->elementosB = array_values(array_unique($elementosB));
    }

    public function obtenerUnion(): array      // elementos de A y B, sin repetir
    {
        return array_values(array_unique(array_merge($this->elementosA, $this->elementosB)));
    }


    // Solo los elementos que están en A y también en B
    public function obtenerInterseccion(): array
    {
        return array_values(array_intersect($this->elementosA, $this->elementosB));
    }

    // Elementos de A que no están en B
    public function obtenerDiferenciaAB(): array
    {
        return array_values(array_diff($this->elementosA, $this->elementosB));
    }

    // Elementos de B que no están en A
    public function obtenerDiferenciaBA(): array
    {
        return array_values(array_diff($this->elementosB, $this->elementosA));
    }
}

// Convierte "a, b,, c" en ['a','b','c'] (quita espacios y vacíos)
function convertirALista(string $texto): array
{
    return array_values(array_filter(array_map('trim', explode(',', $texto)), 'strlen'));
}

// Muestra el conjunto entre llaves; si está vacío, el símbolo de conjunto vacío
function formatearConjunto(array $elementos): string
{
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
        $calculo = new conjuntos($listaA, $listaB);
        $operaciones = [
            "Unión (A ∪ B)" => $calculo->obtenerUnion(),
            "Intersección (A ∩ B)" => $calculo->obtenerInterseccion(),
            "Diferencia (A - B)" => $calculo->obtenerDiferenciaAB(),
            "Diferencia (B - A)" => $calculo->obtenerDiferenciaBA(),
        ];
    }
}
