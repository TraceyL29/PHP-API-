<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include('function.php');
$requestMethod= $_SERVER["REQUEST_METHOD"];
if ($requestMethod == 'POST') {
    $inputData = json_decode(file_get_contents("php://input"), true);
    /*echo $inputData['username'];*/
    if (empty($inputData)) {
      /*form*/
       $storeCustomer= storeCustomer($_POST);
      /*echo $_POST['username'];*/
     }else {
      /*raw data*/
       $storeCustomer= storeCustomer($inputData);
    /*echo $inputData;*/
     }
     echo $storeCustomer;
}else {
  $data =[
    'status'=> 405,
    'message' => $requestMethod. ' Method not allowed',
  ];
  /* status on postman*/
   header("HTTP/1.0 405 method not allowed");
  echo json_encode($data);
}
 ?>
