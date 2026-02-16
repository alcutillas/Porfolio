<?php
require_once("templates/header.php");
?>

<main id="main-proyectos">
    <?php
    if(!isset($_GET["categorias"]) || $_GET["categorias"] == "todas"){
        $proyectos = proyectos($conexion);
    }else
        $proyectos = proyectos($conexion, idCategoria($conexion, $_GET["categorias"]));


    $respuesta ="";
    foreach($proyectos as $p){
            $respuesta .= '<div class="proyecto">
            <h3>' . $p["titulo"] . '</h3>
            <h4>' . nombreCategoria($conexion,$p["categoria_id"]) . '</h4>
            <img src = static/img/proyectos/' . $p["imagen"] . '>
            <p>' . $p["descripcion"] . '</p>
            </div>';
        }
        ?>
        <div class="proyectos"><?= $respuesta ?></div>;
        
</main>

<?php
require_once("templates/footer.php");
?>