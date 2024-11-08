<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" />
    <link rel="stylesheet" href="detail9.css" />
  </head>
  <body>
    <?php
    session_start(); // Start the session to check if the user is logged in
    ?>
    <div class="main-container">
      <div class="rectangle">
        <div class="shutter-story">
          <span class="shutter">Shutter</span>
          <span class="story">Story</span>
        </div>
        <!-- PHP Code to change Account link dynamically -->
        <?php
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            // User is logged in, show 'My Account' link
            echo '<a style="left: 1800px;" href="my_account.php" class="account">My Account</a>';
        } else {
            // User is not logged in, show 'Login' link
            echo '<a href="Login.html" class="account">Account</a>';
        }
        ?>
        <!-- End of PHP Code -->
                 <div class="account-alert-outline">
        </div>

        <div class="shopping-cart-outlined">
          <div class="vector-1"></div>
        </div>
        <a href="rental_product.php" class="rental-service">Photography Service</a
        ><a href="contact.html" class="contact">Contact</a>

        <a href="Homepage.php"class="home">Home</a>
        <a href="Product.html" class="shop">Product</a>
      </div>
      <div class="rectangle-2">
        <div class="line">
        </div>
         
      </div>
      <div class="flex-row-be">
        <div class="so-a"></div>
        <span class="so-alpha-camera"
          >SONY G LENS 70-100mm</span>
        <span class="rm-price">RM 4,000.00</span>
        <div class="star-filled"><div class="vector-4"></div>
      </div>
        <div class="star-filled-5"><div class="vector-6"></div>
      </div>
        <div class="star-filled-7"><div class="vector-8"></div>
      </div>
        <div class="star-filled-9"><div class="vector-a"></div>
      </div>
        <div class="star-half"><div class="vector-b"></div>
      </div>
        <span class="exmor-sensor"
          >50MP Full-Frame Exmor RS BSI CMOS Sensor<br />Up to 30 fps Shooting,
          ISO 50-102400<br />8K 30p and 4K 120p Video in 10-Bit<br />4.3K 16-Bit
          Raw Video Output, S-Cinetone<br />9.44m-Dot EVF with 240 fps Refresh
          Rate<br />759-Pt. Fast Hybrid AF, Real-time Eye AF<br />5-Axis
          SteadyShot Image Stabilization<br />Dual Drive Mech. Shutter, 1/400
          Sec Sync<br />5 GHz MIMO Wi-Fi, 1000BASE-T Ethernet<br />Dual
          CFexpress Type A/SD Card Slots</span
        >
      </div>
      <div class="flex-row-ed">
        <form method="POST" action="add_to_cart.php">
            <!-- Hidden input to send product ID -->
            <input type="hidden" name="product_id" value="9"> <!-- Replace '1' with the correct product ID -->
            
            <!-- Quantity selection -->
            <div class="rectangle-c">
                <button type="button" onclick="decreaseQuantity()">-</button>
                <input type="number" id="quantity" name="quantity" value="1" min="1" class="number">
                <button type="button" onclick="increaseQuantity()">+</button>
            </div>
    
            <!-- Add to Cart button -->
            <div class="rectangle-d">
                <button type="submit" class="add-to-cart">Add To Cart</button>
            </div>
        </form>
    </div>
    
    <script>
        // JavaScript functions to increase or decrease the quantity
        function increaseQuantity() {
            var quantity = document.getElementById('quantity');
            quantity.value = parseInt(quantity.value) + 1;
        }
    
        function decreaseQuantity() {
            var quantity = document.getElementById('quantity');
            if (quantity.value > 1) {
                quantity.value = parseInt(quantity.value) - 1;
            }
        }
    </script>
      <div class="flex-row-b">
        <div class="rectangle-e">
          <div class="line-f"></div>
          <span class="description">Description</span>
          <span class="description-10"
            >A flagship in the truest sense, the Sony Alpha a1 is the one camera
            designed to do it all. Built without compromise, this full-frame
            mirrorless offers high-resolution for stills shooting, impressive 8K
            video recording, speed and sensitivity, and connectivity for the
            most demanding professional workflows.<br /><br />At its core, the
            a1 is distinguished by a newly designed 50.1MP full-frame Exmor RS
            BSI CMOS sensor and the BIONZ XR processing engine. Pairing the
            efficient stacked sensor design with optimized processing means the
            a1 is capable of 30 fps continuous shooting at full-resolution, 8K
            30p and 4K 120p 10-bit video recording, and still offers versatile
            sensitivity up to ISO 102400 for low-light shooting. The sensor's
            design also includes a 759-point Fast Hybrid AF system, which offers
            advanced subject tracking and Real-time Eye AF on humans and
            animals, even including a dedicated Bird Mode.<br />
          </span>
          <div class="flex-row-afe">
            <div class="so-a-11"></div>
            <div class="so-a-12"></div>
          </div>
          <div class="line-13"></div>
        </div>
        <div class="rectangle-14">
          <span class="related-products">Related Products</span>
          <div class="flex-row-dff">
            <div class="so-selgm"></div>
            <div class="regroup">
              <div class="nk-e"></div>
              <div class="so-selg"></div>
            </div>
          </div>
          <div class="flex-row-fd">
            <span class="sony-g-lens">SONY G LENS 70-100mm</span
            ><span class="nikon-f">NIKON 100-200mm f2.5</span
            ><span class="sony-g-lens-15">SONY G LENS 24-70mm f1.8</span>
          </div>
          <div class="flex-row">
            <span class="rm">RM 25,000.00</span
            ><span class="rm-16">RM 25,000.00</span
            ><span class="rm-17">RM 25,000.00</span>
          </div>
        </div>
        <div class="so-selfgm"></div>
        <span class="nikon-mm-f">NIKON 50mm f1.8 </span
        ><span class="rm-18">RM 25,000.00</span>
        <div class="rectangle-19">
          <div class="flex-row-bee">
            <span class="free-delivery">Free Delivery</span
            ><span class="secure-payment">Secure Payment</span>
          </div>
          <div class="flex-row-1a">
            <span class="orders-over-rm">For all orders over RM500.</span
            ><span class="secure-payment-1b">100% secure payment.</span>
          </div>
        </div>
      </div>
      <div class="rectangle-1c">
        <span class="links">Quick Links</span>
        <div class="flex-row-cd">
          <span class="home-1d">Home</span
          ><span class="photography-service">Photography Service</span>
        </div>
        <div class="flex-row-ed-1e">
          <span class="shop-1f">Product</span
          ><span class="rental-policy">Rental Policy</span>
        </div>
        <span class="about">About</span><span class="contact-20">Contact</span>
        <div class="line-21"></div>
        <span class="all-rights-reserved"
          >2024 ShutterStory. All rights reserved</span
        >
      </div>
    </div>
  </body>
</html>
