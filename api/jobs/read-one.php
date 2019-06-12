<?php 
  require_once '../../core/init.php';
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');



  $db = MyPDO::instance();

  $job = $db->run('SELECT * FROM `jobs` WHERE `deleted` = 0 AND id=?', $_GET['id'])->fetch();

 

  if($jobs) {
    echo json_encode($job);
  } else {
    echo json_encode(
      ['message' => 'No Jobs Found']
    );
  }