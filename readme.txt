
- Accomplished

	- upload files
	- download files

- Undone
	
	- big files
	- improve: move_uploaded_file()
		Shouldn’t store in database, use filestream?

- notes

- move_uploaded_file failed to open stream

	chmod 777 folder_path 

- Download files
	http://php.net/manual/en/function.readfile.php

- Avoid file resizing
    $file_name = $_FILES['file']['name'];
    $file_size = $_FILES['file']['size'];
    $file_type = $_FILES['file']['type'];
    $file_data = $_FILES['file']['tmp_name'];

    $fp      = fopen($file_data, 'r');
    $file_data = fread($fp, filesize($file_data));
    $file_data = addslashes($file_data);
    fclose($fp);

    $sql = "INSERT INTO file(file_name,file_size,file_content,file_type,upload_time)
              VALUES ('$file_name','$file_size','$file_data','$file_type','$upload_time')";
      mysql_query($sql);



