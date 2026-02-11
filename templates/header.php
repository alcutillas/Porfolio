<?php
session_start();
    require_once("includes/funciones.php");
    require_once("includes/conexion.php");
    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto Entorno Servidor</title>
    <link rel="stylesheet" href="static/css/style.css">
</head>

<body>
    
    <header>
        <h1>PORTFOLIO</h1>
        <ul>
            <a href="index.php"><li>Inicio</li></a>
            <a href="proyectos.php"><li>Proyectos</li></a>
            <a href="contacto.php"><li>Contacto</li></a>
            <li id="categorias">                
                    <?php
                    echo generarSelect($conexion,'categorias', 'nombre', 'categorias');
                    ?>
            </li>
            <a href="login.php"><li>Login</li></a>
        </ul>
    </header>