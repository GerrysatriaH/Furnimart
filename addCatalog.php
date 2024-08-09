<?php require "connect.php"; ?>
<?php
    if(isset($_POST['save'])){
        $nama = $_POST['nama'];
        $harga = $_POST['harga'];
        $kategori = $_POST['kategori'];
        $stok = $_POST['stok'];
        if ($_FILES['foto']['error'] === 4){
            echo "<script> alert('gambar tidak ada'); </script>";
        } else {
            $fileName = $_FILES['foto']['name'];
            $fileSize = $_FILES['foto']['size'];
            $tmpName = $_FILES['foto']['tmp_name'];
            $validImageExtention = ['jpg', 'jpeg', 'png'];
            $imageExtention = explode('.', $fileName);
            $imageDataType = $imageExtention[1];

            if (!in_array ($imageDataType, $validImageExtention)){
                echo "<script> alert ('extensi gambar salah'); </script>";
            } else if ($fileSize > 1000000000000000){
                echo "<script> alert ('file gambar terlalu besar'); </script>";
            } else {
                $newImageName = $nama. time().'.'.$imageDataType;
                move_uploaded_file ($tmpName, 'img/'. $newImageName);
                $script = "INSERT INTO furniture SET nama='$nama', harga=$harga, kategori='$kategori', stok=$stok, foto='$newImageName'";
            }
        }
        $query = mysqli_query($conn, $script);
        if($query){
            echo "<script> alert('Data Berhasil ditambah'); </script>";
            echo"<meta http-equiv='refresh' content='0; URL=index.php'>";
        } else {
            echo "<script> alert('Data gagal ditambah'); </script>";
            echo"<meta http-equiv='refresh' content='0; URL=addCatalog.php'>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Furnimart E-Commerce</title>
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/catalog.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-content">
            <div class="logo">
                <a href="index.php"> Furni<span>mart</span></a>
            </div>
            <ul class="navbar-list">
                <div class="icon close-bar">
                    <i class="fa-solid fa-arrow-left"></i>
                </div>
                <li><a href="index.php">Home</a></li>
                <li><a href="chart.php">Product Chart</a></li>
                <li><a href="addCatalog.php">Edit Catalog</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
            <div class="icon menu-bar">
                <i class="fa-solid fa-bars"></i>
            </div>
        </div>
    </nav>
    <section class="bg-catalog">
        <div class="form-addcatalog-product">
            <div class="close">&times;</div>
            <form method="post" enctype="multipart/form-data">
                <h2>Add Catalog</h2>
                <div class="form-catalog">
                    <label>Product name</label>
                    <input type="text" name="nama">
                </div>
                <div class="form-catalog">
                    <label>Product price</label>
                    <input type="number" name="harga">
                </div>
                <div class="form-catalog">
                    <label>Product stock</label>
                    <input type="number" name="stok">
                </div>
                <div class="form-catalog">
                    <label>Product Category</label>
                    <input type="text" name="kategori">
                </div>
                <div class="form-catalog">
                    <label>Product picture</label>
                    <input type="file" name="foto" accept=".jpg, .jpeg, .png">
                </div>
                <input type="submit" name="save" value="Save Data">
            </form>
        </div>
    </section>
    <section class="Table-product">
        <button class="add-btn"> + ADD PRODUCT </button>
        <div class="container">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nama Produk</th>
                        <th scope="col">Jumlah Produk</th>
                        <th scope="col">Kategori Product</th>
                        <th scope="col">Harga Produk</th>
                        <th scope="col">Pengaturan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $no = 1;
                        $sql = "SELECT * FROM furniture ORDER BY id";
                        $result = mysqli_query($conn, $sql);
                        while($data = mysqli_fetch_array($result)){ 
                    ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?= $data['nama'];?></td>
                            <td><?= $data['stok'];?></td>
                            <td><?= $data['kategori'];?></td>
                            <td>Rp.<?= number_format($data['harga']);?></td>
                            <td>
                                <a href="editCatalog.php?id='<?=$data['id'];?>'">Edit</a>
                                <a href="deleteCatalog.php?id='<?=$data['id'];?>'" onclick = "return confirm('Apakah data ini ingin dihapus ?')">Delete</a>
                            </td>
                         </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </section>
    <footer class="footer">
        <h4>Copyright &copy; 2022 - Created By Gerry Satria Halim</h4>
    </footer>
</body>
    <script src="js/addCatalog.js"></script>
    <script src="js/script.js"></script>
</html>