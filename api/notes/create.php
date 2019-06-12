<?php

require_once '../../core/init.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

$data = json_decode(file_get_contents("php://input"));

$db =  MyPDO::instance();

if(!empty($data->body)) {

  //var_dump($data->field->name, $data->field->value, $data->id);exit;
  
  $db->run("INSERT INTO notes SET  `body` = '{$data->body}', `jobid` = '{$data->jobid}'");
  $id = $db->lastInsertId();
  echo json_encode([
    "id" => $id,
    "body" => $data->body,
    "jobid" => $data->jobid,
  ]);
  exit;
} else {
  echo json_encode(["message" => "please validate"]);
}
