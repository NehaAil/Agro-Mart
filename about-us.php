<?php

session_start();

require_once 'include/config.php';

if (empty($_SESSION['isLogin'])) {

    echo "<script>alert('Kindly login to proceed');location.href='index.php'</script>";
}

require_once 'include/header.php';

?>
 <!-- Single Page Header start -->
 <div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">About Us</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Pages</a></li>
        <li class="breadcrumb-item active text-white">About Us</li>
    </ol>
</div>
<!-- Single Page Header End -->

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <h2 class="text-dark mb-4">Welcome to AgroMart</h2>
            <p class="lead">
            We are passionate about providing you with the freshest, healthiest organic fruits and vegetables available.


            </p>
            <p class="lead">
            At AgroMart, we believe in the power of nature and the importance of sustainable farming practices. 
            That's why we work closely with local farmers who share our commitment to organic farming methods. 
            Our produce is grown without the use of synthetic pesticides or fertilizers, ensuring that you receive food that is not only delicious but also free from harmful chemicals.

            </p>
            <p class="lead">
             Our mission is simple: to provide you with the best organic fruits and vegetables while promoting health, sustainability, and community. We are proud to be your trusted source for fresh, organic produce, and we look forward to serving you for many years to come.

            </p>
        </div>
    </div>
</div>
<?php
require_once 'include/footer.php';
?>
