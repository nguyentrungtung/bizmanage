<?php namespace App\Http\Controllers;

class ApiController extends Controller {
	
	protected function errorResponse($msg = '') {
		return response()->json(
			['type' => 'error', 'message' => $msg]
		);
	}
}
