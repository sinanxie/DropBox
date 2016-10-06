<?php
  include_once 'dbconfig.php';

  function debug_to_console( $data ) {
    if ( is_array( $data ) )
      $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
    else
      $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";
    echo $output;
  }

  // session_start();
  $file_owner = $_SESSION["useremail"];
  debug_to_console($file_owner);

//  if (isset($_POST['btn_uploadFile']) {
    $file_oldname = $_FILES['file']['name'];
    $file_name = rand(1000,100000)."-".$_FILES['file']['name'];
    // $file_name = $_FILES['file']['name'];
    $file_size = $_FILES['file']['size'];
    $file_type = $_FILES['file']['type'];
    // $file_data = file_get_contents(addslashes($_FILES['file']['tmp_name']));
    // $file_data = file_get_contents($_FILES['file']['tmp_name']);
    $file_data = $_FILES['file']['tmp_name'];
    // $file_data = addslashes(file_get_contents($_FILES['file']['tmp_name']));
    // 
    // $fp      = fopen($file_data, 'r');
    // $file_data = fread($fp, filesize($file_data));
    // $file_data = addslashes($file_data);
    // fclose($fp);

    // $upload_time = date("Y-m-d H:i:s");

    $upload_time = substr(str_replace("+",":",str_replace("T"," ",date(DATE_ATOM))),0,18);
    $folder = "upload/";
    $dirpath = realpath(dirname(getcwd()))."/DropBox_Basic/upload/";

    $file_name = basename($file_name);

    move_uploaded_file($file_data,$dirpath.$file_name);

    // //  new file size in KB
    // $new_size = $file_size/1024;

    //  make file name in lower case
    // $new_file_name = strtolower($file);

    //  $final_file = str_replace(' ', '-', $new_file_name);

//    if(move_uploaded_file($file_loc,$folder,$final_file)){
      $sql = "INSERT INTO files_Basic(file_oldname,file_name,file_size,file_type, upload_time, upload_path, file_owner)
              VALUES ('$file_oldname','$file_name','$file_size','$file_type','$upload_time','$dirpath','$file_owner')";
      // $sql = "INSERT INTO file(file_name,file_content,file_type)
      //         VALUES ('$file_name','$file_data','$file_type')";
      mysql_query($sql);
//    }
//  }

?>

