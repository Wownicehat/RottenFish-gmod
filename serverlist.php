

<?php

session_start();
if(!isset($_SESSION["pw"]) || ($_SESSION["pw"] != "ok"))
{
	die("Not logged in !");
}
$db = new PDO("mysql:host=localhost:3306;dbname=dbname", "username", "password");


$r = $db->prepare("DELETE FROM servers WHERE lastping < NOW() - INTERVAL 7 DAY;");
$r->execute();
$q = "SELECT * FROM `servers`";
$q = $q . " ORDER BY lastping DESC";
?>

<table id="popp" class="table table-striped table-dark table-sm"  data-toggle="table">
		<thead>
		<tr>
			<th scope="col"  data-sortable="true"> CONNECT </th>
			<th scope="col"  data-sortable="true"> STATUS </th>
			<th scope="col"  data-sortable="true"> NAME </th>
			<th scope="col"  data-sortable="true"> IP </th>
			<th scope="col"  data-sortable="true"> PLAYER </th>
			<th scope="col"  data-sortable="true"> MAP </th>
			<th scope="col"  data-sortable="true"> ACTION </th>
		</tr>
	</thead>

		<?php
			foreach ( $db->query($q) as $key) {
			?>
			<tr>
			<td scope="row">

			<a href="?del=<?php echo $key["id"]; ?>">X</a>
			 <a href="steam://connect/<?php echo $key["ip"]; ?>">Connect</a>
			 </td>
			<td scope="row"><?php echo $key["status"]; ?></td>
			 <td scope="row">
			 	<?php if($key["player"] != "0") echo"<div class='c'>";
			 	echo $key["name"];
			 		if($key["player"] != "0") echo "</div>";
			 	?>
			 	<div id="code_<?php echo $key["id"]; ?>" style="display: none;">
			 		<h3><?php echo $key["name"]; ?></h3>
			 		
			 	</div>
			 	<div id="det_<?php echo $key["id"]; ?>" style="display: none;" class="dabdab">
			 		<h3><?php echo $key["name"]; ?></h3>
			 		
			 		<a class="hidebtn" href="#hide" onclick="hideode('det_<?php echo $key["id"]; ?>')">Hide</a>

			 	</div>

			 </td>
			 <td scope="row"><?php echo $key["ip"]; ?></td>
			 <td scope="row"><?php echo $key["player"]; ?> / <?php echo $key["maxplayer"]; ?></td>
			 <td scope="row">
			 	<?php echo $key["map"]; ?>
			 </td>
			 <td scope="row">
			 
			 <a href="/server/<?php echo $key["id"]; ?>">Server Info</a>

			
			
			<?php
			}

		?>
		</tr>
</table>
