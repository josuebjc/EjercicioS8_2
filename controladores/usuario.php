<?php
        include '../config/conexion.php';
        $pdo = new Conexion();
        //usando el metodo post se realizaran todas las consultas
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $entityBody = json_decode(file_get_contents('php://input'),true);
            if($entityBody['Operacion'] == 'Login'){
                $sql = "select * from usuarios where Username = :Username and clave = :clave  and estado = 1;";   // 
                $sql = $pdo->prepare($sql);
                $sql->bindValue(':Username', $entityBody['Username']);
                $sql->bindValue(':clave', $entityBody['clave']);
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                header("HTTP/1.1 200 OK");
                echo json_encode($sql->fetchall());
            }
            if($entityBody['Operacion'] == 'Consulta'){
                $sql = "select * from usuarios where Username = if(:Username IS NULL,Username,:Username) and estado = 1;";   // 
                $sql = $pdo->prepare($sql);
                $sql->bindValue(':Username', $entityBody['Username']);
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                header("HTTP/1.1 200 OK");
                echo json_encode($sql->fetchall());
            }
            if($entityBody['Operacion'] == 'Crear'){
                $sql = "insert into  usuarios (Username, nombre, edad, email, clave, telefono, create_time, estado)
                            values(:Username, :nombre, :edad, :email, :clave, :telefono, :create_time, :estado);";   
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':Username', $entityBody['Username']);
                $stmt->bindValue(':nombre', $entityBody['nombre']);
                $stmt->bindValue(':clave', $entityBody['clave']);
                $stmt->bindValue(':edad', $entityBody['edad']);
                $stmt->bindValue(':email', $entityBody['email']);
                $stmt->bindValue(':telefono', $entityBody['telefono']);
                $stmt->bindValue(':create_time', $entityBody['create_time']);
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
                    $sql = "update usuarios 
                            set nombre = if(:nombre IS NULL,nombre,:nombre),
                                clave = if(:clave IS NULL,clave,:clave),
                                edad = if(:edad IS NULL,edad,:edad),
                                email = if(:email IS NULL,email,:email),
                                telefono = if(:telefono IS NULL,telefono,:telefono),
                                create_time = if(:create_time IS NULL,create_time,:create_time),
                                estado = if(:estado IS NULL,estado,:estado)
                            where Username = :Username;";  
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindValue(':Username', $entityBody['Username']);
                    $stmt->bindValue(':nombre', $entityBody['nombre']);
                    $stmt->bindValue(':edad', $entityBody['edad']);
                    $stmt->bindValue(':email', $entityBody['email']);
                    $stmt->bindValue(':telefono', $entityBody['telefono']);
                    $stmt->bindValue(':create_time', $entityBody['create_time']);
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
                if(isset($entityBody['Username'])){
                    $sql = "update usuarios 
                            set estado = 0
                            where Username = :Username;";  
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindValue(':Username', $entityBody['Username']);
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