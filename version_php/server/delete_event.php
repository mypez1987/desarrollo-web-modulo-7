<?php

  require('lib.php');

  $id=$_POST['id'];

  $con = new ConectorDB();

  if ($con->initConexion('agenda_db')=='OK')
  {
    if ($con->eliminarRegistro('eventos',"id='$id'"))
    {
      $response['msg'] = "OK";
    }
    else
    {
      $response['msg'] = "Hubo un problema y los registros no fueron eliminados";
    }
    $con->cerrarConexion();
  }
  else
  {    
    $response['msg'] = "No se pudo conectar a la Base de Datos";
  }

  echo json_encode($response);

 ?>
