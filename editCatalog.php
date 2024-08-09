<?php require "connect.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Catalog</title>
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/catalog.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
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

    <section class="bg-editcatalog">
    <div class="form-editcatalog-product">
    <?php
    if($_GET['id'] == null){
        header("location:index.php");
    } elseif (isset($_GET['id'])) {
        $id = $_GET['id'];
        $script = "SELECT * FROM furniture WHERE id = $id";
        $query = mysqli_query($conn, $script);
        $data = mysqli_fetch_array($query);
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
                    $newImageName = $nama. time().'.' .$imageDataType;
                    move_uploaded_file ($tmpName, 'img/'. $newImageName);

                    $query_update = "UPDATE furniture SET nama='$nama', harga=$harga, kategori='$kategori', stok=$stok, foto='$newImageName' WHERE id=$id";
                    mysqli_query($conn, $query_update);

                    echo "<script> alert('Data Berhasil diubah'); </script>";
                    echo"<meta http-equiv='refresh' content='0; URL=index.php'>";
                }
            }
        }
    }
            ?>
        <form method="post" enctype="multipart/form-data">
            <h2>Edit Catalog</h2>
            <div class="form-catalog">
                <label for="">Product name</label>
                <input type="text" name="nama" value="<?= $data['nama']; ?>"/>
            </div>
            <div class="form-catalog">
                <label for="">Product price</label>
                <input type="number" name="harga" value="<?= $data['harga']; ?>"/>
            </div>
            <div class="form-catalog">
                <label for="">Product stock</label>
                <input type="number" name="stok" value="<?= $data['stok']; ?>"/>
            </div>
            <div class="form-catalog">
                    <label for="">Product Category</label>
                    <input type="text" name="kategori" value="<?= $data['kategori']; ?>">
                </div>
            <div class="form-catalog">
                <label for="">Product picture</label>
                <input type="file" name="foto" accept=".jpg, .jpeg, .png" value="<?= $data['foto']; ?>"/>
            </div>
            <input type="submit" name="save" value="Save Data">
        </form>
    </div>
    </section>
</body>
</html>