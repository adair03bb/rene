<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Agenda de Promedios</title>
    <link rel="stylesheet" type="text/css" href="./estilos.css">
</head>
<body>
    <?php 
    require_once("conexion.php");
    require_once("Alumno.php"); 
    ?>

    <form action="" method="post">
        <label>Nombre:</label><input type="text" name="nombre"><br>
        <label>Carrera:</label><input type="text" name="carrera"><br>
        <label>Edad:</label><input type="number" name="edad"><br>
        <br><center><input type="submit" name="boton" value="Guardar"></center>
    </form>

    <?php
    if (isset($_POST["boton"])) {
        $data = $_POST["carrera"];
        
        // Clave de cifrado
        $clave = "test-key";
        
        // Cifrado de la cadena
        $cifrado = openssl_encrypt($data, 'AES-128-CBC', $clave);
        
        $obj = new Alumno();
        $obj->alta($_POST["nombre"], $cifrado, $_POST["edad"]);
        echo "<h2>Alumno registrado!</h2>";
    }

    if (isset($_GET["ne"])) {
        $obj = new Alumno();
        $retorno = $obj->eliminar($_GET["ne"]);
        if ($retorno) {
            echo "<h2>Alumno eliminado!!</h2>";
        }
    }

    // Mostrar tabla de alumnos
    $obj = new Alumno();
    $alumnos = $obj->obtenerAlumnos();
    ?>

    <h2>Alumnos Registrados</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Carrera (Cifrado)</th>
            <th>Edad</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($alumnos as $alumno): ?>
        <tr>
            <td><?php echo $alumno['id']; ?></td>
            <td><?php echo $alumno['nombre']; ?></td>
            <td><?php echo $alumno['carrera']; ?></td>
            <td><?php echo $alumno['edad']; ?></td>
            <td><a href="?ne=<?php echo $alumno['id']; ?>">Eliminar</a></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <form action="" method="post">
        <input type="hidden" name="accion" value="desencriptar">
        <input type="submit" value="Desencriptar Información">
    </form>

    <?php
    if (isset($_POST["accion"]) && $_POST["accion"] == "desencriptar") {
        echo "<h2>Información Desencriptada</h2>";
        echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Carrera (Desencriptado)</th>
                <th>Edad</th>
            </tr>";
        foreach ($alumnos as $alumno) {
            $descifrado = openssl_decrypt($alumno['carrera'], 'AES-128-CBC', 'test-key');
            echo "<tr>
                <td>{$alumno['id']}</td>
                <td>{$alumno['nombre']}</td>
                <td>{$descifrado}</td>
                <td>{$alumno['edad']}</td>
            </tr>";
        }
        echo "</table>";
    }
    ?>

</body>
</html>
