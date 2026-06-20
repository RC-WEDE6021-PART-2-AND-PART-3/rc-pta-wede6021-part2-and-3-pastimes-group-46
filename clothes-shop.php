<?php

$host = "localhost";
$dbname = "clothingstore";
$username = "root";
$password = "";

$mysqli = new mysqli($host, $username, $password, $dbname);

if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error);
}

// Include this line at the top to avoid PHP header error
header("Content-Type: text/html;charset=UTF-8");

$display_message = ""; // Define $display_message variable to avoid undefined variable notice

if(isset($_POST['add_to_cart'])){
    $products_name = $_POST['product_name'];
    $products_price = $_POST['product_price'];
    $products_image = $_POST['product_image'];
    $products_quantity = 1;

    // Check if the product is already in the cart
    $select_cart = $mysqli->prepare("SELECT * FROM `tblaoder` WHERE name=?");
    $select_cart->bind_param("s", $products_name);
    $select_cart->execute();
    $result = $select_cart->get_result();
    
    if($result->num_rows > 0){
        $display_message = "Product already added to cart";
    } else {
        // If the product is not in the cart, insert it
        $insert_products = $mysqli->prepare("INSERT INTO `tblaoder` (name, price, image, quantity) VALUES (?, ?, ?, ?)");
        $insert_products->bind_param("sssi", $products_name, $products_price, $products_image, $products_quantity);
        if($insert_products->execute()) {
            $display_message = "Product added to cart successfully";
        } else {
            $display_message = "Failed to add product to cart";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<nav>
      <div class="nav__header">
        <div class="nav__logo">
          <a href="#">ReWear</a>
        </div>
        <div class="nav__menu__btn" id="menu-btn">
          <i class="ri-menu-line"></i>
        </div>
      </div>
      <ul class="nav__links" id="nav-links">
        <li><a href="Home.html">HOME</a></li>
        <li><a href="#">ABOUT US</a></li>
        <li><a href="cart.php">Cart</a></li>
      </ul>
      <div class="nav__btns">
        
        <a href=""><button  class="btn"><i class="ri-search-line"></i></button></a>
        <a href="cart.php"><button class="btn"><i class="ri-shopping-bag-line"></i></button></a>
      </div>
    </nav>
    <section class="Featured">
        <div class="Featured-product">
            <h4 id="Fp">SHOP</h4>
        </div>
        <div><?php echo $display_message; ?></div>
        <div class="product-container">
        <?php
        $select_product = $mysqli->query("SELECT * FROM `tblclothes`");
        if($select_product->num_rows > 0){
            while($fetch_products = $select_product->fetch_assoc()){
                ?>
                    <div class="product-card">
                        <div class="product-image">
                            <span class="discount-tag">50% off</span>
                            <img src="<?php echo $fetch_products['image']; ?>" alt="<?php echo $fetch_products['name']; ?>" class="product-thumb" alt="">
                            <form action="" method="post">
                                <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                                <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                                <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                                <input type="submit" class="card-btn" value="Add to Cart" name="add_to_cart">
                            </form>
                        </div>
                        <div class="product-info">
                            <h2 class="product-brand"><?php echo $fetch_products['name']; ?></h2>
                            <p class="product-short-des">a short line about the cloth..</p>
                            <span class="price">$<?php echo $fetch_products['price'] * 0.5; ?></span>
                            <span class="actual-price">$<?php echo $fetch_products['price']; ?></span>
                        </div>
                    </div>
                
            <?php
            }
        }
        ?>
        </div>
    </section>
    <!-- Display message to the user -->
    
</body>
<footer class="footer">
    
  
    <div class="container2">
      <div class="footer_inner">
        <div class="c-footer">
          <div class="layout">
            <div class="layout_item w-50">
              <div class="newsletter">
                <h3 class="newsletter_title">Get updates on fun stuff you probably want to know about in your inbox.</h3>
                <form action="">
                  <input type="text" placeholder="Email Address">
                  <button>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                      <path fill="none" d="M0 0h24v24H0z" />
                      <path d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z" />
                    </svg>
                  </button>
                </form>
              </div>
            </div>
  
            <div class="layout_item w-25">
              
                <h5 class="c-nav-tool_title">Menu</h5>
                <br>
                <ul class="c-nav-tool_list">
                  <li>
                    <a href="clothes-shop.php" class="c-link">Shop All</a>
                  </li>
  
                  <li>
                    <a href="/pages/about-us" class="c-link">About Us</a>
                  </li>
  
                  <li>
                    <a href="/blogs/community" class="c-link">Community</a>
                  </li>
                  <li>
                    <a href="#" class="c-link">Vibes</a>
                  </li>
                  <li>
                    <a href="admin_login.php" class="c-link">Admin</a>
                  </li>
                </ul>
              
  
            </div>
  
            <div class="layout_item w-25">
             
                <h5 class="c-nav-tool_title">Support</h5>
                <br>
                <ul class="c-nav-tool_list">
  
                  <li class="c-nav-tool_item">
                    <a href="/pages/shipping-returns" class="c-link">Shipping &amp; Returns</a>
                  </li>
  
                  <li class="c-nav-tool_item">
                    <a href="/pages/help" class="c-link">Help &amp; FAQ</a>
                  </li>
  
                  <li class="c-nav-tool_item">
                    <a href="/pages/terms-conditions" class="c-link">Terms &amp; Conditions</a>
                  </li>
  
                  <li class="c-nav-tool_item">
                    <a href="/pages/privacy-policy" class="c-link">Privacy Policy</a>
                  </li>
  
                  <li class="c-nav-tool_item">
                    <a href="/pages/contact" class="c-link">Contact</a>
                  </li>
  
                  <li class="c-nav-tool_item">
                    <a href="index.html" class="c-link">
                      Login
                    </a>
                  </li>
                </ul>
              
  
            </div>
          </div>
          <div class="layout c-2">
            <div class="layout_item w-50">
              <ul class="flex">
                <li>
                  <img id="payment" src="img/apple-pay-logo-svgrepo-com.svg"   width="50" height="50" >
                 
                </li>
                <li>
                  <img id="payment" src="img/paypal-svgrepo-com.svg"   width="50" height="50" >
                </li>
                <li>
                  <img id="payment" src="img/mastercard-svgrepo-com.svg"   width="50" height="50" >
                </li>
                <li>
                  <img id="payment" src="img/visa-svgrepo-com.svg"   width="50" height="50" >
                </li>
                
              </ul>
            </div>
            
            <div class="layout_item w-25" style="display:flex;justify-content: end;align-items: center;">
              
              

                <img id="mouse" src="img/mouse-cursor_7664475.png"  width="40px" hidden="20px"  >
             
              
            </div>
          </div>
        </div>
      </div>
      <div class="footer_copyright">
        <p>&copy; 2024 Created By Mulweli.</p>
      </div>
    </div>
  </footer>
</html>
