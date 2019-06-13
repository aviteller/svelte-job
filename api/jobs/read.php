<?php 
  require_once '../../core/init.php';
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');



  $db = MyPDO::instance();
  $orderBy = 'ORDER BY id desc';
  if(isset($_GET['orderBy'])) {
    $orderBy = " ORDER BY {$_GET['orderBy']} desc".isset($_GET['dir'])?:'desc';
  }




  if(isset($_GET['search'])) {
    $jobs = $db->run("SELECT * FROM `jobs` WHERE `deleted` = 0 AND `name` LIKE '%{$_GET['search']}%' OR `company` LIKE '%{$_GET['search']}%' $orderBy")->fetchAll();
  } elseif(isset($_GET['deleted'])) {
    $jobs = $db->run("SELECT * FROM `jobs` WHERE `deleted` = 1 $orderBy")->fetchAll();
  } else {
    $jobs = $db->run("SELECT * FROM `jobs` WHERE `deleted` = 0 $orderBy")->fetchAll();
  }


 

  if($jobs) {
    echo json_encode($jobs);
  } else {
    echo json_encode(
      ['message' => 'No Jobs Found']
    );
  }