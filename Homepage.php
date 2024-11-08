<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" />
    <link rel="stylesheet" href="homepage.css" />
  </head>
  <body>
    <?php
    session_start(); 
    ?>
    <div class="main-container">
      <div class="rectangle">
        <span class="quick-links">Quick Links</span>
        <div class="flex-row-ae">
          <a href="Homepage.php" class="home-1">Home</a>
        </div>
        <div class="flex-row-d">
          <a href="Product.php" class="shop">Product</a>
        </div>
        <a href="photo1.html" class="rental-service">Photography Service</a>
          <a href="Contact.php" class="contact">Contact</a>
            <div class="line"></div>
        <span class="all-rights-reserved"
          >2024 ShutterStory. All rights reserved</span>
      </div>
      <div class="rectangle-2">
        <div class="shutterstory">
          <span class="shutter">Shutter</span>
          <span class="story">Story</span>
        </div>
        <a href="cart.php">
          <div class="ant-design-shopping-cart-outlined">
            <div class="vector-3"></div>
          </div>
        </a>

        <?php
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            echo '<a style="left: 1800px;" href="my_account.php" class="account">My Account</a>';
        } else {
            echo '<a href="Login.html" class="account">Account</a>';
        }
        ?>

        <a href="photo1.html" class="rental-service-4">Photography Service</span>
        <a href="Contact.php" class="contact-5">Contact</a>
        <a href="Homepage.php" class="home-6">Home</a>
        <a href="Product.php" class="shop-7">Product</a>
      </div>
      <div class="sony-ar-v-view"></div>
      <div class="rectangle-8">
        <div class="shutterstory-9">
          <span class="shutter-a">Shutter</span
          ><span class="story-b">Story</span>
        </div>
      </div>
      <div class="rectangle-c">
        <span class="top-picks-for-you">Top Picks For You</span
        ><span class="bright-ideal-selection"
          >Find a bright ideal to suit your taste with our great selection of
          suspension</span
        >
        <div class="flex-row">
          <div class="mask-group"><div class="cn-eosrp"></div></div>
          <div class="so"></div>
          <div class="cn-er-body"></div>
          <div class="cn-eosrp-stm"></div>
          <div class="sony-alpha-a-iv">
            <span class="line-break"><br /></span>
            <a href="Detail2.php" class="sony-alpha-a-iv-d">Sony Alpha a7 IV Mirrorless <br />Digital Camera</a>
          </div>
          <div class="canon-eos-rp">
            <span class="line-break-e"><br /></span>
            <a href="Detail6.php" class="canon-eos-rp-mirrorless">Canon EOS RP Mirrorless Digital Camera</a>
          </div>
          <div class="canon-eos-rp-mirrorless-f">
            <span class="line-break-10"><br /></span>
            <a href="Detail7.php" class="canon-eos-rp-mirrorless-11">Canon EOS RP Mirrorless Digital Camera</a>
          </div>
          <a href="Detail5.php" class="plain-console-teak-mirror">Plain console with teak mirror</a>
        </div>
        <div class="flex-row-bc">
          <span class="price-12000">RM 11,000.00</span>
          <span class="price-8500">RM 9,000.00</span>
          <span class="price-7500">RM 8,000.00</span>
          <span class="price-7500-12">RM 10,000.00</span>
        </div>
      </div>
      <div class="website-banner-eos-r"></div>
      <div class="rectangle-13">
        <span class="our-blogs">Our Blogs</span
        ><span class="bright-ideal-selection-14"
          >Find a bright ideal to suit your taste with our great selection</span
        >
        <div class="flex-row-15">
          <div class="div"></div>
          <div class="div-16"></div>
        </div>
        <div class="flex-row-e">
          <span class="span">Going all-in with millennial design</span
          ><span class="span-17">Going all-in with millennial design</span>
        </div>
      </div>
      <div class="div-18"></div>
      <span class="span-19">Going all-in with millennial design</span>
      <div class="div-1a">
        <span class="span-1b">ShutterStory</span
        ><span class="span-1c">Follow our store on IG</span>
        <div class="div-1d">
            <span class="span-1e">Follow Us</span></div>
      </div>
    </div>
  </body>
</html>
