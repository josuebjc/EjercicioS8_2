<?php
        include '../config/conexion.php';
        $pdo = new Conexion();
        //usando el metodo post se realizaran todas las consultas
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $entityBody = json_decode(file_get_contents('php://input'),true);
            if($entityBody['Operacion'] == 'ConsultaTotales'){
                $sql = "select count(1) as Total from productos where estado = 1;";   // 
                $sql = $pdo->prepare($sql);
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                header("HTTP/1.1 200 OK");
                echo json_encode($sql->fetchall());
            }
            if($entityBody['Operacion'] == 'Consulta'){
                $sql = "select * from productos where id = if(:id IS NULL,id,:id) and estado = 1;";   // 
                $sql = $pdo->prepare($sql);
                $sql->bindValue(':id', $entityBody['id']);
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                header("HTTP/1.1 200 OK");
                echo json_encode($sql->fetchall());
            }
            if($entityBody['Operacion'] == 'Crear'){
                $sql = "insert into productos (create_time, descripcion, cantidad, precio, modelo, marca, caracteristicas, estado)
                        values(:create_time, :descripcion, :cantidad, :precio, :modelo, :marca, :caracteristicas, :estado);";   
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':create_time', $entityBody['create_time']);
                $stmt->bindValue(':descripcion', $entityBody['descripcion']);
                $stmt->bindValue(':cantidad', $entityBody['cantidad']);
                $stmt->bindValue(':precio', $entityBody['precio']);
                $stmt->bindValue(':modelo', $entityBody['modelo']);
                $stmt->bindValue(':marca', $entityBody['marca']);
                $stmt->bindValue(':caracteristicas', $entityBody['caracteristicas']);
                $stmt->bindValue(':estado', $entityBody['estado']);
                $stmt->execute();
                $idPost = $pdo->lastInsertId();
                if($idPost){
                    header("HTTP/1.1 200 ok");
                    $Resp = '{"Registro Creado": "'.$idPost.'"'.
                        '"Resultado":"Success}"';
                    echo json_encode($Resp);
                }else{
                    header("HTTP/1.1 301 Error");
                    $Resp = '{"Registro Creado": "'.$idPost.'"'.
                        '"Resultado":"Error en procesamiento}"';
                    echo json_encode($Resp);
                }
            }    
            if($entityBody['Operacion'] == 'Actualizar' ){
                //echo 'PR: '.$entityBody['id'].' valor: '.(!empty(isset($entityBody['id'])));
                if(isset($entityBody['id'])){
                    $sql = "update productos 
                            set create_time = if(:create_time IS NULL,create_time,:create_time),
                                descripcion = if(:descripcion IS NULL,descripcion,:descripcion),
                                cantidad = if(:cantidad IS NULL,cantidad,:cantidad),
                                precio = if(:precio IS NULL,precio,:precio),
                                modelo = if(:modelo IS NULL,modelo,:modelo),
                                marca = if(:marca IS NULL,marca,:marca),
                                caracteristicas = if(:caracteristicas IS NULL,caracteristicas,:caracteristicas),
                                estado = if(:estado IS NULL,estado,:estado)
                            where id = :id;";  
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindValue(':id', $entityBody['id']);
                    $stmt->bindValue(':create_time', $entityBody['create_time']);
                    $stmt->bindValue(':descripcion', $entityBody['descripcion']);
                    $stmt->bindValue(':cantidad', $entityBody['cantidad']);
                    $stmt->bindValue(':precio', $entityBody['precio']);
                    $stmt->bindValue(':modelo', $entityBody['modelo']);
                    $stmt->bindValue(':marca', $entityBody['marca']);
                    $stmt->bindValue(':caracteristicas', $entityBody['caracteristicas']);
                    $stmt->bindValue(':estado', $entityBody['estado']);
                    $resultado = $stmt->execute();
                    if($resultado){
                        header("HTTP/1.1 200 ok");
                        $Resp = '{"Registro Actualizado": "'.$stmt->rowCount().'"'.
                            '"Resultado":"Success"}';
                        echo json_encode($Resp);
                    }else{
                        header("HTTP/1.1 301 Error");
                        $Resp = '{"Registro Actualizado": "'.$stmt->rowCount().'"'.
                            '"Resultado":"Error en procesamiento"}';
                        echo json_encode($Resp);
                    }
                }else{
                    header("HTTP/1.1 301 Error");
                        $Resp = '{"Registro Actualizado": "0"'.
                            '"Resultado":"Error el campo id es obligatorio"}';
                        echo json_encode($Resp);
                }

            }
            if($entityBody['Operacion'] == 'Borrar' ){
                //echo 'PR: '.$entityBody['id'].' valor: '.(!empty(isset($entityBody['id'])));
                if(isset($entityBody['id'])){
                    $sql = "update productos 
                            set estado = 0
                            where id = :id;";  
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindValue(':id', $entityBody['id']);
                    $resultado = $stmt->execute();
                    if($resultado){
                        header("HTTP/1.1 200 ok");
                        $Resp = '{"Registro Borrado": "'.$stmt->rowCount().'"'.
                            '"Resultado":"Success"}';
                        echo json_encode($Resp);
                    }else{
                        header("HTTP/1.1 301 Error");
                        $Resp = '{"Registro Borrado": "'.$stmt->rowCount().'"'.
                            '"Resultado":"Error en procesamiento"}';
                        echo json_encode($Resp);
                    }
                }else{
                    header("HTTP/1.1 301 Error");
                        $Resp = '{"Registro Borrado": "0"'.
                            '"Resultado":"Error el campo id es obligatorio"}';
                        echo json_encode($Resp);
                }
            }
            if($entityBody['Operacion'] == 'BorrarLista' ){
                //echo 'PR: '.$entityBody['id'].' valor: '.(!empty(isset($entityBody['id'])));
                if(isset($entityBody['id'])){
                    $sql = "update productos 
                            set estado = 0
                            where id in (".$entityBody['id'].");";  
                    $stmt = $pdo->prepare($sql);
                    $resultado = $stmt->execute();
                    if($resultado){
                        header("HTTP/1.1 200 ok");
                        $Resp = '{"Registro Borrado": "'.$stmt->rowCount().'"'.
                            '"Resultado":"Success"}';
                        echo json_encode($Resp);
                    }else{
                        header("HTTP/1.1 301 Error");
                        $Resp = '{"Registro Borrado": "'.$stmt->rowCount().'"'.
                            '"Resultado":"Error en procesamiento"}';
                        echo json_encode($Resp);
                    }
                }else{
                    header("HTTP/1.1 301 Error");
                        $Resp = '{"Registro Borrado": "0"'.
                            '"Resultado":"Error el campo id es obligatorio"}';
                        echo json_encode($Resp);
                }

            }
            exit;
         }
?>