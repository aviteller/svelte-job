<?php

require_once '../../core/init.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

$data = json_decode(file_get_contents("php://input"));

$db =  MyPDO::instance();




//var_dump($data->field->name, $data->field->value, $data->id);exit;

$db->run("UPDATE notes SET  `{$data->field->name}` = '{$data->field->value}' WHERE id={$data->id}");

echo json_encode(["message" => "{$data->field->name} updated to {$data->field->value} for note# $data->id"]);
exit;
