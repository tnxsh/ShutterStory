<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" />
    <link rel="stylesheet" href="product.css" /> 
  </head>
  <body>
  <?php
    session_start(); 
    ?>
    <div class="main-container">
      <div class="rectangle">
        <div class="shutter-story">
          <span class="shutter">Shutter</span><span class="story">Story</span>
        </div>

        <?php
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            echo '<a style="left: 1800px;" href="my_account.php" class="account">My Account</a>';
        } else {
            echo '<a href="Login.html" class="account">Account</a>';
        }
        ?>
       <div class="mdi-account-alert-outline"></div>

         <a href="cart.php">
            <div class="ant-design-shopping-cart-outlined">
              <div class="vector-1"></div>
            </div>
        </a>
        <a href="Homepage.php" class="home">Home</a>
        <a href="Product.php" class="shop-2">Product</a>
        <a href="photo1.html" class="rental-service">Photography Service</span>
        <a href="Contact.php" class="contact">Contact</a>
      </div>
      <div class="rectangle-3">
        <div class="meubel-house-logos"></div>
        <span class="shop-4">Product</span>
      </div>

      <div class="products-container">
        <?php
        $conn = new mysqli('localhost', 'root', '', 'shutterstory_db');

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT product_id, product_name, description, price, image FROM products";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="product">';
                if (!empty($row['image'])) {
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($row['image']) . '" alt="Product Image" style="width: 200px; height: 200px;">';
                }
                $productDetailPage = "Detail" . $row["product_id"] . ".php"; 
                echo '<h2><a href="' . $productDetailPage . '">' . $row["product_name"] . '</a></h2>';
                echo '<p>' . $row["description"] . '</p>';
                echo '<p>Price: RM' . $row["price"] . '</p>';
                echo '<form method="POST" action="add_to_cart.php">';
                echo '<input type="hidden" name="product_id" value="' . $row["product_id"] . '">';
                echo '<input type="number" name="quantity" value="1" min="1">';
                echo '<button type="submit">Add to Cart</button>';
                echo '</form>';

                echo '<form method="GET" action="rental_detail.php" class="rental-form">';
                echo '<input type="hidden" name="product_id" value="' . $row["product_id"] . '">';
                echo '<button type="submit" class="rent-button">Rent</button>';
                echo '</form>';
                echo '</div>';

            }
        } else {
            echo "<p>No products available.</p>";
        }

        $conn->close();
        ?>
      </div>

      <div class="rectangle-2c">
        <span class="secure-payment">Secure Payment</span>
        <span class="free-delivery">Free Delivery</span>
        <span class="order-over-rm">For all orders over Rm 5000.</span>
        <span class="secure-payment-2d">100% secure payment.</span>
      </div>
      <div class="rectangle-2e">
        <span class="links">Links</span>
        <div class="flex-row-2f">
          <a href="homepage.php" class="home-30">Home</a>
          <a href="photo1.html" class="photography-service">Photography Service</a>        
        </div>
        <div class="flex-row-dcc">
          <a href="product.php" class="shop-31">Product</a>
        </div>
        <a href="contact.php" class="contact-32">Contact</a>
        <div class="line"></div>
        <span class="rights-reserved"
          >2024 ShutterStory. All rights reserved</span>
      </div>
    </div>
  </body>
</html>
