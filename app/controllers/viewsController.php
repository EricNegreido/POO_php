<?php
  namespace app\controllers;
  use app\models\viewsmodel;

  class viewsController extends viewsModel{
    public function getViewsController($view){
      if($view!=""){
        $respuesta = $this->getViewsModel($view);
      }else{
        $respuesta = "login";
      }
      return $respuesta;
    }
  }