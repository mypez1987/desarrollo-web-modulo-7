<?php

  session_start();

  if (isset($_SESSION['username']))
  {
    session_destroy();
    $response['msg'] = "OK";
  }

  echo json_encode($response);

 ?>
