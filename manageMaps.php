<!DOCTYPE HTML>
    <html>
        <h1>Manage Maps</h1>
		
		<?php
		require "./db.php";
		
		$result = mysqli_query($con, "SELECT * FROM maps");
		$result = mysqli_query($con,"SELECT maps.image_url, maps.id, mock_devmaster.description 
				FROM  mock_devmaster, maps
				WHERE 
		maps.developmentcode = mock_devmaster.developmentcode
		 ") or die("ERROR: " . mysqli_error($con));
		while ($row = mysqli_fetch_assoc($result))
		{
		echo "<div class='mapBox'>";
		echo "<img src='".$row['image_url']."' style='width: 150px;'>";
		echo $row['description'] . " <a class='gotoEditMap' href='./editMap.php?map_id=".$row['id']."' >Edit Map</a> - <a target='_new' href='./viewMap.php?map_id=".$row['id']."'>View Map</a> - ";
		echo "<a href='#' class='deleteMap' id='".$row['id']."'>Delete</a>";
		echo "</div>";
		}
		?>
    </html>
	
	<script>
	$(".gotoEditMap").click(function() {
	$("#portal").load( $(this).attr('href') ); //Load updateMap.php into portal.
    return false;
});
	$(".deleteMap").click(function(){
	var map_id = $(this).attr("id");
	var parent = $(this).parent();

	$("<div style='background-color: white;'></div>").appendTo('body')
    .html('<div><h6>Are you sure you want to delete this map & all defined areas for it?</h6></div>')
    .dialog({
        modal: true,
        title: 'Delete message',
        zIndex: 10000,
        autoOpen: true,
        width: '500px',
        resizable: false,
        buttons: {
            Yes: function () {
                	parent.remove();
	
					$.post( "./deleteMap.php?map_id=" + map_id, function( data ) {
		
					});
                $(this).dialog("close");
            },
            No: function () {
                $(this).dialog("close");
            }
        },
        close: function (event, ui) {
            $(this).remove();
        }
    });
	

	});
	</script>