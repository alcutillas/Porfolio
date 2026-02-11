<?php
    include 'templates/header.php';
?>

<main class="contacto">
    <h2>Registro</h2>
    
    <form action="" method="post" class="contacto-form">
        <?php
        if(isset($_POST["user"]) && isset($_POST["contra"])){
        if($_POST["user"] == "admin" && $_POST["contra"] == "1234"){
            $_SESSION["rol"] = "admin";
            header("Location:index.php");
        }else{
            echo "<strong style=color:red>Datos incorrectos</strong>";
        }

    }
    ?>
        <label>
            Usuario
            <input type="text" name="user" required>
        </label>

        <label>
            Contraseña
            <input type="password" name="contra" required>
        </label>

        <button type="submit">Iniciar sesión</button>
    </form>
</main>

<?php include 'templates/footer.php'; ?>