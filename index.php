<?php
if(isset($_GET["categorias"])){
    $cat = $_GET["categorias"];
    header('Location:proyectos.php?categorias=' . $cat);
}
    
setcookie("visitas", 0, time()+3600*24*30);

require_once("templates/header.php");
?>
<main id="index">
    <h1>Porfolio de Álvaro Cutillas</h1>
    <img src="static/img/logo.jpg" alt="Logo">
</main>
<?php
require_once("templates/footer.php");
?>
