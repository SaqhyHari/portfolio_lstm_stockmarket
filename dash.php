<?php 
  session_start(); 
  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: index.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: index.php");
  }
?><!DOCTYPE html>
<html lang="en">
<title>Share Market Recommendation System</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<style>
.mySlides {display:none;}
input[type=text], select {
  width: 25%;
  padding: 12px 20px;
  margin: 8px 0px;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing:content-box ;
}
.button {
  background-color: #D3D3D3;
  border: none;
  color: black;
  padding: 15px 30px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 150px;
  cursor: pointer;
}
body,h1,h2,h3,h4,h5,h6 {font-family: "Lato", sans-serif}
.w3-bar,h1,button {font-family: "Montserrat", sans-serif}
.fa-anchor,.fa-coffee {font-size:200px}
	a{text-decoration: none;}
img {
  float: left;
  width: 100%;
  padding:20px;
  }
</style>
<body>
<!-- Navbar -->
<div class="w3-top">
  <div class="w3-bar w3-red w3-card w3-left-align w3-large">
    <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-red" href="javascript:void(0);" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
    <?php  if (isset($_SESSION['username'])) : ?>
    	<p>Welcome <strong><?php echo $_SESSION['username']; ?></strong>, <a href="dash.php?logout='1'" style="color: blue;">logout</a> </p>
    <?php endif ?>
	<a href="#" class="w3-bar-item w3-button w3-padding-large w3-white">Home</a>
	<a href="#invst" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">Output</a>
<!--    <a href="" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">Previous Invst</a>-->
    <a href="#contact" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">Contact</a>
  </div>
</div>
<!-- Header -->
<header class="w3-container w3-red w3-center" style="padding:128px 16px">
  <form method="post"><br>
		<h1>Investmest Amount:</h1>
				<input type="text" name="amt"/><br><br>
		<label class="heading">Select Your Preferred Sectors:</label><br>
<pre><input type="checkbox" name="check_list[]" value="Finance"><label>Finance</label>  <input type="checkbox" name="check_list[]" value="Pharma"><label>Pharma</label>  <input type="checkbox" name="check_list[]" value="IT"><label>IT</label>  <input type="checkbox" name="check_list[]" value="Banking"><label>Banking</label>  <input type="checkbox" name="check_list[]" value="Energy"><label>Energy</label>
</pre>
	<br><br>	<input type="submit" class="button" name="submit" value="Submit"/>
</form>
		<?php
		$myfile = fopen("loginData.txt", "w");
		if (isset($_POST['amt'])) {
		$txt = $_POST['amt'];
		fwrite($myfile, $txt."\r\n");
		}
		?>
<?php include 'checkbox_value.php';?>
<?php
if(isset($_POST["submit"])){
	header("Location: openanaconda.php");
}
?>
</header>
<!-- First Grid -->
<div class="w3-row-padding w3-padding-64 w3-container" id="invst">
  <div class="w3-content">
    <div class="w3-twothird">
      <h1>Recommendation</h1>
      <p><pre>	<?php
$myfile = fopen("loginData1.txt", "r") or die("Unable to open file!");
echo fread($myfile,filesize("loginData1.txt"));
fclose($myfile);
?>	</pre></p>
    </div>
    <div class="w3-third w3-center">
      <i class="fa fa-anchor w3-padding-64 w3-text-red"></i>
    </div>
  </div>
</div>
<!-- Second Grid -->
<div class="w3-row-padding w3-light-grey w3-padding-64 w3-container">
  <div class="w3-content">
    
    <div class="w3-twothird">
      <h1>Graph</h1>
      <div class="w3-content w3-display-container"><br>
  <?php
$files = glob("NSE/*.*");
for ($i = 0; $i < count($files); $i++) {
    $image = $files[$i];
    echo '<img src="' . $image . '" class="myslides"alt="Random image" />' . "<br /><br />";
}
?>
  <button class="w3-button w3-black w3-display-left" onclick="plusDivs(-1)">&#10094;</button>
  <button class="w3-button w3-black w3-display-right" onclick="plusDivs(1)">&#10095;</button>
</div>
</div>
</div>
</div>
<div class="w3-row-padding w3-padding-64 w3-container" id="invst">
  <div class="w3-content">
    <div class="w3-twothird">
      <h1>Estimated Profit :</h1>
      <p><pre>	<?php
$myfile = fopen("loginData2.txt", "r") or die("Unable to open file!");
echo fread($myfile,filesize("loginData2.txt"));
fclose($myfile);
?>	</pre></p>
    </div>
  </div>
</div>
<!-- Footer -->
<footer class="w3-container w3-padding-64 w3-center w3-opacity" id="contact">  
  <div class="w3-container w3-black w3-center w3-opacity w3-padding-64">
    <h1 style="text-align:center">Contact Details : </h1>
		<h6>E-mail : bebar@gmail.com </h6>
</div>
</footer>
<script>
var slideIndex = 1;
showDivs(slideIndex);
function plusDivs(n) {
  showDivs(slideIndex += n);
}
function showDivs(n) {
  var i;
  var x = document.getElementsByClassName("mySlides");
  if (n > x.length) {slideIndex = 1}
  if (n < 1) {slideIndex = x.length}
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  x[slideIndex-1].style.display = "block";  
}
</script>
</body>
</html>