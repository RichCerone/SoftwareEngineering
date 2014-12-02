<!DOCTYPE HTML>
    <html>
    <body>
        <!--Author: Richard Cerone-->
        <!--Title-->
        <h1>Upload A New Map</h1>
        <?php
            include "./db.php"; //Connect to database.
            
            //Get map names.
            $result = mysqli_query($con, "SELECT developmentcode, description FROM mock_devmaster");
            echo "<p>Select Developemt:<p>";
            echo "<select name='dev_selector'>"; //Create drop down.
            while($row = mysqli_fetch_assoc($result)) //Check if database is empty.
            {
                //Fill drop down with map names from the database.
                echo "<option value='".$row['developmentcode']."'>".$row['developmentcode']." ".$row['description']."</option> ";
            }
            echo "</select>"; //end drop down.
        ?>
        <!--File upload form-->
        <form id="form1" action="upload.php" method="post" enctype="multipart/form-data">
            <p>Select image to upload:</p>
            <input type="file" name="file" id="file"><br>
            <input type="button" value="Upload Image" name="submit">
        </form>
		<progress></progress>
    </body>
    </html>
    <script>
    $("#editMap").click(function() 
            {
                $("#portal").load("editMap.php"); //Load updateMap.php into portal.
            });
			
			
$(':file').change(function(){
    var file = this.files[0];
    var name = file.name;
    var size = file.size;
    var type = file.type;
    //Your validation
	
	
	
	if (!( (type == "image/jpeg") || (type == "image/jpg") || (type == "image/png") || (type == "image/bmp") ))
	{
	alert("ERROR: image must be jpeg, jpg, png or bmp. Your file type was " + type);
	}
});

$(':button').click(function(){
    var formData = new FormData($('form')[0]);
    $.ajax({
        url: './upload.php',  //Server script to process data
        type: 'POST',
        xhr: function() {  // Custom XMLHttpRequest
            var myXhr = $.ajaxSettings.xhr();
            if(myXhr.upload){ // Check if upload property exists
                myXhr.upload.addEventListener('progress',progressHandlingFunction, false); // For handling the progress of the upload
            }
            return myXhr;
        },
        //Ajax events
        beforeSend: beforeSendHandler,
        success: function(data) {

		var returnArray = JSON.parse(data);
				if (returnArray['success'] == 0)
					{
					alert("ALERT: " + returnArray['message']);
					}
				else
					{
					var fp = returnArray['filePath'];
					var dc = $('select[name=dev_selector]').val();
					
					$.post('./insertToMaps.php', {developmentcode: dc, filePath: fp}, function (response) {
						  $("#portal").load("editMap.php?map_id=" + response);
					   });
		
					}
		
		},
		
        error: errorHandler,
        // Form data
        data: formData,
        //Options to tell jQuery not to process data or worry about content-type.
        cache: false,
        contentType: false,
        processData: false
    });
});

var beforeSendHandler = function() {
console.log("beforeSendHandler");
}

var errorHandler = function() {
console.log("errorHandler");
}

var completeHandler = function() {
console.log("completeHandler");
}

function progressHandlingFunction(e){
    if(e.lengthComputable){
        $('progress').attr({value:e.loaded,max:e.total});
    }
}
    </script>