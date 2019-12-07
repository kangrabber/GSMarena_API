<?php
require('config.php');
if(empty($_GET['url'])){
    exit('URL TIDAK BOLEH KOSONG');
}
header("Content-Type: application/json");
echo gsmArena($_GET['url']);
?>