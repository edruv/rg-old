<?php
	require_once 'config.php';
	require_once 'methods.php';
	if(isset($_POST['btnRegister'])){
		$nombre = $_POST['campoNombre'];
		$apellidom = (empty($_POST['campoApellidoMaterno'])) ? "" : $_POST['campoApellidoMaterno'];
		$apellidop = $_POST['campoApellidoPaterno'];
		$calle = $_POST['campoCalle'];
		$municipio = $_POST['Municipio'];
		$ext = $_POST['campoExt'];
		$interior = (empty($_POST['campoInt'])) ? "" : $_POST['campoInt'];
		$telefono = $_POST['campoTelefono'];
		$colonia = $_POST['campoColonia'];
		$llave = $nombre.".".$apellidop.".".$apellidom;
		$status = array();

		if (!empty($nombre) && !empty($apellidop) &&	!empty($calle) && !empty($municipio) &&	!empty($ext) &&	!empty($telefono) && !empty($colonia)){
			$cnf = db();
			$conn = dbconnection($cnf);
			if($conn){
				$stmt = $conn->prepare('SELECT * from usuario WHERE llave=:llave');
				$stmt->execute(array(':llave' => $llave));
				$checkuser = $stmt->fetch(PDO::FETCH_ASSOC);

				if (false) {
				// if (empty($checkuser)) {
					$stmt = $conn->prepare('INSERT into usuario(nombre,apellidom,apellidop,llave) values(:name,:apm,:app,:ll)');
					$info = $stmt->execute(array(':name'=> $nombre, ':apm' => $apellidom,':app' => $apellidop, ':ll' => $llave));
					if($info){
						# if($stmt->fetch(PDO::FETCH_ASSOC)){
						$stmt = $conn->prepare('SELECT * FROM usuario WHERE llave = :llave');
						$stmt->execute(array(':llave'=>"$llave"));
						$info = $stmt->fetch(PDO::FETCH_ASSOC);
						if(!empty($info)){
							$idUsuario = $info['id'];
							$stmt = $conn->prepare('INSERT INTO cliente(idusuario,numeroint,numeroext,calle,colonia,municipio,telefono) VALUES(:idu, :ni, :ne,:calle, :col, :mun, :tel)');
							$info = $stmt->execute(array(':idu' =>$idUsuario, ':ni' =>$interior, ':ne' =>$ext, ':calle' =>$calle, ':col' => $colonia, ':mun' => $municipio, ':tel' => $telefono));
							if($info){
								$status = ['status'=>'true'];
								echo json_encode($status);
							}else{
								$status = ['status'=>'error','mensaje' =>"Ocurrio un error al crear cliente"];
								echo json_encode($status);
							}
						}else{
							$status = ['status'=>'log','mensaje' =>"No se encontro usuario"];
							echo json_encode($status);
						}
					}else{
						$status = ['status'=>'log','mensaje' =>"Error al crear usuario"];
						echo json_encode($status);
					}
				} else {
					$status = ['status'=>'error','mensaje' =>"El usuario \"$nombre $apellidop $apellidom\" ya existe."];
					echo json_encode($status);
				}

			}else{
				$status = ['status'=>'db','mensaje' =>"Error de conexión"];
				echo json_encode($status);
			}
		} else {
			$status = ['status'=>'error','mensaje' =>"Algunos campos obligatorios estan vacios."];
			echo json_encode($status);
		}

	}
?>
