<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/Agencia/assets/includes/global.php';;
    include_once F_PETICION;
    $rol=5;
    if(isset($_COOKIE['rol'])){
        $rol=$_COOKIE['rol'];
    }
?>
<!DOCTYPE html>
<html lang="en" xmlns:th="http://www.thymeleaf.org">
<head>
<?php
    include F_HEAD;
    echo '<script src="'.JS.'/api_turismoreal.js"></script>';
?>
</head>
<body class="fotitio" style="background-attachment:fixed;">
<?php

include F_NAVBAR;

?>
    
    
    
    
    <form class=" text-center  formularioregistro container" style="Background-color:transparent!important" action="<?php echo FUNCIONES;?>/registro.php" method="POST">
        
        <div class="row text-center justify-content-center ">
        <div class="contenedor text-center col-xs-12  col-md-5 col-lg-4" >
        <h1 class="text-primary text-center mb-4 display-4">Registrarse</h1>

            <input class="form-control mb-3" type="text" name="rut" placeholder="Rut" id="txtRut" required/>     
            <input class="form-control mb-3" type="text" name="nombres" placeholder="Nombres" required/>
            <input class="form-control mb-3" type="text" name="apellidos" placeholder="Apellidos" required/>
            <input class="form-control mb-3" type="date" name="fnacimiento" placeholder="Fecha Nacimiento" required/>
            <input class="form-control mb-3" type="text" name="email" placeholder="Email" required/>
            <input class="form-control mb-3" type="text" name="telefono" placeholder="Telefono" required/>
            <input class="form-control mb-3" type="text" name="direccion" placeholder="Direccion" required/>
            <select class="form-control mb-3" class="form-control"  name="region" placeholder="Región" id="regiones" required> </select>
            <select class="form-control mb-3" name="comuna" placeholder="Comuna" id="comunas" required> </select>
            <select class="form-control mb-3"  name="sexo" placeholder="Sexo" id="genero" required> </select>
            <input class="form-control mb-3" type="text" name="usuario" id="usuario" placeholder="Nombre Usuario" required/>

            <span id="usuarioerror"></span>
            
                <input class="form-control" type="password" name="password" placeholder="Contraseña" required/>
            
            <input class="btn btn-primary btn-lg my-3" type="submit" value="Registrarse" class="button">
            <p class="text-primary">Al registrarte, aceptas nuestras Condiciones de uso y Política de privacidad.</p>
            <p class="text-primary">¿Ya tienes una cuenta?<a style="text-decoration:none" class="link" href="<?php echo CUENTA;?>/iniciar-sesion.php"> Iniciar Sesion</a></p>
    </div>    
        </div>
        
    </form>
    <script src="<?php echo JS;?>/jquery-3.5.1.min.js"></script>
    <script src="<?php echo JS;?>/popper.min.js" ></script>
    <script src="<?php echo JS;?>/bootstrap.min.js" ></script>
    <?php include F_FOOTER;?>
</body>
</html>
