
<?php

$primerOperando = "";
$segundoOperando = "";
$cadenaEntradaActual = $_GET["valorActual"] ?? "";

$mensajeSalidaPantalla = "";
$operadorSeleccionado = "";

$registroHistorial = $_GET["historial"] ?? [];
//envio de historial y elimina elementos que no sean texto 
if (!is_array($registroHistorial)) {
    $registroHistorial = [];
}

$registroHistorial = array_filter($registroHistorial, 'is_string');

$contenidoPantalla = $cadenaEntradaActual;
$debeCalcularResultado = false;

// Validar que la expresión no comience con un operador o igual
if ($cadenaEntradaActual !== "") {
    if (esOperacion($cadenaEntradaActual[0]) || $cadenaEntradaActual[0] == "i") {
        $cadenaEntradaActual = "";
        $contenidoPantalla = "";
        $mensajeSalidaPantalla = "Ingrese primero un número y luego una operación.";
    }
}

if ($cadenaEntradaActual !== "") {

    // Comprobar si se presionó el botón de igual
    if (substr($cadenaEntradaActual, -1) === "i") {
        $debeCalcularResultado = true;
    }

    // Buscar el operador
    $posicionOperador = false;

    for ($i = 0; $i < strlen($cadenaEntradaActual); $i++) {
        if (esOperacion($cadenaEntradaActual[$i])) {
            $posicionOperador = $i;
            break;
        }
    }

    if ($posicionOperador !== false) {

        // Obtener el operador
        $operadorOriginal = $cadenaEntradaActual[$posicionOperador];

        // Si se ingresó otro operador al final, reemplazar el anterior
        if (
            !$debeCalcularResultado &&
            esOperacion(substr($cadenaEntradaActual, -1))
        ) {

            $cadenaEntradaActual = substr_replace(
                $cadenaEntradaActual,
                substr($cadenaEntradaActual, -1),
                $posicionOperador,
                1
            );
        }

        // Separar los operandos
        $primerOperando = substr(
            $cadenaEntradaActual,
            0,
            $posicionOperador
        );

        $segundoOperando = substr(
            $cadenaEntradaActual,
            $posicionOperador + 1
        );

        $operadorSeleccionado = $cadenaEntradaActual[$posicionOperador];

        // Convertir el operador interno a su símbolo
        $operadorSeleccionado = toSimbolo($operadorSeleccionado);

        // Si el último caracter es un operador, mostrarlo
        if (
            !$debeCalcularResultado &&
            esOperacion(substr($cadenaEntradaActual, -1))
        ) {

            $contenidoPantalla = $operadorSeleccionado;
        }

        // Eliminar el símbolo de igual del segundo operando
        if ($debeCalcularResultado) {
            $segundoOperando = substr($segundoOperando, 0, -1);
        }

        // Mostrar la expresión
        $mensajeSalidaPantalla = "Salida: " .
            $primerOperando .
            $operadorSeleccionado .
            $segundoOperando;

        if ($segundoOperando !== "" && !$debeCalcularResultado) {
            $contenidoPantalla = $segundoOperando;
        }

        // Realizar el cálculo
        if ($debeCalcularResultado) {

            try {

                // Validar los operandos
                if (
                    !is_numeric($primerOperando) ||
                    !is_numeric($segundoOperando)
                ) {

                    throw new InvalidArgumentException(
                        "Los operandos deben ser números."
                    );
                }

                // Evitar división o módulo entre cero
                if (($operadorSeleccionado == "/" ||
                        $operadorSeleccionado == "%") &&
                    (float)$segundoOperando == 0
                ) {

                    throw new DivisionByZeroError(
                        "No se puede dividir entre cero."
                    );
                }

                $resultado = operar(
                    $primerOperando,
                    $segundoOperando,
                    $operadorSeleccionado
                );

                $contenidoPantalla = " = " . $resultado;

                $mensajeSalidaPantalla .= $contenidoPantalla;

                // Limitar el historial a 20 operaciones y guarda el historial
                $registroHistorial[] = $cadenaEntradaActual;
                $registroHistorial = array_slice(
                    $registroHistorial,
                    -20
                );

                $cadenaEntradaActual = "";
            } catch (Throwable $errorExcepcion) {

                $mensajeSalidaPantalla =
                    "Error: " . $errorExcepcion->getMessage();

                $contenidoPantalla = "Error";
            }
        }
    } elseif ($debeCalcularResultado) {

        $mensajeSalidaPantalla =
            "Debe ingresar una operación y dos operandos.";

        $contenidoPantalla = "Error";
    }
}


