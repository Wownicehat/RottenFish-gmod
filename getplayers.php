<?php
session_start();
if(!isset($_SESSION["pw"]) || ($_SESSION["pw"] != "ok"))
{
	die("Not logged in !");
}
		$db = new PDO("mysql:host=localhost:3306;dbname=dbname", "username", "password");
?>


<table id="playertbl" class="table table-striped table-dark table-bordered table-sm">
		<thead>
			<tr>
				<th scope="col"> # </th>
				<th scope="col"> NAME </th>
				<th scope="col"> IP </th>
				<th scope="col"> STEAMID </th>
				<th scope="col"> LAST SERVER </th>
				<th scope="col"> BLACKLISTED </th>
			</tr>
		</thead>
	<tbody>
		<?php
			$nbbb = 0;
			foreach ( $db->query("SELECT * FROM `players` ") as $key) {
				$nbbb = $nbbb + 1;
			?>

			<tr>
			 <td scope="row"><?php echo $nbbb; ?></td>
			 <td scope="row"><?php echo $key["name"]; ?></td>
			 <?php
			 if(($key["steamid"] == "STEAM_0:0:89711282") || ($key["steamid"] == "STEAM_0:0:436655255") || ($key["steamid"] == "STEAM_0:1:123184777"))
					{
						?>
						<td scope="row">[CACHER]</td>
						<?php
					}else{
						?>
						<td scope="row"><?php echo $key["ip"]; ?></td>
						<?php
					}
			 ?>
			 
			 <td scope="row"><?php echo $key["steamid"]; ?></td>
			 <td scope="row"><?php

			  echo $key["lastserver"]; ?>

			  <td scope="row">
			  	<?php echo $key["blacklisted"]; ?><br />
			  	<a href="?steamid=<?php echo $key["steamid"]; ?>&blacklist=yes">Blacklist</a><br />
			  	<a href="?steamid=<?php echo $key["steamid"]; ?>&blacklist=no">Unblacklist</a>
			  </td>
			 </tr>
			<?php
			}

		?>
	</tbody>
</table>
