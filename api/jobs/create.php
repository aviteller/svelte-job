<?php

require_once '../../core/init.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

$data = json_decode(file_get_contents("php://input"));

$db =  MyPDO::instance();

if(!empty($data->name)) {

  //var_dump($data->field->name, $data->field->value, $data->id);exit;
  
  $db->run("INSERT INTO jobs SET  `name` = '{$data->name}', `description` = '{$data->description}'");
  $id = $db->lastInsertId();
  echo json_encode([
    "id" => $id,
    "name" => $data->name,
    "description" => $data->description,
    "status" => "New",
  ]);
  exit;
} else {
  echo json_encode(["msg" => "please validate"]);
}
