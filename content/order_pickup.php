  <!-- Pages Customer Info -->
<?php 

// jadi kita ambil dulu id dari trans_laundry_pickupnya, ambil table notes dari trans_order_detail dari trans_laundry_pickupnya, 
// nah join sepertu biasa tapi yang detail gausah karena dia udah di select secara individu 
$query = mysqli_query($config, "SELECT 
    trans_laundry_pickup.id,
    trans_laundry_pickup.id_order,
    trans_order.order_code,
    customer.customer_name,
    trans_laundry_pickup.pickup_date,
FROM trans_laundry_pickup
LEFT JOIN trans_order ON trans_laundry_pickup.id_order = trans_order.id
LEFT JOIN customer ON trans_laundry_pickup.id_customer = customer.id
ORDER BY trans_laundry_pickup.id DESC");

$rows = mysqli_fetch_all($query, MYSQLI_ASSOC);
?>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title"> Data User</h5>
          <div class="mb-3" align="right">
            <a href="?page=tambah-pickup_order" class="btn btn-primary">Add</a>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                    <th>No</th>
                    <th>ID Order</th>
                    <th>Customer</th>
                    <th>Pickup Date</th>
                    <th>Notes</th>
                    <th></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($rows as $key => $row): ?>
                <tr>
                    <td><?= $key += 1 ?></td>
                    <td><?= $row['order_code']; ?></td>
                    <td><?= $row['customer_name']; ?></td>
                    <td><?= $row['pickup_date']; ?></td>
                    <td><?= $row['notes']; ?></td>  
                  <td>
                    <!-- <a href="?page=tambah-instructor-major&id=" class="btn btn-primary">Add
                      major</a> -->
                    <a onclick="return confirm('bener gak mau dihapus?')"
                      href="?page=order_pickup&delete=<?php echo $row['id']?>" class="btn btn-danger">Delete</a>
                  </td>
                </tr>
                <?php endforeach ?> 
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>