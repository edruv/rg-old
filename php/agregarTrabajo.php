<?php
	require_once 'config.php';
	require_once 'methods.php';

	if (isset($_GET['clientes'])) {
		$cnf = db();
		$conn = dbconnection($cnf);

		$query = $conn->prepare('SELECT c.id, u.nombre,u.apellidop, u.apellidom, c.telefono from cliente c inner join usuario u on u.id=c.idusuario');
		$query->execute();
		$info = $query->fetchAll(PDO::FETCH_ASSOC);

		echo json_encode($info);
	}

	if (isset($_GET['cliente'])) {
		$id = $_GET['cliente'];
		$cnf = db();
		$conn = dbconnection($cnf);

		$query = $conn->prepare('SELECT c.id, u.nombre,u.apellidop, u.apellidom, c.calle, c.numeroext, c.numeroint, c.colonia, c.municipio, c.telefono from cliente c
			inner join usuario u on u.id=c.idusuario
			where c.id=:id');
		$query->execute(array(':id'=>$id));
		$info = $query->fetchAll(PDO::FETCH_ASSOC);

		echo json_encode($info);
	}

	if (isset($_GET['tipotrabajo'])) {
		$cnf = db();
		$conn = dbconnection($cnf);

		$query = $conn->prepare('SELECT * from tipotrabajo');
		$query->execute();
		$info = $query->fetchAll(PDO::FETCH_ASSOC);

		echo json_encode($info);
	}
	if (isset($_GET['electrodomestico'])) {
		$cnf = db();
		$conn = dbconnection($cnf);

		$query = $conn->prepare('SELECT * from tipoelect');
		$query->execute();
		$info = $query->fetchAll(PDO::FETCH_ASSOC);

		echo json_encode($info);
	}
?>
