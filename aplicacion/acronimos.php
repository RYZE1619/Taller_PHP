<?php
require_once __DIR__ . "/../operaciones/acronimo.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Acrónimos</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="menu-container">
        <h2>ACRONIMOS</h2>

        <form action="#res" method="post">
            <div>
                <p>Ingrese una frase:</p>
                <input class="calc-historial" name="textoingr" type="text" placeholder="Ej: Hola-Mundo"
                    value="<?= htmlspecialchars($entradaFrase, ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="menu-apps">
                <button type="submit">GENERAR ACRONIMO</button>
            </div>
        </form>

        <div id="res">
            <?php if ($acronimoFinal !== ""): ?>
                <p>El Acronimo de "<?= htmlspecialchars($entradaFrase, ENT_QUOTES, 'UTF-8') ?>" es:</p>
                <h2><?= htmlspecialchars($acronimoFinal, ENT_QUOTES, 'UTF-8') ?></h2>
            <?php endif; ?>
        </div>

        <div class="menu-apps">
            <a href="../index.html">VOLVER AL MENU</a>
        </div>
    </div>
</body>

</html>