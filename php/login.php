<?php
  session_start();

  function debug_to_console( $data ) {
    if ( is_array( $data ) )
      $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
    else
      $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";
    echo $output;
  }

  //debug_to_console("This is login.php");

  //  DB info
  //  $DBServerName = "52.33.164.228:3306";
  $DBServerName = "localhost";
  $DBUserName = "root";
  // $DBPassWord = "998998";
  // $DBPassWord = "921022";
  $DBPassWord = "998998";
  $DBName = "DropBox";
  // Create connection
  $conn = mysqli_connect($DBServerName, $DBUserName, $DBPassWord, $DBName) or die('Connect Error (' . mysqli_connect_errno() . ') '
. mysqli_connect_error());

  //
  $action = $_POST['action'];
  $useremail = $_POST['useremail'];
  $username = $_POST['username'];
  $hash = $_POST['userpass']; 
  $userpass = md5($hash);
  // $userpass = md5($salt . $password);


  // debug_to_console($action);
  // debug_to_console($useremail);
  // debug_to_console($userpass);


  //--------------------------------------
  // log in
  // -------------------------------------
  if($action=="login"){
    //--------------------------------------
    // sql - select data from table
    // -------------------------------------
    $sql = "SELECT * FROM users_Basic WHERE user_email='$useremail' and user_pass='$userpass'";
    $res = mysqli_query($conn, $sql);
    if(!$res) {
      die('Invalid query:'. mysqli_error($conn));
    }
    $row = mysqli_fetch_array($res);
    $active = $row['active'];
    $count = mysqli_num_rows($res);
    //debug_to_console("count=" . $count);
    if ($count==1) {
      //echo "You have entered valid use name and password";
      //header('Location: ../home.html');
      //debug_to_console($row['user_pass'] );
      // echo '<script type="text/javascript"> 
      //           window.location = "home.html";
      //       </script>';
      // Set session variables
      $_SESSION["useremail"] = $useremail;
      $_SESSION["username"] = $row['user_name'];
      echo 'true';
    } else {
      //$msg = 'Wrong username or password';
      //echo 'user email and password do not match';
      echo 'false';
    }
  }


  //--------------------------------------
  // register
  // -------------------------------------
  if ($action=="register") {
    //--------------------------------------
    // sql - select data from table
    // -------------------------------------
    $sql = "SELECT * FROM users_Basic WHERE user_email='$useremail'";
    $res = mysqli_query($conn, $sql);
    if(!$res) {
      die('Invalid query:'. mysqli_error($conn));
    }
    $row = mysqli_fetch_array($res);
    $active = $row['active'];
    $count = mysqli_num_rows($res);

    if ($count==1) {
      echo 'false';
    } else {
      //--------------------------------------
      // sql - insert data into table
      // -------------------------------------
      $sql_insert = "INSERT INTO users_Basic (user_email, user_pass, user_name) VALUES ('$useremail','$userpass', '$username')";
      if (mysqli_query($conn, $sql_insert)) {
        $_SESSION["useremail"] = $useremail;
        $_SESSION["username"] = $username;
        echo 'true';
      } 
    }
  }


?>

