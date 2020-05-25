<?php 
setcookie('username','value', '0','/','localhost',true, true);
session_start();
header( "Set-Cookie: name=value; httpOnly" );
include 'connection.php';
if (!$_SESSION) {
	header("Location: login.php");
	exit();
}

$id = $_SESSION['id'];
$query = "SELECT `teacher_name`, `data` FROM `data` WHERE `teacher_id`=$id";
$result = mysqli_query($con, $query);
$name = mysqli_fetch_assoc($result);

echo '<center>';
echo '<br>';
echo '<br>';
echo '<br>';
echo '<h1> Welcome &nbsp  '.$name['teacher_name'].'<br> </h1>';
echo '<h2> Live Status: '.$name['data'].'<br> </h2>';
?>

<div style="width: 300px; height: 200px;  padding: 20px; background: rgba(0%,0%,0%,0.2);">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
	<br><p>
	<h3 align="center">SELECT STATUS</h3>
	<select name="data" style="width: 100px; height: 30px;">
	<option value="Busy">Busy</option>
	<option value="Available">Available</option>
	<option value="Other">Other</option>
	</select>
	<br>
	<br>
	<center><input type="submit" name="submit" value="submit"></p></center>
</form>
</div>

<?php  
if(isset($_POST['submit']))
{
	$data = htmlspecialchars($_POST['data']);
	if($data==""){
		echo "Enter a valid status";
	}
	else if($data=="other")
	{
		echo '<br>';
		echo "<form action=\"data.php\" method=\"POST\">
		Enter Status: <input  type=\"text\" name=\"data\">
		<input type=\"submit\" name=\"submit\" value=\"submit\">
		</form>";
	}
	else{
		$sql = "UPDATE data SET `data`= '$data' WHERE `teacher_id`= $id";
		if (mysqli_query($con, $sql)) {
			header("Location: data.php");
		} else {
			echo "Error updating record: " . $con->error;
		}
	}
}
echo '</center>';
?>

<!DOCTYPE html>
<html>
<head>
	<style type="text/css">
		p {
			color: blue;
		}
		body{
			background-image: url('green.jpg');
		}
	</style>
</head>
<body>
<p align="right"><a href="logout.php">Logout</a></p>
</body>
</html>
