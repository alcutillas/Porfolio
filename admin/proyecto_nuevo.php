<?php 
include '../templates/header_admin.php'; 

?>
<br><br><br><br>
<br>
<?php
$extensiones = ["image/jpg", "image/jpeg", "image/png"];

// Comprobamos si se ha enviado el formulario
$error = false;
if (isset($_POST['guardar'])) {

if($_POST["categoria_id"] != NULL)
$consulta = "INSERT INTO proyectos('titulo','descripcion','categoria_id','imagen') values (" . $_POST["titulo"] . "," . $_POST["descripcion"] . ", " . $_POST["categoria_id"] . ", " . $_POST["imagen"] . ")";
else
$consulta = "INSERT INTO proyectos('titulo','categoria_id','imagen') values (" . $_POST["titulo"] .", " . $_POST["categoria_id"] . ", " . $_POST["imagen"] . ")";

    // Comprobamos que el archivo existe y no tiene errores
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    
        // Comprobamos que el archivo se ha subido correctamente
        if (is_uploaded_file($_FILES['imagen']['tmp_name'])) {

            $nombreOriginal = $_FILES['imagen']['name'];
            $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);
            $nombreSeguro = uniqid() . "." . $extension;

            if (in_array($_FILES['imagen']['type'], $extensiones)) {
                    $directorio = $_SERVER['DOCUMENT_ROOT'] . "/porfolio/static/img/proyectos";
                    move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio . "/" . $nombreSeguro);
            }else{
                echo "No se permite esa extensión";
                $error = true;
            }

        }else
            $error = true;
    }else
        $error = true;

    
}



?>

<main id="editar">
    <h1>Nuevo proyecto (admin)</h1>

    <form action="" method="post" enctype="multipart/form-data">

        <label>Título</label>
        <input type="text" name="titulo" required>

        <label>Descripción</label>
        <textarea name="descripcion"></textarea>

        <label>Categoría</label>
        <select name="categoria_id">
            <?php
                $categorias = $conexion->query("SELECT * FROM categorias");
                foreach($categorias as $c){
                    $selected = ($c["id"] == $proyecto["categoria_id"]) ? "selected" : "";
                    echo "<option value='{$c["id"]}' $selected>{$c["nombre"]}</option>";
                }
            ?>
        </select>

        <label>Imagen</label>
        <input type="file" name="imagen" required>
        
        <br><br>

        <a href="panel.php" class="btn-edit" style="text-decoration:none">Cancelar</a>
        <input type="submit" class="btn-save" value="Guardar cambios" name="guardar">


    </form>
</main>



<?php include '../templates/footer.php'; ?>
