<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <title>RPL Unit Testing - Data Obat</title>
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
        body{
            background-color: #89d0e6;
            min-height: 110vh;
        }
        .card-header{
            background-color: white;
            margin: 30px 280px;
            text-align: center;
        }
        .card{
            border-radius: 20px;
        }
        .card h5{
            text-align: center;
        }
        /*.text-right a{
            margin-top: 10px;
        }*/
    </style>
</head>
<?php
spl_autoload_register(function ($className) {
    include 'classes/' . $className . '.php';
});
?>

<?php $stok = new Stok(); ?>


<body>
    <div class="container mt-4 justify-content-center">
        <?php

        session_start();
        if (isset($_POST['submit'])) {
            $nama = $_POST['nama'];
            $jumlah_stok = $_POST['jumlah_stok'];
            $harga_beli = $_POST['harga_beli'];
            $laba = $_POST['laba'];
            $tanggal = $_POST['tanggal'];
            $harga_jual  = $_POST['harga_jual'];

            $stok->id = uniqid('trans_');
            $stok->nama_obat = $nama;
            $stok->jumlah_stok = $jumlah_stok;
            $stok->harga_beli = $harga_beli;
            $stok->laba = $laba;
            $stok->tanggal = $tanggal;
            $stok->harga_jual = $stok->countHargaJual();

            if ($stok->insert()) {
                $_SESSION['dataInput'] = 'success';

                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            } else {
                $_SESSION['dataInput'] = 'fail';

                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            }
        }
        //Message
        if (isset($_SESSION['dataInput'])) {
            if ($_SESSION['dataInput'] == 'success') {
                echo "<span class='insert'>Data Inserted Successfully...</span>";
            } elseif ($_SESSION['dataInput'] == 'fail') {
                echo "<span class='insert'>Data Inserted Failed...</span>";
            }
            unset($_SESSION['dataInput']);
        }

        if (isset($_POST['update'])) {
            $id = $_POST['id'];
            $nama = $_POST['updt_nama'];
            $jumlah_stok = $_POST['updt_jumlah_stok'];
            $harga_beli = $_POST['updt_harga_beli'];
            $laba = $_POST['updt_laba'];
            $tanggal = $_POST['updt_tanggal'];
            $harga_jual  = $_POST['updt_harga_jual'];

            // $stok->$id = uniqid('trans_');
            $stok->nama_obat = $nama;
            $stok->jumlah_stok = $jumlah_stok;
            $stok->harga_beli = $harga_beli;
            $stok->laba = $laba;
            $stok->tanggal = $tanggal;
            $stok->harga_jual = $stok->countHargaJual();

            if ($stok->update($id)) {
                $_SESSION['dataUpdate'] = 'success';

                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            } else {
                $_SESSION['dataUpdate'] = 'fail';

                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            }
        }
        if (isset($_SESSION['dataUpdate'])) {
            if ($_SESSION['dataUpdate'] == 'success') {
                echo "<span class='insert'>Data Updated Successfully...</span>";
            } elseif ($_SESSION['dataUpdate'] == 'fail') {
                echo "<span class='insert'>Updating Data Failed...</span>";
            }
            unset($_SESSION['dataUpdate']);
        }

        if (isset($_GET['action']) && $_GET['action'] == 'delete') {
            $id = (int)$_GET['id'];

            if ($stok->delete($id)) {
                echo "<span class='delete'> Data deleted succesfully...</span>";
                $_SESSION['dataDelete'] = 'success';

                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            } else {
                $_SESSION['dataDelete'] = 'fail';

                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            }
        }
        if (isset($_SESSION['dataDelete'])) {
            if ($_SESSION['dataDelete'] == 'success') {
                echo "<span class='insert'>Data Deleted Successfully...</span>";
            } elseif ($_SESSION['dataDelete'] == 'fail') {
                echo "<span class='insert'>Deleting Data Failed...</span>";
            }
            unset($_SESSION['dataDelete']);
        }

        ?>
        <div class="card-header">
            <h2 class="card-title">Data Obat di Apotek XYZ</h2>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Tabel Laba Stok Obat</h5>
                <div class="row">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" id="insert-data-btn" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#InsertFormModal" style="margin-bottom:10px;">
                            Tambah Data
                        </button>
                    </div>
                </div>
                <table class="table table-light table-striped table-hover">
                    <thead>
                        <tr class="table-dark">
                            <th scope="col">Id Barang</th>
                            <th scope="col">Nama Obat</th>
                            <th scope="col">Jumlah Stok</th>
                            <th scope="col">Harga Satuan</th>
                            <th scope="col">Laba (%)</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Harga Jual</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        if (is_array($stok->readAll()) || is_object($stok->readAll())) {
                            foreach ($stok->readAll() as $value) {
                                $i++;
                        ?>
                                <tr>
                                    <th scope="row"><?php echo $value['id']  ?></th>
                                    <td><?php echo $value['nama_obat']  ?></td>
                                    <td><?php echo number_format($value['jumlah_stok'], 0, ',', '.');  ?></td>
                                    <td><?php echo "Rp" . number_format($value['harga_beli'], 2, ',', '.');  ?></td>
                                    <td><?php echo number_format($value['laba'], 0, ',', '.');  ?></td>
                                    <td><?php echo $value['tanggal'];  ?></td>
                                    <td><?php echo "Rp" . number_format($value['harga_jual'], 2, ',', '.');  ?></td>
                                    <td class="text-right">
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#UpdateFormModal" onclick="<?php echo "fillUpdateForm(" . $value['id'] . ")" ?>">Edit</button>
                                        <a id="del-btn-<?php echo $value['id']; ?>" class=" btn btn-danger" href="<?php echo $_SERVER['PHP_SELF'] ?>?action=delete&id=<?php echo $value['id']; ?>">Delete</a>

                                        <!-- <button class="btn btn-danger">Hapus</button> -->
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td>No data</td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Insert Form modal -->
    <div class="modal fade" id="InsertFormModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah data stok obat Apotek XYZ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post">
                    <div class="modal-body">
                    <div class="mb-3">
                            <label for="nama-obat" class="form-label">Nama Obat </label>
                            <input type="text" name="nama" class="form-control" maxlength="255" id="nama-obat" required>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah_stok" class="form-label">Jumlah Stok</label>
                            <input type="number" name="jumlah_stok" min="0" max="2147483647" class="fieldInsertInput form-control" id="jumlah_stok" required>
                        </div>
                        <div class="mb-3">
                            <label for="harga_beli" class="form-label">Harga Beli</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input id="harga_beli" required type="number" min="0" max="2147483647" name="harga_beli" class="fieldInsertInput form-control rupiah" aria-label="Amount (to the nearest dollar)">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="laba" class="form-label">Laba (%)</label>
                            <input type="number" name="laba" min="0" max="2147483647" class="fieldInsertInput form-control" id="laba" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" id="tanggal" required>
                        </div>
                        <div class="mb-3">
                            <label for="harga_jual" class="form-label">Harga Jual</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input id="harga_jual" type="number" min="0" name="harga_jual" class=" form-control rupiah" aria-label="Amount (to the nearest dollar)" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" name="submit" value="Submit" />

                    </div>
                </form>

            </div>
        </div>
    </div>


    <!-- Update Form modal -->
    <div class="modal fade" id="UpdateFormModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit data stok obat Apotek XYZ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post">
                    <input type="hidden" name="id" id="updt_id" value="" />

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="Text1" class="form-label">Nama Obat </label>
                            <input type="text" name="updt_nama" maxlength="255" class="form-control" id="updt_nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="updt_jumlah_stok" class="form-label">Jumlah Stok</label>
                            <input type="number" name="updt_jumlah_stok" min="0" max="2147483647" class="fieldUpdateInput form-control" id="updt_jumlah_stok" required>
                        </div>
                        <div class="mb-3">
                            <label for="updt-harga_beli" class="form-label">Harga Beli</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input required id="updt_harga_beli" type="number" min="0" max="2147483647" name="updt_harga_beli" class="fieldUpdateInput form-control rupiah" aria-label="Amount (to the nearest dollar)">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="updt_laba" class="form-label">Laba (%)</label>
                            <input type="number" name="updt_laba" min="0" max="2147483647" class="fieldUpdateInput form-control" id="updt_laba" required>
                        </div>
                        <div class="mb-3">
                            <label for="updt_tanggal" class="form-label">Tanggal</label>
                            <input type="date" name="updt_tanggal" class="form-control" id="updt_tanggal" required>
                        </div>
                        <div class="mb-3">
                            <label for="updt_harga_jual" class="form-label">Harga Jual</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input readonly id="updt_harga_jual" type="number" min="0" name="updt_harga_jual" class="form-control rupiah" aria-label="Amount (to the nearest dollar)">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" name="update" value="Update" />

                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        function ajax_get(url, callback) {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    console.log('responseText:' + xmlhttp.responseText);
                    try {
                        var data = JSON.parse(xmlhttp.responseText);
                    } catch (err) {
                        console.log(err.message + " in " + xmlhttp.responseText);
                        return;
                    }
                    callback(data);
                }
            };

            xmlhttp.open("GET", url, true);
            xmlhttp.send();
        }

        function fillUpdateForm(id) {
            ajax_get("./ajax.php?id=" + id, function(data) {
                document.getElementById("updt_id").value = data["id"];
                document.getElementById("updt_nama").value = data["nama_obat"];
                document.getElementById("updt_jumlah_stok").value = data["jumlah_stok"];
                document.getElementById("updt_harga_beli").value = data["harga_beli"];
                document.getElementById("updt_laba").value = data["laba"];
                document.getElementById("updt_tanggal").value = data["tanggal"];
                document.getElementById("updt_harga_jual").value = data["harga_jual"];
            });
        }

        const fixedInput = document.querySelector('#harga_jual');
        let input1 = parseInt(document.querySelector('#harga_beli').value);
        let input2 = parseInt(document.querySelector('#laba').value);
        fixedInput.value = 0;
        document.addEventListener("DOMContentLoaded", event => {

            document.querySelectorAll('.fieldInsertInput').forEach(item => {
                item.addEventListener('change', (event) => {
                    input1 = parseInt(document.querySelector('#harga_beli').value);
                    input2 = parseInt(document.querySelector('#laba').value);

                    fixedInput.value = input1 * input2 / 100 + input1;
                    console.log(fixedInput.value);

                })
            })
        })
        

        const fixedInputUpdt = document.querySelector('#updt_harga_jual');
        let input3 = parseInt(document.querySelector('#updt_harga_beli').value);
        let input4 = parseInt(document.querySelector('#updt_laba').value);
        fixedInputUpdt.value = 0;
        document.addEventListener("DOMContentLoaded", event => {

            document.querySelectorAll('.fieldUpdateInput').forEach(item => {
                item.addEventListener('change', (event) => {
                    input3 = parseInt(document.querySelector('#updt_harga_beli').value);
                    input4 = parseInt(document.querySelector('#updt_laba').value);

                    fixedInputUpdt.value = input3 * input4 / 100 + input3;
                    console.log(fixedInputUpdt.value);

                })
            })
        })
    </script>
</body>

</html>