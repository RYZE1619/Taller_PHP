<?php
require_once __DIR__ . "/../operaciones/contArbol.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">

    <title>Arbol binario</title>
</head>

<body>
    <div class="menu-container">
        <div>
            <h2>ARBOL BINARIO</h2>
            <p>
                Este árbol binario funciona a partir de dos de los tres tipos de recorridos disponibles. Para obtener un resultado correcto, es necesario completar como mínimo dos de los siguientes campos: preorden, inorden o postorden.
                Los nombres de los nodos deben ingresarse separados únicamente por comas (,), sin espacios ni otros caracteres. Por ejemplo: A,B,D,E,C.
                Es importante ingresar los elementos en el orden correspondiente a cada recorrido, ya que un orden incorrecto puede generar resultados erróneos o impedir la reconstrucción adecuada del árbol binario.</li>
            </p>
            <p>
                Los valores deben ser únicos y corresponder al mismo árbol.
            </p>
        </div>
        <form action="#resultado" method="POST">
            <div>
                <label>Recorrido en preorden:</label>

                <input
                    type="text"
                    name="preorden"
                    value="<?= htmlspecialchars($entradaPre, ENT_QUOTES, 'UTF-8') ?>"
                    placeholder="Ejemplo: A,B,D,E,C">
            </div>
            <div>
                <label>Recorrido en inorden:</label>

                <input
                    type="text"
                    name="inorden"
                    value="<?= htmlspecialchars($entradaIn, ENT_QUOTES, 'UTF-8') ?>"
                    placeholder="Ejemplo: D,B,E,A,C">
            </div>
            <div>
                <label class="subtitulo">Recorrido en postorden:</label>
                <input
                    type="text"
                    name="postorden"
                    value="<?= htmlspecialchars($entradaPost, ENT_QUOTES, 'UTF-8') ?>"
                    placeholder="Ejemplo: D,E,B,C,A">
            </div>
            <button type="submit">Construir árbol</button>
        </form>
        <div id="resultado">

            <?php if ($mensajeError !== ""): ?>

                <h2><?= htmlspecialchars($mensajeError, ENT_QUOTES, 'UTF-8') ?></h2>

            <?php elseif ($arbolFin !== null): ?>

                <h4>Resultado del árbol binario</h4>

                <?php imprimirArbol($arbolFin); ?>

            <?php endif; ?>
        </div>
    </div>
</body>

</html>