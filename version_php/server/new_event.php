<?php

  require('lib.php');

  session_start();

  if (isset($_SESSION['username']))
  {
    $con = new ConectorDB();
    if ($con->initConexion('agenda_db')=='OK')
    {
      $resultado = $con->consultar(['usuarios'],['id'], "WHERE email ='" .$_SESSION['username']."'");
      $fila = $resultado->fetch_assoc();

      $data['titulo'] = "'".$_POST['titulo']."'";
      $data['fecha_inicio'] = "'".$_POST['start_date']."'";
      $data['hora_inicio'] = "'".$_POST['start_hour']."'";
      $data['fecha_fin'] = "'".$_POST['end_date']."'";
      $data['hora_fin'] = "'".$_POST['end_hour']."'";
      $data['dia'] = "'".$_POST['allDay']."'";
      $data['fk_usuarios'] = $fila['id'];

      if ($con->insertData('eventos', $data))
      {
        $response['msg']= 'OK';
      }
      else
      {
        $response['msg']= 'No se pudo realizar la inserción de los datos';
      }
      $resultado = $con->ultimoid('eventos','id');
      $fila = $resultado->fetch_assoc();
      $response['maxid']=$fila['MAX(id)'];
    }
    else
    {
      $response['msg']= 'No se pudo conectar a la base de datos';
    }
  }
  else
  {
    $response['msg']= 'No se ha iniciado una sesión';
  }
  echo json_encode($response);

 ?>
