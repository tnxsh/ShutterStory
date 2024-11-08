<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ShutterStory</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" />
    <link rel="stylesheet" href="Rental_detail1.css" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  </head>
  <body>
    <?php
    session_start(); // Start the session to check if the user is logged in
    ?>
    <div class="main-container">
      <div class="rectangle">
        <div class="shutter-story">
          <span class="shutter">Shutter</span><span class="story">Story</span>
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
          <div class="account-alert-outline"></div>
        <div class="shopping-cart-outlined">
          <div class="vector-1"></div></div>
        <a href="rental_product.php" class="rental-service">Photography Service</a
        ><a href="contact.html" class="contact">Contact</a>
        <a href="Homepage.php" class="home">Home</a
          ><a href="Product.html" class="shop">Product</a>
      </div>
      <div class="rectangle-2">
        <div class="line"></div>
      </div>
      <div class="flex-row-be">
        <div class="so-a"></div>
        <span class="so-alpha-camera"
          >Sony Alpha a1 Mirrorless <br />Digital Camera (Full Set) <br /><br
        /></span>
        <div class="star-filled"><div class="vector-4"></div></div>
        <div class="star-filled-5"><div class="vector-6"></div></div>
        <div class="star-filled-7"><div class="vector-8"></div></div>
        <div class="star-filled-9"><div class="vector-a"></div></div>
        <div class="star-half"><div class="vector-b"></div></div>
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
    <form method="POST" action="rental_checkout.php">
        <!-- Hidden input to send product ID -->
        <input type="hidden" name="product_id" value="1"> <!-- Replace '1' with the correct product ID -->
        
        <!-- Pickup Date selection -->
        <label for="pickup_date">Pick-up Date:</label>
          <input type="date" id="pickup_date" name="pickup_date" required>

          <!-- jQuery script to initialize datepicker -->
          <script>
            $(document).ready(function() {
              $("#pickup_date").datepicker({
                dateFormat: 'yy-mm-dd', // Format the date to match your database (year-month-day)
                changeMonth: true, // Optional: Dropdown for month
                changeYear: true,  // Optional: Dropdown for year
                minDate: 0         // Optional: Disable past dates
              });
            });
          </script>
        </div>

        <!-- Return Date selection -->
        <label for="return_date" style="margin-left: 1101px;">Return Date:</label>        
        <input type="date" id="return_date" name="return_date" required>

        <!-- jQuery script to initialize datepicker -->
        <script>
          $(document).ready(function() {
            $("#return_date").datepicker({
              dateFormat: 'yy-mm-dd', // Format the date to match your database (year-month-day)
              changeMonth: true, // Optional: Dropdown for month
              changeYear: true,  // Optional: Dropdown for year
              minDate: 0         // Optional: Disable past dates
            });
          });
        </script>
        </div>

        <div class="rectangle-t" style="
                    flex-shrink: 0;
                    position: relative;
                    width: 242.724px;
                    height: 76.222px;
                    bottom: 2858px;
                    left: 1467px;
                    border: none;
                    border-radius: 15px;
                ">
            <h3>Rental Rates</h3>
            <table border="1" cellpadding="10" cellspacing="0">
              <thead>
                <tr>
                  <th>Duration</th>
                  <th>Rate / Day</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Daily Rate</td>
                  <td>RM 428.00 / Day</td>
                </tr>
                <tr>
                  <td>Weekly Rate</td>
                  <td>RM 282.86 / Day</td>
                </tr>
                <tr>
                  <td>Monthly Rate</td>
                  <td>RM 166.33 / Day</td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Add to Cart button -->
          <div class="rectangle-d">
            <button type="submit" class="add-to-cart" style="left: 218px;">Rent Now</button>
          </div>
        </form>
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
