<?php
//----------Creacion Base de Datos----------------------------------------------
  require('access.php');
  require('lib.php');

  $conexion = new mysqli($host, $user, $password);
  if ($conexion->connect_error)
  {
    echo "Error:" . $conexion->connect_error;
  }
  $sql = 'CREATE DATABASE agenda_db';
  if ($conexion->query($sql) === TRUE)
  {
    echo "La base de datos agenda_db se creó exitosamente<br>";
  }
  else
  {
    echo "Se presentó un error ".$conexion->error;
  }
  $conexion->close();
//------------------------------------------------------------------------------
//---------Creacion Tabla Usuarios----------------------------------------------
  $nombreTabla='usuarios';
  $usuario['id']='INT';
  $usuario['email']='VARCHAR(20)';
  $usuario['nombre']='VARCHAR(45)';
  $usuario['contrasena']='VARCHAR(60)';
  $usuario['fecha_nato']='DATE';

  $conector = new ConectorDB();

  if ($conector->initConexion('agenda_db')=='OK')
  {
    $query = $conector->getNewTableQuery($nombreTabla,$usuario);
    if ($conector->ejecutarQuery($query))
    {
      echo "La tabla se creó exitosamente<br>";
    }
    else
    {
      echo "Se produjo un error al crear la tabla<br>";
    }
    $conector->cerrarConexion();
  }
  else
  {
    echo $conector->initConexion();
  }
//------------------------------------------------------------------------------
//----------Creacion Tabla eventos----------------------------------------------
  $nombreTabla = 'eventos';
  $event['id']= 'INT';
  $event['titulo']= 'VARCHAR(45)';
  $event['fecha_inicio']= 'DATE';
  $event['hora_inicio']= 'TIME';
  $event['fecha_fin']= 'DATE';
  $event['hora_fin']= 'TIME';
  $event['dia']= 'BOOLEAN';
  $event['fk_usuarios']='INT';

  $conector = new ConectorDB();

  if ($conector->initConexion('agenda_db')=='OK')
  {
    $query = $conector->getNewTableQuery($nombreTabla, $event);
    if ($conector->ejecutarQuery($query))
    {
      echo "La tabla se creó exitosamente<br>";
    }
    else
    {
      echo "Se produjo un error al crear la tabla<br>";
    }
    $conector->cerrarConexion();
  }
  else
  {
    echo $conector->initConexion();
  }
//------------------------------------------------------------------------------
//----------Restriccion---------------------------------------------------------
  $conector = new ConectorDB();

  if ($conector->initConexion('agenda_db')=='OK')
  {
    if($conector->nuevaRestriccion('usuarios','ADD PRIMARY KEY (id)'))
    {
      echo "Se añadido una restriccion exitosamante<br>";
    }
    else
    {
        echo "Se presento un error al añadir una restriccion<br>";
    }

    $conector->cerrarConexion();
  }
  else
  {
    echo $conector->initConexion();
  }

  if ($conector->initConexion('agenda_db')=='OK')
  {
    if($conector->nuevaRestriccion('eventos','ADD PRIMARY KEY (id)'))
    {
      echo "Se añadido una restriccion exitosamante<br>";
    }
    else
    {
        echo "Se presento un error al añadir una restriccion<br>";
    }

    $conector->cerrarConexion();
  }
  else
  {
    echo $conector->initConexion();
  }
//------------------------------------------------------------------------------
//----------AUTO_INCREMENT------------------------------------------------------
  $conector = new ConectorDB();
  if ($conector->initConexion('agenda_db')=='OK')
  {
    if($conector->AUTO_INCREMENT('eventos','id'))
    {
      echo "Se modifico id exitosamente<br>";
    }
    else
    {
      echo "Se produjo un error en la modificacion de id<br>";
    }
  }
  else
  {
      echo $conector->initConexion();
  }

