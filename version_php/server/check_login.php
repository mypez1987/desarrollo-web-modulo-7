<?php

  require('lib.php');

  $conector = new ConectorDB();

  $response['conexion'] = $conector->initConexion('agenda_db');


  if ($response['conexion']=='OK')
  {
    $resultado_consulta = $conector->consultar(['usuarios'],  ['email', 'contrasena'], 'WHERE email="'.$_POST['username'].'"');

    if ($resultado_consulta->num_rows != 0)
    {
      $fila = $resultado_consulta->fetch_assoc();
      if (password_verify($_POST['password'], $fila['contrasena']))
      {
        $response['acceso'] = 'concedido';
        session_start();
        $_SESSION['username']=$fila['email'];
      }
      else
      {
        $response['motivo'] = 'Contraseña incorrecta';
        $response['acceso'] = $fila;
      }
    }
    else
    {
      $response['motivo'] = 'Email incorrecto';
      $response['acceso'] = 'rechazado';
    }
  }

  echo json_encode($response);

  $conector->cerrarConexion();

 ?>
