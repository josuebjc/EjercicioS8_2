<?php
        include '../config/conexion.php';
        $pdo = new Conexion();
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
           if(isset($_GET['id'])){
                $sql = $pdo->prepare("select * from promocion where idProd = :id");
                $sql->bindValue(':id', $_GET['id']);
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                header("HTTP/1.1 200 OK");
                echo json_encode($sql->fetchall());
                exit;
           }else{  
                $sql = $pdo->prepare("select * from promocion");
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                header("HTTP/1.1 200 OK");
                echo json_encode($sql->fetchall());
                exit;
           }
        }
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $sql = "insert into promocion (`idProd`, `idProm`, `Descripcion`, `Descuento`,  `Aumento`)
                    values(:idProd,  :idProm,  :Descripcion,  :Descuento,  :Aumento);";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':idProd', $_POST['idProd']);
            $stmt->bindValue(':idProm', $_POST['idProm']);
            $stmt->bindValue(':Descripcion', $_POST['Descripcion']);
            $stmt->bindValue(':Descuento', $_POST['Descuento']);
            $stmt->bindValue(':Aumento', $_POST['Aumento']);
            $stmt->execute();
            $idPost = $pdo->lastInsertId();
            if($idPost){
                header("HTTP/1.1 200 OK");
                echo json_encode($idPost);
                exit;
            }
        }
?>