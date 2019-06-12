<?php 
  require_once '../../core/init.php';
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');



  $db = MyPDO::instance();




  if(isset($_GET['search'])) {
    $jobs = $db->run("SELECT * FROM `jobs` WHERE `deleted` = 0 AND `name` LIKE '%{$_GET['search']}%'")->fetchAll();
  } else {
    $jobs = $db->run('SELECT * FROM `jobs` WHERE `deleted` = 0')->fetchAll();
  }


 

  if($jobs) {
    echo json_encode($jobs);
  } else {
    echo json_encode(
      ['message' => 'No Jobs Found']
    );
  }