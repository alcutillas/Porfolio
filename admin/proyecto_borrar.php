<?php include '../templates/header_admin.php'; 

if(!isset($_GET["id"]))
    header("Location:panel.php");


if(isset($_POST["cancelar"]))
    header("Location:panel.php");
if(isset($_POST["borrar"])){

        //Busqueda de la imagen en la carpeta
        $consulta = "SELECT imagen from proyectos where id = ?";
        $preparada = $conexion ->prepare($consulta);
        try{
            $preparada ->execute([$_GET["id"]]);
        }catch(Exception $e){
            echo "Error en la consulta de borrar";
        }
        $resul = $preparada->fetch();
        $nombreSeguro = $resul['imagen'];


        //Borrado del proyecto por id
        $consulta = "DELETE FROM proyectos where id = ?";
        $preparada = $conexion ->prepare($consulta);

        try{
            $preparada ->execute([$_GET["id"]]);
        }catch(Exception $e){
            echo "Error en la consulta de borrar";
        }


        //Borrado de la imagen
        
        $directorio = $_SERVER['DOCUMENT_ROOT'] . "/porfolio/static/img/proyectos";
        unlink($directorio . "/" . $nombreSeguro);
    
    header("Location:panel.php");
}
    

?>

<main id="borrar">
    <h1>Borrar proyecto (admin)</h1>
    <form action="" method="post">
        <label for="borrar">¿Estás seguro de que deseas borrar el proyecto<strong> Portfolio Personal </strong>(ID: <?= $_GET["id"] ?>)?</label>
        <input type="submit" class="btn-edit" value="Cancelar" name="cancelar">
        <input type="submit" class="btn-delete" value="Borrar" name="borrar">
    </form>
</main>

<?php include '../templates/footer.php'; ?>