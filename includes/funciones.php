<?php
function generarSelect($conexion, $tabla, $columna, $nombreSelector, $destino = "", $mostrarTodas = true) {

    $seleccionado = $_GET[$nombreSelector] ?? 'todas';

    $html = "<form action='$destino' method='get'>
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

    function proyectos($conexion, $idCategoria = "todas"){
        $consulta = "SELECT * from proyectos";
        if($idCategoria != "todas")
            $consulta .= " where categoria_id = \"" . $idCategoria . "\"";
        $preparada = $conexion ->prepare($consulta);
        try{
            $preparada ->execute();
        }catch(Exception $e){
            echo "Error en la consulta de proyectos";
        }
        
        
        return $preparada->fetchAll();
        
    }

    function borrarProyecto($conexion, $id){
        $consulta = "DELETE FROM proyectos where id = $id";
        $preparada = $conexion ->prepare($consulta);

        try{
            $preparada ->execute();
        }catch(Exception $e){
            echo "Error en la consulta de borrar";
        }
    }

    function tecnologiasProyecto($conexion, $idproyecto){
        $consulta = "SELECT tecnologia_id FROM proyecto_tecnologia where proyecto_id = $idproyecto";
        $preparada = $conexion ->prepare($consulta);

        try{
            $preparada ->execute();
        }catch(Exception $e){
            echo "Error en la consulta de id";
        }
        $consulta = 'SELECT * FROM tecnologias where id = ' . $preparada->fetch()["tecnologia_id"];
        $preparada = $conexion ->prepare($consulta);

        try{
            $preparada ->execute();
        }catch(Exception $e){
            echo "Error en la consulta de tecnologia";
        }
        

        $respuesta = "";
        foreach($preparada->fetchAll() as $t){
            var_dump($t);
            $respuesta .= $t["nombre"] . "| ";
        }
       
        return $respuesta;
    }
?>
