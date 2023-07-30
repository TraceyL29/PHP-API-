<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include('function.php');
$requestMethod= $_SERVER["REQUEST_METHOD"];

if ($requestMethod == 'GET') {
  if (isset($_GET['username'])) {
    $customer= getCustomer($_GET);
    echo $customer;
  }else {
    $customer= getCustomerList();
    echo $customer;
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
