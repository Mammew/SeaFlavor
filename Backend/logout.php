<?php
    if (isset($_POST["logout"])) {
        session_start();
        setcookie("rememberMe","",time()-120);
        session_destroy();
        header("Location: ../Frontend/home.php");
    }
    header("Location: ../Frontend/home.php");
?>