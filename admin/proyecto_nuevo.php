<?php 
include '../templates/header_admin.php'; 
?>

<br><br><br><br><br>

<?php
$extensiones = ["image/jpg", "image/jpeg", "image/png"];
$error = false;

if (isset($_POST['guardar'])) {

    // -------------------------
    // SUBIR IMAGEN
    // -------------------------
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {

        if (is_uploaded_file($_FILES['imagen']['tmp_name'])) {

            $nombreOriginal = $_FILES['imagen']['name'];
            $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);
            $nombreSeguro = uniqid() . "." . $extension;

            if (in_array($_FILES['imagen']['type'], $extensiones)) {

                $directorio = $_SERVER['DOCUMENT_ROOT'] . "/porfolio/static/img/proyectos";
                move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio . "/" . $nombreSeguro);

            } else {
                echo "No se permite esa extensión";
                $error = true;
            }

        } else {
            $error = true;
        }

    } else {
        $error = true;
    }

    if (!$error) {

        // -------------------------
        // INSERTAR PROYECTO
        // -------------------------
        $titulo = $_POST["titulo"];
        $descripcion = $_POST["descripcion"];
        $categoria_id = $_POST["categoria_id"];
        $imagen = $nombreSeguro;

        $insert = $conexion->prepare("
            INSERT INTO proyectos (titulo, descripcion, categoria_id, imagen)
            VALUES (?, ?, ?, ?)
        ");

        $insert->execute([$titulo, $descripcion, $categoria_id, $imagen]);

        // Obtener ID del proyecto recién creado
        $proyecto_id = $conexion->lastInsertId();

        // -------------------------
        // INSERTAR TECNOLOGÍAS
        // -------------------------
        $tecnologiasInput = $_POST["tecnologias"];
        $listaTecnologias = array_map('trim', explode(",", $tecnologiasInput));

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
            $insertRel->execute([$proyecto_id, $tec_id]);
        }

        header("Location:panel.php");
        exit;
    }
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
                    echo "<option value='{$c["id"]}'>{$c["nombre"]}</option>";
                }
            ?>
        </select>

        <label>Tecnologías (separadas por comas)</label>
        <input type="text" name="tecnologias" placeholder="Ej: PHP, JavaScript, MySQL" required>

        <label>Imagen</label>
        <input type="file" name="imagen" required>
        
        <br><br>

        <a href="panel.php" class="btn-edit" style="text-decoration:none">Cancelar</a>
        <input type="submit" class="btn-save" value="Guardar cambios" name="guardar">

    </form>
</main>

<?php include '../templates/footer.php'; ?>
