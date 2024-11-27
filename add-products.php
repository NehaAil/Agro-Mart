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

if (isset($_POST['add_submit'])) {

    $name = addslashes(trim($_POST['name']));
    $description = addslashes(trim($_POST['description']));
    $price = addslashes(trim($_POST['price']));
    $categoryid = addslashes(trim($_POST['category']));

    $status = 1;

    
    $date = date('Y-m-d H:i:s');
    $imagePath = time() . "." . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    if (move_uploaded_file($_FILES['image']['tmp_name'], "images/" . $imagePath)) {

        $insertQuery = "INSERT INTO product (pname, description, image, price, date, userid, status, categoryid) VALUES ('$name', '$description', '$imagePath', '$price', '$date', '$userid', '$status', '$categoryid')";

        if (mysqli_query($conn, $insertQuery)) {

            echo "<script>alert('Product added successfully');location.href='add-products.php'</script>";
        } else {
            echo "<script>alert('Unable to process your request!');location.href='add-products.php'</script>";
        }
        } else {

        echo "<script>alert('Unable to upload image on server.');</script>";
    }

    
}
if (isset($_POST['update_submit'])) {

    $product_id = addslashes(trim($_POST['id']));

    $name = addslashes(trim($_POST['name']));
    $description = addslashes(trim($_POST['description']));
    $price = addslashes(trim($_POST['price']));
    $categoryid = addslashes(trim($_POST['category']));

    $status = 1;

    $date = date('Y-m-d H:i:s');
    
    if (!empty($_FILES['image']['name'])) {
        $imagePath = time() . "." . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        if (move_uploaded_file($_FILES['image']['tmp_name'], "images/" . $imagePath)) {

            $updateQuery = "UPDATE product SET pname='$name', description='$description', image='$imagePath', price='$price', date='$date', userid='$userid', status='$status', categoryid='$categoryid' WHERE id='$product_id'";
    
            if (mysqli_query($conn, $updateQuery)) {
    
                echo "<script>alert('Product updated successfully');location.href='add-products.php'</script>";
            } else {
                echo "<script>alert('Unable to process your request!');location.href='add-products.php'</script>";
            }
        } else {
            echo "<script>alert('Unable to upload image on server.');</script>";
        }
        
    } else {

        $updateQuery = "UPDATE product SET pname='$name', description='$description', price='$price', date='$date', userid='$userid', status='$status', categoryid='$categoryid' WHERE id='$product_id'";

        if (mysqli_query($conn, $updateQuery)) {
            echo "<script>alert('Product updated successfully');location.href='add-products.php'</script>";
        } else {
            echo "<script>alert('Unable to process your request!');location.href='add-products.php'</script>";
        }
    }
}


if (isset($_POST['delete_submit'])) {

    $date = date('Y-m-d H:i:s');

    if (mysqli_query($conn, "UPDATE product SET status = 0 WHERE id = '$_POST[delete_id]'")) {

        echo "<script>alert('Product deleted successfully');location.href='add-products.php'</script>";
    } else {

        echo "<script>alert('Unable to process your request!');location.href='add-products.php'</script>";
    }
}
?>

<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Add Products</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Pages</a></li>
        <li class="breadcrumb-item active text-white">Add Products</li>
    </ol>
