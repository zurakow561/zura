<!DOCTYPE html>
<?php
include "koneksi.php"
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Register - SB Admin</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <div class="content">
            <div class="card mt-5 mb-5">
                <div class="row">
                    <div class="col-sm-6 text-center">
                        <img src="assets/img/R.png" width="500">
                    </div>
                    <div class="col-sm-6">
                        <div class="card-body">
                            <?php
                            if (isset($_POST['register'])) {
                                $UserName = $_POST['UserName'];
                                $Password = md5($_POST['Password']);
                                $Email = $_POST['Email'];
                                $NamaLengkap = $_POST['NamaLengkap'];
                                $Alamat = $_POST['Alamat'];

                                $insert = mysqli_query($koneksi, "INSERT INTO user values('','$UserName','$Password','$Email','$NamaLengkap','$Alamat','3')");
                                if ($insert) {
                                    echo '<script>alert("Register Berhasil"); location.href="login.php"</script>';
                                } else {
                                    echo '<script>alert("Register gagal")</script>';
                                }
                            }
                            ?>
                            <form method="post">
                                <div class="form-group mt-5">
                                    <label>Username</label>
                                    <input type="text" name="UserName" class="form-control">
                                </div>
                                <div class="form-group mt-2">
                                    <label>Password</label>
                                    <input type="password" name="Password" class="form-control">
                                </div>
                                <div class="form-group mt-2">
                                    <label>Email</label>
                                    <input type="text" name="Email" class="form-control">
                                </div>
                                <div class="form-group mt-2">
                                    <label>Nama Lengkap</label>
                                    <input type="text" name="NamaLengkap" class="form-control">
                                </div>
                                <div class="form-group mt-2">
                                    <label>Alamat</label>
                                    <input type="text" name="Alamat" class="form-control">
                                </div>
                                <div class="form-group mt-3">
                                    <button type="submit" class="btn btn-primary" name="register" value="register">REGISTER</button>
                                </div>
                                <div class="form-group mt-3">
                                    <a href="login.php" class="btn btn-secondary">Login</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
</body>

</html>