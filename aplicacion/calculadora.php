<?php
require_once __DIR__ . "/../operaciones/calculadora_op.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Calculadora</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="menu-container" id="pantalla">
        <h2>CALCULADORA</h2>

        <div>
            <?php echo htmlspecialchars($mensajeSalidaPantalla); ?>
        </div>
        <div class="calc-pantalla">
            <?php echo htmlspecialchars($contenidoPantalla !== "" ? $contenidoPantalla : "0"); ?>
        </div>

        <div class="calc-teclado">
            <!-- 1Fila -->
            <a href="calculadora.php" class="limpiar">C</a>
            <a href="<?php echo ruta($cadenaEntradaActual, 'r', $registroHistorial); ?>" class="operador">%</a>
            <a href="<?php echo ruta($cadenaEntradaActual, '/', $registroHistorial); ?>" class="operador">/</a>

            <!-- 2Fila -->
            <a href="<?php echo ruta($cadenaEntradaActual, '7', $registroHistorial); ?>">7</a>
            <a href="<?php echo ruta($cadenaEntradaActual, '8', $registroHistorial); ?>">8</a>
            <a href="<?php echo ruta($cadenaEntradaActual, '9', $registroHistorial); ?>">9</a>
            <a class="operador" href="<?php echo ruta($cadenaEntradaActual, '*', $registroHistorial); ?>">*</a>

            <!-- 3Fila -->
            <a href="<?php echo ruta($cadenaEntradaActual, '4', $registroHistorial); ?>">4</a>
            <a href="<?php echo ruta($cadenaEntradaActual, '5', $registroHistorial); ?>">5</a>
            <a href="<?php echo ruta($cadenaEntradaActual, '6', $registroHistorial); ?>">6</a>
            <a class="operador" href="<?php echo ruta($cadenaEntradaActual, '-', $registroHistorial); ?>">-</a>

            <!-- 4Fila -->
            <a href="<?php echo ruta($cadenaEntradaActual, '1', $registroHistorial); ?>">1</a>
            <a href="<?php echo ruta($cadenaEntradaActual, '2', $registroHistorial); ?>">2</a>
            <a href="<?php echo ruta($cadenaEntradaActual, '3', $registroHistorial); ?>">3</a>
            <a class="operador" href="<?php echo ruta($cadenaEntradaActual, 's', $registroHistorial); ?>">+</a>

            <!-- 5Fila -->
            <a href="<?php echo ruta($cadenaEntradaActual, '0', $registroHistorial); ?>">0</a>
            <a class="igual" href="<?php echo ruta($cadenaEntradaActual, 'i', $registroHistorial); ?>">=</a>
        </div>

        <!--Historial-->
        <?php if (!empty($registroHistorial)): ?>
            <div class="calc-historial">
                <strong>Historial:</strong><br>
                <?php mostrarHistorial($registroHistorial); ?>
            </div>
        <?php endif; ?>

        <div class="menu-apps">
            <div>

            </div>
            <a href="../index.html">VOLVER AL MENU</a>
        </div>
    </div>
</body>

</html>