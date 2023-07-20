<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "phpcrud";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Tidak bisa terkoneksi ke database");
}
$name = "";
$email = "";
$password = "";
$sukses = "";
$error = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

if($op == 'delete'){//untuk delete
    $id = $_GET['id'];
    $sql1 = "DELETE FROM user WHERE id = '$id'";
    $q1 = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil menghapus data";
    }else{
        $error = "Gagal menghapus data";
    }
}

if ($op == 'edit') {//untuk edit
    $id = $_GET['id'];
    $sql1 = "SELECT * FROM user WHERE id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    $r1 = mysqli_fetch_array($q1);
    $name = $r1['name'];
    $email = $r1['email'];
    $password = $r1['password'];

    if ($name == '') {
        $error = "Data tidak ditemukan";
    }
}

if (isset($_POST['submit'])) { //untuk create
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($name && $email && $password) {
        if ($op == 'edit') { // untuk update
            $sql1 = "UPDATE user SET name = '$name', email = '$email', password = '$password' WHERE id = '$id'";
            $q1 = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error = "Data gagal diupdate";
            }
        } else { // untuk insert
            $sql1 = "INSERT INTO user(name,email,password) VALUES ('$name','$email','$password')";
            $q1 = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Berhasil memasukkan data baru";
            } else {
                $error = "Gagal memasukkand data";
            }
        }
    } else {
        $error = "Silahkan masukkan semua data";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px;
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-secondary" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">PHP</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">User</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="contact.php">Contact Us</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="register.php">Register</a>
            </li>
        </ul>
        </div>
    </div>
    </nav>

    <div class="mx-auto">
        <!-- utk memasukkan data -->
        <div class="card">
            <div class="card-header">
                Edit Data
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:5;url=index.php");//5 detik
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:5;url=index.php");//5 detik
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $name ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="email" name="email" value="<?php echo $email ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="password" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="password" name="password" value="<?php echo $password ?>">
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>

        <!-- utk mengeluarkan data -->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data User
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Email</th>
                            <th scope="col">Password</th>
                        </tr>
                    <tbody>
                        <?php
                        $sql2 = "SELECT * FROM user ORDER BY id DESC";
                        $q2 = mysqli_query($koneksi, $sql2);
                        $urut = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id = $r2['id'];
                            $name = $r2['name'];
                            $email = $r2['email'];
                            $password = $r2['password'];

                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $name ?></td>
                                <td scope="row"><?php echo $email ?></td>
                                <td scope="row"><?php echo $password ?></td>
                                <td scope="row">
                                    <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="index.php?op=delete&id=<?php echo $id ?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>      
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    </div>
</body>

</html>