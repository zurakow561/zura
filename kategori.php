<style>
        /* The Modal (background) */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            overflow: auto;
        }

        /* Modal Content */
        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 20px;
            border-radius: 8px;
            max-width: 450px;
            width: 90%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            position: relative;
        }

        /* Close Button */
        .close {
            color: #555;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: #000;
        }

        /* Form container styles */
        .form-container {
            display: flex;
            flex-direction: column;
            align-items: stretch;
        }

        /* Input styles */
        .form-container input[type=text],
        .form-container input[type=password],
        .form-container input[type=date] {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            background-color: #f9f9f9;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-container input[type=text]:focus,
        .form-container input[type=password]:focus,
        .form-container input[type=date]:focus {
            border-color: #4caf50;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.2);
            outline: none;
        }

        /* Button styles */
        .form-container button {
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 8px 0;
            font-size: 16px;
            transition: background-color 0.3s, transform 0.2s;
        }

        .form-container button:hover {
            transform: translateY(-1px);
        }

        /* Success button style */
        /* .form-container .btn-success {
            background-color: #4caf50;
        }

        .form-container .btn-success:hover {
            background-color: #45a049;
        }

        /* Cancel button specific style */
        /* .form-container .btn-danger {
            background-color: #f44336;
        }

        .form-container .btn-danger:hover {
            background-color: #e53935;
        }

        /* Reset button style */
        /* .form-container .btn-secondary {
            background-color: #9e9e9e;
        }

        .form-container .btn-secondary:hover {
            background-color: #757575;
        }  */

        /* Container for button alignment */
        .form-container .button-container {
            display: flex;
            gap: 12px;
            justify-content: center;
            width: 100%;
            padding: 10px 0;
        }

        /* Responsive styles */
        @media screen and (max-width: 500px) {
            .modal-content {
                width: 95%;
            }

            .form-container .button-container {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <h1 class="mt-4">Kategori Buku</h1>
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-success" onclick="document.getElementById('id01').style.display='block'" style="width:auto;">
                <i class="fa fa-plus"></i> Add
            </button>

            <!-- Add Modal -->
            <div id="id01" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="document.getElementById('id01').style.display='none'">&times;</span>
                    <form method="post">
                        <?php
                        if (isset($_POST['submit'])) {
                            $kategori = $_POST['kategori'];
                            $query = mysqli_query($koneksi, "INSERT INTO kategoribuku(NamaKategori) VALUES ('$kategori')");

                            if ($query) {
                                echo '<script>alert("Penambahan data berhasil.");</script>';
                            } else {
                                echo '<script>alert("Penambahan data gagal.");</script>';
                            }
                        }
                        ?>
                        <div class="form-container">
                            <input type="text" placeholder="Tambahkan data" name="kategori" required>
                            <div class="button-container">
                                <button type="submit" class="btn-success" name="submit" value="submit"><i class="fa fa-save"></i> Save</button>
                                <button type="reset" class="btn-secondary">Reset</button>
                            </div>
                            <div class="button-container">
                                <button type="button" onclick="document.getElementById('id01').style.display='none'" class="btn-danger">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Update Modal -->
            <div id="id02" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="document.getElementById('id02').style.display='none'">&times;</span>
                    <form method="post">
                        <?php
                        if (isset($_POST['update'])) {
                            $kategori_id = $_POST['kategori_id'];
                            $kategori = $_POST['kategori'];
                            $query = mysqli_query($koneksi, "UPDATE kategoribuku SET NamaKategori='$kategori' WHERE KategoriID='$kategori_id'");

                            if ($query) {
                                echo '<script>alert("Update berhasil.");</script>';
                            } else {
                                echo '<script>alert("Update gagal.");</script>';
                            }
                        }
                        ?>
                        <div class="form-container">
                            <input type="hidden" id="edit_kategori_id" name="kategori_id">
                            <input type="text" id="edit_kategori" placeholder="Edit kategori" name="kategori" required>
                            <div class="button-container">
                                <button type="submit" class="btn-success" name="update" value="update">Update</button>
                                <button type="reset" class="btn-secondary">Reset</button>
                            </div>
                            <div class="button-container">
                                <button type="button" onclick="document.getElementById('id02').style.display='none'" class="btn-danger">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <table class="table table-bordered" id="datatable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $query = mysqli_query($koneksi, "SELECT * FROM kategoribuku");
                    while ($data = mysqli_fetch_array($query)) {
                    ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $data['NamaKategori']; ?></td>
                            <td>
                                <a href="javascript:void(0);" onclick="openEditModal(<?php echo $data['KategoriID']; ?>, '<?php echo $data['NamaKategori']; ?>')" class="btn btn-info">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a onclick="return confirm('Anda akan menghapus data ini?')" class="btn btn-danger" href="?page=hapus_kategori&&id=<?php echo $data['KategoriID']; ?>">
                                    <i class="fa fa-eraser"></i> 
                                </a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Function to open the edit modal and set values
        function openEditModal(id, name) {
            document.getElementById('edit_kategori_id').value = id;
            document.getElementById('edit_kategori').value = name;
            document.getElementById('id02').style.display = 'block';
        }

        // Close modals when clicking outside of them
        window.onclick = function(event) {
            if (event.target.className === 'modal') {
                event.target.style.display = 'none';
            }
        }
    </script>