<?php
require_once("templates/header.php");
?>

<main id="main-proyectos">
    <?php
    if(!isset($_GET["categorias"]) || $_GET["categorias"] == "todas"){
        echo mostrarProyectos($conexion);
    }else
    echo mostrarProyectos($conexion, idCategoria($conexion, $_GET["categorias"]));
    ?>
</main>

<?php
require_once("templates/footer.php");
?>