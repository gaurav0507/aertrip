<?php defined('BASEPATH') OR exit('No direct script access allowed');
require REST_CONTROLLER_PATH;
class Department extends REST_Controller {
	
	function __construct()
    {
        parent::__construct();
		
		 $this->load->helper('form');
         $this->load->helper('string');
		 
		 $this->load->model(array('Common_model'));
		 
	}
	
	
	public function showdepartment_GET()
	{
		$json_array = Array();
		
		$get_department = $this->Common_model->show(FALSE,array('*'));
		
		$json_array['status'] = TRUE;
		$json_array['department'] = $get_department;
		$this->response($json_array,REST_Controller::HTTP_OK);
		
	}
	
	public function createdepartment_POST()
	{
		$departments = $this->input->post('departments');
		
		$this->form_validation->set_rules('departments', 'Department Name', 'required');
            
		if($this->form_validation->run() == FALSE)
		{
			$json_array['status'] = FALSE;
		    $json_array['message'] = validation_errors('','');
			$this->response($json_array, REST_Controller::HTTP_OK);
	    }
		else
		{
			$check = $this->Common_model->show(TRUE,array('*'),array('departments'=>$departments));
			if(empty($check))
			{
				$insert = array('departments'=>$departments,'status'=>1);
				$results = $this->Common_model->save('departments',$insert);
				if(!empty($results))
				{
				    $json_array['status'] = TRUE;
				    $json_array['message'] = 'Department Added successfully';
				    $this->response($json_array,REST_Controller::HTTP_OK);
				}
				else
				{
					$json_array['status'] = FALSE;
				    $json_array['message'] = 'Department Not Added';
				    $this->response($json_array,REST_Controller::HTTP_OK);
				}
				
			}
			else
			{
				 $json_array['status'] = FALSE;
				 $json_array['message'] = 'Department Already Added';
				 $this->response($json_array,REST_Controller::HTTP_OK);
			}	
		}
	}
	
	public function editdepartment_POST()
	{
		
		$eid = $this->input->post('eid');
		$departments = $this->input->post('departments');
		
		$this->form_validation->set_rules('eid', 'Eid', 'required');
		$this->form_validation->set_rules('departments', 'Department Name', 'required');
            
		if($this->form_validation->run() == FALSE)
		{
			$json_array['status'] = FALSE;
		    $json_array['message'] = validation_errors('','');
			$this->response($json_array, REST_Controller::HTTP_OK);
	    }
		else
		{
		    $check = $this->Common_model->show(TRUE,array('*'),array('departments'=>$departments));
			if(empty($check))
			{ 
		        $where = array('id'=>$eid);
				$update = array('departments'=>$departments,'status'=>1);
				
				$results = $this->Common_model->save('departments',$update,$where);
				if(!empty($results))
				{
				    $json_array['status'] = TRUE;
				    $json_array['message'] = 'Department updated successfully';
				    $this->response($json_array,REST_Controller::HTTP_OK);
				}
				else
				{
					$json_array['status'] = FALSE;
				    $json_array['message'] = 'Department Not updated';
				    $this->response($json_array,REST_Controller::HTTP_OK);
				}
			}
			else
			{
				 $json_array['status'] = FALSE;
				 $json_array['message'] = 'Department Already Added';
				 $this->response($json_array,REST_Controller::HTTP_OK);
			}	
		}
	}
	
	public function deletedepartment_POST()
	{
		$id = $this->input->post('id');
		
		$this->form_validation->set_rules('id', 'Id', 'required');
		
		if($this->form_validation->run() == FALSE)
		{
			$json_array['status'] = FALSE;
		    $json_array['message'] = validation_errors('','');
			$this->response($json_array, REST_Controller::HTTP_OK);
	    }
		else
		{
			$check = $this->Common_model->show(TRUE,array('*'),array('id'=>$id));
			if(!empty($check))
			{
			    $where = array('id'=>$id);
				$results = $this->Common_model->delete('departments',$where);
				if(!empty($results))
				{
				    $json_array['status'] = TRUE;
				    $json_array['message'] = 'Department Deleted successfully';
				    $this->response($json_array,REST_Controller::HTTP_OK);
				}
				else
				{
					$json_array['status'] = FALSE;
				    $json_array['message'] = 'Department Not updated';
				    $this->response($json_array,REST_Controller::HTTP_OK);
				}
			}
			else
			{
				$json_array['status'] = FALSE;
				$json_array['message'] = 'Record Not Founded';
				$this->response($json_array,REST_Controller::HTTP_OK);
			}
			
		}
		
	}
	
}