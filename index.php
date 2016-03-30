<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<div>
	<form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
  <select name="user">
    <option value="1">AlexA</option>
    <option value="2">AlexD</option>
    <option value="3">Cezar</option>
    <option value="4">Sebi</option>
  </select>
  <input type="submit">
</form>
</div>

<?php
$dir = 'sqlite:/var/db/tpaper.db';
$db  = new PDO($dir) or die("cannot open the database");
print "<table class ='center'>";
print "<tr><td>Id</td><td>Name</td><td>Buy</td><td>Date</td></tr>";
$result = $db->query('SELECT * FROM users ORDER BY BUY, date ASC ');
foreach($result as $row)
{
print "<tr><td>".$row['ID']."</td>";
print "<td>".$row['NAME']."</td>";
print "<td>".$row['BUY']."</td>";
print "<td  style=\"width:50px\">".$row['date']."</td></tr>";
}
print "</table>";

if (!empty($_POST)) {
	$result = $db->query('SELECT * FROM users');
	$array = $result->fetchAll(); 
	$today = date("Y-m-d");
	$idd = $_POST['user'] - 1;
	$then = $array[$idd][date];
	if((strtotime($today) - strtotime($then)) < 172800 ){
		print "<script type='text/javascript'>alert(\"2 days must pass until you can make a buy\")</script>";
	}else{
		$db->exec("update users set buy = buy + 1, date = date('now') WHERE ID = ".$_POST['user'].";");
		header("Refresh:0");
	}
}


$result = $db->query('SELECT * FROM users ORDER BY BUY, date ASC ');
$array = $result->fetchAll(); 

print "Must buy : ".$array[0][NAME];


$db = NULL;
?>
</body>
</html>