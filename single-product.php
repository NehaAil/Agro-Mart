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

?>

<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Shop Detail</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Pages</a></li>
        <li class="breadcrumb-item active text-white">Shop Detail</li>
    </ol>
</div>
        <!-- Single Page Header End -->

<?php
$sql = "SELECT * FROM product where id = '$productid'";
$res = mysqli_query($conn, $sql);
if(mysqli_num_rows($res)>0){
    $row = mysqli_fetch_assoc($res);
?>
     
<!-- Single Product Start -->
<div class="container-fluid py-5 mt-5">
            <div class="container py-5">
                <div class="row g-4 mb-5">
                    <div class="col-lg-8 col-xl-9">
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="border rounded">
                                    <a href="#">
                                        <img src="images/<?php echo $row['image']; ?>" class="img-fluid rounded" alt="Image">
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <h4 class="fw-bold mb-3"><?php echo $row['pname']; ?></h4>
                                <?php
                                $categoryid = $row['categoryid'];
                                $sql1 = "SELECT * FROM category where id = '$categoryid'";
                                $res1 = mysqli_query($conn, $sql1);
                                if(mysqli_num_rows($res1)>0){
                                $row1 = mysqli_fetch_assoc($res1);
                                ?>
                                <p class="mb-3">Category: <?php echo $row1['category_name']; ?></p>
                                <?php
                                }
                                ?>
                                <h5 class="fw-bold mb-3">Rs. <?php echo $row['price']; ?> </h5>
                                
                                <p class="mb-4"><?php echo $row['description']; ?></p>
                                
                                
                                <a href="payment.php?productid=<?php echo $productid; ?>&amount=<?php echo $row['price']; ?>" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Buy Now</a>
                            </div>
                            
                            
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

<?php
}
?>
<?php
require_once 'include/footer.php';
?>
