<?php
define("OFFLINE_URL","http://localhost/Agencia");//QUITAR EL 81!!!!!!!!!
define("ONLINE_URL","https://turismoreal-2020.000webhostapp.com");
define("API_URL","http://turismoreal.xyz");
define("BASE_URL",OFFLINE_URL);
define("SRC_URL",ONLINE_URL);
define("FUNCIONES",BASE_URL.'/funciones');
define("VISTAS",BASE_URL.'/vistas');
define("IMG",SRC_URL.'/assets/img');
define("CSS",SRC_URL.'/assets/css');
define("JS",SRC_URL.'/assets/js');
define("ASSETS",SRC_URL.'/assets');
define("INCLUDES",BASE_URL.'/assets/includes');
define("VENDOR",API_URL."/recursos/boostrap/vendor");
/* RUTAS */
define("DEPTOS",VISTAS."/deptos");
define("CUENTA",VISTAS."/cuenta");
define("GESTION",VISTAS."/gestion");
//define("ERROR",VISTAS."/error");
?>