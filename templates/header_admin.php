<?php
session_start();

if($_SESSION["rol"] != "admin")
    header("Location:../login.php");

    require_once($_SERVER['DOCUMENT_ROOT'] . "/porfolio/includes/funciones.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/porfolio/includes/conexion.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto Entorno Servidor</title>
    <link rel="stylesheet" href="/porfolio/static/css/stylo.css">
</head>

<body>
    
    <header>
        <h1>PORTFOLIO <?php
        ?></h1>
        <ul>
            <a href="/porfolio/index.php"><li>Inicio</li></a>
            
            <a class="logout" href="/porfolio/logout.php"><li>Cerrar Sesion</li></a>
            
        </ul>
    </header>