<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$requestMethod= $_SERVER["REQUEST_METHOD"];
include('function.php');

if ($requestMethod == 'PUT') {
  $inputData = json_decode(file_get_contents("php://input"), true);
  /*echo $inputData['username'];*/
  if (empty($inputData)) {
    /*form*/
     $updateCustomer= updateCustomer($_POST, $_GET);
    /*echo $_POST['username'];*/
   }else {
    /*raw data*/
     $updateCustomer= updateCustomer($inputData, $_GET);
     echo $updateCustomer;
   }
   
}else {
  $data =[
    'status'=> 405,
    'message' => $requestMethod. ' Method not allowed',
  ];
  header("HTTP/1.0 405 method not allowed");
  echo json_encode($data);
}

 ?>
