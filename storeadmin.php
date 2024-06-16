<?php
session_start();


$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'hostelhub';

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);

$products = array();
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        
        $row['price'] = (float)$row['price'];
        $products[] = $row;
    }
}


if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add-to-cart'])) {
        $productId = $_POST['product-id'];
        $quantity = $_POST['quantity'];

        
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId] += $quantity;
        } else {
            $_SESSION['cart'][$productId] = $quantity;
        }
    }
}


if (isset($_POST['clear-cart'])) {
    $_SESSION['cart'] = array();
}


function calculateCartTotal($products)
{
    $totalPrice = 0;
    foreach ($_SESSION['cart'] as $productId => $quantity) {
        foreach ($products as $product) {
            if ($product['productid'] == $productId) {
                $totalPrice += (float)$product['price'] * (float)$quantity;
                break;
            }
        }
    }
    return $totalPrice;
}



if (isset($_POST['purchase'])) {
    $studentId = $_POST['student-id'];
    $mobileNumber = $_POST['mobile-number'];

    
    $studentSql = "SELECT * FROM student_details WHERE id = '$studentId' AND mobile_number = '$mobileNumber'";
    $studentResult = mysqli_query($conn, $studentSql);

    if (mysqli_num_rows($studentResult) > 0) {
        
        $balanceSql = "SELECT store FROM balance WHERE id = '$studentId'";
        $balanceResult = mysqli_query($conn, $balanceSql);

        if (mysqli_num_rows($balanceResult) > 0) {
            $balanceData = mysqli_fetch_assoc($balanceResult);
            $storeBalance = $balanceData['store'];

            
            $totalPrice = calculateCartTotal($products);

            if ($storeBalance >= $totalPrice) {
                
                $newBalance = $storeBalance - $totalPrice;
                $updateBalanceSql = "UPDATE balance SET store = '$newBalance' WHERE id = '$studentId'";
                mysqli_query($conn, $updateBalanceSql);

                
                $insertPurchaseSql = "INSERT INTO store (id, total_price) VALUES ('$studentId', '$totalPrice')";
                mysqli_query($conn, $insertPurchaseSql);

                
                unset($_SESSION['cart']);

                
                echo "<script>alert('Purchase successful!');</script>";
            } else {
                
                echo "<script>alert('Insufficient store balance!');</script>";
            }
        } else {
            
            echo "<script>alert('Store balance not found!');</script>";
        }
    } else {
        
        echo "<script>alert('Invalid student ID or mobile number!');</script>";
    }
}


