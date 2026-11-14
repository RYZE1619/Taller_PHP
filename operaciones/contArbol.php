<?php
require_once __DIR__ . "/nodo.php";

// Recibir y limpiar los datos del formulario
$entradaPre = trim($_POST["preorden"] ?? "");
$entradaIn = trim($_POST["inorden"] ?? "");
$entradaPost = trim($_POST["postorden"] ?? "");

$listaPre = [];
$listaIn = [];
$listaPost = [];
$arbolFin = null;
$mensajeError = "";

// Convertir los textos en array
if ($entradaPre !== "") {
    $listaPre = separarElementos($entradaPre);
}

if ($entradaIn !== "") {
    $listaIn = separarElementos($entradaIn);
}

if ($entradaPost !== "") {
    $listaPost = separarElementos($entradaPost);
}

// Contar cuántos recorridos fueron ingresados
$cantidadDatos = count(array_filter([
    $entradaPre,
    $entradaIn,
    $entradaPost
], fn($dato) => $dato !== ""));

if ($cantidadDatos < 2) {
    $mensajeError = "Debe ingresar al menos dos recorridos.";
} else {
    $datosValidos = true;

    foreach ([$listaPre, $listaIn, $listaPost] as $lista) {
        // array_unique elimina los elemento repetidos que sean diferentes 
        if (count($lista) !== count(array_unique($lista))) {
            $datosValidos = false;
        }
    }

    // Comprobar que los recorridos de dos en dos tienen que estar las mismas letras
    if ($datosValidos) {
        if ($entradaPre !== "" && $entradaIn !== "") {
            $datosValidos = mismosElementos($listaPre, $listaIn);
        }

        if ($datosValidos && $entradaIn !== "" && $entradaPost !== "") {
            $datosValidos = mismosElementos($listaIn, $listaPost);
        }

        if ($datosValidos && $entradaPre !== "" && $entradaPost !== "") {
            $datosValidos = mismosElementos($listaPre, $listaPost);
        }
    }

    if (!$datosValidos) {
        $mensajeError = "Los recorridos tienen elementos repetidos o diferentes.";
    } else {

        // Preorden e inorden permiten reconstruir el árbol
        if ($entradaPre !== "" && $entradaIn !== "") {
            $arbolFin = construirPreIn($listaPre, $listaIn);

            // Si se ingresaron los tres recorridos, comprobar que el postorden coincida
            if (
                $entradaPost !== "" &&
                obtenerPostorden($arbolFin) !== $listaPost
            ) {
                $arbolFin = null;
                $mensajeError = "El recorrido ingresado no concuerdan.";
            }
        } elseif ($entradaIn !== "" && $entradaPost !== "") {
            $arbolFin = construirInPost($listaIn, $listaPost);
        } else {
            $arbolFin = construirPrePost($listaPre, $listaPost);
        }

        if ($arbolFin === null && $mensajeError === "") {
            $mensajeError = "No fue posible construir el árbol.";
        }
    }
}

// Separar los valores introducidos por comas
function separarElementos(string $texto): array
{
    $elementos = array_map("trim", explode(",", $texto));

    // Eliminar espacios vacíos y reorganizar los índices del arreglo
    return array_values(array_filter(
        $elementos,
        fn($valor) => $valor !== ""
    ));
}

// Comparar dos listas sin importar su orden
function mismosElementos(array $lista1, array $lista2): bool
{
    // Ordenar ambas listas permite compararlas aunque tengan distinto orden
    sort($lista1);
    sort($lista2);

    return $lista1 === $lista2;
}

// Construcción utilizando preorden e inorden
function construirPreIn(array $pre, array $in): ?Nodo
{
    if (empty($pre) || empty($in)) {
        return null;
    }

    // En preorden, el primer elemento siempre es la raíz
    $valor = $pre[0];
    $posicion = array_search($valor, $in, true);

    if ($posicion === false) {
        return null;
    }

    $raiz = new Nodo($valor);

    // En inorden, los valores anteriores a la raíz son los de la izquierda
    $izquierdaIn = array_slice($in, 0, $posicion);
    $derechaIn = array_slice($in, $posicion + 1);

    // La cantidad de nodos izquierdos indica cómo dividir el preorden
    $cantidadIzq = count($izquierdaIn);

    $izquierdaPre = array_slice($pre, 1, $cantidadIzq);
    $derechaPre = array_slice($pre, $cantidadIzq + 1);

    // Repetir el proceso recursivamente para construir ambos subárboles
    $raiz->setIzquierda(construirPreIn($izquierdaPre, $izquierdaIn));
    $raiz->setDerecha(construirPreIn($derechaPre, $derechaIn));

    return $raiz;
}

