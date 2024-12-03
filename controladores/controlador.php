<?php
        include '../config/conexion.php';
        $pdo = new Conexion();
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
           if(isset($_GET['id'])){
                $sql = $pdo->prepare("select * from productos where id = :id and estado = 1");
                $sql->bindValue(':id', $_GET['id']);
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                header("HTTP/1.1 200 OK");
                echo json_encode($sql->fetchall());
                exit;
           }else{  
                $sql = $pdo->prepare("select * from productos where estado = 1");
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                header("HTTP/1.1 200 OK");
                echo json_encode($sql->fetchall());
                exit;
           }
        }
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $entityBody = json_decode(file_get_contents('php://input'),true); //obtiene el body del request, obtiene el json y lo convierte en objeto 
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
            exit;
         }  
?>