<?php include 'templates/header.php'; ?>

<main class="contacto">
    <h2>Contacto</h2>
    <p class="intro">
        ¿Tienes un proyecto, una idea o simplemente quieres saludar?  
        Rellena el formulario y te responderé lo antes posible.
    </p>

    <form action="#" method="post" class="contacto-form">
        <label>
            Nombre
            <input type="text" name="nombre" required>
        </label>

        <label>
            Email
            <input type="email" name="email" required>
        </label>

        <label>
            Mensaje
            <textarea name="mensaje" rows="5" required></textarea>
        </label>

        <button type="submit">Enviar mensaje</button>
    </form>
</main>

<?php include 'templates/footer.php'; ?>