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
                Este arbol binario funciona a partir de dos de los tres tipos de recorridos disponibles. Para obtener un resultado correcto, es necesario completar como minimo dos de los siguientes campos: preorden, inorden o postorden.
                Los nombres de los nodos deben ingresarse separados unicamente por comas (,), sin espacios ni otros caracteres. Por ejemplo: A,B,D,E,C.
                Es importante ingresar los elementos en el orden correspondiente a cada recorrido, ya que un orden incorrecto puede generar resultados erroneos o impedir la reconstruccion adecuada del arbol binario.
            </p>
            <p>
                Los valores deben ser Unicos y corresponder al mismo arbol.
            </p>
        </div>
        <form action="#resultado" method="POST">
            <div>
                <label>Recorrido en preorden: </label>

                <input class="calc-historial"
                    type="text"
                    name="preorden"
                    value="<?= htmlspecialchars($entradaPre, ENT_QUOTES, 'UTF-8') ?>"
                    placeholder="Ejemplo: A,B,D,E,C">
            </div>
            <div>
                <label>Recorrido en inorden: </label>

                <input class="calc-historial"
                    type="text"
                    name="inorden"
                    value="<?= htmlspecialchars($entradaIn, ENT_QUOTES, 'UTF-8') ?>"
                    placeholder="Ejemplo: D,B,E,A,C">
            </div>
            <div>
                <label>Recorrido en postorden: </label>
                <input class="calc-historial"
                    type="text"
                    name="postorden"
                    value="<?= htmlspecialchars($entradaPost, ENT_QUOTES, 'UTF-8') ?>"
                    placeholder="Ejemplo: D,E,B,C,A">
            </div>
            <div class="menu-apps">
                <button type="submit">Construir árbol</button>
            </div>
        </form>
        <div>
            <?php if ($mensajeError !== ""): ?>
                <h2><?= htmlspecialchars($mensajeError, ENT_QUOTES, 'UTF-8') ?></h2>
            <?php elseif ($arbolFin !== null): ?>
                <p>Resultado del arbol binario</p>
                <?php imprimirArbol($arbolFin); ?>
            <?php endif; ?>
        </div>
        <div class="menu-apps">
            <a href="../index.html">VOLVER AL MENU</a>
        </div>
    </div>
</body>

</html>