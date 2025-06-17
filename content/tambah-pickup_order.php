<?php

if (isset($_POST['id_customer'])) {
    $id_customer = $_POST['id_customer'];

    // Ambil order terbaru milik customer
    $queryOrder = mysqli_query($config, "SELECT id AS id_order FROM trans_order WHERE id_customer = '$id_customer' ORDER BY id DESC LIMIT 1");
    $rowOrder = mysqli_fetch_assoc($queryOrder);

    if ($rowOrder) {
        $id_order = $rowOrder['id_order'];

        // Ambil notes dari trans_order_detail
        $queryDetail = mysqli_query($config, "SELECT notes FROM trans_order_detail WHERE id_order = '$id_order'");
        $rowDetail = mysqli_fetch_assoc($queryDetail);

        $notes = isset($rowDetail['notes']) ? $rowDetail['notes'] : '-';
        $pickup_date = date("Y-m-d");

        // Simpan data pickup
        $insertQ = mysqli_query($config, "INSERT INTO trans_laundry_pickup 
            (notes, id_order, id_customer, pickup_date) 
            VALUES ('$notes', '$id_order', '$id_customer', '$pickup_date')");

        header("location: ?page=order_pickup&tambah=berhasil");
    } else {
        echo "<script>alert('Customer ini belum memiliki order.');</script>";
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($config, "DELETE FROM trans_laundry_pickup WHERE id = '$id'");
    header("Location: ?page=order_pickup&hapus=berhasil");   
}    

// Ambil semua customer untuk dropdown
$queryCustomer = mysqli_query($config, "SELECT id, customer_name FROM customer");
$customers = mysqli_fetch_all($queryCustomer, MYSQLI_ASSOC);

?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Tambah Pickup Order</h5>

                <form action="" method="post">
                    <div class="mb-3">
                        <label for="id_customer">Pilih Customer:</label>
                            <select name="id_customer" class="form-control" required>
                                <option value="">-- Pilih Customer --</option>
                                    <?php foreach ($customers as $cust): ?>
                                <option value="<?= $cust['id'] ?>">
                                    <?= $cust['customer_name'] ?>
                                </option>
                            <?php endforeach; ?>
                            </select>
                            </div>

                    <div class="mb-3">
                        <input type="submit" class="btn btn-success" value="Simpan Pickup">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
