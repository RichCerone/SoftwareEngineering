<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> <!-- Includes Jquery into the project -->
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script>
  $(function() {
    $( "#draggable" ).draggable();
  });
  </script>
<?php
include "./db.php";
include "./objects.php";
$map_id = $_GET['map_id'];
$result = mysqli_query($con, "SELECT * FROM maps WHERE id = '$map_id' LIMIT 1");
$row = mysqli_fetch_assoc($result);
$image_url = $row['image_url'];
 
$shapes = array();
$currentHouseNumber = "0";
$currentShape = null;

$result = mysqli_query($con, "SELECT * FROM coordinates WHERE map_id = '$map_id' ORDER BY housenumber ASC, order_num ASC") or die ("ERROR: " . mysqli_error($con));

while ($row = mysqli_fetch_assoc($result))
{
if ($currentHouseNumber != $row['housenumber']) //create a new shape everytime we get to a new house
	{
	$currentShape = new Shape($row['housenumber']);
	array_push($shapes, $currentShape);
	$currentHouseNumber = $row['housenumber'];
	} 

$currentShape->addPoint(new Point($row['x_pos'],$row['y_pos']));
}


$firstTime = true;
$json_shapes = "[";


foreach($shapes as $shape)
{
	if ($firstTime == false)
		{
		$json_shapes .= ",";
		}
	$json_shapes .= $shape->to_json();
	$firstTime = false;
}

$json_shapes .= "]";

?>
<div class="page_wrapper">

    <div class="right_div" id="draggable" >
		<!--Box with addresses-->
		Addresses (Draggable)
		<select id="houseOptions" class='fullWidth' name="select_addresses"  size="5">
		<?php
		//$result = mysqli_query($con,"SELECT id,address1 FROM mock_housemaster WHERE developmentcode = '".$developmentcode."' ");
		$result = mysqli_query($con,"SELECT mock_housemaster.housenumber, mock_housemaster.address1 
				FROM  mock_housemaster, maps
				WHERE 
		maps.id = '$map_id' AND
		mock_housemaster.developmentcode = maps.developmentcode ") or die("ERROR: " . mysqli_error($con));
		while ($row = mysqli_fetch_assoc($result))
		{
		echo "<option value='".$row['housenumber']."'>".$row['address1']."</option>";
		}
		?>
		</select>
		<!--END Box with addresses-->
	</div>
    <div class="left_div">
		<form>
			<textarea id='newCords' rows=3 name="coords1" class="canvas-area input-xxlarge" disabled 
				placeholder="Shape Coordinates" 
				map_id="<?php echo $map_id; ?>"
				data-image-url="<?php echo $image_url; ?>"
				style="position:absolute;"
				></textarea>
		</form>
		
		<!--Where the map will be displayed -->
		<div id='areaViewer'></div>
	</div>
</div>

<style>

.fullWidth{
width: 100%; 
}
.page_wrapper {
    width:100%;
    border:1px solid;
}
.left_div {
    width:auto;
    background:white;
    overflow:scroll;
}
.right_div {
    width:200px;
    background:white;
    float:right;
	position:absolute;
	right: 0;
	border: 1px solid black;
}


</style>

	<script>
	
	</script>
    <?php include "./js/jquery.canvasAreaDraw2.php"; ?>

<!--
<script language="javascript" src="./js/jquery.canvasAreaDraw2.js"></script>
-->
<script>
$("#editMap").click(function() {
    $("#portal").load("editMap.php"); //Load updateMap.php into portal.
});
</script>