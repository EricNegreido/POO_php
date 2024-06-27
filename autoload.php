<!-- con este archivo conseguimos cargar las clases automaticamemte en vez de una por una
Cuando una nueva clase se inicializa y no existe, el nombre de la clase se pasa al autoloader y este es ejecutado. -->

<?php

// obtiene los nombres de las clases
spl_autoload_register(function($clase){
  // __DIR__ obtiene el directorio actual del que se esta ejecutando  

  $archivo = __DIR__."/".$clase.".php";
  $archivo = str_replace("\\","/", $archivo);

  if(is_file($archivo)){
      require_once $archivo;
  }
});