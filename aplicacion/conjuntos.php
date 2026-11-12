<?php
require_once __DIR__ . "/../operaciones/conjuntos.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operaciones de Conjuntos</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="menu-container">
        <h2>CONJUNTOS</h2>

        <form action="#res" method="post">
            <div>
                <p>Conjunto A (separado por comas):</p>
                <input class="calc-historial" type="text" name="conjuntoA" placeholder="Ej: 1,2,3,4"
                    value="<?= htmlspecialchars($entradaA, ENT_QUOTES, 'UTF-8') ?>">
            </div>
            <div>
                <p>Conjunto B (separado por comas):</p>
                <input class="calc-historial" type="text" name="conjuntoB" placeholder="Ej: 3,4,5,6"
                    value="<?= htmlspecialchars($entradaB, ENT_QUOTES, 'UTF-8') ?>">
            </div>
            <div class="menu-apps">
                <button type="submit">CALCULAR</button>
            </div>
        </form>

        <div id="res">
            <?php if ($mensajeError !== ""): ?>
                <p><?= htmlspecialchars($mensajeError, ENT_QUOTES, 'UTF-8') ?></p>
            <?php elseif ($operaciones !== null): ?>
                <div class="calc-historial">
                    <?php foreach ($operaciones as $titulo => $resultado): ?>
                        <p><?= htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8') ?>:
                            <?= htmlspecialchars(formatearConjunto($resultado), ENT_QUOTES, 'UTF-8') ?></p>
                    <?php endforeach; ?>
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