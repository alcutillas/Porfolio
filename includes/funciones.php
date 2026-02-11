<?php
function generarSelect($conexion, $tabla, $columna, $nombreSelector, $mostrarTodas = true) {

    $seleccionado = $_GET[$nombreSelector] ?? 'todas';

    $html = "<form action='' method='get'>
             <select name='$nombreSelector' onchange=\"this.form.submit()\">\n";

    if ($mostrarTodas) {
        $selected = ($seleccionado == 'todas') ? "selected" : "";
        $html .= "<option value='todas' $selected>Categorias</option>\n";
    }

    $sql = "SELECT DISTINCT $columna FROM $tabla ORDER BY $columna";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();

    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $fila) {
        $opcion = htmlspecialchars($fila[$columna]);
        $selected = ($seleccionado == $opcion) ? "selected" : "";
        $html .= "<option value='$opcion' $selected>$opcion</option>\n";
    }

    $html .= "</select></form>\n";

    return $html;
}

    function idCategoria($conexion, $categoria){
        if($categoria == "todas")
            return "todas";
        else{
            $consulta = "SELECT id from categorias where nombre = \"" . $categoria . "\"";
            $preparada = $conexion ->prepare($consulta);
            try{
                $preparada -> execute();
            }catch(Exception $e){
                echo "Error en la consulta: " . $e->getMessage();
            }
           return $preparada ->fetchAll()[0]["id"];            
        }
    }

    function nombreCategoria($conexion, $idCategoria){
        $consulta = "SELECT nombre from categorias where id = \"" . $idCategoria . "\"";
            $preparada = $conexion ->prepare($consulta);
            try{
                $preparada -> execute();
            }catch(Exception $e){
                echo "Error en la consulta: " . $e->getMessage();
            }
           return $preparada ->fetchAll()[0]["nombre"];
    }

    function mostrarProyectos($conexion, $idCategoria = "todas"){
        $consulta = "SELECT * from proyectos";
        if($idCategoria != "todas")
            $consulta .= " where categoria_id = \"" . $idCategoria . "\"";
        $preparada = $conexion ->prepare($consulta);
        $preparada ->execute();
        
    $respuesta = "";

        $proyectos = $preparada->fetchAll();
        foreach($proyectos as $p){
            $respuesta .= '<div class="proyecto">
            <h3>' . $p["titulo"] . '</h3>
            <h4>' . nombreCategoria($conexion,$p["categoria_id"]) . '</h4>
            <img src = static/img/proyectos/' . $p["imagen"] . '>
            <p>' . $p["descripcion"] . '</p>
            </div>';
        }
        return "<div class=\"proyectos\">" .$respuesta. "</div>";
    }
?>
