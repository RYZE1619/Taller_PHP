<?php
require_once __DIR__ . "/../operaciones/estadistica.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medidas de Tendencia Central</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="menu-container">
        <h2>TENDENCIA CENTRAL</h2>

        <form action="#res" method="post">
            <div>
                <p>Ingrese los números separados por comas:</p>
                <input class="calc-historial" type="text" name="datos" placeholder="Ej: 4,8,15,16,23,42"
                    value="<?= htmlspecialchars($entradaDatos, ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="menu-apps">
                <button type="submit">CALCULAR</button>
            </div>
        </form>

        <div id="res">
            <?php if ($mensajeError !== ""): ?>
                <p><?= htmlspecialchars($mensajeError, ENT_QUOTES, 'UTF-8') ?></p>
            <?php elseif ($resultadoPromedio !== null): ?>
                <div class="calc-historial">
                    <p>Promedio: <?= $resultadoPromedio ?></p>
                    <p>Mediana: <?= $resultadoMediana ?></p>
                    <p>Moda: <?= !empty($resultadoModa) ? implode(", ", $resultadoModa) : "No hay moda" ?></p>
                </div>
            <?php endif; ?>

        </div>

        <div class="menu-apps">
            <div></div>
            <a href="../index.html">VOLVER AL MENU</a>
        </div>
    </div>
</body>

</html>