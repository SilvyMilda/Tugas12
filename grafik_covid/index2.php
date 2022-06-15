<?php
include('koneksi.php');
$country=mysqli_query($koneksi, "SELECT * from tb_negara");
while($row= mysqli_fetch_array($country)){
	$nama_country[]=$row['country'];

	$query=mysqli_query($koneksi, "SELECT sum(cases) as cases from tb_negara where id_country='".$row['id_country']."'");
	$row= $query->fetch_array();
	$total_kasus[]= $row['cases'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>	COVID 19 PIE</title>
	<script type="text/javascript" src="Chart.js"></script>
	<!--<link href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js">-->
</head>
<body>
	<div id="canvas-holder" style="width:50%">
		<canvas id="chart-area"></canvas>
	</div>
	<script>
		var config = {
			type: 'pie',
			data: {
				datasets: [{
					data:<?php echo json_encode($total_kasus);?>,

					backgroundColor: [
						'rgba (255, 99, 132, 0.2)',
						'rgba (54, 162, 235, 0.2)',
						'rgba (255, 206, 86, 0.2)',
						'rgba (75, 192, 192, 0.2)'
					];
					borderColor: [
						'rgba (255, 99, 132, 1)',
						'rgba (54, 162, 235, 1)',
						'rgba (255, 206, 86, 1)',
						'rgba (75, 192, 192, 1)'
					],
					label: 'Presentase Total Kasus'
				}],
				labels: <?php echo json_encode($nama_country); ?>},
				options: {
					responsive: true
			}
		};

		window.onload = finction (){
			var ctx = document.getElementById('chart-area').getContext('2d');
			window.myPie = new Chart (ctx, config);
		};

		document.getElementById('randomizeData').addEventListener('click', function () {
			config.data.datasets.forEach(function(dataset) {
				dataset.data =dataset.data.map (function {
					return randomScalingFactor;
				});
			});
				window.myPie.update();
		});

		varcolorNames = Object.keys(window.chartColors);
		document.getElementById('addDataset').addEventListener('click' function () {
			var newDataset = {
				backgroundColor: [],
				data: [],
				label: 'New dataset' + config.data.datasets.length,
			};
			for (var index = 0; index <config.data.labels.length; ++index) {
				newDataset.data.push(randomScalingFactor());
				varcolorName = varcolorNames[index% colorNames.length];
				varnewColor = window.chartColors[colorName];
				newDataset.backgroundColor.push(newColor);
			}
			config.data.datasets.push(newDataset);
			window.myPie.update();
		});

		document.getElementById('removeDataset').addEventListener('click', function() {
			config.data.datasets.splice(0,1);
			window.myPie.update();
		});
	</script>
</body>
</html>