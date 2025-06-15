<!-- Pages Customer Info -->

<?php 
$query = mysqli_query($config, "SELECT * FROM type_of_service WHERE deleted_at IS NULL");
$rows = mysqli_fetch_all($query, MYSQLI_ASSOC);


?>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title"> Data Services</h5>
        <div class="mb-3" align="right">
          <a href="?page=tambah-service" class="btn btn-primary">Add</a>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Laundry</th>
                <th>Harga</th>
                <th>Description</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($rows as $key => $row): ?>
              <tr>
                <td><?php echo $key += 1; ?></td>
                <td><?php echo $row['service_name'] ?></td>
                <td><?php echo $row['price'] ?></td>
                <td><?php echo $row['description'] ?></td>
                <td>
                  <!-- <a href="?page=tambah-instructor-major&id=" class="btn btn-primary">Add
                    major</a> -->
                  <a href="?page=tambah-service&edit=<?php echo $row ['id']?>" class="btn btn-primary">Edit</a>
                  <a onclick="return confirm('bener gak mau dihapus?')"
                    href="?page=tambah-service&delete=<?php echo $row ['id']?>" class="btn btn-danger">Delete</a>
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