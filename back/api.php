<?php

	try {

		$route = './modules/'.$_REQUEST['module'].'/request.php';

		if (! @include_once($route))
			throw new Exception('Module not found!');

		if (!file_exists($route))
			throw new Exception('Module not found!');
		else
			require_once($route);

	} catch (Exception $e) {
		$response = ['status' => 0, 'message' => $e->getMessage()];
		echo json_encode($response);
		die();
	}
