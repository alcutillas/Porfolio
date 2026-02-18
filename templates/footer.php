<footer>
    <div>
        <h3>Contacto</h3>
        <p>Álvaro Cutillas López</p>
        <p>alvcutlop@alu.edu.gva.es</p>
        <p>666 666 666</p>
    </div>
    <div>
        <h3>Porfolio</h3>
        <p>
        Desarrollos en <?php
        $sql = 'SELECT DISTINCT nombre from categorias';
            $resultado = $conexion->prepare($sql);
            $resultado->execute();

            foreach ($resultado->fetchAll(PDO::FETCH_ASSOC) as $fila) {
            echo $fila['nombre'] . " ";
            }
            
        ?>
        </p>
        <p>2025 Mi Porfolio</p>
    </div>
</footer>
</body>

</html>