<?php
    include_once 'conexion.php';

    session_start();

    if(isset($_SESSION['Rol'])){
        $query = 'SELECT "Nombre" FROM public."Usuario" WHERE "Rol" = ?';
        $buff = $conn->prepare($query);
        $buff->execute(array($_SESSION['Rol']));

        $nombre = $buff->fetch()['Nombre'];
    }
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenid@ a SansApp</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <b>BIENVENID@ A SANSAPP</b>
    <li><a href="index.php">Página principal</a></li>
    <?php if(!isset($_SESSION['Rol'])):?>
    <li><a href="login.php">Iniciar Sesion</a></li>
    <li><a href="signup.php">Registrarse</a></li>
    <?php else:?>
    <li><b><a href="post.php">Publicar Anuncio</a></b></li>
    <li><b><a href="cart.php">Carrito de compras</a></b></li>
    <li><a href="profile.php">Mi perfil</a></li>
    <li><a href="includes/logout.inc.php">Cerrar Sesión</a></li>
    <?php endif?>

    <br>
    <?php if(isset($_GET['signup']) and $_GET['signup'] == 'success'){
            echo '<b>¡Cuenta creada, inicia sesión para continuar!</b>';
    } else if(isset($_GET['login']) and $_GET['login'] == 'success'){
        echo '<b>¡Sesión iniciada!. Bienvenid@ '.$nombre.'.</b>';
    }
    ?>
    <br>
    <b>Encuentra lo que necesitas:</b>
    <form action="includes/search.inc.php" method="POST">
        <input type="text" name="busqueda" placeholder="Búsqueda...">
        <select name="tipo">
            <option value="p">Producto</option>
            <option value="u">Usuario</option>
            <option value="c">Categoría</option>
        </select>
        <button type="submit" name="submit-busqueda">Buscar</button>
    </form>
    <?php if(isset($_GET['error']) and $_GET['error'] == 'faltanCamposBusqueda'){
            echo '¡Error en la búsqueda!';
    }?>
</body>
</html>