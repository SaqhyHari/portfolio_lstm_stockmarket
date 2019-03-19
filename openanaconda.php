<htlm>

<body>
<?php
execInBackground('start cmd.exe @cmd /K "C:\ProgramData\Anaconda3\Scripts\activate.bat C:\ProgramData\Anaconda3 && python C:\xampp\htdocs\Final\portfolio.py"');
function execInBackground($cmd) { 
    if (substr(php_uname(), 0, 7) == "Windows"){ 
        pclose(popen("start /B ". $cmd, "r"));  

    } 
    else { 
        exec($cmd . " > /dev/null &");   
    } 
}
//header("Location: dash.php");
?>
</body>
</htlm>