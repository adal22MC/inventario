<?php
    session_start();
    if ( isset($_SESSION['username'])){
        header('Location: admin.php');
    }

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <?php include('include/cabezera.php'); ?>
</head>

<body class="bg-dark">

    <div class="container pt-4">
        <div class="row justify-content-md-center  mt-5">
            <div class="col-sm-11 col-ms-12 col-lg-6" id="contenedor">
                <div class="card border-0">
                    <div class="card-header text-center">
                        <img src="dist/img/avatar5.png" alt="logo">
                    </div>
                    <div class="card-body form">
                        <form id="formIngresar">
                            <div class="form-group">
                                <input name="usuario" id="username" class="form-control text" type="text" placeholder="Username" required>
                            </div>
                            <div class="form-group">
                                <input name="pass" id="password" class="form-control text" type="password" placeholder="Password" required>
                            </div>
                            <button id="entrar" type="submit" class="btn btn-block btn-primary">Acceder</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <?php include('include/scripts.php'); ?>
    <script src="dist/js/pages/login.js"></script>
    

</body>

</html>