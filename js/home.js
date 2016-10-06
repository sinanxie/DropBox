//	A touch of jQuery magic will keep an eye on your file inputs and fire an event called fileselect when a file is chosen:
$(document).on('change', '.btn-file :file', function() {
  var input = $(this),
      numFiles = input.get(0).files ? input.get(0).files.length : 1,
      label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
  input.trigger('fileselect', [numFiles, label]);
});

$(document).ready( function() {
    $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
        
        var input = $(this).parents('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;
        
        if( input.length ) {
            input.val(log);
        } else {
            if( log ) alert(log);
        }
        
    });

        var url = "list_files.php";
        $("#list_files").html("");
        $.getJSON(url, function(data){
            $.each(data.files, function(index, file) {
                var newRow = 
                "<button type='button' class='btn_delete' id='"+ file.file_id + "' style='margin:2px'>Delete</button>"
                + "<a class='listfiles' id='"+ file.file_id + "'>" + file.file_oldname + "- upload time - " + file.upload_time + "" 
                + "</a><br/>";
                $(newRow).appendTo("#list_files");
            });

            //$(".list_files").on('click', function() {
            $(".listfiles").click(function(){
                var string = this.id;
                var queryString = "?file_id=" + string;
//                window.location.href = "download.php" + queryString;

                var url = "download.php";
                var form = $('<form action="' + url + '" method="post" type="hidden">' +
                  '<input type="hidden" name="file_id" value="' + string + '" />' +
                  '</form>');
                $('body').append(form);
                $(form).submit();
            });

            $(".btn_delete").on('click', function() {
                var string = this.id;
                var queryString = "?file_id=" + string;
//                window.location.href = "download.php" + queryString;

                var url = "deletefile.php";
                var form = $('<form action="' + url + '" method="post" type="hidden">' +
                  '<input type="hidden" name="file_id" value="' + string + '" />' +
                  '</form>');
                $('body').append(form);
                $(form).submit();
            });

        });

    // $("#btn_uploadFile").click(function() {
    // 	/* Act on the event */

    // });
    $('#btn_uploadFile').on('click', function() {
    	var file_data = $('#file').prop('files')[0];   
    	var form_data = new FormData();                  
    	form_data.append('file', file_data);

        if(typeof(file_data)!='undefined'){
            $('#loader-icon').show();
    	// alert(form_data);                             
    	$.ajax({
                url: 'upload.php', // point to server-side PHP script 
                dataType: 'text',  // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
                success: function(php_script_response){
                    // alert(php_script_response); // display response from the PHP script, if any               
                    //  Clear chosen file
                    $('#loader-icon').hide();

                    var file = $("#file");  
                    file.replaceWith( file = file.clone(true) );
                    $("#text_file").val('');

                    var url = "list_files.php";
                    $("#list_files").html("");
                    $.getJSON(url, function(data){
                        $.each(data.files, function(index, file) {
                            var newRow = 
                            "<button type='button' class='btn_delete' id='"+ file.file_id + "' style='margin:2px'>Delete</button>"
                            + "<a class='listfiles' id='"+ file.file_id + "'>" + file.file_oldname + "- upload time - " + file.upload_time + "" 
                            + "</a><br/>";
                            $(newRow).appendTo("#list_files");
                        });

                        //$(".list_files").on('click', function() {
                        $(".listfiles").click(function(){
                            var string = this.id;
                            var queryString = "?file_id=" + string;
            //                window.location.href = "download.php" + queryString;

                            var url = "download.php";
                            var form = $('<form action="' + url + '" method="post" type="hidden">' +
                              '<input type="hidden" name="file_id" value="' + string + '" />' +
                              '</form>');
                            $('body').append(form);
                            $(form).submit();
                        });

                        $(".btn_delete").on('click', function() {
                            var string = this.id;
                            var queryString = "?file_id=" + string;
            //                window.location.href = "download.php" + queryString;

                            var url = "deletefile.php";
                            var form = $('<form action="' + url + '" method="post" type="hidden">' +
                              '<input type="hidden" name="file_id" value="' + string + '" />' +
                              '</form>');
                            $('body').append(form);
                            $(form).submit();
                        });
                    });
                }
     	});

        }
	});



	// $('#btn_downloadFile').on('click', function() {
 //    	// var file_data = $('#choose_file').prop('files')[0];   
 //    	// var form_data = new FormData();                  
 //    	// form_data.append('file', file_data);
 //    	// alert(form_data); 
 //    	window.location.replace("download.php");                          
 //    	$.ajax({
 //                url: 'download.php', // point to server-side PHP script 
 //                // dataType: 'text',  // what to expect back from the PHP script, if anything
 //                // cache: false,
 //                // contentType: false,
 //                // processData: false,
 //                // data: form_data,                         
 //                type: 'post',
 //                success: function(php_script_response){
 //                    // alert(php_script_response); // display response from the PHP script, if any
 //                }
 //     	});
	// });
});