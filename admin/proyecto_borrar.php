<?php include '../templates/header.php'; 

if($_SESSION["rol"] != "admin")
    header("Location:../login.php");


if(isset($_POST["cancelar"]))
    header("Location:panel.php");
if(isset($_POST["borrar"])){
    borrarProyecto($conexion, $_GET["id"]);
    header("Location:panel.php");
}
    

?>

<main id="borrar">
    <h1>Borrar proyecto (admin)</h1>
    <form action="" method="post">
        <label for="borrar">¿Estás seguro de que deseas borrar el proyecto<strong> Portfolio Personal </strong>(ID: <?= $_GET["id"] ?>)?</label>
        <input type="submit" value="Cancelar" name="cancelar">
        <input type="submit" value="Borrar" name="borrar">
    </form>
</main>

<?php include '../templates/footer.php'; ?>