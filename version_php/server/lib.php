<?php
  class ConectorDB
  {

    private $host = 'localhost';
    private $user = 'root';
    private $password = '123456';
    private $conexion;

    function initConexion($nombre_db)
    {
      $this->conexion = new mysqli($this->host, $this->user, $this->password, $nombre_db);
      if ($this->conexion->connect_error)
      {
        return "Error:" . $this->conexion->connect_error;
      }
      else
      {
        return "OK";
      }
    }

    function getNewTableQuery($nombre_tbl, $campos)
    {
      $sql = 'CREATE TABLE '.$nombre_tbl.' (';
      $length_array = count($campos);
      $i = 1;
      foreach ($campos as $key => $value)
      {
        $sql .= $key.' '.$value;
        if ($i!= $length_array)
        {
          $sql .= ', ';
        }
        else
        {
          $sql .= ');';
        }
        $i++;
      }
      return $sql;
    }

    function nuevaRestriccion($tabla,$restriccion)
    {
      $sql='ALTER TABLE '.$tabla.' '.$restriccion;
      if($this->ejecutarQuery($sql))
      {
        return true;
      }
      else
      {
        return false;
      }
    }

    function nuevaRelacion($from_tbl, $to_tbl, $from_field, $to_field)
    {
      $sql='ALTER TABLE '.$from_tbl.' ADD FOREIGN KEY ('.$from_field.') REFERENCES '.$to_tbl.'('.$to_field.');';
      if($this->ejecutarQuery($sql))
      {
        return true;
      }
      else
      {
        return false;
      }
    }

    function insertData($tabla,$data){
      $sql = 'INSERT INTO '.$tabla.' (';
      $i = 1;
      foreach ($data as $key => $value) {
        $sql .= $key;
        if ($i<count($data)) {
          $sql .= ', ';
        }else $sql .= ')';
        $i++;
      }
      $sql .= ' VALUES (';
      $i = 1;
      foreach ($data as $key => $value) {
        $sql .= $value;
        if ($i<count($data)) {
          $sql .= ', ';
        }else $sql .= ');';
        $i++;
      }
      return $this->ejecutarQuery($sql);
    }

    function consultar($tablas, $campos, $condicion = "")
    {
      $sql = "SELECT ";
      $ultima_key = end(array_keys($campos));
      foreach ($campos as $key => $value)
      {
        $sql .= $value;
        if ($key!=$ultima_key)
        {
          $sql.=", ";
        }
        else $sql .=" FROM ";
      }
      $ultima_key = end(array_keys($tablas));
      foreach ($tablas as $key => $value)
      {
        $sql .= $value;
        if ($key!=$ultima_key)
        {
          $sql.=", ";
        }
        else $sql .= " ";
      }
      if ($condicion == "")
      {
        $sql .= ";";
      }
      else
      {
        $sql .= $condicion.";";
      }
      return $this->ejecutarQuery($sql);
    }

    function eliminarRegistro($tabla, $condicion)
    {
      $sql = "DELETE FROM ".$tabla." WHERE ".$condicion.";";
      return $this->ejecutarQuery($sql);
    }

    function actualizarRegistro($tabla, $data, $condicion)
    {
      $sql = 'UPDATE '.$tabla.' SET ';
      $i=1;
      foreach ($data as $key => $value)
      {
        $sql .= $key.'='.$value;
        if ($i<sizeof($data))
        {
          $sql .= ', ';
        }
        else
        {
          $sql .= ' WHERE '.$condicion.';';
        }
        $i++;
      }
      return $this->ejecutarQuery($sql);
    }

    function ejecutarQuery($query)
    {
      return $this->conexion->query($query);
    }

    function cerrarConexion()
    {
      $this->conexion->close();
    }

    function getConexion()
    {
      return $this->conexion;
    }

    function getEventos($user_id)
    {
      $sql = "SELECT ev.id AS id, ev.titulo AS titulo, ev.fecha_inicio AS fecha_inicio, ev.hora_inicio AS hora_inicio, ev.fecha_fin AS fecha_fin, ev.hora_fin AS hora_fin, ev.dia AS dia, ev.fk_usuarios AS fk_usuarios
              FROM eventos AS ev
              WHERE ev.fk_usuarios = ".$user_id.";";
      return $this->ejecutarQuery($sql);
    }

    function contarnumfilas($tabla,$campo,$condicion)
    {
      $sql="SELECT COUNT(".$campo.") FROM ".$tabla. " WHERE " .$campo."=".$condicion.";";
      return $this->ejecutarQuery($sql);
    }

    function ultimoid($tabla,$campo)
    {
      $sql="SELECT MAX(".$campo.") FROM ".$tabla.";";
      return $this->ejecutarQuery($sql);
    }

    function AUTO_INCREMENT($tabla,$campo)
    {
      //ALTER TABLE `eventos` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;
      $sql="ALTER TABLE ".$tabla." CHANGE ".$campo." ".$campo." INT(11) NOT NULL AUTO_INCREMENT;";
        return $this->ejecutarQuery($sql);
    }


  }
?>
