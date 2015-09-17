<?php
// CREATE TABLE Posts
// {
// id INT PRIMARY KEY AUTO_INCREMENT,
// title VARCHAR(200),
// url VARCHAR(200)
// }

$conn=mysql_connect('localhost', 'root', '') or die('Could not connect to server.' );;
mysql_select_db('testcode', $conn) or die('Could not select database.');
$sql="select * from post limit 20";

$response = array();
$posts = array();
$result=mysql_query($sql);
while($row=mysql_fetch_array($result)) 
{ 
$title=$row['title']; 
$url=$row['url']; 

$posts[] = array('title'=> $title, 'url'=> $url);

} 

$response['posts'] = $posts;

$fp = fopen('results.json', 'w');
fwrite($fp, json_encode($response));
fclose($fp);

// $json=json_encode($response);
// printf($json);
// var_dump($json);

$string = file_get_contents("results.json");
$jsonRS = json_decode ($string,true);
$jsonData = $jsonRS['posts'];
// var_dump($jsonRS);
$jsonData[0]["title"] = "TENNIS";
$newJsonString = json_encode($jsonData);
file_put_contents('results.json', $newJsonString);

echo "<table border='1'>";
$title="";$url="";
foreach ($jsonData as $rs) {
  	$title = stripslashes($rs["title"]);
  	$url = stripslashes($rs["url"]);
  	echo "
		<tr>
			<td>".$title."</td>
			<td>".$url."</td>
		</tr>
  	";
}
echo "</table>";
?>
