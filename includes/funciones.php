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

    


function tecnologiasProyecto($conexion, $proyecto_id) {

    $sql = "SELECT t.nombre 
            FROM tecnologias t
            INNER JOIN proyecto_tecnologia pt 
                ON t.id = pt.tecnologia_id
            WHERE pt.proyecto_id = ?";

    $stmt = $conexion->prepare($sql);
    $stmt->execute([$proyecto_id]);

    return implode(", ", $stmt->fetchAll(PDO::FETCH_COLUMN));
}


?>
