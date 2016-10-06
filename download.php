<?php
  $dbhost = "localhost";
  $dbuser = "root";
  //$dbpass = "921022";
  $dbpass = "998998";
  $dbname = "DropBox";

  mysql_connect($dbhost, $dbuser, $dbpass) or die ('cannot connect to the server');
  mysql_select_db($dbname) or die ('database selection problem');
    
    $id = $_POST['file_id'];
  //  $id = 20;
    $query = "SELECT file_oldname,file_name, file_size, file_content, file_type, upload_path FROM files_Basic WHERE file_id='$id'";
    $result = mysql_query($query) or die('Error, query failed');
    list($oldname, $name, $size, $content, $type, $path) = mysql_fetch_array($result);
     
    $fullpath = $path.$name;
    header('Content-Description: File Transfer');
    header('Content-Type: $type');
    header('Content-Disposition: attachment; filename="'.$oldname.'"');
    // header('Content-Disposition: attachment; filename="'.basename($fullpath).'"');
    header('Content-Length: ' . filesize($fullpath));
    readfile($fullpath);      //  must have to download full-size file
?>

