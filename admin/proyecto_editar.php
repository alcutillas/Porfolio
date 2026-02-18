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

// Obtener tecnologías actuales del proyecto
$consultaTec = $conexion->prepare("
    SELECT t.nombre 
    FROM tecnologias t
    INNER JOIN proyecto_tecnologia pt ON pt.tecnologia_id = t.id
    WHERE pt.proyecto_id = ?
");
$consultaTec->execute([$id]);
$tecs = $consultaTec->fetchAll(PDO::FETCH_COLUMN);
$proyecto["tecnologias"] = implode(", ", $tecs);

// Si se cancela
if(isset($_POST["cancelar"]))
    header("Location:panel.php");

// Si se actualiza
if(isset($_POST["guardar"])){

    $extensiones = ["image/jpg", "image/jpeg", "image/png"];

    // Obtener imagen actual
    $consulta = "SELECT imagen FROM proyectos WHERE id = ?";
    $preparada = $conexion->prepare($consulta);
    $preparada->execute([$id]);
    $resul = $preparada->fetch();
    $nombreSeguro = $resul['imagen'];

    // Borrar imagen anterior
    $directorio = $_SERVER['DOCUMENT_ROOT'] . "/porfolio/static/img/proyectos";
    unlink($directorio . "/" . $nombreSeguro);

    // Subir nueva imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {

        if (is_uploaded_file($_FILES['imagen']['tmp_name'])) {

            $nombreOriginal = $_FILES['imagen']['name'];
            $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);
            $nombreSeguro = uniqid() . "." . $extension;

            if (in_array($_FILES['imagen']['type'], $extensiones)) {

                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio . "/" . $nombreSeguro)) {
                    echo "<p>Archivo subido con éxito</p>";
                } else {
                    echo "<p>Error al mover el archivo al directorio de destino</p>";
                }
            }
        }
    }

    // Datos del formulario
    $titulo = $_POST["titulo"];
    $descripcion = $_POST["descripcion"];
    $categoria_id = $_POST["categoria_id"];
    $imagen = $nombreSeguro;

    // Actualizar proyecto
    $update = "UPDATE proyectos 
               SET titulo = ?, descripcion = ?, categoria_id = ?, imagen = ?
               WHERE id = ?";

    $stmt = $conexion->prepare($update);
    $stmt->execute([$titulo, $descripcion, $categoria_id, $imagen, $id]);

    // -------------------------------
    //   ACTUALIZAR TECNOLOGÍAS
    // -------------------------------

    $tecnologiasInput = $_POST["tecnologias"];
    $listaTecnologias = array_map('trim', explode(",", $tecnologiasInput));

    // Borrar relaciones anteriores
    $conexion->prepare("DELETE FROM proyecto_tecnologia WHERE proyecto_id = ?")
             ->execute([$id]);

    // Insertar nuevas tecnologías
    foreach ($listaTecnologias as $tec) {

        // Buscar si existe
        $stmt = $conexion->prepare("SELECT id FROM tecnologias WHERE nombre = ?");
        $stmt->execute([$tec]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $tec_id = $row["id"];
        } else {
            // Crear si no existe
            $insertTec = $conexion->prepare("INSERT INTO tecnologias (nombre) VALUES (?)");
            $insertTec->execute([$tec]);
            $tec_id = $conexion->lastInsertId();
        }

        // Insertar relación
        $insertRel = $conexion->prepare("
            INSERT INTO proyecto_tecnologia (proyecto_id, tecnologia_id) 
            VALUES (?, ?)
        ");
        $insertRel->execute([$id, $tec_id]);
    }

    header("Location:panel.php");
}
?>

<main id="editar">
    <h1>Editar proyecto (admin)</h1>

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

        <label>Tecnologías (separadas por comas)</label>
        <input type="text" name="tecnologias" value="<?= $proyecto["tecnologias"] ?>" required>

        <label>Imagen</label>
        <input type="file" name="imagen">

        <br><br>

        <input type="submit" class="btn-edit" value="Cancelar" name="cancelar">
        <input type="submit" class="btn-save" value="Guardar cambios" name="guardar">

    </form>
</main>

<?php include '../templates/footer.php'; ?>