//------------------------------------------------------------------------------
//----------Relacion------------------------------------------------------------
  $conector = new ConectorDB();

  if ($conector->initConexion('agenda_db')=='OK')
  {
    if($conector->nuevaRelacion('eventos','usuarios','fk_usuarios','id'))
    {
      echo "Se añadido una relacion exitosamante<br>";
    }
    else
    {
        echo "Se presento un error al añadir una relacion<br>";
    }

    $conector->cerrarConexion();
  }
  else
  {
    echo $conector->initConexion();
  }
//------------------------------------------------------------------------------
//----------Creacion de Usuarios------------------------------------------------
//---------Usuaio #1-----------------------------------------------------------
    $dsuser['id'] = 1;
    $dsuser['email'] = "'pablo.g@mail.com'";
    $dsuser['nombre'] = "'Pablo Gonzales'";
    $hash=password_hash("123", PASSWORD_DEFAULT);
    $dsuser['contrasena'] = "'$hash'";
    $dsuser['fecha_nato'] = "'2017-04-17'";
    Crear_User_event('usuarios',$dsuser);
    $dsevent['id'] = 1;
    $dsevent['titulo'] = "'fiesta'";
    $dsevent['fecha_inicio'] = "'2017-05-10'";
    $dsevent['hora_inicio'] = "''";
    $dsevent['fecha_fin'] = "''";
    $dsevent['hora_fin'] = "''";
    $dsevent['dia'] = 1;
    $dsevent['fk_usuarios'] = 1;
    Crear_User_event('eventos',$dsevent);
  //-----------------------------------------------------------------------------
  //---------Usuaio #2-----------------------------------------------------------
    $dsuser['id'] = 2;
    $dsuser['email'] = "'cristian.d@mail.com'";
    $dsuser['nombre'] = "'Cristian Bastidas'";
    $hash = password_hash("456", PASSWORD_DEFAULT);
    $dsuser['contrasena'] = "'$hash'";
    $dsuser['fecha_nato'] = "'1987-11-10'";
    Crear_User_event('usuarios',$dsuser);
    $dsevent['id'] = 2;
    $dsevent['titulo'] = "'reunion'";
    $dsevent['fecha_inicio'] = "'2017-06-12'";
    $dsevent['hora_inicio'] = "'10:25:00'";
    $dsevent['fecha_fin'] = "'2017-06-13'";
    $dsevent['hora_fin'] = "'10:45:00'";
    $dsevent['dia'] = 0;
    $dsevent['fk_usuarios'] = 2;
    Crear_User_event('eventos',$dsevent);
    //-----------------------------------------------------------------------------
    //---------Usuaio #3-----------------------------------------------------------
    $dsuser['id'] = 3;
    $dsuser['email'] = "'vanesa.r@mail.com'";
    $dsuser['nombre'] = "'Vanesa Rodriguez'";
    $hash = password_hash("789", PASSWORD_DEFAULT);
    $dsuser['contrasena'] = "'$hash'";
    $dsuser['fecha_nato'] = "'1991-06-17'";
    Crear_User_event('usuarios',$dsuser);
    $dsevent['id'] = 3;
    $dsevent['titulo'] = "'conferencia'";
    $dsevent['fecha_inicio'] = "'2017-07-17'";
    $dsevent['hora_inicio'] = "''";
    $dsevent['fecha_fin'] = "''";
    $dsevent['hora_fin'] = "''";
    $dsevent['dia'] = 1;
    $dsevent['fk_usuarios'] = 3;
    Crear_User_event('eventos',$dsevent);
  //-----------------------------------------------------------------------------

    function Crear_User_event($tabla,$datos)
    {
      $con = new ConectorDB();
      if ($con->initConexion('agenda_db')=='OK')
      {
        if ($con->insertData($tabla,$datos))
        {
          echo "Se insertaron los datos correctamente<br>";
        }
        else
        {
          echo "Se ha producido un error en la inserción<br>";
        }
        $con->cerrarConexion();
      }
      else
      {
        echo "Se presentó un error en la conexión<br>";
      }
    }
?>
