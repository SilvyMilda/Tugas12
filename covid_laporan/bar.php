<?php 
include('koneksi.php');
$country=mysqli_query($koneksi, "SELECT * from tb_negara");
while($row= mysqli_fetch_array($country)){
	$nama_country[]=$row['country'];

	$query=mysqli_query($koneksi, "SELECT sum(cases) as cases from tb_negara where id_country='".$row['id_country']."'");
	$row= $query->fetch_array();
	$total_kasus[]= $row['cases'];
}
while($row= mysqli_fetch_array($country)){
	$nama_country[]=$row['country'];

	$query=mysqli_query($koneksi, "SELECT sum(new_cases) as new_cases from tb_negara where id_country='".$row['id_country']."'");
	$row= $query->fetch_array();
	$new_kasus[]= $row['new_cases'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>	(BAR)LAPORAN COVID-19</title>
	<script type="text/javascript" src="Chart.js"></script>
	<!--<link href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js">-->
</head>
<body>
	<div style="width: 800px; height: 800px">
		<canvas id="myChart"></canvas>
	</div>
	<script type="text/javascript">
		var ctx = document.getElementById("myChart").getContext('2d');
		var myChart= new Chart(ctx,{
			type: 'bar',
			data: {
				labels: <?php echo json_encode($nama_country); ?>,
				datasets: [{
					label: 'Total Kasus',
					data: <?php echo json_encode($total_kasus); ?>,

					backgroundColor: 'rgba(255, 99, 132, 0.2)',
					borderColor: 'rgba(255, 99, 132, 1)',
					borderWidth: 1
					
				}]

				datasets: [{
					label: 'New Kasus',
					data: <?php echo json_encode($new_kasus); ?>,

					backgroundColor: 'rgba(176, 53, 0, 0.2)',
					borderColor: 'rgba(255, 99, 132, 1)',
					borderWidth: 1
					
				}]
			},
			options: {
				scales:{
					yAxes:[{
						ticks: {
							beginAtZero: true
						}
					}]
				}
			}
		});
	</script>
</body>
</html>