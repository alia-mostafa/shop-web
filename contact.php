<?php session_start();
$host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "myapp";
$mysqli = new mysqli($host, $db_user, $db_pass, $db_name);
if ($mysqli->connect_errno) {
    die("Failed to connect to MySQL: " . $mysqli->connect_error);
}
if (isset($_POST['submit_contact'])) {
    $name = $mysqli->real_escape_string($_POST['name']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $message = $mysqli->real_escape_string($_POST['message']);
    $sql = "INSERT INTO p (name, email, message) VALUES ('$name', '$email', '$message')";
    if ($mysqli->query($sql)) {
        echo "Message sent successfully!";
    } else {
        echo "Error: " . $mysqli->error;
    }
}
$mysqli->close(); ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/stylecontact.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.1.0/css/all.min.css">

</head>

<body>


    <header class="navbar">
        <div class="logo">MY<span>STORE</span></div>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Products</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="">Account</a></li>
            </ul>
        </nav>
    </header>

    <section>

        <div class="container1">

            <h1 class="h1_contact">
                Contact
            </h1><!-- end of h1_contact -->

            <p style="text-transform: capitalize
        ;" class="p_contact">
                fill out the form below and we will get back to you as soon as possible.
            </p>
            <form action="contact.php" method="POST" class="form_contact">

                <label for="">Name</label>
                <input type="text" class="input_contact" name="name" style="gap: 0px;" placeholder="Full Name" required>
                <label for="">Email</label>
                <input type="email" name="email" class="input_contact" placeholder="Email Address" required>
                <label for="">Message</label>
                <textarea name="message" id="" cols="60" rows="10" class="textarea_contact"
                    placeholder="Your Message"></textarea>

                <button type="submit" name="submit_contact"
                    style="width: 60px; height: 30px; border-radius: 6px; border: none;"
                    class="button_contact">Send</button>

            </form><!-- end of form_contact -->

        </div><!-- end of container 1 -->


        <div class="container2">
            <h2 class="h2_contact">
                Get in Touch
            </h2><!-- end of h2_contact -->
            <h3 style="padding: 30px 0 0 0;">Contact information</h3>
            <div class="conact_info">

                <div style="display: flex; gap: 5px;" class="email_info">
                    <div class="img"> <img style="display: inline;" width="20" height="20"
                            src="icons/envelope-regular-full.svg" alt=""></div>
                    <span style="padding-top: 2px;">support@mystore.com</span><br>
                </div><!-- end of email_info -->

                <div style="display: flex; gap: 5px;" class="email_info">
                    <div class="img"> <img style="display: inline;" width="20" height="20"
                            src="icons/phone-solid-full.svg" alt=""></div>
                    <span style="padding-top: 2px;">+20 1234 567 890</span>
                </div><!-- end of email_info -->

                <div style="display: flex; gap: 5px;" class="email_info">
                    <div class="img"> <img style="display: inline;" width="20" height="20"
                            src="icons/clock-regular-full.svg" alt=""></div>
                    <span style="padding-top: 2px;">Monday - Friday: 9am - 5pm</span>
                </div><!-- end of email_info -->



            </div><!-- end of contact_info -->
            <div class="map">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d110315.8240905454!2d31.422659339710883!3d30.22653777591069!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14581ab73d4ca47d%3A0x89e1c92d1d007f67!2sAl%20Obour%20City%2C%20Obour%2C%20Al-Qalyubia%20Governorate!5e0!3m2!1sen!2seg!4v1764101024045!5m2!1sen!2seg"
                    width="300" height="250" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div><!-- end of map -->

            <div class="social_contact">
                <h3 class="follow">
                    Follow Us
                </h3>
                <div class="social_icons">
                    <a href="#"> <img src="icons/instagram-brands-solid-full.svg" alt=""></a>
                    <a href="#"> <img src="icons/linkedin-brands-solid-full.svg" alt=""></a>
                    <a href="#"><img src="icons/square-facebook-brands-solid-full.svg" alt=""></a>
                    <a href="#"><img src="icons/square-twitter-brands-solid-full.svg" alt=""></a>

                </div><!-- end of social_contact -->





            </div><!-- end of container 2 -->

    </section><!-- end of section -->

</body>

</html>