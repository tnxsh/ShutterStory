<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ShutterStory</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" />
    <link rel="stylesheet" href="oricontact.css" />
  </head>
  <body>

  <?php
    session_start(); 

    if (isset($_SESSION['feedback_message'])) {
        echo '<div class="feedback-message">' . $_SESSION['feedback_message'] . '</div>';
        unset($_SESSION['feedback_message']); 
    }
    ?>

    <?php
    session_start(); 
    ?>
    <div class="main-container">
      <form action="feedback.php" method="POST"> 
      <div class="rectangle">
        <div class="account-alert-outline">
        </div>
        <div class="shutter-story">
          <span class="shutter">Shutter</span>
          <span class="story">Story</span>
        </div>
        <a href="cart.php">
        <div class="shopping-cart-outlined">
          <div class="vector-1"></div>
        </div>
        </a>

        <?php
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

          echo '<a style="left: 1800px;" href="my_account.php" class="account">My Account</a>';
        } else {

          echo '<a href="Login.html" class="account">Account</a>';
        }
        ?>

        <a href="photo1.html" class="rental-service">Photography Service</a>
        <span class="contact-2">Contact</span>
        <a href="Homepage.php" class="home">Home</a>
        <a href="Product.php" class="shop">Product</a>
        <div class="mdi-account-alert-outline"></div>
      </div>
      <div class="rectangle-3">
        <div class="meubel-house-logos">
        </div>
        <span class="contact-4">Contact</span>
      </div>
      <div class="rectangle-5">
        <span class="get-in-touch">Get In Touch With Us</span>
        <div class="flex-row-d">
          <span class="product-services-info"
            >For More Information About Our Product & Services. Please Feel Free
            To Drop Us An Email. Our Staff Always Be There To Help You Out. Do
            Not Hesitate!</span>

          <div class="rectangle-6">
            <div class="flex-column-ca">
              <span class="phone">Phone</span>
              <span class="mobile-hotline"
                >Mobile: 0123 456789<br />Hotline: 0123456789</span>
              <span class="working-time">Working Time</span>
              <span class="opening-hours"
                >Monday-Friday: 9:00 - 22:00 <br />Saturday-Sunday: 9:00 -
                21:00</span>
            </div>
            <div class="flex-column-fae">
              <div class="bxs-phone">
                <div class="vector-7">
                </div>
              </div>
              <div class="bi-clock-fill">
                <div class="vector-8">
                </div>
              </div>
            </div>
          </div>
          <div class="rectangle-9">
            <span class="your-name">Your name</span>
            <div class="rectangle-a">               
              <input type="text" id="name" name="name" class="login-input" placeholder="Your Name" />
            </div>
            <span class="email-address">Email address</span>
            <div class="rectangle-b">
              <input type="text" id="email" name="email" class="login-input" placeholder="Email Address" />
            </div>
            <span class="subject">Message</span>
            <div class="rectangle-d">
              <input type="text" id="message" name="message" class="login-input" placeholder="Your Message" />
            </div>
            <div class="rectangle-e">
              <button class="submit">Submit</span>              
            </div>
          </div>

        </div>
      </div>
      <div class="rectangle-f">
        <div class="flex-row-ddd">
          <span class="free-delivery">Free Delivery</span>
          <span class="secure-payment">Secure Payment</span>
        </div>
        <div class="flex-row-d-10">
          <span class="orders-over-rm">For all orders over Rm 5000.</span>
          <span class="secure-payment-11">100% secure payment.</span>
        </div>
      </div>
      <div class="rectangle-12">
        <div class="flex-row-a">
          <span class="links">Links</span><span class="help">Help</span>
        </div>
        <div class="flex-row">
          <a href="Homepage.php" class="home-13">Home</a>
          <span class="photography-service">Photography Service</span>
        </div>
        <div class="flex-row-a-14">
          <span class="shop-15">Product</span>
        </div>
        <span class="contact-16">Contact</span>
        <span class="all-rights-reserved">2024 ShutterStory. All rights reserved</span>
      </div>
      <div class="line">
      </div>
    </div>
  </body>
</html>
