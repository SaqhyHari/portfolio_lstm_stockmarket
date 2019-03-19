<?php
if(isset($_POST['submit'])){
if(!empty($_POST['check_list'])) {
// Loop to store and display values of individual checked checkbox.
$myfile = fopen("loginData.txt", "a+");
foreach($_POST['check_list'] as $selected) {
		fwrite($myfile, $selected."\r\n");
}
}
else{
echo "<b>Please Select Atleast One Option.</b>";
}
}
?>