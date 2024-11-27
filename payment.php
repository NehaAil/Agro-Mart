<?php

session_start();

require_once 'include/config.php';

if (empty($_SESSION['isLogin'])) {

    echo "<script>alert('Kindly login to proceed');location.href='index.php'</script>";
}

require_once 'include/header.php';

?>

<?php

$email = $_SESSION['email'];
$sql = "SELECT * FROM user WHERE email = '$email'";
$res = mysqli_query($conn, $sql);

if ($res) { 
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $userid = $row['id'];
    }
}

if (isset($_GET['productid'])) {

    $productid = $_GET['productid'];
}
if (isset($_GET['amount'])) {

    $amount = $_GET['amount'];
}

if (isset($_POST['add_submit'])) {

    $status = 1;
    $paymentno = 'PAY' . rand(100000, 999999);
    $date = date('Y-m-d H:i:s');

    $insertQuery = "INSERT INTO payment (userid, productid, payment_number, status, date, price) VALUES ('$userid', '$productid', '$paymentno', '$status', '$date', '$amount')";

    if (mysqli_query($conn, $insertQuery)) {

        echo "<script>alert('Product booked successfully');location.href='single-product.php?productid=$productid'</script>";
    } else {
        echo "<script>alert('Unable to process your request!');location.href='single-product.php?productid=$productid'</script>";
    }
}
?>

<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Payment</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Pages</a></li>
        <li class="breadcrumb-item active text-white">Payment</li>
    </ol>
</div>
        <!-- Single Page Header End -->


     
<!-- Single Product Start -->
<div class="container-fluid py-5 mt-5">
    <div class="container py-5">
        <div class="row g-4 mb-5">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form action="#" method="POST">
                            <div class="mb-3">
                                <label for="card_number" class="form-label">Card Number</label>
                                <input type="number" class="form-control" id="card_number" required name="card_number" placeholder="Enter Card Number">
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="expiration_date" class="form-label">Expiration Date</label>
                                        <input type="text" class="form-control" id="expiration_date" required name="expiration_date" placeholder="MM/YYYY">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="cvv" class="form-label">CVV</label>
                                        <input type="text" class="form-control" id="cvv" required name="cvv" placeholder="Enter CVV">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="add_submit" class="btn btn-primary">Pay Now</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Amount</h5>
                        <p class="card-text">Total Amount: Rs <?php echo $amount; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php
require_once 'include/footer.php';
?>
