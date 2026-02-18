<?php 
include '../templates/header_admin.php'; 

if(!isset($_GET["id"]))
    header("Location:panel.php");

$id = $_GET["id"];

// Obtener datos del proyecto
$consulta = "SELECT * FROM proyectos WHERE id = ?";
$stmt = $conexion->prepare($consulta);
$stmt->execute([$id]);
$proyecto = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$proyecto)
    header("Location:panel.php");


// Si se cancela
if(isset($_POST["cancelar"]))
    header("Location:panel.php");

// Si se actualiza
if(isset($_POST["guardar"])){

$extensiones = ["image/jpg", "image/jpeg", "image/png"];

    //Busqueda de la imagen en la carpeta
        $consulta = "SELECT imagen from proyectos where id = ?";
        $preparada = $conexion ->prepare($consulta);
        try{
            $preparada ->execute([$id]);
        }catch(Exception $e){
            echo "Error en la consulta de borrar";
        }
        $resul = $preparada->fetch();
        $nombreSeguro = $resul['imagen'];
        echo $resul['imagen'];

         $directorio = $_SERVER['DOCUMENT_ROOT'] . "/porfolio/static/img/proyectos";
        unlink($directorio . "/" . $nombreSeguro);

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    
        // Comprobamos que el archivo se ha subido correctamente
        if (is_uploaded_file($_FILES['imagen']['tmp_name'])) {

            $nombreOriginal = $_FILES['imagen']['name'];
            $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);
            $nombreSeguro = uniqid() . "." . $extension;

            if (in_array($_FILES['imagen']['type'], $extensiones)) {
                    $directorio = $_SERVER['DOCUMENT_ROOT'] . "/porfolio/static/img/proyectos";
                    
                    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio . "/" . $nombreSeguro)) {
                        echo "<p>Archivo subido con éxito</p>";
                    } else {
                        echo "<p>Error al mover el archivo al directorio de destino</p>";
                    }
            }

        }
    }


    $titulo = $_POST["titulo"];
    $descripcion = $_POST["descripcion"];
    $categoria_id = $_POST["categoria_id"];
    $imagen = $nombreSeguro;


    $update = "UPDATE proyectos 
               SET titulo = ?, descripcion = ?, categoria_id = ?, imagen = ?
               WHERE id = ?";

    $stmt = $conexion->prepare($update);

    try{
        $stmt->execute([$titulo, $descripcion, $categoria_id, $imagen, $id]);
    }catch(Exception $e){
        echo "Error en la consulta de actualización";
    }

    header("Location:panel.php");
}
?>

<main id="editar">
    <h1>Editar proyecto (admin)</h1>
    <?php
    $consulta = "SELECT imagen from proyectos where id = ?";
        $preparada = $conexion ->prepare($consulta);
        try{
            $preparada ->execute([$id]);
        }catch(Exception $e){
            echo "Error en la consulta de borrar";
        }
        $resul = $preparada->fetch();
        $nombreSeguro = $resul['imagen'];
        echo $resul['imagen'];
?>
    <form action="" method="post" enctype="multipart/form-data">

        <label>Título</label>
        <input type="text" name="titulo" value="<?= $proyecto["titulo"] ?>" required>

        <label>Descripción</label>
        <textarea name="descripcion" required><?= $proyecto["descripcion"] ?></textarea>

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
        <input type="file" name="imagen" value="<?= $proyecto["imagen"] ?>">

        <br><br>

        <input type="submit" class="btn-edit" value="Cancelar" name="cancelar">
        <input type="submit" class="btn-save" value="Guardar cambios" name="guardar">

    </form>
</main>

<?php include '../templates/footer.php'; ?>
