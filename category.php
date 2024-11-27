<?php

session_start();

require_once 'include/config.php';

if (empty($_SESSION['isLogin'])) {

    echo "<script>alert('Kindly login to proceed');location.href='index.php'</script>";
}

require_once 'include/header.php';

?>
<?php
if (isset($_POST['add_submit'])) {

    $name = addslashes(trim($_POST['name']));
    $description = addslashes(trim($_POST['description']));
    $status = 1;

    

    $insertQuery = "INSERT INTO category (category_name, description, status) VALUES ('$name', '$description', '$status')";

    if (mysqli_query($conn, $insertQuery)) {

        echo "<script>alert('Category added successfully');location.href='category.php'</script>";
    } else {
        echo "<script>alert('Unable to process your request!');location.href='category.php'</script>";
    }
}
if (isset($_POST['update_submit'])) {
    $category_id = $_POST['id']; 
    $name = addslashes(trim($_POST['name']));
    $description = addslashes(trim($_POST['description']));


    $updateQuery = "UPDATE category SET category_name = '$name', description = '$description' WHERE id = $category_id";

    if (mysqli_query($conn, $updateQuery)) {
        echo "<script>alert('Category updated successfully');location.href='category.php'</script>";
    } else {
        echo "<script>alert('Unable to update category!');location.href='category.php'</script>";
    }
}


if (isset($_POST['delete_submit'])) {

    $date = date('Y-m-d H:i:s');

    if (mysqli_query($conn, "DELETE from category WHERE id = '$_POST[delete_id]'")) {

        echo "<script>alert('Category deleted successfully');location.href='category.php'</script>";
    } else {

        echo "<script>alert('Unable to process your request!');location.href='category.php'</script>";
    }
}
?>

<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Category</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Pages</a></li>
        <li class="breadcrumb-item active text-white">Category</li>
    </ol>
</div>
<!-- Single Page Header End -->
<!-- Article Start-->
<div class="container-fluid fruite py-5">
    <div class="container py-5">
        <h1 class="mb-4">Add Category</h1>
        <div class="row g-4">
            <div class="col-lg-12">
                <div class="row g-4">
                    <div class="col-9"></div>
                    <div class="col-xl-3">
                        <div class="input-group w-100 mx-auto d-flex">
                            <a class="btn border border-secondary rounded-pill px-3 text-primary" data-bs-toggle='modal' data-bs-target='#add'><i class="bi bi-plus-square-fill me-2 text-primary"></i> Add Category</a>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">status</th>
                            <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM category";
                            $res = mysqli_query($conn,$sql);

                            if(mysqli_num_rows($res) > 0) {
                                $i = 1;

                                while($row = mysqli_fetch_array($res)) {
                                    echo "<tr>";
                                    echo "<td>$i</td>";
                                    echo "<td>$row[category_name]</td>";
                                    echo "<td>$row[description]</td>";
                                    $status = $row['status'];
                                    $statusText = ($status == 1) ? 'Active' : 'Inactive';
                                    echo "<td>$statusText</td>";                                    
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
                                                        <h1 class="modal-title fs-5" id="addLabel">Edit Category</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-xl-12 mb-3">
                                                                <label class="form-label">Name<span class="text-danger">*</span></label>
                                                                <input autocomplete='off' type="text" class="form-control" maxlength="100" required name="name" value="<?php echo $row['category_name']; ?>">
                                                            </div>
                                                            <div class="col-xl-12 mb-3">
                                                                <label class="form-label">Description<span class="text-danger">*</span></label>
                                                                <textarea class="form-control" rows="4" required name="description"><?php echo $row['description']; ?></textarea>
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
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="addLabel">Add Category</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-xl-12 mb-3">
                                            <label class="form-label">Name<span class="text-danger">*</span></label>
                                            <input autocomplete='off' type="text" class="form-control" maxlength="100" required name="name">
                                        </div>
                                        <div class="col-xl-12 mb-3">
                                            <label class="form-label">Description<span class="text-danger">*</span></label>
                                            <textarea class="form-control" rows="4" required name="description"></textarea>
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
