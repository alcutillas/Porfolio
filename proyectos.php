<?php
require_once("templates/header.php");
?>

<main id="main-proyectos">

<form action="" method="GET" class="form-buscador">
    <input 
        type="text" 
        name="buscador" 
        placeholder="Filtrar la búsqueda..."
        value="<?= $_GET['buscador'] ?? '' ?>"
        class="input-buscador"
    >
    <button type="submit" class="btn-buscar">
        Buscar
    </button>
</form>

    <?php

    // Obtener categoría
    if(!isset($_GET["categorias"]) || $_GET["categorias"] == "todas"){
        $categoria = "todas";
    } else {
        $categoria = idCategoria($conexion, $_GET["categorias"]);
    }

    // Obtener texto del buscador
    $busqueda = $_GET["buscador"] ?? null;

    // Llamar al método correctamente
    $proyectos = proyectos($conexion, $categoria, $busqueda);

    $respuesta ="";
    foreach($proyectos as $p){
        $respuesta .= '<div class="proyecto">
            <h3>' . $p["titulo"] . '</h3>
            <h4>' . nombreCategoria($conexion,$p["categoria_id"]) . '</h4>
            <img src="static/img/proyectos/' . $p["imagen"] . '">
            <p>' . tecnologiasProyecto($conexion,$p["id"]) . '</p>
            <p>' . $p["descripcion"] . '</p>
        </div>';
    }
    ?>

    <div class="proyectos"><?= $respuesta ?></div>

</main>

<?php
require_once("templates/footer.php");
?>