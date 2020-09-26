<?php defined('BASEPATH') OR exit('No direct script access allowed');
require REST_CONTROLLER_PATH;
class Employee extends REST_Controller {
	
	function __construct()
    {
        parent::__construct();
		
		 $this->load->helper('form');
         $this->load->helper('string');
		 
		 $this->load->model(array('Common_model'));
		 
	}
	
	
	public function showemployee_GET()
	{
		$json_array = Array();
		
		$get_employee = $this->Common_model->showemployee(FALSE,array('employee.id','employee.name','departments.departments'));
		
		$json_array['status'] = TRUE;
		$json_array['Employee'] = $get_employee;
		$this->response($json_array,REST_Controller::HTTP_OK);
		
	}
	
	public function createemployee_POST()
	{
		$department_id = $this->input->post('department_id');
		$name = $this->input->post('name');
		
		$this->form_validation->set_rules('department_id', 'Department Id', 'required');
		$this->form_validation->set_rules('name', 'FullName', 'required');
            
		if($this->form_validation->run() == FALSE)
		{
			$json_array['status'] = FALSE;
		    $json_array['message'] = validation_errors('','');
			$this->response($json_array, REST_Controller::HTTP_OK);
	    }
		else
		{
			$check = $this->Common_model->show(TRUE,array('*'),array('id'=>$department_id));
			if(!empty($check))
			{
				$insert = array('department_id'=>$department_id,'name'=>$name);
				
				$results = $this->Common_model->save('employee',$insert);
				if(!empty($results))
				{
				    $json_array['status'] = TRUE;
				    $json_array['message'] = 'Employee Added successfully';
				    $this->response($json_array,REST_Controller::HTTP_OK);
				}
				else
				{
					$json_array['status'] = FALSE;
				    $json_array['message'] = 'Employee Not Added';
				    $this->response($json_array,REST_Controller::HTTP_OK);
				}
				
			}
			else
			{
				 $json_array['status'] = FALSE;
				 $json_array['message'] = 'Department Not Founded';
				 $this->response($json_array,REST_Controller::HTTP_OK);
			}	
		}
	}
	
	public function editemployee_POST()
	{
		
		$eid = $this->input->post('eid');
		$name = $this->input->post('name');
		$department_id = $this->input->post('department_id');
		
		$this->form_validation->set_rules('eid', 'Eid', 'required');
		$this->form_validation->set_rules('department_id', 'Department Id', 'required');
		$this->form_validation->set_rules('name', 'Name', 'required');
            
		if($this->form_validation->run() == FALSE)
		{
			$json_array['status'] = FALSE;
		    $json_array['message'] = validation_errors('','');
			$this->response($json_array, REST_Controller::HTTP_OK);
	    }
		else
		{
		    $check = $this->Common_model->show(TRUE,array('*'),array('id'=>$department_id));
			if(!empty($check))
			{ 
		        $where = array('id'=>$eid);
				$update = array('department_id'=>$department_id,'name'=>$name);
				
				$results = $this->Common_model->save('employee',$update,$where);
				if(!empty($results))
				{
				    $json_array['status'] = TRUE;
				    $json_array['message'] = 'Employee updated successfully';
				    $this->response($json_array,REST_Controller::HTTP_OK);
				}
				else
				{
					$json_array['status'] = FALSE;
				    $json_array['message'] = 'Employee Not updated';
				    $this->response($json_array,REST_Controller::HTTP_OK);
				}
			}
			else
			{
				 $json_array['status'] = FALSE;
				 $json_array['message'] = 'Department Not Founded';
				 $this->response($json_array,REST_Controller::HTTP_OK);
			}	
		}
	}
	
	public function deleteemployee_POST()
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
			$check = $this->Common_model->showemployee(TRUE,array('*'),array('employee.id'=>$id));
			if(!empty($check))
			{
			    $where = array('id'=>$id);
				$results = $this->Common_model->delete('employee',$where);
				if(!empty($results))
				{
				    $json_array['status'] = TRUE;
				    $json_array['message'] = 'Employee Deleted successfully';
				    $this->response($json_array,REST_Controller::HTTP_OK);
				}
				else
				{
					$json_array['status'] = FALSE;
				    $json_array['message'] = 'Employee Not updated';
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
	
	
	public function search_employee()
	{
		
		$post = $this->input->post('universal_search');

		if ($post == "" && strlen($post) > 3)
		{
			$json_array['status'] = FALSE;
			$json_array['message'] = 'Data Not Founded';
			$this->response($json_array,REST_Controller::HTTP_OK);
			
		}
		else
		{
		     $return = $this->Common_model->search($post);
			 if(!empty($return['Employee_details']))
             {
			    $json_array['status'] = TRUE;
				$json_array['data'] = $return['Employee_details'];
				$this->response($json_array,REST_Controller::HTTP_OK);
			 }
			 else
			 {
				 $json_array['status'] = FALSE;
				 $json_array['message'] = 'Data Not Founded';
				 $this->response($json_array,REST_Controller::HTTP_OK);
			 }
		}
		
	}
	
}