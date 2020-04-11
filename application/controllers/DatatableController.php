<?php
defined('BASEPATH') or exit('No direct script access allowed');

// include('fungsi.php');

class DatatableController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('url');
		// $this->load->library(['MySession']);
		$this->load->model(['AccountModel']);

		// $this->globalfunction= new GlobalFunction();		
	}

	public function get_data(){

		$jsonPOST = file_get_contents('php://input');
		$dataReceived = json_decode($jsonPOST, true);


		if ($dataReceived['ihateapple'] == 'mentor') {

			$userCond = array('role_id' => AS_MENTOR);
			$dbResult = $this->BasicQuery->selectAllResult('user',$userCond);
			
			$this->success('berhasil', $dbResult);

		}else if ($dataReceived['ihateapple'] == 'course') {

			$courseCond = array('status' => 1);
			$dbResult = $this->BasicQuery->selectAllResult('course',$courseCond);

			foreach ($dbResult as $key => $value) {
				$userCond = array('id' => $value['mentor_id'],'role_id' => AS_MENTOR);
				$dbResult[$key]['mentor'] = $this->BasicQuery->selectAll('user',$userCond);
			}
			

			$this->success('berhasil', $dbResult);

		}else if ($dataReceived['ihateapple'] == 'single_course') {

			$courseCond = array('id' => $dataReceived['id'], 'status' => 1);
			$dbResult = $this->BasicQuery->selectAll('course',$courseCond);

			$userCond = array('id' => $dbResult['mentor_id'],'role_id' => AS_MENTOR);
			$dbResult['mentor'] = $this->BasicQuery->selectAll('user',$userCond);
			

			$this->success('berhasil', $dbResult);

		}else if ($dataReceived['ihateapple'] == 'payment_unpaid') {

			$payCond = array('status' => 0, 'id_user' => $dataReceived['id_user']);
			$dbResult = $this->BasicQuery->selectAllResult('payment',$payCond);

			$this->success('berhasil', $dbResult);

		}else if ($dataReceived['ihateapple'] == 'payment_all') {

			$payCond = array('id_user' => $dataReceived['id_user']);
			$dbResult = $this->BasicQuery->selectAllResult('payment',$payCond);

			$this->success('berhasil', $dbResult);

		}
		
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
