<?php
function Login($usuario, $clave){
    try{
        //importar las credenciales /home/setup/database.php
        require '../config/database.php';
        //consulta SQL
        $sql = "select Username,nombre,edad,email,telefono 
                   from usuarios where Username = '".$usuario."' and clave = '".$clave."'  and estado = 1;";
        //Realizar la consulta
        //echo 'SQL: '.$sql;
        $consulta = mysqli_query($db, $sql);
        //acceder a los resultados
        /*echo "<pre>";
          var_dump(mysqli_fetch_assoc($consulta));
        echo "</pre>";*/
        //Cerrar la conexion (opcional)
         $resp = mysqli_fetch_assoc($consulta);
         return $resp;
        $resultado = mysqli_close($db);
        //echo $resultado;
    }catch(\Throwable $th){
        var_dump($th);
    }
}
function estaAutenticado() :bool {
    session_start();
    $auth = $_SESSION['login'];
    if($auth){
        return  true;
    }
    return false;
}
function CrearUsuario($nombre, $apellido, $edad, $Telefono, $username, $email, $clave){
    try{
        //importar las credenciales
        require '../config/database.php';
        //consulta SQL
        $sql = "select count(1) as Existe
                   from usuarios where Username = '".$username."'  and estado = 1;";
        $consulta = mysqli_query($db, $sql);
        $resp = mysqli_fetch_assoc($consulta);
        if($resp['Existe'] == 0){
            $sql1 = "insert into  usuarios (Username, nombre, edad, email, clave, telefono, create_time, estado)
                    values('$username', CONCAT('$nombre',' ','$apellido'), $edad, '$email', '$clave', '$Telefono', NOW(), 1);";
            //echo 'count:'.$sql1;
            $stmt = mysqli_query($db, $sql1);
            $count = mysqli_affected_rows($db);
            //var_dump($count);
            //if($stmt->row )
            //echo 'count:'.$count;
            if($count == 1){
                $respuesta = 'success';
            }else{
                $respuesta = 'No se pudo crear el registro';
            }
        }else{
            $respuesta = 'el Username ya existe';
        }
         return $respuesta;
        $resultado = mysqli_close($db);
        //echo $resultado;
    }catch(\Throwable $th){
        var_dump($th);
    }
}

?>