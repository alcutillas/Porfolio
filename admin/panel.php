<?php include '../templates/header.php'; 

if($_SESSION["rol"] != "admin")
    header("Location:../login.php");
?>

<main>

<?php
echo generarSelect($conexion,'categorias', 'nombre', 'categoriasAdmin'); 


if(!isset($_GET["categoriasAdmin"]) || $_GET["categoriasAdmin"] == "todas"){
        $proyectos = proyectos($conexion);
    }else
        $proyectos = proyectos($conexion, idCategoria($conexion, $_GET["categoriasAdmin"]));


    $respuesta ="";
    foreach($proyectos as $p){
            $respuesta .= '<tr>
            <td>' . $p["titulo"] . '</td>
            <td>' . nombreCategoria($conexion,$p["categoria_id"]) . '</td>
            <td>' . $p["descripcion"] . '</td>
            <td>' . tecnologiasProyecto($conexion,$p["id"]) . '</td>
            <td class=table-actions><a href=proyecto_editar.php?id='.$p["id"].'<button class=btn-edit>Editar</button></a><a href=proyecto_borrar.php?id='.$p["id"].'<button class=btn-delete>Borrar</button></a></td>
            </tr>';
        }
        ?>

<table class=table-modern>
<tr>
    <th>Título</th>
    <th>Categoría</th>
    <th>Descripción</th>
    <th>Tecnologías</th>
    <th>Acciones</th>
</tr>    
<?= $respuesta ?></table>



<a href="proyecto_borrar.php">Borrar</a>
</main>
<?php include '../templates/footer.php'; ?>