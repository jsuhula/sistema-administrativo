<?php
	
use dao\EmpleadoDAO;

date_default_timezone_set('America/Guatemala');
$fechaHoraActual = date("Y-m-d H:i:s");
$codigoEmpleado = isset($_GET['CodigoEmpleado']) ? $_GET['CodigoEmpleado'] : "";

$empleado = empleadoDao();
$registro = $empleado->obtenerEmpleado($codigoEmpleado)->fetch(PDO::FETCH_OBJ);
function empleadoDao(): EmpleadoDAO
{
	require_once("../config/Autoload.php");
	require_once("../dao/EmpleadoDAO.php");
	require_once('../includes/MySQLConnector.php');
	
	return  new EmpleadoDAO();
}
	
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

<body onLoad="setTimeout('window.close()', 2000);" style="font-size: 12px;">
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
			<hr>
			<h5 class="text-center"><?php echo $registro->CodigoEmpleado; ?></h5>

			<table class="table table-striped">
				<tbody class="bg-black">
					<tr>
						<td colspan="4" class="bg-success bg-opacity-50 text-white fs-5"><span>Información
								Personal</span></td>
					</tr>
					<tr>
						<td><strong>Código de Empleado:</strong></td>
						<td><?php echo $registro->CodigoEmpleado; ?></td>
						<td><strong>Nombres:</strong></td>
						<td><?php echo $registro->Nombres; ?></td>
					</tr>
					<tr>
						<td><strong>Apellidos:</strong></td>
						<td><?php echo $registro->Apellidos; ?></td>
						<td><strong>DPI:</strong></td>
						<td><?php echo $registro->DPI; ?></td>
					</tr>
					<tr>
						<td><strong>NIT:</strong></td>
						<td><?php echo $registro->NIT; ?></td>
						<td><strong>Fecha de Nacimiento:</strong></td>
						<td><?php echo $registro->FechaNacimiento; ?></td>
					</tr>
				</tbody>
			</table>

			<table class="table table-striped">
				<tbody class="bg-black">
					<tr>
						<td colspan="4" class="bg-success bg-opacity-50 text-white fs-5"><span>Contactos</span></td>
					</tr>
					<tr>
						<td><strong>Correo Electrónico:</strong></td>
						<td><?php echo $registro->Email; ?></td>
						<td><strong>Número de Teléfono:</strong></td>
						<td><?php echo $registro->Telefono; ?></td>
					</tr>
				</tbody>
			</table>

			<table class="table table-striped">
				<tbody class="bg-black">
					<tr>
						<td colspan="4" class="bg-success bg-opacity-50 text-white fs-5"><span>Credenciales</span></td>
					</tr>
					<tr>
						<td><strong>Profesión/Puesto:</strong></td>
						<td><?php echo $registro->Profesion; ?></td>
						<td><strong>Departamento:</strong></td>
						<td><?php echo $registro->Departamento; ?></td>
					</tr>
					<tr>
						<td><strong>Fecha de Ingreso:</strong></td>
						<td><?php echo $registro->FechaIngreso; ?></td>
						<td><strong>Fecha de Retiro:</strong></td>
						<td><?php echo $registro->FechaRetiro; ?></td>
					</tr>
				</tbody>
			</table>

			<table class="table table-striped">
				<tbody class="bg-black">
					<tr>
						<td colspan="4" class="bg-success bg-opacity-50 text-white fs-5"><span>Salario y
								Beneficios</span></td>
					</tr>
					<tr>
						<td><strong>Salario:</strong></td>
						<td>Q. <?php echo $registro->SalarioBase; ?></td>
						<td><strong>Carnet de IRTRA:</strong></td>
						<td><?php echo $registro->IRTRA; ?></td>
					</tr>
					<tr>
						<td><strong>Carnet de IGSS:</strong></td>
						<td><?php echo $registro->IGSS; ?></td>
						<td><strong>Estado:</strong></td>
						<td><?php echo $registro->Estado; ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

</body>

</html>
<script>
	html2pdf().set({
		margin: 0.5,
		filename: "<?php echo $registro->NombreCompleto; ?>"+"-"+"<?php echo $fechaHoraActual; ?>",
		image: {
			type: 'jpeg',
			quality: 0.999
		},
		html2camvas: {
			scale: 1,
			letterRendering: false,
		},
		jsPDF: {
			unit: "in",
			format: "letter",
			orientation: 'portrait'
		}
	}).from(document.body).save().catch(err => console.log(err));
</script>
