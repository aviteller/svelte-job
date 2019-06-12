<?php 
  require_once '../../core/init.php';
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');



  $db = MyPDO::instance();

  $notes = $db->run('SELECT * FROM `notes` WHERE `deleted` = 0 AND `jobid`=?', [$_GET['id']])->fetchAll();

 

  if($notes) {
    echo json_encode($notes);
  } else {
    echo json_encode(
      ['message' => 'No notes Found']
    );
  }