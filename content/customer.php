<!-- Pages Customer Info -->

<?php 
$query = mysqli_query($config, "SELECT * FROM customer WHERE deleted_at IS NULL");
$rows = mysqli_fetch_all($query, MYSQLI_ASSOC);

?>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title"> Data Customer</h5>
        <div class="mb-3" align="right">
          <a href="?page=tambah-customer" class="btn btn-primary">Add</a>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Customer</th>
                <th>Phone</th>
                <th>Address</th>
                <th>waktu buat</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($rows as $key => $row): ?>
              <tr>
                <td><?php echo $key += 1; ?></td>
                <td><?php echo $row['customer_name'] ?></td>
                <td><?php echo $row['phone'] ?></td>
                <td><?php echo $row['address'] ?></td>
                <td><?php echo $row['created_at'] ?></td>
                <td>
                  <!-- <a href="?page=tambah-instructor-major&id=" class="btn btn-primary">Add
                    major</a> -->
                  <a href="?page=tambah-customer&edit=<?php echo $row ['id']?>" class="btn btn-primary">Edit</a>
                  <a onclick="return confirm('bener gak mau dihapus?')"
                    href="?page=tambah-customer&delete=<?php echo $row ['id']?>" class="btn btn-danger">Delete</a>
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