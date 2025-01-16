<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once __DIR__ . '/composer/vendor/autoload.php';
use Dotenv\Dotenv;

class MailerFacade {
    private $mailer;

    public function __construct() {
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();

        $this->mailer = new PHPMailer(true);

        $this->mailer->isSMTP();
        $this->mailer->Host = $_ENV['SMTP_HOST'];
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $_ENV['SMTP_USERNAME'];
        $this->mailer->Password = $_ENV['SMTP_PASSWORD'];
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port = $_ENV['SMTP_PORT'];

        $this->mailer->setFrom($_ENV['SMTP_FROM_EMAIL'], $_ENV['SMTP_FROM_NAME']);
    }

    public function sendEmail($recipient, $subject, $messageBody) {
        try {
            if (empty($recipient) || !filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Invalid recipient email address.");
            }
            if (empty($subject)) {
                throw new Exception("Email subject cannot be empty.");
            }
            if (empty($messageBody)) {
                throw new Exception("Email body cannot be empty.");
            }

            $this->mailer->clearAddresses();
            $this->mailer->addAddress($recipient);
    
            // Email Content
            $this->mailer->isHTML(true);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $messageBody;
    
            // Send Email
            $this->mailer->send();
            return true; // Success
        } catch (Exception $e) {
            throw new Exception("Failed to send email: {$this->mailer->ErrorInfo}");
        }
    }
}

?>