// Construcción utilizando inorden y postorden
function construirInPost(array $in, array $post): ?Nodo
{
    if (empty($in) || empty($post)) {
        return null;
    }

    // En postorden, el último elemento es la raíz
    $valor = array_pop($post);
    $posicion = array_search($valor, $in, true);

    if ($posicion === false) {
        return null;
    }

    $raiz = new Nodo($valor);

    // Separar los nodos izquierdos y derechos usando la posición de la raíz
    $izquierdaIn = array_slice($in, 0, $posicion);
    $derechaIn = array_slice($in, $posicion + 1);

    $cantidadIzq = count($izquierdaIn);

    // Dividir postorden según la cantidad de nodos de cada lado
    $izquierdaPost = array_slice($post, 0, $cantidadIzq);
    $derechaPost = array_slice($post, $cantidadIzq);

    // Construir cada subárbol mediante llamadas recursivas
    $raiz->setIzquierda(construirInPost($izquierdaIn, $izquierdaPost));
    $raiz->setDerecha(construirInPost($derechaIn, $derechaPost));

    return $raiz;
}

// Construcción utilizando preorden y postorden
function construirPrePost(array $pre, array $post): ?Nodo
{
    if (empty($pre) || empty($post)) {
        return null;
    }

    // El primer elemento de preorden representa la raíz
    $valor = $pre[0];
    $raiz = new Nodo($valor);

    if (count($pre) === 1) {
        return $raiz;
    }

    // El segundo elemento de preorden identifica la raíz del subárbol izquierdo
    $valorIzq = $pre[1];
    $posicion = array_search($valorIzq, $post, true);

    if ($posicion === false) {
        return null;
    }

    // Calcular cuántos nodos pertenecen al subárbol izquierdo
    $cantidadIzq = $posicion + 1;

    $izquierdaPre = array_slice($pre, 1, $cantidadIzq);
    $derechaPre = array_slice($pre, $cantidadIzq + 1);

    // Separar postorden en izquierda y derecha, excluyendo la raíz final
    $izquierdaPost = array_slice($post, 0, $cantidadIzq);
    $derechaPost = array_slice($post, $cantidadIzq, -1);

    // Construir los dos subárboles recursivamente
    $raiz->setIzquierda(construirPrePost($izquierdaPre, $izquierdaPost));
    $raiz->setDerecha(construirPrePost($derechaPre, $derechaPost));

    return $raiz;
}

// Obtener el recorrido postorden para verificar el resultado
function obtenerPostorden(?Nodo $nodo): array
{
    if ($nodo === null) {
        return [];
    }

    // El orden postorden es: izquierda, derecha y raíz
    return array_merge(
        obtenerPostorden($nodo->getIzquierda()),
        obtenerPostorden($nodo->getDerecha()),
        [$nodo->getValor()]
    );
}

// Organizar el árbol para mostrarlo en pantalla
function imprimirArbol(?Nodo $raiz): void
{
    if ($raiz === null) {
        return;
    }

    echo '<pre class="visualArbol">';

    $niveles = [];
    $cola = [["nodo" => $raiz, "nivel" => 0, "pos" => 0]];

    // BFS recorre el árbol por niveles, desde la raíz hacia abajo
    while (!empty($cola)) {
        $actual = array_shift($cola);
        $currNodo = $actual["nodo"];
        $nivel = $actual["nivel"];

        if ($currNodo !== null) {
            $niveles[$nivel][] = [
                "valor" => $currNodo->getValor(),
                "padre_pos" => $actual["pos"]
            ];

            // Guardar los hijos con su nivel y posición estimada
            $cola[] = ["nodo" => $currNodo->getIzquierda(), "nivel" => $nivel + 1, "pos" => $actual["pos"] * 2];
            $cola[] = ["nodo" => $currNodo->getDerecha(), "nivel" => $nivel + 1, "pos" => $actual["pos"] * 2 + 1];
        }
    }

    // Identificar el último nivel para calcular los espacios
    $maxNivel = max(array_keys($niveles));

    for ($i = 0; $i <= $maxNivel; $i++) {
        // Los espacios disminuyen a medida que se imprimen niveles inferiores
        $espacioInicial = pow(2, $maxNivel - $i + 1) - 2;
        $espacioEntre = pow(2, $maxNivel - $i + 2) - 1;

        echo str_repeat(" ", $espacioInicial);

        foreach ($niveles[$i] as $nodoData) {
            echo $nodoData["valor"] . str_repeat(" ", $espacioEntre);
        }
        echo "\n";
        // Dibujar las conexiones entre los niveles
        if ($i < $maxNivel && isset($niveles[$i + 1])) {
            echo str_repeat(" ", $espacioInicial - 1);

            for ($j = 0; $j < count($niveles[$i]); $j++) {
                echo "/ \\" . str_repeat(" ", $espacioEntre - 2);
            }

            echo "\n";
        }
    }
    echo '</pre>';
}
