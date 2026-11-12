<?php
require_once __DIR__ . "/../operaciones/fibonacci.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fibonacci</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="menu-container">
        <h2>FIBONACCI</h2>

        <form action="#res" method="post">
            <div>
                <p>¿Cuantos terminos desea ver?</p>
                <input class="calc-historial" type="number" name="cantidad" min="1" max="90"
                    placeholder="Ej: 10"
                    value="<?= htmlspecialchars($entradaCantidad, ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="menu-apps">
                <button type="submit">GENERAR SERIE</button>
            </div>
        </form>

        <div id="res">
            <?php if ($mensajeError !== ""): ?>
                <p><?= htmlspecialchars($mensajeError, ENT_QUOTES, 'UTF-8') ?></p>
            <?php elseif (!empty($serieFinal)): ?>
                <p>Los primeros <?= count($serieFinal) ?> terminos son:</p>
                <h2><?= implode(", ", $serieFinal) ?></h2>
            <?php endif; ?>
        </div>

        <div class="menu-apps">
            <a href="../index.html">VOLVER AL MENU</a>
        </div>
    </div>
</body>

</html>