// Obtener los valores de una expresión
function getValores(string $expresionTexto): array
{
    $indiceOperadorEncontrado = false;

    for ($i = 0; $i < strlen($expresionTexto); $i++) {

        if (esOperacion($expresionTexto[$i])) {
            $indiceOperadorEncontrado = $i;
            break;
        }
    }

    if ($indiceOperadorEncontrado === false) {
        return [
            "valor1" => "",
            "valor2" => "",
            "operacion" => ""
        ];
    }

    $operandoUno = substr(
        $expresionTexto,
        0,
        $indiceOperadorEncontrado
    );

    $operandoDos = substr(
        $expresionTexto,
        $indiceOperadorEncontrado + 1
    );

    $simboloOperacion = $expresionTexto[$indiceOperadorEncontrado];

    return [
        "valor1" => $operandoUno,
        "valor2" => $operandoDos,
        "operacion" => $simboloOperacion
    ];
}


// Comprobar si un carácter representa una operación
function esOperacion(string $caracterEvaluar): bool
{
    return in_array(
        $caracterEvaluar,
        ["s", "-", "*", "/", "r"],
        true
    );
}


// Convertir los operadores internos a símbolos
function toSimbolo(string $caracterOperador): string
{
    switch ($caracterOperador) {

        case "s":
            return "+";

        case "r":
            return "%";

        default:
            return $caracterOperador;
    }
}


// Realizar las operaciones matemáticas
function operar(
    int|float|string $numeroA,
    int|float|string $numeroB,
    string $tipoOperador
): int|float {

    $numeroA = (float)$numeroA;
    $numeroB = (float)$numeroB;

    switch ($tipoOperador) {

        case '+':
            return $numeroA + $numeroB;

        case '-':
            return $numeroA - $numeroB;

        case '*':
            return $numeroA * $numeroB;

        case '/':
            if ($numeroB == 0) {
                throw new DivisionByZeroError(
                    "No se puede dividir entre cero."
                );
            }

            return $numeroA / $numeroB;

        case '%':
            if ($numeroB == 0) {
                throw new DivisionByZeroError(
                    "No se puede calcular el módulo entre cero."
                );
            }

            return fmod($numeroA, $numeroB);

        default:
            throw new InvalidArgumentException(
                "Operador no válido."
            );
    }
}


// Construir la ruta de la calculadora
function ruta(
    string $expresionEnCurso,
    string $caracterPresionado,
    array $listaHistorial
): string {

    $cadenaConcatenada = $expresionEnCurso . $caracterPresionado;

    $parametrosUrl = [
        'valorActual' => $cadenaConcatenada,
        'historial' => $listaHistorial
    ];

    return "calculadora.php?" .
        http_build_query($parametrosUrl) .
        "#pantalla";
}


// Mostrar el historial de operaciones
function mostrarHistorial(array $coleccionHistorial): void
{
    foreach ($coleccionHistorial as $expresionGuardada) {

        // Eliminar el símbolo de igual
        $expresion = substr($expresionGuardada, -1) === "i"
            ? substr($expresionGuardada, 0, -1)
            : $expresionGuardada;

        $datosDescomprimidos = getValores($expresion);

        $primerTermino = $datosDescomprimidos["valor1"];
        $segundoTermino = $datosDescomprimidos["valor2"];

        $simboloAplicado = toSimbolo(
            $datosDescomprimidos["operacion"]
        );

        if (
            !is_numeric($primerTermino) ||
            !is_numeric($segundoTermino)
        ) {
            continue;
        }

        try {

            $resultado = operar(
                $primerTermino,
                $segundoTermino,
                $simboloAplicado
            );

            echo htmlspecialchars(
                $primerTermino . $simboloAplicado .
                    $segundoTermino . "=" . $resultado
            ) . "<br>";
        } catch (Throwable $error) {
            continue;
        }
    }
}

?>
