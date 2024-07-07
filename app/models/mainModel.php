<?php 
  namespace app\models;
  use \PDO;

  if(file_exists(__DIR__."/../../config/server.php")){
    require_once __DIR__."/../../config/server.php";
  }
  class mainModel{
    private $server = $DB_SERVER;
    private $db= $DB_NAME;
    private $user= $DB_USER;
    private $pass = $DB_PASS;

    protected function conectar(){
      $conexion = new PDO("mysql:host=". $this->server.";dbname=".$this->db, $this->user, $this->pass);
      $conexion->exec("SET CHARACTER SET utf8");
      return $conexion;
    }

    protected function ejecConsulta($consulta){
      $sql = $this->conectar()->prepare($consulta);
      $sql->execute();
      return $sql;
    }

    public function limpiarCadena($cadena){
      $palabras=["<script>","</script>","<script src","<script type=","SELECT * FROM","SELECT "," SELECT ","DELETE FROM","INSERT INTO","DROP TABLE","DROP DATABASE","TRUNCATE TABLE","SHOW TABLES","SHOW DATABASES","<?php","?>","--","^","<",">","==","=",";","::"];
      $cadena = trim($cadena); //quitamos espacios vacios
      $cadena = stripslashes($cadena);//quitamos barras invertidas
      foreach($palabras as $palabra){
        $cadena = str_ireplace($palabra, "", $cadena);// busca y reemplaza la palabra
      }
      $cadena = trim($cadena); //quitamos espacios vacios
      $cadena = stripslashes($cadena);//quitamos barras 

      return $cadena;

    }

    protected function VerificarDatos($filtro, $cadena){
      if(preg_match("/^".$filtro."$/", $cadena)){
        return false;
      }else{
        return true;
      }

    }

    protected function guardarDatos($tabla, $datos){
      $query="INSERT INTO $tabla (";

      $Count = 0;

      foreach($datos as $clave){
        if($Count > 0){ 
          $query.= ","; 
        }
        $query.=$clave["campo_nombre"];
        $Count++;
  
      }
      $query.=") VALUES(";

      $Count = 0;

      foreach($datos as $clave){
        if($Count > 0){ 
          $query.= ","; 
        }
        $query.=$clave["campo_marcador"];
        $Count++;
  
      }
      $query.=")";
      $sql=$this->conectar()->prepare($query);
      foreach($datos as $clave){
        $sql->bindParam($clave["campo_marcador"], $clave["campo_valor"]);


    }
    $sql->execute();
    return $sql;
    
  }