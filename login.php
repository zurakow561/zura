<!DOCTYPE html>
<?php
include "koneksi.php"
?>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <div class="content">
            <div class="card mt-5 mb-5">
                <div class="row">
                    <div class="col-sm-6 text-center">
                        <img src="assets/img/L.png" width="500">
                    </div>
                    <div class="col-sm-6">
                        <div class="card-body">
                            <?php
                            if (isset($_POST['login'])) {
                                $UserName = $koneksi->real_escape_string($_POST['UserName']);
                                $Password = md5($_POST['Password']); // Make sure the password hashing matches with what's stored in the database

                                // Corrected SQL query with AND for both conditions
                                $query = "SELECT * FROM user WHERE UserName='$UserName' AND Password='$Password'";
                                $data = $koneksi->query($query);

                                // Check if query execution was successful
                                if (!$data) {
                                    die('Query Error: ' . $koneksi->error);
                                }

                                $cek = mysqli_num_rows($data);
                                if ($cek > 0) {
                                    $_SESSION['user'] = mysqli_fetch_array($data, MYSQLI_ASSOC);
                                    echo '<script>alert("Login berhasil"); location.href="index.php";</script>';
                                } else {
                                    echo '<script>alert("Username/password salah");</script>';
                                }

                                // Free result set
                                $data->free();
                            }

                            // Close connection
                            $koneksi->close();
                            ?>
                            <form method="post">
                                <div class="form-group mt-5">
                                    <label>username</label>
                                    <input type="text" name="UserName" class="form-control">
                                </div>
                                <div class="form-group mt-2">
                                    <label>password</label>
                                    <input type="password" name="Password" class="form-control">
                                </div>
                                <div class="form-group mt-3">
                                    <button type="submit" class=" btn btn-primary" name="login" value="login">login</button>
                                </div>
                                <div class="form-group mt-3">
                                    <a href="register.php" class="btn btn-secondary">register</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>

</html>