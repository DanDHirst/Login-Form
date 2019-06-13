<?php
//start session then destroy it
session_start();
session_destroy();
//change to index file
header("Location: ../index.php");
exit;