<?php
  namespace app\models;

  class viewsModel{
    protected function getViewsModel($view){
      $listaBlanca =["dashboard"];

      if(in_array($view, $listaBlanca)){
        if(is_file("./app/views/content/".$view."-view.php")){
          $contenido = "./app/views/content/".$view."-view.php";
        }else{
          $contenido ="404";
        }
      }elseif($view=="login" || $view=="index"){
        $contenido = "login";
      }else{
        $contenido="404";
      }
      return $contenido;
        
    }
  }
