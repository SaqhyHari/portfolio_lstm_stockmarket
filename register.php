<?php include('server.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Register</title>
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
	<link rel="stylesheet" type="text/css" href="css/main.css"></head>
<body>
  
	<div class="limiter">
	
	<div class="container-login100" style="background-image: url('images/bg-01.jpg');">
			
		<div class="wrap-login100">
		
				<form method="post" action="">
						<?php include('errors.php'); ?>

					<span class="login100-form-title p-b-34 p-t-27">
						Register
					</span><label for="fname">Username</label>
    <input type="text" name="username" placeholder="Username...">

    <label for="lname">Password</label>
    <input type="password" name="password_1" placeholder="Password...">

	<label for="mname">Retype Password</label>
    <input type="password" name="password_2" placeholder="Password...">

<br><br>
  		<input type="submit" class="button" value="Register" name="reg_user" />
  		Already a member? <a href="index.php">Sign in</a>
  </form>
  
</body>
</html>