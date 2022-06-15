<?php
include('koneksi.php');
$country=mysqli_query($koneksi, "SELECT * from tb_negara");
while($row= mysqli_fetch_array($country)){
	$nama_country[]=$row['country'];

	$query=mysqli_query($koneksi, "SELECT sum(new_deaths) as new_deaths from tb_negara where id_country='".$row['id_country']."'");
	$row= $query->fetch_array();
	$new_deaths[]= $row['new_deaths'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>(PIE)LAPORAN COVID-19</title>
	<script type="text/javascript" src="Chart.js"></script>
</head>
<body>
	<div id="canvas-holder" style="width:50%">
		<canvas id="chart-area"></canvas>
	</div>
	<script type="">
		var config={
			type:'pie',
			data:{
				datasets:[{
					data:<?php echo json_encode($new_deaths);?>,
					backgroundColor: [
					'rgba(255, 99, 132, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(255, 206, 86, 0.2)',
					'rgba(255, 226, 135, 0.2)',
					'rgba(0, 59, 176, 0.2)',
					'rgba(0, 0, 0, 0.2)',
					'rgba(255, 0, 0, 0.2)',
					'rgba(75, 192, 192, 0.2)'
					],
					borderColor:[
					'rgba(255, 99, 132, 0.2)',
					'rgba(255, 99, 132, 0.2)',
					'rgba(255, 99, 132, 0.2)',
					'rgba(255, 99, 132, 0.2)',
					'rgba(255, 99, 132, 0.2)',
					'rgba(255, 99, 132, 0.2)',
					'rgba(255, 99, 132, 0.2)'
					],
					label:'Presentase Penjualan Barang'
				}],
				labels:<?php echo json_encode($nama_country);?>
			},
			options:{
				responsive:true
			}
		};

		window.onload=function(){
			var ctx=document.getElementById('chart-area').getContext('2d');
			window.myPie=new Chart(ctx, config);
		};

		document.getElementById('randomizeData').addEventListener('click', function(){
			config.data.datasets.forEach(function(dataset){
				dataset.data=dataset.data.map(function(){
					return randomScalingFactor();
				});
			});

			window.myPie.update();
		});

		var colorNames=Object.keys(window.chartColors);
		document.getElementById('addDataset').addEventListener('click', function(){
			var newDataset={
				backgroundColor:[],
				data:[],
				label:'New dataset'+
				config.data.datasets.length,
			};
			for(var index=0; index<config.data.labels.length;
				++index){
				newDataset.data.push(randomScalingFactor());
			var colorName = colorNames[index%colorNames.length];
			var newColor=window.chartColors[colorName];
			newDataset.backgroundColor.push(newColor);
			}
			config.data.datasets.push(newDataset);
			window.myPie.update();
		});

		document.getElementById('removeDataset').addEventListener('click',function(){
			config.data.datasets.splice(0,1);
			window.myPie.update();
		});

	</script>
</body>
</html>