<?php
    require('connect.php');
    session_start();

	// Stock Chart
    $produk = mysqli_query($conn,"SELECT * FROM furniture");
    while($row = mysqli_fetch_array($produk)){
	    $nama_produk[] = $row['nama'];
		$jumlah_produk[] = $row['stok'];
    }

	// Category Chart
	$label = ["Meja", "Kursi", "Lemari"];
	for ($i = 0; $i < 3; $i++){
		$query = mysqli_query($conn,"SELECT COUNT(kategori) As jumlah FROM furniture WHERE kategori='".$label[$i]."'");
		$row = $query->fetch_array();
		$jumlah_barang_per_jenis[] = $row['jumlah'];
	}

	// Category Chart
	for ($i = 0; $i < 3; $i++){
		$query = mysqli_query($conn,"SELECT SUM(stok) As jumlah FROM furniture WHERE kategori='".$label[$i]."'");
		$row = $query->fetch_array();
		$jumlah_stok_barang_per_kategori[] = $row['jumlah'];
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Produk Chart</title>
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/graf.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
	<script type="text/javascript" src="js/Chart.js"></script>
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
	<div class="graf" style="width: 800px;height: 700px">
		<div class="desc-graf">
			<h2>Grafik Stock Barang</h2>
			<p> Grafik ini menampilkan banyaknya stok dari setiap satuan barang.</p>
		</div>
		<canvas id="chart-stok"></canvas>
	</div>
	<div class="graf" style="width: 800px;height: 600px">
		<div class="desc-graf">
			<h2>Grafik Jumlah Jenis Barang Berdasarkan Kategori</h2>
			<p> Grafik ini menampilkan banyaknya jenis barang yang memiliki kategori meja, kursi, dan lemari.</p>
		</div>
		<canvas id="chart-kategori"></canvas>
	</div>
	<div class="graf" style="width: 800px;height: 600px">
		<div class="desc-graf">
			<h2>Grafik Jumlah Stok Barang Berdasarkan Kategori</h2>
			<p> Grafik ini menampilkan banyaknya stok barang berdasarkan kategorinya seperti 
				barang meja, barang kursi, dan barang lemari.</p>
		</div>
		<canvas id="chart-stock-kategori"></canvas>
	</div>
	<script>
		// Chart Stock
		var ctx = document.getElementById("chart-stok").getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'line',
			data: {
				labels: <?php echo json_encode($nama_produk); ?>,
				datasets: [{
					label: 'Grafik Stok Furniture',
					data: <?php echo json_encode($jumlah_produk); ?>,
					backgroundColor: 'rgba(23, 147, 255, 0.2)',
					borderColor: 'rgba(23, 147, 255, 1)',
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				}
			}
		});

		// Chart Kategori
		var ctx1 = document.getElementById("chart-kategori").getContext('2d');
		var myChart = new Chart(ctx1, {
			type: 'doughnut',
			data: {
				labels: <?php echo json_encode($label); ?>,
				datasets: [{
					label: 'Grafik Banyak Stock Barang Berdasarkan Kategori',
					data: <?php echo json_encode($jumlah_barang_per_jenis); ?>,
					backgroundColor: [
					'rgb(255, 99, 132)',
					'rgb(54, 162, 235)',
					'rgb(255, 205, 86)'
					],
					hoverOffset: 4
				}]
			}
		});

		// Chart Stok Kategori
		var ctx2 = document.getElementById("chart-stock-kategori").getContext('2d');
		var myChart = new Chart(ctx2, {
			type: 'bar',
			data: {
				labels: <?php echo json_encode($label); ?>,
				datasets: [{
					label: 'Grafik Banyak Stok Barang Berdasarkan Kategori',
					data: <?php echo json_encode($jumlah_stok_barang_per_kategori); ?>,
					backgroundColor: 'rgba(0, 88, 122, 0.2)',
					borderColor: 'rgba(0, 88, 122,1)',
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				}
			}
		});
	</script>
</body>
<script src="js/script.js"></script>
</html>