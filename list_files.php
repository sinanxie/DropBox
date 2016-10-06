<?php
  session_start();
  $user_email = $_SESSION["useremail"];

  $DBServerName = "localhost";
  $DBUserName = "root";
  //$DBPassWord = "921022";
  $DBPassWord = "998998";
  $DBName = "DropBox";
  // Create connection
  $conn = mysqli_connect($DBServerName, $DBUserName, $DBPassWord, $DBName) or die('Connect Error (' . mysqli_connect_errno() . ') '
. mysqli_connect_error());

  $sql = "SELECT file_id,file_oldname,upload_time FROM files_Basic WHERE file_owner='$user_email'";
  $res = mysqli_query($conn, $sql);
  if(!$res) {
    die('Invalid query:'. mysqli_error($conn));
  }

  $var = array();
  while ($obj = mysqli_fetch_object($res)) {
    $var[] = $obj;
  }

  echo '{"files":'.json_encode($var).'}';

?>

