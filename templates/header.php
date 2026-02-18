<?php
session_start();

    require_once($_SERVER['DOCUMENT_ROOT'] . "/porfolio/includes/funciones.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/porfolio/includes/conexion.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto Entorno Servidor</title>
    <link rel="stylesheet" href="/porfolio/static/css/style.css">
</head>

<body>
    
    <header>
        <h1>PORTFOLIO <?php
        ?></h1>
        <ul>
            <a href="/porfolio/index.php"><li>Inicio</li></a>
            <a href="/porfolio/proyectos.php"><li>Proyectos</li></a>
            <a href="/porfolio/contacto.php"><li>Contacto</li></a>
            <li id="categorias">                
                    <?php
                    echo generarSelect($conexion,'categorias', 'nombre', 'categorias', '/porfolio/proyectos.php');
                    ?>
            </li>
            <?php
            if(empty($_SESSION)){
            ?>
            <a href="/porfolio/login.php"><li>Login</li></a>
            <?php
            }else{
                if($_SESSION["rol"] == "admin"){
                ?>
                <a href="/porfolio/admin/panel.php"><li>Panel Admin</li></a>
                <?php
                }
            ?>
            <a class="logout" href="/porfolio/logout.php"><li>Cerrar Sesion</li></a>
            
            <?php
            }
            ?>
        </ul>
    </header>