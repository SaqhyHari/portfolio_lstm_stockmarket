<?php include('server.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
input[type=text], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}
input[type=password], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}
div {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}
.button {
  padding: 19px 39px 18px 39px;
  color: #000;
  background-color: #D3D3D3;
  font-size: 18px;
  text-align: center;
  font-style: normal;
  border-radius: 5px;
  width: 100%;
  border: 1px solid #3ac162;
  border-width: 1px 1px 3px;
  box-shadow: 0 -1px 0 rgb(211,211,211,211) inset;
  margin-bottom: 10px;
}
a:link {
  color: white;
}

/* visited link */
a:visited {
  color: white;
}

/* mouse over link */
a:hover {
  color: white;
}

/* selected link */
a:active {
  color: white;
}</style>	
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
	
	<div class="container-login100" style="background-image: url('https://pixelz.cc/wp-content/uploads/2018/08/stock-market-electronic-chart-bullish-uhd-4k-wallpaper.jpg');">
			
		<div class="wrap-login100">
		
				<form method="post" action="">
						<?php include('errors.php'); ?>

					<span class="login100-form-title p-b-34 p-t-27">
						Log in
					</span><label for="fname">Username</label>
    <input type="text" name="username" placeholder="Username...">

    <label for="lname">Password</label>
    <input type="password" name="password" placeholder="Password...">

<br><br>
  		<input type="submit" class="button" value="Login" name="submit" />

  		Not yet a member? <a href="register.php">Sign up</a>
  </form>
  <?php
if(isset($_POST["submit"])){
if(!empty($_POST['username']) && !empty($_POST['password'])) {
	$user=$_POST['username'];
	$pass=$_POST['password'];
	$db = mysqli_connect('localhost', 'root', '', 'user');
	//mysql_select_db('user') or die("cannot select DB");
	$user_check_query = "SELECT * FROM login WHERE username='".$user."' AND password='".$pass."'";
	$result = mysqli_query($db, $user_check_query);
	$numrows=mysqli_num_rows($result);
	if($numrows!=0)
	{
	while($row=mysqli_fetch_assoc($result))
	{
	$dbusername=$row['username'];
	$dbpassword=$row['password'];
	}
	if($user == $dbusername && $pass == $dbpassword)
	{
	session_start();
	$_SESSION['username']=$user;
	/* Redirect browser */
	header("Location: dash.php");
	}
	} else {
	echo "Invalid username or password!";
	}
} 
        else 
        {
	echo "All fields are required!";
        }
		
}
?>

			</div>
		
		</div>
		
	</div>
	
</body>
</html>