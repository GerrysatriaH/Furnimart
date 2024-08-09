<?php 
    require "connect.php"; 
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Furnimart E-Commerce</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-content">
            <div class="logo">
                <a href="index.php">Furni<span>mart</span></a>
            </div>
            <ul class="navbar-list">
                <div class="icon close-bar">
                    <i class="fa-solid fa-arrow-left"></i>
                </div>
                <li><a href="index.php">Home</a></li>
                <?php
                    if(isset($_SESSION['username'])){
                ?>      
                    <li><a href="chart.php">Product Chart</a></li>
                    <li><a href="addCatalog.php">Edit Catalog</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php
                    } else {
                ?>
                    <li class="login"><a href="login.php">Login As Admin</a></li>
                <?php } ?>
            </ul>
            <div class="icon menu-bar">
                <i class="fa-solid fa-bars"></i>
            </div>
        </div>
    </nav>
    <header>
        <div class="banner">
            <?php
                if(!isset($_SESSION['username'])){
            ?>
                <h1>Selamat Datang di Website Kami.</h1>
            <?php
                } else {
                    $query = "SELECT username FROM users";
                    $result = mysqli_query($conn, $query);
                    $data = mysqli_fetch_array($result);
            ?>
                <h1>Selamat Datang, <?= $data['username'];?></h1>
            <?php
                }
            ?>
            <button>
                <a href="#search"><b>Shop Now</b></a> 
            </button>
        </div>
    </header>
    <section id="search">
        <div class="search-product">
            <h3>Search Product</h3>
            <div class="search">
                <form method="get" action="#search">
                    <input type="text" name="search" placeholder="Search here">
                    <input type="submit" value="search">
                </form> 
            </div>
            <div class="category">
                <ul>
                    <form method="get" action="#search">
                        <li>
                            <input type="submit" name="kursi" value="kursi"/>
                        </li>
                        <li>
                            <input type="submit" name="lemari" value="lemari"/>
                        </li>
                        <li>
                            <input type="submit" name="meja" value="meja"/>
                        </li>
                    </form>    
                </ul>
            </div>
        </div>  
    </section>
    <section class="product-catalog" id="catalog">
        <h2>Katalog Produk</h2>
        <div class="container">
        <?php
            $batas = 4;
            $halaman = @$_GET['halaman'];
            if(empty($halaman)){
                $posisi = 0;
                $halaman = 1;
            }
            else{
                $posisi = ($halaman-1) * $batas;
            }
            if(isset($_GET['search'])){
                $search = $_GET['search'];
                $sql = "SELECT * FROM furniture WHERE nama LIKE '%$search%' ORDER BY id Desc LIMIT $posisi,$batas";
            } elseif(isset($_GET['kursi'])){
                $sql = "SELECT * FROM furniture WHERE kategori LIKE 'kursi' ORDER BY id Desc LIMIT $posisi,$batas";
            } elseif(isset($_GET['lemari'])){
                $sql = "SELECT * FROM furniture WHERE kategori LIKE 'lemari' ORDER BY id Desc LIMIT $posisi,$batas";
            } elseif(isset($_GET['meja'])){
                $sql = "SELECT * FROM furniture WHERE kategori LIKE 'meja' ORDER BY id Desc LIMIT $posisi,$batas";
            } else {
                $sql = "SELECT * FROM furniture ORDER BY id Desc LIMIT $posisi,$batas";
            }
            $result = mysqli_query($conn, $sql);
            while ($data = mysqli_fetch_array($result)){
        ?>
            <div class="card">
                <img src="img/<?= $data['foto'];?>" alt="Error Img" width= 175px height= 175px>
                  <div class="card-body">
                        <h3><?= $data['nama'];?></h3>
                        <p align="right">Rp.<?= number_format($data['harga']);?></p>
                        <button class="buy">Buy</button>
                  </div>
            </div>
        <?php
            }
        ?>
    </div>
    <?php
        if(isset($_GET['search'])){
            $search = $_GET['search'];
            $sql2 = "SELECT * FROM furniture WHERE nama LIKE '%$search%' ORDER BY id Desc";
        } elseif(isset($_GET['kursi'])){
            $sql2 = "SELECT * FROM furniture WHERE kategori LIKE 'kursi' ORDER BY id Desc";
        } elseif(isset($_GET['lemari'])){
            $sql2 = "SELECT * FROM furniture WHERE kategori LIKE 'lemari' ORDER BY id Desc";
        } elseif(isset($_GET['meja'])){
            $sql2 = "SELECT * FROM furniture WHERE kategori LIKE 'meja' ORDER BY id Desc";
        } else {
            $sql2 = "SELECT * FROM furniture ORDER BY id Desc";
        }
            $result2=mysqli_query($conn,$sql2);
            $jmldata=mysqli_num_rows($result2);
            $jmlhalaman=ceil($jmldata/$batas);
        ?>
        <br>
        <ul class="pagination">
            <?php
                for($i=1;$i<=$jmlhalaman;$i++){
                    if($i!=$halaman){
                        if(isset($_GET['search'])){
                            $search = $_GET['search'];
                            echo "<li class='page-item'><a href='index.php?halaman=$i&$search'>$i</a></li>";
                        } elseif(isset($_GET['kursi'])){
                            $kursi = 'kursi';
                            echo "<li class='page-item'><a href='index.php?halaman=$i&$kursi'>$i</a></li>";
                        } elseif(isset($_GET['lemari'])){
                            $lemari = 'lemari';
                            echo "<li class='page-item'><a href='index.php?halaman=$i&$lemari'>$i</a></li>";
                        } elseif(isset($_GET['meja'])){
                            $meja = 'meja';
                            echo "<li class='page-item'><a href='index.php?halaman=$i&$meja'>$i</a></li>";
                        } else {
                            echo "<li class='page-item'><a href='index.php?halaman=$i'>$i</a></li>";
                        }
                    } else {
                        echo "<li class='page-item active'><a href='#'>$i</a></li>";
                    }
                }
            ?>
        </ul>
    </section>
    <section class="checkout">
        <div>
            <h2>Checkout Barang</h2>
            <p><b>Jumlah Barang yang dibeli : <b><span id="hitung">0</span></p>
            <button onclick="checkout()">Checkout</button>
        </div>
    </section>
    <footer>
        <div class="container-1">
            <div class="column column-1">
                <h3>Customer Support</h3>
                <ul>
                    <li><i class="fa-solid fa-phone-flip"></i> 081219201210</li>
                    <li><i class="fa-solid fa-envelope-open-text"></i> FurnimartInd@gmail.com</li>
                </ul>
            </div>
            <div class="column column-2">
                <h3>Follow Us</h3>
                <ul>
                    <li><i class="fa-brands fa-facebook"></i> Furnimart Indonesia</li>
                    <li><i class="fa-brands fa-instagram"></i> @furnimart_indonesia</li>
                    <li><i class="fa-brands fa-twitter"></i> @furnimart</li>
                </ul>
            </div>
        </div>
        <h4>Copyright &copy; 2022 - Created By Gerry Satria Halim</h4>
    </footer> 
</body>
<script src="js/script.js"></script>
</html>