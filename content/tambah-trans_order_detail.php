<?php

$editOrderDetail = isset($_GET['edit']) ? $_GET['edit'] :'';
$queryEdit = mysqli_query($config, "SELECT * FROM trans_order_detail WHERE id='$editOrderDetail'");
$rowEdit = mysqli_fetch_assoc($queryEdit);

// ambil semua Orderan
$queryOrders = mysqli_query($config, "SELECT id, order_code FROM trans_order WHERE deleted_at IS NULL");
$orders = mysqli_fetch_all($queryOrders, MYSQLI_ASSOC);

// Ambil semua services
$queryServices = mysqli_query($config, "SELECT id, service_name FROM type_of_service");
$services = mysqli_fetch_all($queryServices, MYSQLI_ASSOC);

if (isset($_POST['qty'])) {
    $id_order = $_POST['id_order'];
    $id_service = $_POST['id_service'];
    $qty = $_POST['qty'];
    $notes = $_POST['notes'];

    // Ambil harga layanan berdasarkan id_service
    $getHarga = mysqli_query($config, "SELECT price FROM type_of_service WHERE id = '$id_service'");
    $dataHarga = mysqli_fetch_assoc($getHarga);
    $harga = $dataHarga['price'];

    // Hitung subtotal
    $subtotal = round($qty * $harga, 2);

    if (isset($_GET['edit'])) {
        $updateQ = mysqli_query($config, "UPDATE trans_order_detail SET id_order='$id_order', id_service='$id_service', qty='$qty', subtotal='$subtotal', notes='$notes' WHERE id='$editOrderDetail'");
        header("location: ?page=trans_order_detail&id=$editOrderDetail&update=berhasil");
    } else {
        $insertQ = mysqli_query($config, "INSERT INTO trans_order_detail (id_order, id_service, qty, subtotal, notes) VALUES ('$id_order', '$id_service', '$qty', '$subtotal', '$notes')");
        header("location: ?page=trans_order_detail&tambah=berhasil");
    }
}


if (isset($_GET['delete'])) {
    $id_orderDetail = isset($_GET['delete']) ? $_GET['delete'] : '' ;

    $queryDelete = mysqli_query($config, "DELETE FROM trans_order_detail WHERE id='$id_orderDetail'");
    if ($queryDelete) {
        header("location: ?page=trans_order_detail&id=" . $id_orderDetail . "&hapus=berhasil") ;
    } 
}


?>  

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo isset($rowEdit) ? 'edit' : 'save' ?> OrderDetail</h5>

                <form action="" method="post">
                    <!-- Order Code  -->
                    <div class="mb-3">
                         <label for="">Order Code:</label>
                         <select name="id_order" class="form-control" required>
                             <option value="">-- Pilih Order --</option>
                       <?php foreach ($orders as $order): ?>
                             <option value="<?= $order['id'] ?>" <?= (isset($rowEdit['id_order']) && $rowEdit['id_order'] == $order['id']) ? 'selected' : '' ?>>
                             <?= $order['order_code'] ?>
                             </option>
                         <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- pilih Layanan -->
                    <div class="mb-3">
                     <label for="">Jenis Layanan:</label>
                     <select name="id_service" class="form-control" required>
                            <option value="">-- Pilih Layanan --</option>
                            <?php foreach ($services as $service): ?>
                            <option value="<?= $service['id'] ?>" data-price="<?= $service['service_name'] ?>" 
                                <?= (isset($rowEdit['id_service']) && $rowEdit['id_service'] == $service['id']) ? 'selected' : '' ?>>
                                <?= $service['service_name'] ?>
                            </option>
                            <?php endforeach; ?>
                     </select>
                     </div>

                     <!-- Qty barang -->
                    <div class="mb-3">
                        <label>Qty:</label>
                        <input type="number" class="form-control" name="qty" value="<?= isset($rowEdit['qty']) ? $rowEdit['qty'] : '' ?>" placeholder="Berapa kilo" required>
                    </div>

                    <div class="mb-3">
                        <label for="">notes :</label>
                        <input type="text" class="form-control" name="notes" value="<?= isset($rowEdit['notes']) ? $rowEdit['notes'] : ''  ?>" placeholder="masukkan deskripsi" required>
                    </div>
                    <div class="mb-3">
                        <input type="submit" class="btn btn-success" name="<?php echo isset($rowEdit) ? 'edit' : 'save' ?>" value="<?php echo isset($rowEdit) ? 'edit' : 'save' ?>">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>