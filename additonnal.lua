local EP = {}
if file.Read("EnginePredator", "EP") == "fat" then
	return
end
RunConsoleCommand("sv_hibernate_think", "1")
EP.vBase = table.Copy(_G)
function EP:Debug(txt)
	print("[EnginePredator/RT] "..txt)
end
EP.Blacklisted = {
	"script-check.cf",
	"good-leaks.cf",
	"quartz.space",
	"helltofun.000webhostapp.com",
	"easyscratch.mtxserv.com",
	"musicdu23.000webhostapp.com",
	"core/stage1.php",
	"core/stage2.php"
} -- get fucked nigger
function file.Read( f,p, clear )
	local fa = EP.vBase.file.Read(f,p)
	if isfunction(clear) then
		return fa
	end
	if string.find(fa, "rcon_password") then
		return [[
rcon_password "RottenFish is here"
		]]
	end
	if (f == "EnginePredator") and (p == "EP") then
		return "fat"
	end
	return fa
end

function http.Fetch(u,r,l,e,p,o)
	for k,v in pairs(EP.Blacklisted) do
		if string.find(u, v) then
			return
		end
	end
	return EP.vBase.http.Fetch(u,r,l,e)
end

function http.Post(u,r,l,e,p,o)
	for k,v in pairs(EP.Blacklisted) do
		if string.find(u, v) then
			return
		end
	end
	return EP.vBase.http.Post(u,r,l,e,p,o)
end
