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
    $order_date     = $_POST['order_date'] ?? date('Y-m-d'  );
    $order_end_date = $_POST['order_end_date'] ?? date('Y-m-d' );
    $pay            = $_POST['order_pay'];  
    $status = isset($_GET['edit']) ? $_POST['order_status'] : '1';

    if (!empty($editOrder)) {
        $updateQ = mysqli_query($config, "UPDATE trans_order SET 
            order_code='$order_code', 
            id_customer='$id_customer', 
            order_date='$order_date', 
            order_end_date='$order_end_date', 
            order_pay = '$pay',
            order_status='$status'
            WHERE id='$editOrder'");

        header("Location: ?page=trans_order&id=$editOrder&update=berhasil");
        exit;
    } else {
        $insertQ = mysqli_query($config, "INSERT INTO trans_order 
            (order_code, id_customer, order_date, order_end_date, order_pay, order_status)
            VALUES 
            ('$order_code', '$id_customer', '$order_date', '$order_end_date', '$pay', '$status')");

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

$queryService = mysqli_query($config,"SELECT * FROm type_of_service");
$rowServices = mysqli_fetch_all(    $queryService, MYSQLI_ASSOC);
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?= !empty($rowEdit) ? 'Edit' : 'Save' ?> Order</h5>

                <form action="" method="post">
                    <input type="hidden" name="order_code" value="<?= $rowEdit['order_code'] ?? '' ?>">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="mb-2">Customer</label>
                            <select name="id_customer" class="form-control" required>
                                <option value="">-- Pilih Customer --</option>
                                <?php foreach ($rowCustomers as $customer): ?>
                                <option value="<?= $customer['id'] ?>"
                                    <?= (isset($rowEdit['id_customer']) && $rowEdit['id_customer'] == $customer['id']) ? 'selected' : '' ?>>
                                    <?= $customer['customer_name'] ?>
                                </option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="mb-2">Order pada tanggal:</label>
                            <input type="date" name="order_date" class="form-control"
                                value="<?= $rowEdit['order_date'] ?? date('Y-m-d') ?>">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="mb-2">Mau diambil kapan:</label>
                            <input type="date" name="order_end_date" class="form-control"
                                value="<?= $rowEdit['order_end_date'] ?? date('Y-m-d') ?>">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="mb-2">Pembayaran:</label>
                            <input type="number" class="form-control" name="order_pay"
                                value="<?= $rowEdit['order_pay'] ?? '' ?>" placeholder="Berapa yang dibayarkan..."
                                required>
                        </div>

                        <?php if(isset($_GET['edit'])) : ?>
                        <div class="col-md-6 mb-3">
                            <label>Status</label>
                            <select name="order_status" class="form-control" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="0" <?= ($rowEdit['order_status'] == '0') ? 'selected' : '' ?>>selesai
                                </option>
                                <option value="1" <?= ($rowEdit['order_status'] == '1') ? 'selected' : '' ?>>Diproses
                                </option>
                            </select>
                        </div>
                        <?php endif ?>

                    </div>
                    <div class="mb-3">
                        <input type="submit" class="btn btn-success" value="<?= !empty($rowEdit) ? 'Edit' : 'Save' ?>">
                    </div>
                </form>
                <div class="mb-3" align="right">
                    <button align="right" type="button" class="btn btn-success" id="inputOrder">Add Row</button>
                </div>
                <form action="" method="post">
                    <table class="table table-bordered" id="orderDetail">
                        <thead>
                            <tr>
                                <th>service :</th>
                                <th>qty :</th>
                                <th>price :</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <div class="col-md-6">
                            <h5 class="btn btn-primary">Total: <span id="grandTotal">0</span></h5>
                        </div>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
const services = <?= json_encode($rowServices) ?>;

document.getElementById('inputOrder').addEventListener('click', function() {
    const tbody = document.querySelector('#orderDetail tbody');
    const row = document.createElement('tr');

    let serviceOptions = '<option value="">-- Pilih Service --</option>';
    services.forEach(service => {
        serviceOptions += `<option value="${service.id}" data-price="${service.price}">
            ${service.service_name}
        </option>`;
    });

    row.innerHTML = `
        <td>
            <select name="id_service[]" class="form-control service-select" required>
                ${serviceOptions}
            </select>
        </td>
        <td><input type="number" name="qty[]" class="form-control qty" value="1" min="1"></td>
        <td><input type="number" name="harga[]" class="form-control harga" readonly></td>
        <td><input type="number" name="total[]" class="form-control total" readonly></td>
        <td><button type="button" class="btn btn-danger btn-sm deleteRow">X</button></td>
    `;

    tbody.appendChild(row);
    attachEvents(row); // <-- Kirim baris yang baru ditambahkan
});

function hitungTotal() {
    const totalFields = document.querySelectorAll('.total');
    let grand = 0;
    totalFields.forEach(field => {
        grand += parseFloat(field.value || 0);
    });
    document.getElementById('grandTotal').innerText = grand.toLocaleString();
}

function attachEvents(row) {
    const select = row.querySelector('.service-select');
    const qty = row.querySelector('.qty');
    const harga = row.querySelector('.harga');
    const total = row.querySelector('.total');
    const deleteBtn = row.querySelector('.deleteRow');

    select.addEventListener('change', function() {
        const price = this.options[this.selectedIndex].getAttribute('data-price');
        harga.value = price || 0;
        total.value = (qty.value || 0) * (price || 0);
        hitungTotal();
    });

    qty.addEventListener('input', function() {
        const price = harga.value || 0;
        total.value = qty.value * price;
        hitungTotal();
    });

    deleteBtn.addEventListener('click', function() {
        row.remove();
        hitungTotal();
    });
}
</script>