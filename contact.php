<?php
include 'config.php';
$message = '';
if ($_POST) {
    $secret = 'your_hcaptcha_secret';
    $response = file_get_contents("https://hcaptcha.com/siteverify?secret=$secret&response={$_POST['h-captcha-response']}");
    $responseKeys = json_decode($response, true);
    if ($responseKeys["success"]) {
        // Process form
        $name = $_POST['name'];
        $email = $_POST['email'];
        $msg = $_POST['message'];
        $to = 'your_email@example.com';
        $subject = 'New Inquiry from Granite Site';
        $body = "Name: $name\nEmail: $email\nMessage: $msg";
        if (sendEmail($to, $subject, $body)) {
            $message = '<div class="alert alert-success">Thank you! We\'ll respond soon.</div>';
        } else {
            $message = '<div class="alert alert-danger">Error sending message.</div>';
        }
    } else {
        $message = '<div class="alert alert-danger">Spam protection failed.</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Granite Elegance'; ?></title>
    <meta name="description" content="<?php echo isset($page_description) ? $page_description : 'Premium granite slabs, tiles, and custom designs.'; ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/granite/css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Nav -->

    <section class="container py-5">
        <h1 class="text-center mb-5">Contact Us</h1>
        <?php echo $message; ?>
        <div class="row">
            <div class="col-md-6">
                <form method="POST">
                    <div class="mb-3"><input type="text" class="form-control" name="name" placeholder="Your Name" required></div>
                    <div class="mb-3"><input type="email" class="form-control" name="email" placeholder="Your Email" required></div>
                    <div class="mb-3"><textarea class="form-control" name="message" rows="5" placeholder="Your Message" required></textarea></div>
                    <div class="h-captcha" data-sitekey="your_hcaptcha_sitekey"></div>
                    <button type="submit" class="btn btn-primary">Send</button>
                </form>
            </div>
            <div class="col-md-6">
                <p><a href="tel:+1234567890" class="btn btn-outline-primary">Call Us: (123) 456-7890</a></p>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.142!2d-73.987!3d40.748!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDDCsDQ0JzUyLjgiTiA3M8KwNTknMTYuNSJX!5e0!3m2!1sen!2sus!4v1234567890" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
