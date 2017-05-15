<?php

  require('lib.php');

  session_start();

  if (isset($_SESSION['username']))
  {
    $con = new ConectorDB();

    if ($con->initConexion('agenda_db')=='OK')
    {
      $resultado = $con->consultar(['usuarios'], ['id'], "WHERE email ='".$_SESSION['username']."'");
      $fila = $resultado->fetch_assoc();      

      //$resultado = $con->contarnumfilas('eventos','fk_usuarios',$fila['id']);
      //$fila = $resultado->fetch_assoc();
      //$total = $fila["COUNT(fk_usuarios)"];

      $resultado = $con->getEventos($fila['id']);
      $i=0;
      while($fila = $resultado->fetch_assoc())
      {
        $response['eventos'][$i]['id']=$fila['id'];
        $response['eventos'][$i]['titulo']=$fila['titulo'];
        $response['eventos'][$i]['fecha_inicio']=$fila['fecha_inicio'];
        $response['eventos'][$i]['hora_inicio']=$fila['hora_inicio'];
        $response['eventos'][$i]['fecha_fin']=$fila['fecha_fin'];
        $response['eventos'][$i]['hora_fin']=$fila['hora_fin'];
        $response['eventos'][$i]['dia']=$fila['dia'];
        $response['eventos'][$i]['fk_usuarios']=$fila['fk_usuarios'];
        $i++;
      }
      $response['msg'] = "OK";
    }
    else
    {
      $response['msg'] = "No se pudo conectar a la Base de Datos";
    }
  }
  else
  {
    $response['msg'] = "No se ha iniciado una sesión";
  }

  echo json_encode($response);

 ?>
