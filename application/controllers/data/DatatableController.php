<?php
defined('BASEPATH') or exit('No direct script access allowed');

// include('fungsi.php');

class DatatableController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('url');
		$this->load->library(['MySession','GlobalFunction']);
		$this->load->model(['AccountModel', 'BasicQuery']);

		// $this->globalfunction= new GlobalFunction();		
	}

	public function get_data(){

		$jsonPOST = file_get_contents('php://input');
		$dataReceived = json_decode($jsonPOST, true);

		$this->success('berhasil', $dataReceived);
		// if ($dataReceived['request'] == 'mentor') {
		// 	echo json_encode('berhasil');
		// }
		
	}

	public function success($message, $content = null){
		$obj=new stdClass;
		$obj->status = 200;
		$obj->proc = 'true';
		$obj->message = $message;
		$obj->data = $content;

		echo (json_encode($obj));
	}

	public function failed($message, $content = null){
		$obj=new stdClass;
		$obj->status = 500;
		$obj->proc = 'false';
		$obj->message = $message;
		$obj->data = $content;
		
		echo (json_encode($obj));
	}

	
}
