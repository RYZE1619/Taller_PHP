<?php

require_once "../aplicacion/arbolbinario.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../aplicaciones/arbol.php");
    exit;
}

$arbol = new ArbolBinario();

$preorden = trim($_POST["preorden"] ?? "");
$inorden = trim($_POST["inorden"] ?? "");
$postorden = trim($_POST["postorden"] ?? "");

$ingresados = [];

if ($preorden !== "") {
    $ingresados["preorden"] = $preorden;
}

if ($inorden !== "") {
    $ingresados["inorden"] = $inorden;
}

if ($postorden !== "") {
    $ingresados["postorden"] = $postorden;
}

$error = "";
$seleccionados = [];

if (count($ingresados) < 2) {

    $error = "Debe ingresar al menos dos recorridos.";
} else {

    // Si ingresó los tres, elegir Preorden + Inorden.
    if (count($ingresados) === 3) {

        $seleccionados = [
            "preorden" => $preorden,
            "inorden" => $inorden
        ];
    } else {

        $seleccionados = $ingresados;
    }

    // Validar los recorridos seleccionados.
    foreach ($seleccionados as $tipo => $valor) {

        if (!$arbol->validarRecorrido($valor, $tipo)) {

            $error = "El recorrido "
                . ucfirst($tipo)
                . " no corresponde al árbol establecido.";

            break;
        }
    }
}

$recorridos = $arbol->obtenerRecorridos();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado del árbol</title>
</head>

<body>

    <h1>Resultado</h1>

    <?php if ($error !== ""): ?>

        <p><?php echo htmlspecialchars($error); ?></p>

    <?php else: ?>

        <h2>Árbol binario construido</h2>

        <pre>
            A
           / \
          B   C
         / \
        D   E
        </pre>

        <h2>Recorridos</h2>

        <?php foreach ($recorridos as $tipo => $nodos): ?>

            <p>
                <strong>
                    <?php echo ucfirst($tipo); ?>:
                </strong>

                <?php echo implode(", ", $nodos); ?>
            </p>

        <?php endforeach; ?>

        <p>
            Pareja utilizada:
            <?php
            echo implode(
                " + ",
                array_map("ucfirst", array_keys($seleccionados))
            );
            ?>
        </p>

    <?php endif; ?>

    <a href="../aplicacion/arbol.php">
        Volver al formulario
    </a>

</body>

</html>