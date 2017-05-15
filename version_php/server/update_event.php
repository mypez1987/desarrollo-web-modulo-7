<?php

  require('lib.php');

  $con = new ConectorDB();

  $datos['id'] = "'".$_POST['id']."'";
  $datos['fecha_inicio'] = "'".$_POST['start_date']."'";
  $datos['hora_inicio'] = "'".$_POST['start_hour']."'";
  $datos['fecha_fin'] = "'".$_POST['end_date']."'";
  $datos['hora_fin'] = "'".$_POST['end_hour']."'";


  if ($con->initConexion('agenda_db')=='OK')
  {
    if ($con->actualizarRegistro('eventos', $datos, "id='".$_POST['id']."'"))
    {
      $response['msg'] = 'OK';
    }
    else
    {
      $response['msg'] = "Se ha producido un error en la actualización";
    }
    $con->cerrarConexion();
  }
  else
  {
    $response['msg'] = "Se presentó un error en la conexión";
  }

  echo json_encode($response);

 ?>
