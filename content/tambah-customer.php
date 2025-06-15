<?php

$editCustomer = isset($_GET['edit']) ? $_GET['edit'] :'';
$queryEdit = mysqli_query($config, "SELECT * FROM customer WHERE id='$editCustomer'");
$rowEdit = mysqli_fetch_assoc($queryEdit);


if(isset($_POST['customer_name'])) {
    $customer_name = $_POST['customer_name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    if(isset($_GET['edit'])) {
        $updateQ = mysqli_query($config, "UPDATE customer SET customer_name='$customer_name', phone=$phone, address='$address' WHERE id='$editCustomer'");
        header("location: ?page=customer&id" . $editCustomer . "&update=berhasil");
    } else {
        $insertQ = mysqli_query($config, "INSERT INTO customer (customer_name, phone, address) VALUES ('$customer_name', '$phone', '$address')");
         header("location: ?page=customer&id" . $editCustomer . "&tambah=berhasil");
    }
}

if (isset($_GET['delete'])) {
    $id_customer = isset($_GET['delete']) ? $_GET['delete'] : '' ;
    $now = date('Y-m-d H:i:s'); // Waktu sekarang dalam format datetime

    $queryDelete = mysqli_query($config, "UPDATE customer SET deleted_at='$now' WHERE id='$id_customer'");
    if ($queryDelete) {
        header("location: ?page=customer&" . $id_customer . "&hapus=berhasil") ;
    } 
}


?>  

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo isset($rowEdit) ? 'edit' : 'save' ?> Customer</h5>

                <form action="" method="post">
                    <div class="mb-3">
                        <label for="">Customer :</label>
                        <input type="text" class="form-control" name="customer_name" value="<?= isset($rowEdit['customer_name']) ? $rowEdit['customer_name'] : ''  ?>" placeholder="masukkan nama customer " required>
                    </div>
                    <div class="mb-3">
                        <label for="">Handphone :</label>
                        <input type="number" class="form-control" name="phone" value="<?= isset($rowEdit['phone']) ? $rowEdit['phone'] : ''  ?>" placeholder="masukkan nomor Handphone customer " required>
                    </div>
                    <div class="mb-3">
                        <label for="">Alamat :</label>
                        <input type="text" class="form-control" name="address" value="<?= isset($rowEdit['address']) ? $rowEdit['address'] : ''  ?>" placeholder="masukkan Alamat customer " required>
                    </div>
                    <div class="mb-3">
                        <input type="submit" class="btn btn-success" name="<?php echo isset($rowEdit) ? 'edit' : 'save' ?>" value="<?php echo isset($rowEdit) ? 'edit' : 'save' ?>">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>