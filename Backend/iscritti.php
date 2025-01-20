<?php
    session_start();
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require '../vendor/autoload.php';
    
    if (isset($_SESSION['email']) && isset($_POST['submit'])) {
        
        include 'db_connection.php';
        
        $email = $_SESSION['email'];
        $newsletter = 1;
        try {
            $stmt = $conn->prepare("SELECT * FROM utenti WHERE email = ?");
        } catch (mysqli_sql_exception $e) {
            error_log("Prepared failed: (" . $e . ")");
            echo "Query error...";
            $conn->close();
            exit();
        }
        $stmt->bind_param('s', $email);
        try {
            $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            error_log("Query failed: (" . $e . ")");
            echo "Query fauled...";
            $stmt->close();
            $conn->close();
        }
        $result = $stmt->get_result();
        $rows = $result->fetch_assoc();
        if ($rows["newsletter"] == 1) {
            // in teoria far apparire un alert
            echo "Sei già iscritto alla newsletter.";
        }
        else{
            try {
                $stmt = $conn->prepare("UPDATE utenti SET newsletter = ? WHERE email = ?");
            } catch (mysqli_sql_exception $e) {
                error_log("Prepared failed: (" . $e . ")");
                echo "Query error...";
                exit();
            }
    
            $stmt->bind_param('is', $newsletter, $email);
            try {
                $stmt->execute();
            } catch (mysqli_sql_exception $e) {
                error_log("Query failed: (" . $e . ")");
                echo "Query fauled...";
                $stmt->close();
                $conn->close();
            }
            // parte tutta la roba di PHPMailer
            $mail = new PHPMailer(true);
            try {
                // Configurazione del server SMTP
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Sostituisci con il tuo host SMTP
                $mail->SMTPAuth = true;
                $mail->Username = 'seaflavour.newsletter@gmail.com'; // Sostituisci con il tuo indirizzo email
                $mail->Password = 'oozg kern hhwx cmbm'; // Sostituisci con la tua password email
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                // Destinatari
                $mail->setFrom('seaflavour.newsletter@gmail.com', 'SeaFlavor-Support');
                $mail->addAddress($email);
                // Contenuto dell'email
                $mail->isHTML(true);
                $mail->Subject = 'Benvenuto nella nostra Newsletter!';
                $mail->Body    = 'Grazie per esserti iscritto alla nostra newsletter. Siamo felici di averti con noi!';
                $mail->send();
                echo 'Email di benvenuto inviata con successo.';
                header("Location: ../Frontend/home.php");
            } catch (Exception $e) {
                echo "Errore nell'invio dell'email: {$mail->ErrorInfo}";
            }
        }
    }
    else
        header("Location: ../Frontend/login.html");
?>