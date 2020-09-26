<?php defined('BASEPATH') OR exit('No direct script access allowed');
require REST_CONTROLLER_PATH;
class Contact extends REST_Controller {
	
	function __construct()
    {
        parent::__construct();
		
		$this->load->helper('form');
        $this->load->helper('string');
		$this->load->model(array('Common_model'));
	}

   public function createcontact_POST()
   {
		$employee_id = $this->input->post('employee_id');
		$type = $this->input->post('type');
		$contact = $this->input->post('contact');
		
		$this->form_validation->set_rules('employee_id','Employee Id', 'required');
		$this->form_validation->set_rules('type','Type','required');
		$this->form_validation->set_rules('contact','Contact','required');
            
		if($this->form_validation->run() == FALSE)
		{
			$json_array['status'] = FALSE;
		    $json_array['message'] = validation_errors('','');
			$this->response($json_array, REST_Controller::HTTP_OK);
	    }
		else
		{
			$check = $this->Common_model->showemployee(TRUE,array('*'),array('employee.id'=>$employee_id));
			if(!empty($check))
			{
				$insert = array('employee_id'=>$employee_id,'type'=>$type,'contact'=>$contact);
				$results = $this->Common_model->save('employee_contact',$insert);
				if(!empty($results))
				{
				    $json_array['status'] = TRUE;
				    $json_array['message'] = 'Employee_Contact Added successfully';
				    $this->response($json_array,REST_Controller::HTTP_OK);
				}
				else
				{
					$json_array['status'] = FALSE;
				    $json_array['message'] = 'Employee_Contact Not Added';
				    $this->response($json_array,REST_Controller::HTTP_OK);
				}
				
			}
			else
			{
				 $json_array['status'] = FALSE;
				 $json_array['message'] = 'Employee Id Invalid';
				 $this->response($json_array,REST_Controller::HTTP_OK);
			}	
		}
	}
	
	public function editcontact_POST()
	{
		
		$eid = $this->input->post('eid');
		$type = $this->input->post('type');
		$contact = $this->input->post('contact');
		
		$this->form_validation->set_rules('eid', 'Eid', 'required');
		$this->form_validation->set_rules('type', 'Type', 'required');
		$this->form_validation->set_rules('contact', 'contact', 'required');
            
		if($this->form_validation->run() == FALSE)
		{
			$json_array['status'] = FALSE;
		    $json_array['message'] = validation_errors('','');
			$this->response($json_array, REST_Controller::HTTP_OK);
	    }
		else
		{
		    $check = $this->Common_model->show_contact(TRUE,array('*'),array('id'=>$eid));
			if(!empty($check))
			{ 
		        $where = array('id'=>$eid);
				$update = array('type'=>$type,'contact'=>$contact);
				$results = $this->Common_model->save('employee_contact',$update,$where);
				if(!empty($results))
				{
				    $json_array['status'] = TRUE;
				    $json_array['message'] = 'EmployeeContact updated successfully';
				    $this->response($json_array,REST_Controller::HTTP_OK);
				}
				else
				{
					$json_array['status'] = FALSE;
				    $json_array['message'] = 'EmployeeContact Not updated';
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
	
	public function deletecontact_POST()
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
			$check = $this->Common_model->show_contact(TRUE,array('*'),array('id'=>$id));
			if(!empty($check))
			{
			    $where = array('id'=>$id);
				$results = $this->Common_model->delete('employee_contact',$where);
				if(!empty($results))
				{
				    $json_array['status'] = TRUE;
				    $json_array['message'] = 'Deleted successfully';
				    $this->response($json_array,REST_Controller::HTTP_OK);
				}
				else
				{
					$json_array['status'] = FALSE;
				    $json_array['message'] = 'Not Deleted';
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
	
	public function showcontact_GET()
	{
		
		
		
		
		
		}
	
	
	

}