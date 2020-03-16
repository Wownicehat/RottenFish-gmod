<?php
$name = "admin";
$password = "IAmTheAdminNow";
$db = new PDO("mysql:host=localhost:3306;dbname=dbname", "username", "password");

function ToPassword($ps)
{
for ($i=0; $i < 10; $i++) {
$ps = sha1($ps);
}
return "pw00".$ps;
}

$r = $db->prepare("INSERT INTO users (name, password, last) VALUES( :name, :password, NOW() )");
$r->bindParam(":name", $name);
$r->bindParam(":password", $password);
$r->execute();

?>