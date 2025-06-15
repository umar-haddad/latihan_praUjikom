  <!-- Pages Customer Info -->

  <?php 
  $query = mysqli_query($config, "SELECT trans_order.order_code, trans_order_detail.*, type_of_service.service_name
      FROM trans_order_detail
      LEFT JOIN trans_order ON trans_order_detail.id_order = trans_order.id 
      LEFT JOIN type_of_service ON trans_order_detail.id_service = type_of_service.id
      ORDER BY trans_order_detail.id DESC");
  $rows = mysqli_fetch_all($query, MYSQLI_ASSOC);

  ?>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title"> Data User</h5>
          <div class="mb-3" align="right">
            <a href="?page=tambah-trans_order_detail" class="btn btn-primary">Add</a>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>No</th>
                  <th>ID Order</th>
                  <th>Services</th>
                  <th>Qty</th>
                  <th>Subtotal</th>
                  <th>Notes</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($rows as $key => $row): ?>
                <tr>
                  <td><?php echo $key += 1; ?></td>
                  <td><?php echo $row['order_code'] ?></td>
                  <td><?php echo $row['service_name'] ?></td>
                  <td><?php echo $row['qty'] ?></td>
                  <td><?php echo $row['subtotal'] ?></td>
                  <td><?php echo $row['notes'] ?></td>
                  <td>
                    <!-- <a href="?page=tambah-instructor-major&id=" class="btn btn-primary">Add
                      major</a> -->
                    <a href="?page=tambah-trans_order_detail&edit=<?php echo $row ['id']?>" class="btn btn-primary">Edit</a>
                    <a onclick="return confirm('bener gak mau dihapus?')"
                      href="?page=tambah-trans_order_detail&delete=<?php echo $row ['id']?>" class="btn btn-danger">Delete</a>
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