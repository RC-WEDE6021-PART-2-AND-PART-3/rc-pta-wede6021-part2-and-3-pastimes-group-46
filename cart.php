<?php include 'database.php'; 

$grand_total = 0; // Initialize grand total

if(isset($_POST['update_product_quantity'])){
    $update_value = $_POST['update_quantity'];
    $update_id = $_POST['update_quantity_id'];
    $update_quantity_query = mysqli_query($mysqli, "UPDATE `tblaoder` SET quantity = $update_value WHERE id = $update_id");
    if($update_quantity_query){
        header('location:cart.php');
    }
}

if(isset($_GET['remove'])){
    $remove_id = $_GET['remove'];
    $remove_id = mysqli_real_escape_string($mysqli, $remove_id); // Sanitize input to prevent SQL injection
    $delete_query = "DELETE FROM `tblaoder` WHERE id='$remove_id'";
    if(mysqli_query($mysqli, $delete_query)){
        header('location:cart.php');
    } else {
        echo "Error deleting record: " . mysqli_error($mysqli);
    }
}

if(isset($_GET['delete_all'])){
    mysqli_query($mysqli, "DELETE FROM `tblaoder`");
    header('location:cart.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Stocks Watchlist</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/cart.css">
    
    <!-- more head content -->
</head>



<body>
    

    
<div class="table-widget">
    <span class="caption-container">
        <span class="table-title">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cart" viewBox="0 0 20 20">
                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
            </svg>
            Cart
        </span>
        <?php
        $Select_product= mysqli_query($mysqli,"Select * from `tblaoder`") or die('query failed');
        $rows_count=mysqli_num_rows($Select_product)
        ?>
        <span class="table-row-count">(<?php echo $rows_count;  ?>)Product</span>
        
        
    </span>
    <div class="table-wrapper">
        <!-- generate table here -->
        <table>
            <thead>
                <tr>
                    <th class="sticky-left">Product Image</th>
                    <th></th>
                    <th>Name</th>
                    <th>Price [R]</th>
                    <th>Quantity [1-10]</th>
                    <th>Total (R)</th>
                    
                    
                    <th></th>
                    <th class="sticky-right"></th>
                </tr>
            </thead>
            

            <tbody>
            <?php
            $select_cart_products = mysqli_query($mysqli, "SELECT * FROM `tblaoder`");
            
            if(mysqli_num_rows($select_cart_products) > 0){
                $num = 1; // Initialize the 
                while($fetch_cart_products = mysqli_fetch_assoc($select_cart_products)){
                    ?>
                    <tr>
                <td class="stock sticky-left">
                    <div class="stock-wrapper">
                         <img src="<?php echo $fetch_cart_products['image']; ?>" alt="">
                        <div class="stock-info">
                            <span class="stock-info__ticker">
                                
                            </span>
                            <span class="stock-info__name">
                                
                            </span>
                        </div>
                    </div>
                </td>
                <td></td>
                <td class="price "><?php echo $fetch_cart_products['name']; ?></td>
                <td class="price "><?php echo $fetch_cart_products['price']; ?></td>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="hidden" name="update_quantity_id" value="<?php echo $fetch_cart_products['id']; ?>">
    <td class="price">
        <div class="quantity">
            <button type="button" class="minus" aria-label="Decrease" onclick="updateQuantity(this, -1)">-</button>
            <input type="number" name="update_quantity" class="input-box" value="<?php echo $fetch_cart_products['quantity']; ?>" min="1" max="10">
            <button type="button" class="plus" aria-label="Increase" onclick="updateQuantity(this, 1)">+</button>
        </div>
    </td>
    <td class="price">R<?php echo number_format($fetch_cart_products['price'] * $fetch_cart_products['quantity']); ?></td>
    <td class="sticky-right">
        <button type="submit" name="update_product_quantity" value="Update" class="btn btn--primary">Update</button>
    </td>
</form>

                <td class="sticky-right">
                    
                    <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <button class="btn2 " type="submit" name="remove" value="<?php echo $fetch_cart_products['id']; ?>" onclick="return confirm('Are you sure you want to delete this item?')">
                            <img class="img_i" src="assets/cancel_446185.png" alt="">
                        </button>
                    </form>
                    
                    
                </td>
            </tr>
                    <?php
                    $grand_total += $fetch_cart_products['price'] * $fetch_cart_products['quantity']; // Calculate grand total
                    $num++; // Increment the numbering
                }
            } else {
                echo "<div class='empty_text'><h2 class='h2.empty'>Cart is empty</h2></div>";
            }
            ?>
        </tbody>
    </div>
</div>
<div class="table-widget1">
    <div class="container">
        <div class="shipping-options">
            <h2>Choose shipping mode:</h2>
            <div class="shipping-option">
                <input class="radio" type="radio" id="store-pickup" name="shipping" value="store-pickup">
                <label for="store-pickup">Store pickup (in 20 min) - FREE</label>
            </div>
            <div class="shipping-option">
                <input class="radio" type="radio" id="home-delivery" name="shipping" value="home-delivery">
                <label for="home-delivery">Delivery at home (2-4 day) - R60</label>
            </div>
        </div>
        <div class="order-summary">
            <h2>Summary:</h2>
            <p><span class="price1 ">Subtotal:</span> R<?php echo $grand_total; ?></p>
            <p><span class="price1 ">Shipping:</span> Free</p>
            <p class="total"><span class="price1 ">Total:</span> R<?php echo $grand_total; ?></p>
        </div>
    </div>
    <button class="btn_checkout" type="button">Checkout</button>
    
</div>



<script src="js/cart.js"></script>
</body>
<footer>
    
</footer>
</html>
