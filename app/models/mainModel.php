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

    public function seleccionaDatos($tipo, $tabla, $campo, $id){
      $tipo = $this->limpiarCadena($tipo);
      $tabla = $this->limpiarCadena($tabla);
      $campo = $this->limpiarCadena($campo);
      $id = $this->limpiarCadena($id);

      if($tipo == "Unico"){
        $sql = $this->conectar()->prepare("SELECT * FROM $tabla WHERE $campo=:ID");
        $sql->bindParam(":ID", $id);
      }elseif($tipo == "Normal"){
        $sql = $this->conectar()->prepare("SELECT $campo FROM $tabla");
      }

      $sql->execute();

      return $sql;

    }
    
    protected function actualizarDatos($tabla, $datos, $condicion){
      $query="UPDATE $tabla SET  (";

      $Count = 0;

      foreach($datos as $clave){
        if($Count > 0){ 
          $query.= ","; 
        }
        $query.=$clave["campo_nombre"]."=".$clave["campo_marcador"];
        $Count++;

      }
      $query.="WHERE".$condicion["condicion_campo"]."=".$condicion["condicion_campo"];

      $sql=$this->conectar()->prepare($query);
      foreach($datos as $clave){
        $sql->bindParam($clave["campo_marcador"], $clave["campo_valor"]);
    }
    $sql->bindParam($condicion["condicion_marcador"], $condicion["campo_valor"]);
    
    $sql->execute();
    return $sql;
    
    }

    protected function eliminarRegistro($tabla, $campo, $id){
      $sql=$this->conectar()->prepare("DELETE FROM $tabla WHERE $campo=:id");
      $sql->bindParam(":id", $id);
      $sql->execute();
      return $sql;

    }

    protected function paginadorTablas($pagina, $numeroPaginas, $url, $botones){
      $tabla ='
      <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-center">
      ';
      if($pagina<=1){
        $tabla.='
        <li class="page-item disabled">
        <a class="page-link">Previous</a>
        </li>';
      }else{
        $tabla.='
        <li class="page-item">
        <a class="page-link" href="'.$url.($pagina-1).'/">Previous</a>
        </li>
        <li class="page-item"><a class="page-link" href="'.$url.'1/">1</a></li>
        <li class="page-item"> ... </li>
        ';
      }
      $count = 0;
      for($i = $pagina; $i<= $numeroPaginas; $i++){
        if($count >= $botones){
          break;
        }

        if($pagina == $i){
          $tabla.= '<li class="page-item active" aria-current="page">
            <span class="page-link">'.$i.'</span>
          </li>';

        }else{
          $tabla.= '<li class="page-item"><a class="page-link" href="'.$url.$i.'/">'.$i.'</a></li>';
        }
        $count++;
      }
      if($pagina==$numeroPaginas){
        $tabla.='<li class="page-item disabled">
      <a class="page-link" href="#">Next</a>
      </li>';
      }else{
      $tabla.='
      <li class="page-item"> ... </li>
      <li class="page-item"><a class="page-link" href="'.$url.$numeroPaginas.'/">'.$numeroPaginas.'</a></li>
      <li class="page-item">
      <a class="page-link"  href="'.$url.($numeroPaginas+1).'/">Next</a>
      </li>';
      }
      $tabla.='</ul>
      </nav>';

      return $tabla;
    }
}