</div>
<!-- Single Page Header End -->
<!-- Article Start-->
<div class="container-fluid fruite py-5">
    <div class="container py-5">
        <h1 class="mb-4">Add Products</h1>
        <div class="row g-4">
            <div class="col-lg-12">
                <div class="row g-4">
                    <div class="col-9"></div>
                    <div class="col-xl-3">
                        <div class="input-group w-100 mx-auto d-flex">
                            <a class="btn border border-secondary rounded-pill px-3 text-primary" data-bs-toggle='modal' data-bs-target='#add'><i class="bi bi-plus-square-fill me-2 text-primary"></i> Add Products</a>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Image</th>
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Price</th>
                            <th scope="col">Category</th>
                            <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM product where status= 1";
                            $res = mysqli_query($conn,$sql);

                            if(mysqli_num_rows($res) > 0) {
                                $i = 1;

                                while($row = mysqli_fetch_array($res)) {
                                    echo "<tr>";
                                    echo "<td>$i</td>";
                                    echo "<td><img src='images/$row[image]'style='width:70px; height:70px;' ></td>";
                                    echo "<td>$row[pname]</td>";
                                    echo "<td>$row[description]</td>";
                                    echo "<td>$row[price]</td>";
                                    echo "<td>";
                                    $catid = $row['categoryid'];
                                    $qry = "SELECT * FROM category WHERE id = '$catid'";
                                    $result = mysqli_query($conn, $qry);

                                    if ($result) { 
                                        if (mysqli_num_rows($result) > 0) {
                                            $row2 = mysqli_fetch_assoc($result);
                                            $category = $row2['category_name'];
                                        }
                                    }
                                    echo "$category</td>";
                                    echo "<td width= 120px>";
                                    echo "<form method='post'>";
                                    echo "<a class='btn btn-primary shadow sharp' data-bs-toggle='modal' data-bs-target='#edit$row[id]' href='#'><i class='fa fa-edit'></i></a>";
                                    echo "<input autocomplete='off'  type='hidden' name='delete_id' value='$row[id]'/>
                                    <button type='submit' name='delete_submit' onClick='return confirm(" . '"Are you sure you want to delete?"' . ")' class='btn btn-danger shadow btn-xs sharp'><i class='fa fa-trash'></i></button>";
                                    echo "</form>";
                                    echo "</td>";
                                    echo "</tr>";
                                    $i++;
                                    ?>
                                    <div class="modal fade" id="edit<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-center">
                                            <form method="POST" enctype="multipart/form-data">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="addLabel">Edit Product</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-xl-12 mb-3">
                                                                <label class="form-label">Product Name<span class="text-danger">*</span></label>
                                                                <input autocomplete='off' type="text" class="form-control" maxlength="100" required name="name" value="<?php echo $row['pname']; ?>">
                                                            </div>
                                                            <div class="col-xl-12 mb-3">
                                                                <label class="form-label">Category<span class="text-danger">*</span></label>
                                                                <select class="form-select" name="category">
                                                                    <option value="">Select Category</option>

                                                                    <?php
                                                                    $qry_categories = "SELECT * FROM category";
                                                                    $result_categories = mysqli_query($conn, $qry_categories);

                                                                    if ($result_categories) {
                                                                        while ($row_category = mysqli_fetch_assoc($result_categories)) {
                                                                            $category_id = $row_category['id'];
                                                                            $category_name = $row_category['category_name'];

                                                                            $selected = ($category_id == $row['categoryid']) ? "selected" : "";
                                                                            echo "<option value='$category_id' $selected>$category_name</option>";
                                                                        }
                                                                    }
                                                                    ?>

                                                                </select>

                                                            </div>
                                                            <div class="col-xl-12 mb-3">
                                                                <label class="form-label">Description<span class="text-danger">*</span></label>
                                                                <textarea class="form-control" rows="4" required name="description"><?php echo $row['description']; ?></textarea>
                                                            </div>
                                                            
                                                            <div class="col-xl-12 mb-3">
                                                                <label class="form-label">Price(Rs)<span class="text-danger">*</span></label>
                                                                <input autocomplete='off' type="number" class="form-control" maxlength="100" required name="price" value="<?php echo $row['price']; ?>">
                                                            </div>
                                                            <div class="col-xl-12 mb-3">
                                                                <label class="form-label">Upload Image</label>
                                                                <input type="file" class="form-control" name="image" accept="image/*">
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" name="update_submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="modal fade" id="add" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-center">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="modal-content" style="width: 500px;">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="addLabel">Add Products</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-xl-12 mb-3">
                                            <label class="form-label">Product Name<span class="text-danger">*</span></label>
                                            <input autocomplete='off' type="text" class="form-control" maxlength="100" required name="name">
                                        </div>
                                        <div class="col-xl-12 mb-3">
                                            <label class="form-label">Category<span class="text-danger">*</span></label>
                                            <select class="form-select" name="category">
                                                <option value="">Select Category</option>

                                                <?php
                                                $qry_categories = "SELECT * FROM category";
                                                $result_categories = mysqli_query($conn, $qry_categories);

                                                if ($result_categories) {
                                                    while ($row_category = mysqli_fetch_assoc($result_categories)) {
                                                        $category_id = $row_category['id'];
                                                        $category_name = $row_category['category_name'];
                                                        echo "<option value='$category_id'>$category_name</option>";
                                                    }
                                                }
                                                ?>

                                            </select>
                                        </div>
                                        <div class="col-xl-12 mb-3">
                                            <label class="form-label">Description<span class="text-danger">*</span></label>
                                            <textarea class="form-control" rows="4" required name="description"></textarea>
                                        </div>
                                        
                                        <div class="col-xl-12 mb-3">
                                            <label class="form-label">Price(Rs)<span class="text-danger">*</span></label>
                                            <input autocomplete='off' type="number" class="form-control" maxlength="100" required name="price">
                                        </div>
                                        
                                        <div class="col-xl-12 mb-3">
                                            <label class="form-label">Upload Image<span class="text-danger">*</span></label>
                                            <input type="file" class="form-control" name="image" accept="image/*" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" name="add_submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
require_once 'include/footer.php';
?>
