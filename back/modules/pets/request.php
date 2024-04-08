<?php

use function PHPSTORM_META\type;

error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

include_once './database/connect.php';

$objDb = new DBConnect;
$conn = $objDb->connect();

$data = $_REQUEST;
$method = $_SERVER['REQUEST_METHOD'];

switch($method) {

	case "GET":

		$id = $data['id'] ?? null;

		$sql = "SELECT * FROM mascotas";

		if(isset($id) && is_numeric($id)) {
			$sql .= " WHERE id = :id";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(':id', $id);
			$stmt->execute();
			$pets = $stmt->fetch(PDO::FETCH_ASSOC);
		} else {
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			$pets = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}

		echo json_encode($pets);
	break;

	case "POST":

		$pet = json_decode(file_get_contents("php://input"));

		if (!$pet) {
			$response = ['status' => 0, 'message' => 'No data!'];
			echo json_encode($response);
			die();
		}

		$sentencia = $conn->prepare("INSERT INTO mascotas(nombre, raza, edad) VALUES (?, ?, ?)");
		$result = $sentencia->execute([$pet->nombre, $pet->raza, $pet->edad]);

		$response = [
			'status' => $result ? 1 : 0,
			'message' => $result ? 'Record created successfully.' : 'Failed to create record.',
			"resultado" => $result,
		];

		echo json_encode($response);
	break;

	case "PUT":

		$pet = json_decode(file_get_contents("php://input"));

		if (!$pet) {
			$response = ['status' => 0, 'message' => 'No data!'];
			echo json_encode($response);
			die();
		}

		$sentencia = $conn->prepare("UPDATE mascotas SET nombre = ?, raza = ?, edad = ? WHERE id = ?");
		$result = $sentencia->execute([$pet->nombre, $pet->raza, $pet->edad, $pet->id]);

		$response = [
			'status' => $result ? 1 : 0,
			'message' => $result ? 'Record updated successfully.' : 'Failed to update record.',
			"resultado" => $result,
		];

		echo json_encode($response);
	break;

	case "DELETE":

		$id = $data['id'] ?? null;

		$sql = "DELETE FROM mascotas WHERE id = :id";

		$stmt = $conn->prepare($sql);
		$stmt->bindParam(':id', $id);

		if($stmt->execute()) {
			$response = ['status' => 1, 'message' => 'Record deleted successfully.'];
		} else {
			$response = ['status' => 0, 'message' => 'Failed to delete record.'];
		}

		echo json_encode($response);
	break;

	default:
		echo json_encode(['status' => 0, 'Method no found!']);
}