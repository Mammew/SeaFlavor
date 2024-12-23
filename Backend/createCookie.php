<?php
        function createCookie($email,$cookieValue,$timestamp,$conn)
        {
            setcookie("rememberMe",$cookieValue,$timestamp);
            $cookieExpire = date("Y-m-d H:i:s",$timestamp);
            try {
                $stmt = $conn->prepare("UPDATE user SET id_cookie = ?, cookie_expire = ? WHERE email = ?");
            } catch (mysqli_sql_exception $e) {
                error_log("Prepared failed: (" . $e . ")");
                echo "Query error...";
                return false;
            }
    
            $stmt->bind_param('sss', $cookieValue,$cookieExpire,$email);
            try {
                $stmt->execute();
            } catch (mysqli_sql_exception $e) {
                error_log("Query failed: (" . $e . ")");
                echo "Query fauled...";
                return false;
            }
            return true;
        }
?>