<?php

$editService = isset($_GET['edit']) ? $_GET['edit'] :'';
$queryEdit = mysqli_query($config, "SELECT * FROM type_of_service WHERE id='$editService'");
$rowEdit = mysqli_fetch_assoc($queryEdit);


if(isset($_POST['service_name'])) {
    $service_name = $_POST['service_name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    if(isset($_GET['edit'])) {
        $updateQ = mysqli_query($config, "UPDATE type_of_service SET service_name='$service_name', price=$price, description='$description' WHERE id='$editService'");
        header("location: ?page=service&id" . $editService . "&update=berhasil");
    } else {
        $insertQ = mysqli_query($config, "INSERT INTO type_of_service (service_name, price, description) VALUES ('$service_name', '$price', '$description')");
         header("location: ?page=service&id" . $editService . "&tambah=berhasil");
    }
}

if (isset($_GET['delete'])) {
    $id_service = isset($_GET['delete']) ? $_GET['delete'] : '' ;
    $now = date('Y-m-d H:i:s'); // Waktu sekarang dalam format datetime

    $queryDelete = mysqli_query($config, "UPDATE type_of_service SET deleted_at='$now' WHERE id='$id_service'");
    if ($queryDelete) {
        header("location: ?page=service&" . $id_service . "&hapus=berhasil") ;
    } 
}


?>  

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo isset($rowEdit) ? 'edit' : 'save' ?> Services</h5>

                <form action="" method="post">
                    <div class="mb-3">
                        <label for="">Service :</label>
                        <input type="text" class="form-control" name="service_name" value="<?= isset($rowEdit['service_name']) ? $rowEdit['service_name'] : ''  ?>" placeholder="masukkan pengerjaan " required>
                    </div>
                    <div class="mb-3">
                        <label for="">price :</label>
                        <input type="number" class="form-control" name="price" value="<?= isset($rowEdit['price']) ? $rowEdit['price'] : ''  ?>" placeholder="masukkan harga /kg" required>
                    </div>
                    <div class="mb-3">
                        <label for="">description :</label>
                        <input type="text" class="form-control" name="description" value="<?= isset($rowEdit['description']) ? $rowEdit['description'] : ''  ?>" placeholder="masukkan deskripsi" required>
                    </div>
                    <div class="mb-3">
                        <input type="submit" class="btn btn-success" name="<?php echo isset($rowEdit) ? 'edit' : 'save' ?>" value="<?php echo isset($rowEdit) ? 'edit' : 'save' ?>">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>