if (isset($_POST['update-store-status'])) {
    $storeStatus = $_POST['store-status'];

    
    $statusCheckSql = "SELECT * FROM status WHERE service = 'store'";
    $statusCheckResult = mysqli_query($conn, $statusCheckSql);

    if (mysqli_num_rows($statusCheckResult) > 0) {
        
        $updateStatusSql = "UPDATE status SET status = '$storeStatus' WHERE service = 'store'";
        mysqli_query($conn, $updateStatusSql);
    } else {
        
        $insertStatusSql = "INSERT INTO status (service, status) VALUES ('store', '$storeStatus')";
        mysqli_query($conn, $insertStatusSql);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Admin Page</title>
    <link href="https:
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <style>
       
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f2f2f2;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-family: 'Exo', sans-serif;
        }

        .container {
            max-width: 1080px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            display: flex;
            gap: 20px;
        }

        .product-list {
            flex: 1;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            justify-items: center;
        }

        .product-item {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            background-color: #fff;
        }

        .product-item img {
            max-width: 100%;
            max-height: 200px;
            margin-bottom: 10px;
        }

        .product-item h3 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }

        .product-item p {
            font-size: 16px;
            color: #555;
            margin: 10px 0;
        }

        .product-item button {
            padding: 8px 16px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .product-item button:hover {
            background-color: #555;
        }

        .cart-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .cart {
            width: 100%;
            max-width: 350px;
            margin-top: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            background-color: #fff;
            animation: slideInLeft 0.5s ease;
        }

        .cart h2 {
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .cart table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .cart th,
        .cart td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        .cart tfoot td {
            text-align: right;
        }

        .purchase-form {
            margin-top: 20px;
            animation: fadeInUp 0.5s ease;
        }

        .input-container {
            margin-bottom: 10px;
        }

        .input-container label {
            display: block;
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .input-box {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            color: #333;
            transition: border-color 0.2s ease;
        }

        .input-box:focus {
            outline: none;
            border-color: #555;
            box-shadow: 0 0 3px rgba(0, 0, 0, 0.2);
        }

        

       
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                transform: translateX(-100%);
            }
            to {
                transform: translateX(0);
            }
        }

        .product-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .status-container {
            flex: 1;
            border-radius: 5px;
            padding: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .status-container h2 {
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 18px;
            color: #333;
        }

        .status-data {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            margin: 0;
            padding: 5px 0;
        }

        .update-status-form {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }

        .update-status-form label {
            font-size: 14px;
            font-weight: bold;
            
            margin-right: 5px;
        }

        .update-status-form select {
            padding: 6px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            color: #333;
        }

        .update-status-form button {
            padding: 6px 12px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 14px;
            margin-left: 5px;
        }

        .update-status-form button:hover {
            background-color: #555;
        }

        .update-status-form button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <header>
        <h1>HOSTELHUB STORE ADMIN</h1>
         <!-- Status Section -->
         <div class="status-container">
            <h2>Status</h2>
            <?php
            
            $statusSql = "SELECT * FROM status WHERE service = 'store'";
            $statusResult = mysqli_query($conn, $statusSql);

            if (mysqli_num_rows($statusResult) > 0) {
                while ($row = mysqli_fetch_assoc($statusResult)) {
                    echo "<p>Status of Store: <strong>{$row['status']}</strong></p>";
                }
            }
            ?>

            <!-- Form to update status for the store -->
            <form method="POST" class="update-status-form">
                <label for="store-status">Store Status:</label>
                <select name="store-status" required>
                    <option value="open">Open</option>
                    <option value="close">Close</option>
                </select>
                <button type="submit" name="update-store-status">Update</button>
            </form>
        </div>
    </header>

    <div class="container">
        <!-- Side-by-Side Layout: Display Products and Cart -->
        <div class="product-list">
            <?php foreach ($products as $product) : ?>
                <div class="product-item">
                    <?php
                    
                    $imageData = base64_encode($product['image']);
                    $imageSrc = 'data:image/jpeg;base64,' . $imageData;
                    ?>
                    <img src="<?php echo $imageSrc; ?>" alt="<?php echo $product['name']; ?>">
                    <h3><?php echo $product['name']; ?></h3>
                    <p>Price: ₹<?php echo $product['price']; ?></p>
                    <form method="POST">
                        <input type="hidden" name="product-id" value="<?php echo $product['productid']; ?>">
                        <label for="quantity">Quantity:</label>
                        <input type="number" name="quantity" value="1" min="1">
                        <button type="submit" name="add-to-cart">Add to Cart</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="cart-container">
            <div class="cart">
                <h2>Cart</h2>
                <?php if (!empty($_SESSION['cart'])) : ?>
                    <table>
                        <!-- Cart table content -->
                        
                        <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_SESSION['cart'] as $productId => $quantity) : ?>
                <?php foreach ($products as $product) : ?>
                    <?php if ($product['productid'] == $productId) : ?>
                        <tr>
                            <td><?php echo $product['name']; ?></td>
                            <td><?php echo $quantity; ?></td>
                            <td>₹<?php echo number_format((float)$product['price'], 2, '.', ''); ?></td>
<td>₹<?php echo number_format((float)$product['price'] * (float)$quantity, 2, '.', ''); ?></td>


                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">Total Price:</td>
                <td>₹<?php echo number_format((float)calculateCartTotal($products), 2, '.', ''); ?></td>
            </tr>
        </tfoot>
    </table>
                    </table>
                    <form method="POST" id="purchase-form">
                    <input type="submit" name="clear-cart" value="Clear Cart">
                </form>
                    <form method="POST" id="purchase-form" class="purchase-form">
                        <div class="input-container">
                            <label for="student-id">Student ID:</label>
                            <input type="text" name="student-id" required class="input-box">
                        </div>
                        <div class="input-container">
                            <label for="mobile-number">Mobile Number:</label>
                            <input type="text" name="mobile-number" required class="input-box">
                        </div>
                        <button type="submit" name="purchase" class="checkout-btn">Purchase</button>
                    </form>
                <?php else : ?>
                    <p>Your cart is empty.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>

    <script>
    
    const searchInput = document.querySelector('input[name="search"]');
    const productItems = document.querySelectorAll('.product-item');

    searchInput.addEventListener('input', () => {
        const searchTerm = searchInput.value.toLowerCase();
        productItems.forEach((item) => {
            const productName = item.querySelector('h3').innerText.toLowerCase();
            if (productName.includes(searchTerm)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });

    
    function calculateCartTotal() {
        const cartItems = <?php echo json_encode($_SESSION['cart']); ?>;
        const productData = <?php echo json_encode($products); ?>;
        let totalPrice = 0;

        for (const productId in cartItems) {
            const quantity = cartItems[productId];
            const product = productData.find(item => item.productid === productId);
            if (product) {
                totalPrice += product.price * quantity;
            }
        }

        return totalPrice.toFixed(2);
    }

    
    function updateCartTotal() {
        const totalElement = document.getElementById('cart-total');
        const totalPrice = calculateCartTotal();
        totalElement.textContent = '$' + totalPrice;
    }

    
    updateCartTotal();

    
    document.addEventListener('change', updateCartTotal);

    
    const clearCartButton = document.getElementById('clear-cart');
    clearCartButton.addEventListener('click', () => {
        const confirmation = confirm('Are you sure you want to clear the cart?');
        if (confirmation) {
            fetch('clear_cart.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        
                        document.querySelector('.cart-items').innerHTML = '<p>Your cart is empty.</p>';
                        updateCartTotal();
                    } else {
                        alert('Failed to clear the cart. Please try again later.');
                    }
                })
                .catch(error => {
                    alert('An error occurred while trying to clear the cart. Please try again later.');
                });
        }
    });

    
    const purchaseForm = document.getElementById('purchase-form');
    purchaseForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const studentId = purchaseForm.elements['student-id'].value;
        const mobileNumber = purchaseForm.elements['mobile-number'].value;
        const totalPrice = calculateCartTotal();

        
        const formData = new FormData();
        formData.append('student-id', studentId);
        formData.append('mobile-number', mobileNumber);
        formData.append('total-price', totalPrice);

        fetch('process_purchase.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                
                document.querySelector('.cart-items').innerHTML = '<p>Your cart is empty.</p>';
                updateCartTotal();
                alert('Purchase successful!');
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            alert('An error occurred while processing the purchase. Please try again later.');
        });
    });
</script>
</body>
</html>
