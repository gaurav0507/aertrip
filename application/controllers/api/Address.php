<?php defined('BASEPATH') OR exit('No direct script access allowed');
require REST_CONTROLLER_PATH;
class Address extends REST_Controller {
	
	function __construct()
    {
        parent::__construct();
		
		 $this->load->helper('form');
         $this->load->helper('string');
		 $this->load->model(array('Common_model'));
	}


    public function createaddress_POST()
	{
		$employee_id = $this->input->post('employee_id');
		$type = $this->input->post('type');
		$address = $this->input->post('address');
		
		$this->form_validation->set_rules('employee_id','Employee Id', 'required');
		$this->form_validation->set_rules('type','Type','required');
		$this->form_validation->set_rules('address','Address','required');
            
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
				$insert = array('employee_id'=>$employee_id,'type'=>$type,'address'=>$address);
				$results = $this->Common_model->save('employee_address',$insert);
				if(!empty($results))
				{
				    $json_array['status'] = TRUE;
				    $json_array['message'] = 'Employee Address Added successfully';
				    $this->response($json_array,REST_Controller::HTTP_OK);
				}
				else
				{
					$json_array['status'] = FALSE;
				    $json_array['message'] = 'Employee Address Not Added';
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
	
	public function editaddress_POST()
	{
		
		$eid = $this->input->post('eid');
		$type = $this->input->post('type');
		$address = $this->input->post('address');
		
		$this->form_validation->set_rules('eid', 'Eid', 'required');
		$this->form_validation->set_rules('type', 'Type', 'required');
		$this->form_validation->set_rules('address', 'Address', 'required');
            
		if($this->form_validation->run() == FALSE)
		{
			$json_array['status'] = FALSE;
		    $json_array['message'] = validation_errors('','');
			$this->response($json_array, REST_Controller::HTTP_OK);
	    }
		else
		{
		    $check = $this->Common_model->show_address(TRUE,array('*'),array('id'=>$eid));
			if(!empty($check))
			{ 
		        $where = array('id'=>$eid);
				$update = array('type'=>$type,'address'=>$address);
				
				$results = $this->Common_model->save('employee_address',$update,$where);
				if(!empty($results))
				{
				    $json_array['status'] = TRUE;
				    $json_array['message'] = 'Address updated successfully';
				    $this->response($json_array,REST_Controller::HTTP_OK);
				}
				else
				{
					$json_array['status'] = FALSE;
				    $json_array['message'] = 'Address Not updated';
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
	
	public function deleteaddress_POST()
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
				$results = $this->Common_model->delete('employee_address',$where);
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
	
	public function showaddress_get()
	{
		
		
		}
}