<?php
$myfile = fopen("users.txt", "a+") or die("Unable to open file!");
// echo fread($myfile,filesize("users.txt"));
$txt = "amr.adwan@hotmail.com|Amr Adwan|amr236037\n";
fwrite($myfile, $txt);
fclose($myfile);
?>