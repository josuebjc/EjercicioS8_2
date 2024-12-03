<?php
     require '../vistas/funciones.php';
     $ErrorClave = false;
     $ErrorMessage = '';
     if($_SERVER['REQUEST_METHOD']=='POST'){
         $nombre = $_POST['inputFirstName'];
         $apellido = $_POST['inputLastName'];
         $edad = $_POST['inputAge'];
         $Telefono = $_POST['inputPhone'];
         $username = $_POST['inputUsername'];
         $email = $_POST['inputEmail'];
         $clave = $_POST['inputPassword'];
         $claveConfirm = $_POST['inputPasswordConfirm'];
         if($clave != $claveConfirm){
            $ErrorClave = true;
            $tipo_banner = 'alert alert-danger';
            $ErrorMessage = 'la clave ingresada y la confirmacion son distintos';
         }else{
            $ErrorClave = false;
            $ErrorMessage = CrearUsuario($nombre, $apellido, $edad, $Telefono, $username, $email, $clave);
            if($ErrorMessage == 'success'){
                $ErrorClave = true;
               $tipo_banner = 'alert alert-success';
               $ErrorMessage = 'Registro creado exitosamente';
            }else{
                $ErrorClave = true;
                $tipo_banner = 'alert alert-danger';   
            }
         }
     } 

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Register - SB Admin</title>
        <link href="../css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Crear una cuenta</h3></div>
                                    <div class="card-body">
                                        <form id="formulario" class="was-validated" method="POST">
                                            <?php if($ErrorClave): ?>
                                                <div class="<?php echo $tipo_banner?>" role="alert">
                                                    <?php echo $ErrorMessage ?>
                                                </div>    
                                            <?php endif ?>    
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputFirstName" name="inputFirstName"  type="text" placeholder="Ingrese su nombre" required />
                                                        <label for="inputFirstName">Nombres</label>
                                                        <div class="valid-feedback">Nombre Valido</div>
                                                        <div class="invalid-feedback">Ingrese un valor</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input class="form-control" id="inputLastName" name="inputLastName" type="text" placeholder="Ingrese sus apellidos" required/>
                                                        <label for="inputLastName">Apellidos</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputAge" name="inputAge" type="number" placeholder="Ingrese su Edad" required/>
                                                        <label for="inputAge">Edad</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating">
                                                        <input class="form-control" id="inputPhone" name="inputPhone" type="phone" placeholder="Ingrese su No de Telefono" required/>
                                                        <label for="inputPhone">No. Telefono</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputUsername" name="inputUsername" type="text" placeholder="Ingrese su Username" required/>
                                                <label for="inputUsername">Username</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" name="inputEmail" type="email" placeholder="name@example.com" required/>
                                                <label for="inputEmail">Email</label>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputPassword" name="inputPassword" type="password" placeholder="Create a password" required/>
                                                        <label for="inputPassword">Password</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputPasswordConfirm" name="inputPasswordConfirm" type="password" placeholder="Confirm password" required/>
                                                        <label for="inputPasswordConfirm">Confirm Password</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 mb-0">
                                                <div class="d-grid">
                                                    <input type="submit" class="btn btn-primary btn-block" value="Crear Cuenta">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="login.php">Ya tienes una Cuenta? ir a Login</a></div>
                                    </div>   
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
    </body>
</html>