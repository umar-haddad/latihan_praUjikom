<?php

$editUser = isset($_GET['edit']) ? $_GET['edit'] :'';
$queryEdit = mysqli_query($config, "SELECT * FROM user WHERE id='$editUser'");
$rowEdit = mysqli_fetch_assoc($queryEdit);


if(isset($_POST['name'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = sha1($_POST['password']) ? sha1(($_POST['password'])) :'';
    $level = $_POST['id_level'];

    if(isset($_GET['edit'])) {
        $updateQ = mysqli_query($config, "UPDATE user SET name='$name', email='$email', password='$password', id_level='$level' WHERE id='$editUser'");
        header("location: ?page=user&id" . $editUser . "&update=berhasil");
    } else {
        $insertQ = mysqli_query($config, "INSERT INTO user (name, email, password, id_level) VALUES ('$name', '$email', '$password', '$level')");
         header("location: ?page=user&id" . $editUser . "&tambah=berhasil");
    }
}

if (isset($_GET['delete'])) {
    $id_user = isset($_GET['delete']) ? $_GET['delete'] : '' ;

    $queryDelete = mysqli_query($config, "DELETE FROM user WHERE id='$id_user'");
    if ($queryDelete) {
        header("location: ?page=user&" . $id_user . "&hapus=berhasil");
    } 
}


$queryLevel = mysqli_query($config, "SELECT * FROM level");
$rowLevels = mysqli_fetch_all($queryLevel, MYSQLI_ASSOC);



?>  

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo isset($rowEdit) ? 'edit' : 'save' ?> User</h5>

                <form action="" method="post">
                    <div class="mb-3">
                        <label for="">Nama :</label>
                        <input type="text" class="form-control" name="name" value="<?= isset($rowEdit['name']) ? $rowEdit['name'] : ''  ?>" placeholder="masukkan nama user " required>
                    </div>
                    <div class="mb-3">
                        <label for="">Email :</label>
                        <input type="email" class="form-control" name="email" value="<?= isset($rowEdit['email']) ? $rowEdit['email'] : ''  ?>" placeholder="masukkan nomor Handphone user " required>
                    </div>
                    <div class="mb-3">
                         <label for="" class="mb-3 mt-2">level</label>
                          <select name="id_level" class="form-control" required>
                            <option value="">-- Pilih Level --</option>
                                 <?php foreach ($rowLevels as $level): ?>
                                    <option value="<?= $level['id'] ?>" <?= (isset($rowEdit['id_level']) && $rowEdit['id_level'] == $level['id']) ? 'selected' : '' ?>>
                                         <?= $level['level_name'] ?>
                                    </option>   
                                 <?php endforeach ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="">Password :</label>
                        <input type="password" class="form-control" name="password" value="<?= isset($rowEdit['password']) ? $rowEdit['password'] : ''  ?>" placeholder="masukkan password " required>
                    </div>
                    <div class="mb-3">
                        <input type="submit" class="btn btn-success" name="<?php echo isset($rowEdit) ? 'edit' : 'save' ?>" value="<?php echo isset($rowEdit) ? 'edit' : 'save' ?>">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>