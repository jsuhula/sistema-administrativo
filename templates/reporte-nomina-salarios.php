<?php
date_default_timezone_set('America/Guatemala');

session_start();

if (!$_SESSION) {
	header('location: ../login.php');
}

$fechaHoraActual = date("d-m-Y H:i:s");
$fechaOperacion = isset($_GET['fechaOperacion']) ? $_GET['fechaOperacion'] : "";
$fechaOperacionReporte = date("d-m-Y", strtotime($fechaOperacion));

?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<title>PrintReport</title>
	<script src="../js/html2pdf.bundle.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>

<body onLoad="setTimeout('window.close()', 1000);" style="font-size: 12px;">
	<style>
		* {
			font-family: 'Times New Roman', Times, serif;
		}

		.text-center span {
			line-height: 1;
		}
	</style>
	<div id="page_pdf">
		<div class="container">
			<h1>Restaurante De Aqui Soy!</h1>
			<span>Dirección: Dirección de la Empresa</span><br>
			<span>Teléfono: 123-456-7890</span><br>
			<span>Correo Electrónico: info@empresa.com</span>
			<section id="salarios">
				<div class="text-center">
					<h4>Reporte de Nómina</h4>
				</div>
				<div class="text-end">
					<span>Fecha de Generacion de Reporte:
						<?php echo $fechaHoraActual; ?>
					</span>
					<br/>
					<span>Fecha de Reporte Nomina:
						<?php echo $fechaOperacionReporte; ?>
					</span>
				</div>
				<hr>
				<div>
					<table id="tablaNominaSalario" class="table table-striped text-end">
						<thead class="sticky-top text-white">
							<tr>
								<th>Código</th>
								<th>Empleado</th>
								<th>Salario Base</th>
								<th>Cant. Horas Trabajadas</th>
								<th>Cant. Horas Extras</th>
								<th>Precio Hora</th>
								<th>Comisión</th>
								<th>Q. Horas Extras</th>
								<th>Bono Incentivo</th>
								<th>Descuento Inasistencia</th>
								<th>IGSS</th>
								<th>IRTRA</th>
								<th>Cuota Prestamo</th>
								<th>Total</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</section>
			<div hidden>
				<input type="date" id="fechaNominaSalario" value="<?php echo $fechaOperacion; ?>">
			</div>
			<div hidden>
				<input type="datetimelocal" id="fechaReporte" value="<?php echo $fechaHoraActual; ?>">
			</div>
		</div>
	</div>
</body>

</html>
<script src="../js/funciones-reporte-nomina.js"></script>