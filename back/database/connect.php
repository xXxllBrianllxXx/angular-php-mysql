<?php

	class DBConnect {

		private $pass = '';
		private $user = 'root';
		private $dbname = 'pets';
		private $server = 'localhost';

		public function connect() {

			try {
				$conn = new PDO('mysql:host=' .$this->server .';dbname=' . $this->dbname, $this->user, $this->pass);
				$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				return $conn;
			} catch (\Exception $e) {
				$response = ['status' => 0, 'message' => 'DB connection error', 'error' => $e->getMessage()];
				echo json_encode($response);
				die();
			}
		}
	}
?>