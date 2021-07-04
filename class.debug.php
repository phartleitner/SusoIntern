<?php

class Debug{

public static function writeDebugLog($methode,$message){
$fh = fopen("log.php","a");
fwrite($fh,"<?php\r\n---------------------------------------------------------------------------");
fwrite($fh,"\r\nmessage sent from ".$methode);
$now = date('Ymd H:i:s');
fwrite($fh,"\r\n".$message." - ".$now);
fwrite($fh,"\r\n".'?>');


fclose($fh);
}


}