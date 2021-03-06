<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/Agencia/assets/includes/global.php';;
    include_once F_PETICION;
    ValidarLogin();
    ValidarRol(5);
    $rol=5;
    if(isset($_COOKIE['rol'])){
        $rol=$_COOKIE['rol'];
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include F_HEAD;echo '<script src="'.JS.'/api_turismoreal.js"></script>';?>
    <script src="http://momentjs.com/downloads/moment.min.js"></script>
    <script src="<?php echo JS;?>/scripts-reservar.js"></script>
</head>
<body>
<?php
    include F_NAVBAR;

    if($_GET['depaid']!=null)
    {
        $respuesta=peticion_http('http://turismoreal.xyz/api/departamento/'.$_GET['depaid'],'GET','','',CLASE_DEPARTAMENTO);
        if($respuesta['statusCode']==200){
            $depto=$respuesta['contenido'];
            $loc = (peticion_http('http://turismoreal.xyz/api/localidad/'.$depto->Id_localidad,'GET','','',CLASE_LOCALIDAD))['contenido'];
            $resserv = peticion_http('http://turismoreal.xyz/api/servicio/localidad/'.$depto->Id_localidad,'GET','',$_COOKIE['token'],LISTA_SERVICIO);
            $serv=null;
            $centros =[];
            $s=true;
            if($resserv['statusCode']==200){
                $serv=$resserv['contenido'];
                $centros = (peticion_http('http://turismoreal.xyz/api/centroturistico','GET','','',LISTA_CENTROTURISTICO)['contenido']);
            }else{
                $s=false;
            }
            $actual = IMG.'/nodispon.png';
            $fotos = peticion_http('http://turismoreal.xyz/api/Foto/'.$depto->Id_depto,'GET','','',LISTA_FOTO);
            if($fotos['statusCode']==200)
            {
                $actual = $fotos['contenido'][0]->Ruta;
            }
            $h= "un dormitorio";
            if($depto->Habitaciones>1)
            {
                $h= $depto->Habitaciones." dormitorios";
            }
            $b= "un baño";
            if($depto->Banos>1)
            {
                $b= $depto->Banos." baños";
            }
            echo '<!--INFORMACION DEPARTAMENTO -->
            <section class="info-depa" style="margin-top:80px;">
                <div class="container my-5 border rounded shadow-sm">
                <h1 class="mb-md-2 mt-md-2">Detalles del departamento</h1>
                    <div class="row mb-3 ">
                        <div class="col-xs-12 col-lg-4 ">
                            <img class="img-fluid" src="'.$actual.'" alt="Imagen depto">
                        </div>
                        <div class="col-xs-12 col-lg-5">
                        <h1>'.$depto->Nombre.'</h1>
                        <P>Departamento de '.$depto->Mts_cuadrados.' metros cuadrados, ubicado en la
                        localidad de '.$loc->Nombre.', este cuenta con '.$h.', '.$b.', cocina
                         y una amplia sala de estar.</P>
                        </div>
                        <div class="col-xs-12 col-lg-3">
                            <h3>Arriendo(diario): $'.$depto->Arriendo.'</h3>
                        </div>
                    </div>
                </div>
            </section>';
            echo '<script>arriendo='.$depto->Arriendo.';
                    idDepto='.$depto->Id_depto.';
                </script>';
            echo '<!--ESTADIA -->
            <section class="fecha-estadia">
                <div class="container border rounded shadow-sm mb-5">
                <h1>Estadia</h1>
                    <div class="row mb-3">
                        <div class="col-xs-12 col-lg-6">
                        <div class="row text-center">
                            <div class="col-6 mb-2">
                            <p>Incio Estadia</p>
                            <input class="form-control col-lg-8" id="dtI" type="date">
                            </div>
                            <div class="col-6 mb-2">
                            <p>Fin Estadia</p>
                            <input class="form-control col-lg-8" id="dtF" type="date">
                            </div>
                        </div>
                        
                        </div>
                        <div class="col-xs-12 col-lg-6">
                        <h3>Costo estadia: <span id="txtCostoEstadia">$0</span> <span id="txtDias"></span></h3>
                        </div>
                    </div>
                </div>
            </section>';
            echo '<!--ACOMPAÑANTE -->
            <section class="acompañantes">
                <div class="container border rounded shadow-sm mb-5">
                    <h1>Acompañantes</h1>
                    <div class="row mb-3">
                        <div class="col-xs-12 col-lg-12">
                            <p>Una nueva aventura se disfruta más en compañía, por eso, puedes invitar a quienes 
                    ya te han acompañado antes o agregar un nuevo compañero de aventuras.
                     Si decides tomarte un tiempo a solas no hay problema, solo deja esta sección vacía.</p>';
            $acom=true;
            $max = 'un acompañante';
            if(($depto->Habitaciones-1)>1){
                $max =($depto->Habitaciones-1).' acompañantes';
            }else if(($depto->Habitaciones-1)<=0){
                $acom=false;
            }
            if($acom){
                echo '<p class="font-weight-bold">Maximo de acompañantes determinado por la cantidad de habitaciones (Maximo de 2 acompañantes)</p>
                        </div>';
                $resacom = peticion_http('http://turismoreal.xyz/api/acompanante/usuario/'.$_COOKIE['username'],'GET','',$_COOKIE['token'],LISTA_PERSONAACOMPANANTE);
                switch($resacom['statusCode']){
                    case 200:
                        echo '<div class="input-contenedor">
                            <buttom class="btn btn-primary btn-xl text-uppercase aserv" style="width:90%;margin:0px;">Añadir Acompañante</buttom>
                            <p style="margin:0px;font-size:21px;">o</p>
                            <select id="selecta" style="width:90%;">
                                <option value="">Seleccione Acompañante</option>';
                        foreach($resacom['contenido'] as $a){
                            echo '<option value="'.$a->Acompanante->Id_acom.'">'.$a->Persona->Nombres.' '.$a->Persona->Apellidos.'</option>';
                        }
                            echo '</select>
                        </div><buttom class="btn btn-primary btn-xl text-uppercase aserv">Añadir Selección</buttom>';
                        break;
                    default:
                        echo '<div class="col-xs-12 col-lg-12">
                                <button class="btn btn-primary btn-lg">AÑADIR ACOMPAÑANTE</button>
                            </div>';
                        break;
                }
            }else{
                echo '<p class="font-weight-bold">Maximo de acompañantes determinado por la cantidad de habitaciones. 
                Este departamento solo permite una persona.</p>
                    </div>';
            }
            echo '</div>
                </div>
            </section>';
            echo '<!-- SERVICIO EXTRA-->
            <section class="servicio-extra">
                <div class="container border rounded shadow-sm mb-5">
                <h1>Servicios Extra</h1>
                    <div class="row mb-3">
                        <div class="col-xs-12 col-lg-12">
                        <p>En Turismo Real nos preocupamos de nuestros consumidores y su experiencia 
                    durante su estancia en cualquiera de nuestros departamentos. Debido a esto, es que contamos 
                    con servicios turisticos proveidos por 6 de los centros turisticos mas destacados a lo largo del país.</p>
                        <p>Puedes contratar todos los servicios diferentes que desees. Solo se permite un cupo por persona en cada servicio, debido que estos constan de un maximo de cupos mensuales.
                            Todos los acompañantes pueden contratar un cupo</p>';
                            if($s){
                                echo '</div>
                                    <div class="col-xs-12 col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-6 mb-2">
                                            <select class="form-control" id="selects">
                                                <option value="">Seleccione servicio</option>';
                                         foreach($serv as $ser){
                                             echo '<option value="'.$ser->Id_servicio.'" 
                                             data-nombre="'.$ser->Nombre.'" data-costo="'.$ser->Valor.'" data-centro="'.$ser->Id_centro.'"
                                             data-inicio="'.date('H:i',strtotime($ser->Inicio)).'" data-fin="'.date('H:i',strtotime($ser->fin)).'" 
                                            data-localidad="'.$ser->Id_localidad.'">'.$ser->Nombre.' - $'.$ser->Valor.'</option>';
                                         }
                                     echo '</select>
                                     </div>
                                     <div class="col-lg-6">
                                     <button onclick="agregarServicio()" class="btn btn-primary btn-lg">AÑADIR SELECCION</button>
                                     </div>
                                 </div>
                             </div>
                             <div class="col-xs-12 col-lg-6 mt-2 mt-lg-0">
                                 <h3>Costo Servicios: <span id="txtCostoServicios">$0</span> <span id="txtServicios"></span></h3>
                             </div>';
                                 //AQUI VAN LOS CONTENEDORES
                                 echo '</div>
                                 <div class="col-xs-12 mt-1 pb-0" id="contservicios" style="display:none;"></div>';
                            }else{
                                echo '<h3>Esta localidad no cuenta con servicios aún.<h3>';
                            }
            echo       '</div>
                </div>
            </section>';
            echo '<section class="total">
                <div class="container border rounded shadow-sm my-5">
                    <div class="row my-3">
                        <div class="col-xs-12 col-lg-6">
                            <h1>Costo total de reserva: $<span id="txtTotal">0</span></h1>   
                        </div>
                        <form method="POST" action="'.DEPTOS.'/confirmar-reserva.php" class="col-xs-12 col-lg-6 text-center text-right-lg">
                            <input type="hidden" value="" name ="json" id="sender">
                            <button class="btn btn-primary btn-lg">Continuar</button>
                        <form>
                    </div>
                </div>
            </section>';
        }
    }
include F_FOOTER;?>
 <script>
    window.onload = loadReservar();
</script>
    <script src="<?php echo JS;?>/jquery-3.5.1.min.js"></script>
    <script src="<?php echo JS;?>/popper.min.js" ></script>
    <script src="<?php echo JS;?>/bootstrap.min.js" ></script>
    <style>
    .txt-opciones{
        font-size:20px;
        margin-bottom:0%;
    }
    .cont-seleccion{
        display:inline-block;
        padding:1%;
        background-color:#ddd;
        border-radius:5px;
        margin:0% 1% 1% 0%;
        width:50%;
    }
    .t-seleccion{
        margin:0px;
    }
    .l-seleccion{
        border-color:#000;
        margin: 0px 0px 3px 0px;
    }
    .txt-seleccion, .subt-seleccion{
        margin:0% 0% 1% 0%;
    }
    .txt-seleccion{
        color:#000;
    }
    .subt-seleccion{
        color:#666;
    }
    .txt-costo{
        display:inline-block;
        margin-left:10%;
    }
</style>
</body>
</html>