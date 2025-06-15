<?php
$editOrder = isset($_GET['edit']) ? $_GET['edit'] : '';
$rowEdit = [];

if (!empty($editOrder)) {
    $queryEdit = mysqli_query($config, "SELECT * FROM trans_order WHERE id='$editOrder'");

    if (!$queryEdit) {
        die("Query error: " . mysqli_error($config));
    }

    $rowEdit = mysqli_fetch_assoc($queryEdit);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_code     = uniqid('ORD_');
    $id_customer    = $_POST['id_customer'];
    $order_date     = $_POST['order_date'] ?? date('Y-m-d');
    $order_end_date = $_POST['order_end_date'] ?? date('Y-m-d');
    $total          = $_POST['total'];
    $pay            = $_POST['order_pay'];
    $change         = $pay - $total;
    $status         = $_POST['order_status'];

    if (!empty($editOrder)) {
        $updateQ = mysqli_query($config, "UPDATE trans_order SET 
            order_code='$order_code', 
            id_customer='$id_customer', 
            order_date='$order_date', 
            order_end_date='$order_end_date', 
            order_status='$status', 
            order_pay='$pay', 
            order_change='$change', 
            total='$total'
            WHERE id='$editOrder'");

        header("Location: ?page=trans_order&id=$editOrder&update=berhasil");
        exit;
    } else {
        $insertQ = mysqli_query($config, "INSERT INTO trans_order 
            (order_code, id_customer, order_date, order_end_date, total, order_pay, order_change, order_status)
            VALUES 
            ('$order_code', '$id_customer', '$order_date', '$order_end_date', '$total', '$pay', '$change', '$status')");

        $newId = mysqli_insert_id($config);
        header("Location: ?page=trans_order&id=$newId&tambah=berhasil");
        exit;
    }
}

if (isset($_GET['delete'])) {
    $id_order = $_GET['delete'];
    $now = date('Y-m-d H:i:s');
    $queryDelete = mysqli_query($config, "UPDATE trans_order SET deleted_at='$now' WHERE id='$id_order'");
    if ($queryDelete) {
        header("Location: ?page=trans_order&id=$id_order&hapus=berhasil");
        exit;
    }
}

$queryCustomer = mysqli_query($config, "SELECT * FROM customer");
$rowCustomers = mysqli_fetch_all($queryCustomer, MYSQLI_ASSOC);
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?= !empty($rowEdit) ? 'Edit' : 'Save' ?> Order</h5>

                <form action="" method="post">
                    <input type="hidden" name="order_code" value="<?= $rowEdit['order_code'] ?? '' ?>">

                    <div class="mb-3">
                        <label for="" class="mb-3 mt-2">Customer</label>
                        <select name="id_customer" class="form-control" required>
                            <option value="">-- Pilih Customer --</option>
                            <?php foreach ($rowCustomers as $customer): ?>
                                <option value="<?= $customer['id'] ?>" <?= (isset($rowEdit['id_customer']) && $rowEdit['id_customer'] == $customer['id']) ? 'selected' : '' ?>>
                                    <?= $customer['customer_name'] ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <input type="hidden" name="order_date" value="<?= $rowEdit['order_date'] ?? date('Y-m-d H:i:s') ?>">
                    <input type="hidden" name="order_end_date" value="<?= $rowEdit['order_end_date'] ?? date('Y-m-d H:i:s') ?>">

                    <div class="mb-3">
                        <label for="">Pembayaran :</label>
                        <input type="number" class="form-control" name="order_pay" value="<?= $rowEdit['order_pay'] ?? '' ?>" placeholder="Berapa yang dibayarkan..." required>
                    </div>

                    <div class="mb-3">
                        <label for="">Total :</label>
                        <input type="number" class="form-control" name="total" value="<?= $rowEdit['total'] ?? '' ?>" placeholder="Berapa total biaya..." required>
                    </div>

                    <div class="mb-3">
                        <label for="">Status</label>
                        <select name="order_status" class="form-control" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="1" <?= (isset($rowEdit['order_status']) && $rowEdit['order_status'] == '1') ? 'selected' : '' ?>>Diproses</option>
                            <option value="2" <?= (isset($rowEdit['order_status']) && $rowEdit['order_status'] == '2') ? 'selected' : '' ?>>Selesai</option>
                            <option value="3" <?= (isset($rowEdit['order_status']) && $rowEdit['order_status'] == '3') ? 'selected' : '' ?>>Diambil</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <input type="submit" class="btn btn-success" value="<?= !empty($rowEdit) ? 'Edit' : 'Save' ?>">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
