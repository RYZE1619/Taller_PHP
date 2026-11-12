<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Acronimos</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="menu-container">
        <h2>MENU DE TALLER PHP</h2>
        <form action="../operaciones/acronimo.php" method="post">
            <div>
                <label for="phrase">Ingrese una frase:</label>
                <input type="text" name="phrase" id="phrase" required>
            </div>

            <div>
                <button type="submit">crear acronimo</button>
            </div>
        </form>
    </div>
</body>

</html>