<?php
    session_start();
    setcookie("rememberMe","",time()-120);
    session_destroy();
    header("Location: ../Frontend/home.php");
?>