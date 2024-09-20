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
        .form-container input[type=date],
        .form-container textarea,
        .form-container select {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
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
            transform: translateY(-2px);
        }

        /* Cancel button specific style */
        .form-container .cancelbtn {
            background-color: rgba(244, 67, 54, 0.8);
        }

        .form-container .cancelbtn:hover {
            background-color: rgba(244, 67, 54, 1);
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
    <h1 class="mt-4">Ulasan</h1>
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-success" onclick="document.getElementById('addModal').style.display='block'">
                <i class="fa fa-plus"></i> Add
            </button>

            <!-- Add Modal -->
            <div id="addModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="document.getElementById('addModal').style.display='none'">&times;</span>
                    <form method="post">
                        <?php
                        // Add Review Handling
                        if (isset($_POST['submit'])) {
                            $BukuID = $_POST['BukuID'];
                            $UserID = $_SESSION['user']['UserID'];
                            $Ulasan = $_POST['Ulasan'];
                            $Rating = $_POST['Rating'];
                            $query = mysqli_query($koneksi, "INSERT INTO ulasanbuku (BukuID, UserID, Ulasan, Rating) VALUES ('$BukuID', '$UserID', '$Ulasan', '$Rating')");
                            echo $query ? '<script>alert("Penambahan data berhasil.");</script>' : '<script>alert("Penambahan data gagal.");</script>';
                        }
                        ?>
                        <div class="form-container">
                            <select name="BukuID" class="form-control" required>
                                <option value="">Select Buku</option>
                                <?php
                                $buk = mysqli_query($koneksi, "SELECT * FROM buku");
                                while ($buku = mysqli_fetch_array($buk)) {
                                    echo "<option value='" . $buku['BukuID'] . "'>" . $buku['Judul'] . "</option>";
                                }
                                ?>
                            </select>
                            <textarea placeholder="Ulasan" name="Ulasan" required></textarea>
                            <select name="Rating" class="form-control" required>
                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                    <option><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                            <button type="submit" class="btn btn-success" name="submit"><i class="fa fa-save"></i> Save</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                            <button type="button" onclick="document.getElementById('addModal').style.display='none'" class="btn btn-danger">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>

            <table class="table table-bordered" id="datatable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>User</th>
                        <th>Buku</th>
                        <th>Ulasan</th>
                        <th>Rating</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $query = mysqli_query($koneksi, "SELECT * FROM ulasanbuku LEFT JOIN user ON user.UserID = ulasanbuku.UserID LEFT JOIN buku ON buku.BukuID = ulasanbuku.BukuID");
                    while ($data = mysqli_fetch_array($query)) {
                        ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $data['NamaLengkap']; ?></td>
                            <td><?php echo $data['Judul']; ?></td>
                            <td><?php echo $data['Ulasan']; ?></td>
                            <td><?php echo $data['Rating']; ?></td>
                            <td>
                                <?php if ($data['UserID'] == $_SESSION['user']['UserID']): ?>
                                    <button class="btn btn-success" onclick="openEditModal(<?php echo $data['UlasanID']; ?>, '<?php echo addslashes($data['Ulasan']); ?>', <?php echo $data['Rating']; ?>)">Edit</button>
                                    <button class="btn btn-danger" onclick="deleteReview(<?php echo $data['UlasanID']; ?>)">Delete</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>

            <!-- Edit Modal -->
            <div id="editModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="document.getElementById('editModal').style.display='none'">&times;</span>
                    <form id="editForm" method="post" onsubmit="return handleEditSubmit();">
                        <input type="hidden" name="UlasanID" id="editUlasanID">
                        <textarea name="Ulasan" id="editUlasan" required></textarea>
                        <select name="Rating" id="editRating" required>
                            <?php for ($i = 1; $i <= 10; $i++): ?>
                                <option><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                        <div class="button-container">
                            <button type="submit" class="btn btn-success" name="edit_submit"><i class="fa fa-save"></i> Update</button>
                            <button type="button" onclick="document.getElementById('editModal').style.display='none'" class="btn btn-danger">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>

            <?php
            // Update Review Handling
            if (isset($_POST['edit_submit'])) {
                $UlasanID = $_POST['UlasanID'];
                $Ulasan = $_POST['Ulasan'];
                $Rating = $_POST['Rating'];
                $query = mysqli_query($koneksi, "UPDATE ulasanbuku SET Ulasan = '$Ulasan', Rating = '$Rating' WHERE UlasanID = '$UlasanID' AND UserID = '" . $_SESSION['user']['UserID'] . "'");
                echo $query ? '<script>alert("Berhasil."); location.href="index.php?page=ulasan";</script>' : '<script>alert("Update gagal.");</script>';
            }
            ?>

            <script>
                function openEditModal(ulasanID, ulasan, rating) {
                    document.getElementById('editUlasanID').value = ulasanID;
                    document.getElementById('editUlasan').value = ulasan;
                    document.getElementById('editRating').value = rating;
                    document.getElementById('editModal').style.display = 'block';
                }

                function deleteReview(ulasanID) {
                    if (confirm('Are you sure you want to delete this review?')) {
                        window.location.href = 'hapus_ulasan.php?UlasanID=' + ulasanID; // Redirect to delete script
                    }
                }

                function editReview(ulasanID) {
                    if (confirm('Are you sure you want to edit this review?')) {
                        window.location.href = '?page=ulasan'; // Redirect to delete script
                    }
                }

                // Close modals when clicking outside of them
                window.onclick = function(event) {
                    if (event.target.className === 'modal') {
                        event.target.style.display = 'none';
                    }
                }

                // Handle form submission for the edit modal
                function handleEditSubmit() {
                    // Close the modal immediately
                    document.getElementById('editModal').style.display = 'none';
                    return true; // Allow form submission
                }
            </script>
        </div>
    </div>
</body>
