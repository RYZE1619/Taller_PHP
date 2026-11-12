<?php
require_once __DIR__ . "/../operaciones/binarios.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Decimal a Binario</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="menu-container">
        <h2>DECIMAL A BINARIO</h2>

        <form action="#res" method="post">
            <div>
                <p>Ingrese un número entero:</p>
                <input class="calc-historial" type="number" name="numero" step="1" placeholder="Ej: 25"
                    value="<?= htmlspecialchars($entradaNumero, ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="menu-apps">
                <button type="submit">CONVERTIR</button>
            </div>
        </form>

        <div id="res">
            <?php if ($mensajeError !== ""): ?>
                <p><?= htmlspecialchars($mensajeError, ENT_QUOTES, 'UTF-8') ?></p>
            <?php elseif ($resultadoBinario !== ""): ?>
                <p>El número <?= htmlspecialchars($entradaNumero, ENT_QUOTES, 'UTF-8') ?> en binario es:</p>
                <h2><?= htmlspecialchars($resultadoBinario, ENT_QUOTES, 'UTF-8') ?></h2>
            <?php endif; ?>
        </div>

        <div class="menu-apps">
            <div></div>
            <a href="../index.html">VOLVER AL MENU</a>
        </div>
    </div>
</body>

</html>