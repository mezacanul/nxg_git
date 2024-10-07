<?php

function customDBQuery($customDB, $query){
  global $servername, $customDB, $DBusername, $DBpassword;

  try {
    $conn = new PDO("mysql:host=$servername;dbname=$customDB", $DBusername, $DBpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
    $stmt = $conn->prepare($query);
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $all = $stmt->fetchAll();
    $conn = null;
  } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
  }

  return $all;  
}

function getQuery($query){
    global $servername, $DBname, $DBusername, $DBpassword;
  
    try {
      $conn = new PDO("mysql:host=$servername;dbname=$DBname", $DBusername, $DBpassword);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
      $stmt = $conn->prepare($query);
      $stmt->execute();
  
      // set the resulting array to associative
      $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $all = $stmt->fetchAll();
      $conn = null;
    } catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
    }
  
    return $all;  
}

function updateQuery($query){
  global $servername, $DBname, $DBusername, $DBpassword;

  try {
    $conn = new PDO("mysql:host=$servername;dbname=$DBname", $DBusername, $DBpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
    $stmt = $conn->prepare($query);
    $stmt->execute();

    // set the resulting array to associative
    $success = $stmt->rowCount();
    $conn = null;
    return $success;  
  } catch(PDOException $e) {
    $conn = null;
    echo $query . "<br>" . $e->getMessage();
    return "ERROR";
  }
}

function deleteQuery($query){
  global $servername, $DBname, $DBusername, $DBpassword;

  try {
    $conn = new PDO("mysql:host=$servername;dbname=$DBname", $DBusername, $DBpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // use exec() because no results are returned
    $conn->exec($query);
    $success = "ok";
  } catch(PDOException $e) {
    echo $e->getMessage();
  }
  
  $conn = null;
  return $success;  
}

function addQuery($query){
  global $servername, $DBname, $DBusername, $DBpassword;

  try {
    $conn = new PDO("mysql:host=$servername;dbname=$DBname", $DBusername, $DBpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // use exec() because no results are returned
    $conn->exec($query);
    $success = "ok";
  } catch(PDOException $e) {
    return $e->getMessage();
  }
  
  $conn = null;
  return $success;  
}



?>