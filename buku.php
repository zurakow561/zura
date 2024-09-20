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
    .form-container input[type=date] {
        width: 100%;
        padding: 12px;
        margin: 8px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }

    /* Button styles */
    .form-container button {
        /* background-color: rgba(4, 170, 109, 0.8); Original success color */
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
        /* background-color: rgba(4, 170, 109, 1); Solid success color on hover */
        transform: translateY(-2px);
    }

    /* Cancel button specific style */
    .form-container .cancelbtn {
        background-color: rgba(244, 67, 54, 0.8);
        /* Original cancel color */
    }

    .form-container .cancelbtn:hover {
        background-color: rgba(244, 67, 54, 1);
        /* Solid cancel color on hover */
    }

    /* Container for button alignment */
    .form-container .button-container {
        display: flex;
        gap: 10px;
        margin-top: 10px;
    }

    /* Responsive styles */
    @media screen and (max-width: 500px) {
        .modal-content {
            width: 95%;
        }

        .form-container .button-container {
            flex-direction: column;
            gap: 5px;
        }
    }
</style>
</head>

<body>
    <h1 class="mt-4">Buku</h1>
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-success" onclick="document.getElementById('id01').style.display='block'" style="width:auto;">
                <i class="fa fa-plus"></i> Add
            </button>

            <!-- Add Modal -->
            <div id="id01" class="modal">
                <div class="modal-content animate">
                    <span class="close" onclick="document.getElementById('id01').style.display='none'">&times;</span>
                    <form method="post">
                        <?php
                        if (isset($_POST['submit'])) {
                            $kategoriId = $_POST['KategoriId'];
                            $judul = $_POST['Judul'];
                            $penulis = $_POST['Penulis'];
                            $penerbit = $_POST['Penerbit'];
                            $tahunTerbit = $_POST['TahunTerbit'];
                            $query = mysqli_query($koneksi, "INSERT INTO buku (KategoriID, Judul, Penulis, Penerbit, TahunTerbit) VALUES ('$kategoriId', '$judul', '$penulis', '$penerbit', '$tahunTerbit')");

                            if ($query) {
                                echo '<script>alert("Penambahan data berhasil.");</script>';
                            } else {
                                echo '<script>alert("Penambahan data gagal.");</script>';
                            }
                        }
                        ?>
                        <div class="form-container">
                            <div class="container">
                                <select name="KategoriId" class="form-control" required>
                                    <option value="">Select Kategori</option>
                                    <?php
                                    $kat = mysqli_query($koneksi, "SELECT * FROM kategoribuku");
                                    while ($kategori = mysqli_fetch_array($kat)) {
                                        echo "<option value='" . $kategori['KategoriID'] . "'>" . $kategori['NamaKategori'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <input type="text" placeholder="Judul" name="Judul" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <input type="text" placeholder="Penulis" name="Penulis" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <input type="text" placeholder="Penerbit" name="Penerbit" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <input type="date" placeholder="Tahun Terbit" name="TahunTerbit" required>
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-success" name="submit" value="submit"><i class="fa fa-save"></i> Save</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                            <div class="container" style="background-color:#f1f1f1; text-align: center;">
                                <button type="button" onclick="document.getElementById('id01').style.display='none'" class="btn btn-danger">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Update Modal -->
            <div id="id02" class="modal">
                <div class="modal-content animate">
                    <span class="close" onclick="document.getElementById('id02').style.display='none'">&times;</span>
                    <form method="post">
                        <?php
                        if (isset($_POST['update'])) {
                            $bukuId = $_POST['BukuID'];
                            $kategoriId = $_POST['KategoriId'];
                            $judul = $_POST['Judul'];
                            $penulis = $_POST['Penulis'];
                            $penerbit = $_POST['Penerbit'];
                            $tahunTerbit = $_POST['TahunTerbit'];

                            $query = mysqli_query($koneksi, "UPDATE buku SET KategoriID='$kategoriId', Judul='$judul', Penulis='$penulis', Penerbit='$penerbit', TahunTerbit='$tahunTerbit' WHERE BukuID='$bukuId'");

                            if ($query) {
                                echo '<script>alert("Update berhasil.");</script>';
                            } else {
                                echo '<script>alert("Update gagal.");</script>';
                            }
                        }
                        ?>
                        <div class="form-container">
                            <input type="hidden" id="edit_buku_id" name="BukuID">
                            <div class="container">
                                <select name="KategoriId" id="edit_kategori_id" class="form-control" required>
                                    <option value="">Select Kategori</option>
                                    <?php
                                    $kat = mysqli_query($koneksi, "SELECT * FROM kategoribuku");
                                    while ($kategori = mysqli_fetch_array($kat)) {
                                        echo "<option value='" . $kategori['KategoriID'] . "'>" . $kategori['NamaKategori'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <input type="text" id="edit_judul" placeholder="Judul" name="Judul" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <input type="text" id="edit_penulis" placeholder="Penulis" name="Penulis" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <input type="text" id="edit_penerbit" placeholder="Penerbit" name="Penerbit" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <input type="date" id="edit_tahun_terbit" placeholder="Tahun Terbit" name="TahunTerbit" required>
                                </div>
                            </div>
                            <div class="button-container">
                                <button type="submit" class="btn btn-primary" name="update" value="update">Update</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                            <div class="container" style="background-color:#f1f1f1; text-align: center;">
                                <button type="button" onclick="document.getElementById('id02').style.display='none'" class="btn btn-danger">Cancel</button>
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
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th>Tahun Terbit</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $query = mysqli_query($koneksi, "SELECT * FROM buku LEFT JOIN kategoribuku ON buku.KategoriID = kategoribuku.KategoriID");
                    while ($data = mysqli_fetch_array($query)) {
                    ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $data['NamaKategori']; ?></td>
                            <td><?php echo $data['Judul']; ?></td>
                            <td><?php echo $data['Penulis']; ?></td>
                            <td><?php echo $data['Penerbit']; ?></td>
                            <td><?php echo $data['TahunTerbit']; ?></td>
                            <td>
                                <a href="javascript:void(0);" onclick="openEditModal(<?php echo $data['BukuID']; ?>, '<?php echo $data['KategoriID']; ?>', '<?php echo $data['Judul']; ?>', '<?php echo $data['Penulis']; ?>', '<?php echo $data['Penerbit']; ?>', '<?php echo $data['TahunTerbit']; ?>')" class="btn btn-info">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="javascript:void(0);" onclick="confirmDelete(<?php echo $data['BukuID']; ?>)" class="btn btn-danger">
                                    <i class="fa fa-trash"></i>
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
        function confirmDelete(bukuId) {
            if (confirm('Anda akan menghapus data ini?')) {
                window.location.href = '?page=hapus_buku&id=' + bukuId;
            }
        }


        // Function to open the edit modal and set values
        function openEditModal(bukuId, kategoriId, judul, penulis, penerbit, tahunTerbit) {
            document.getElementById('edit_buku_id').value = bukuId;
            document.getElementById('edit_kategori_id').value = kategoriId;
            document.getElementById('edit_judul').value = judul;
            document.getElementById('edit_penulis').value = penulis;
            document.getElementById('edit_penerbit').value = penerbit;
            document.getElementById('edit_tahun_terbit').value = tahunTerbit;
            document.getElementById('id02').style.display = 'block';
        }

        // Close modals when clicking outside of them
        window.onclick = function(event) {
            if (event.target.className === 'modal') {
                event.target.style.display = 'none';
            }
        }
    </script>
</body>