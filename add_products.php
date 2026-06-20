<?php include 'database.php';

$display_message = ""; // Initialize the display message variable

if(isset($_POST['add_product'])){
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_FILES['product_image']['name'];
    $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
    $product_image_folder = 'img/clothes' . $product_image;

    // Move uploaded file to the desired folder
    if(move_uploaded_file($product_image_tmp_name, $product_image_folder)) {
        // Insert the product into the database using prepared statement
        $insert_query = "INSERT INTO tblclothes (name, price, image) VALUES (?, ?, ?)";
        $stmt = $mysqli->prepare($insert_query);
        $stmt->bind_param("sds", $product_name, $product_price, $product_image_folder);
        
        if($stmt->execute()) {
            $display_message = "Product inserted successfully";
        } else {
            $display_message = "Error inserting product: " . $mysqli->error;
        }
    } else {
        $display_message = "Failed to move uploaded file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>


<div class="container">
    <?php
    if(isset($display_message)){
        echo "<div class='display_message'>
                <span>$display_message</span>
                <i class='fas fa-times' onclick='this.parentElement.style.display=`none`'></i>
              </div>";
    }
    ?>
    
    <section>
        <h3 class="heading">Add Product</h3>
        <form action="" class="add_product" method="post" enctype="multipart/form-data">
            <input type="text" name="product_name" placeholder="Enter product name" class="input_fields" required>
            <input type="number" name="product_price" min="0" placeholder="Enter product price" class="input_fields" required>
            <input type="file" name="product_image" class="input_fields" required accept="image/png, image/jpg,image/jpeg">
            <input type="submit" name="add_product" class="submit_btn" value="Add product">
        </form>
    </section>
</div>

<script src="script.js"></script>
</body>
</html>