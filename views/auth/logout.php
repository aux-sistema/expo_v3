<?php
session_start();
session_unset(); 
session_destroy();
header('Location: /expo_v2/login'); 
exit();
?>