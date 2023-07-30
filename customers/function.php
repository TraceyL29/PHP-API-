<?php

require '../include/dbcon.php';
function error42($message){
  $data =[
    'status'=> 422,
    'message' => $message,
  ];
  header("HTTP/1.0 422 Unprocessable Entity");
  return json_encode($data);
}

function storeCustomer($customerInput){
  global $conn;
  // used before inserting a string in a database, as it removes any special characters that may interfere with the query operations.
  $username = mysqli_real_escape_string($conn, $customerInput['username']);
  $password = mysqli_real_escape_string($conn, $customerInput['password']);
  $email = mysqli_real_escape_string($conn, $customerInput['email']);
  $date =date("Ymd");
  if (empty(trim($username))) {
    return error42('Enter your username');
  }elseif (empty(trim($password))) {
    return error42('Enter your password');
  }elseif (empty(trim($email))){
    return error42('Enter your email');
  }else {
    $query= "insert into player (username, password, email, date) values ('$username', '$password','$email', '$date')";
    $result= mysqli_query($conn, $query);
    if ($result) {
      $data =[
        'status'=> 201,
        'message' => 'Created',
      ];
      header("HTTP/1.0 201 Created successfully");
      return json_encode($data);
    }else {
        $data =[
          'status'=> 500,
          'message' => 'Internal server error',
        ];
        header("HTTP/1.0 500 Internal server error");
        return json_encode($data);
      }
    }
}



function getCustomerList(){
  global $conn;

  $query= "select * from player";
  $sql= mysqli_query($conn, $query);

  if ($sql) {
    if (mysqli_num_rows($sql)>0) {
        $res = mysqli_fetch_all($sql, MYSQLI_ASSOC);
        $data =[
          'status'=> 200,
          'message' => 'customer list fetched successfully',
          'data'=> $res,
        ];
        header("HTTP/1.0 200 customer list fetched successfully");
        return json_encode($data);

    }
    else {
      $data =[
        'status'=> 404,
        'message' => 'No customer found',
      ];
      header("HTTP/1.0 405 no customer found");
      return json_encode($data);
    }
  }
  else {
    $data =[
      'status'=> 500,
      'message' => $requestMethod. 'Internal server error',
    ];
    header("HTTP/1.0 500 Internal server error");
    return json_encode($data);
  }
}

function getCustomer($user){
  global $conn;
  if ($user['username']== null) {
      return error42('enter username');
  }
  else{
    $username = mysqli_real_escape_string($conn,$user['username']);
    $query= "select * from player where username='$username'";
    $sql= mysqli_query($conn, $query);
    $result = mysqli_fetch_assoc($sql);
    if ($result) {
    $data =[
      'status'=> 200,
      'message' => 'customer fetched successfully',
      'data'=> $result,
    ];
    header("HTTP/1.0 200 customer fetched successfully");
    return json_encode($data);
  }else {
    $data =[
      'status'=> 404,
      'message' => 'No customer found',
    ];
    header("HTTP/1.0 405 no customer found");
    return json_encode($data);
 }

  }
}

function updateCustomer($customerInput, $customerParam){
  global $conn;
  if (!isset($customerParam['id'])) {
    return error42("enter customer's id");
  }else if (isset($customerParam['id'])== null){
    return error42("customer name not found in URL");
  }
  // used before inserting a string in a database, as it removes any special characters that may interfere with the query operations.
  $id = mysqli_real_escape_string($conn, $customerParam['id']);
  $username = mysqli_real_escape_string($conn, $customerInput['username']);
  $password = mysqli_real_escape_string($conn, $customerInput['password']);
  $email = mysqli_real_escape_string($conn, $customerInput['email']);
  $date =date("Ymd");
  if (empty(trim($username))) {
    return error42('Enter your username');
  }elseif (empty(trim($password))) {
    return error42('Enter your password');
  }elseif (empty(trim($email))){
    return error42('Enter your email');
  }else {
    $query= "update player SET username = '$username', password = '$password',email= '$email' where id = '$id'";
    $result= mysqli_query($conn, $query);
    if ($result) {
      $data =[
        'status'=> 201,
        'message' => 'Updated',
        'data'=> $result,
      ];
      header("HTTP/1.0 201 Created successfully");
      return json_encode($data);
    }else {
        $data =[
          'status'=> 500,
          'message' => 'Internal server error',
        ];
        header("HTTP/1.0 500 Internal server error");
        return json_encode($data);
      }
    }
}


function deleteCustomer($customerId){
  global $conn;
  if (!isset($customerId['id'])) {
    return error42("enter customer's id");
  }else if (isset($customerId['id'])== null){
    return error42("customer id not found in URL");
  }

  $id = mysqli_real_escape_string($conn, $customerId['id']);
  $query= "delete from player where id ='$id'";
  $result= mysqli_query($conn, $query);
  if ($result) {
    $data =[
      'status'=> 204,
      'message' => 'Deleted',
      'data'=> $result,
    ];
    header("HTTP/1.0 204 Deleted successfully");
    return json_encode($data);
  }else {
      $data =[
        'status'=> 500,
        'message' => 'Internal server error',
      ];
      header("HTTP/1.0 500 Internal server error");
      return json_encode($data);
    }
}
 ?>
