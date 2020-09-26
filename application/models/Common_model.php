<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Common_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
	
	
	
    public function save($tableName,$arrdata, $arrwhere = array())
    {
    	if(!empty($arrwhere)) {
    		$this->db->where($arrwhere);	
            return $this->db->update($tableName, $arrdata);
    	} else {
    		$this->db->insert($tableName, $arrdata);	
            return $this->db->insert_id();
    	}
    }

    public function show($return_as_strict_row,$select_array, $where_array = array())
    {
        $this->db->select($select_array);
        $this->db->from('departments');
        if(!empty($where_array)) {
           $this->db->where($where_array); 
        }
        $result_array = $this->db->get()->result_array();   
        if($return_as_strict_row)
        {
            if(count($result_array) > 0) // ensure only one record has been previously inserted
            {
                $result_array  = $result_array[0];
            }
        }                
        return $result_array;
    }
	
	public function showemployee($return_as_strict_row,$select_array, $where_array = array())
    {
        $this->db->select($select_array);
        $this->db->from('employee');
		$this->db->join('departments','employee.department_id = departments.id');
        if(!empty($where_array)) {
           $this->db->where($where_array); 
        }
        $result_array = $this->db->get()->result_array();   
        if($return_as_strict_row)
        {
            if(count($result_array) > 0) {
                $result_array  = $result_array[0];
            }
        }                
        return $result_array;
    }
	
	
	public function delete($tableName, $arrwhere)
	{
		return $this->db->delete($tableName, $arrwhere);	
	}
	
	public function show_contact($return_as_strict_row,$select_array, $where_array = array())
	{
		$this->db->select($select_array);
        $this->db->from('employee_contact');
        if(!empty($where_array)) {
           $this->db->where($where_array); 
        }
        $result_array = $this->db->get()->result_array();   
        if($return_as_strict_row)
        {
            if(count($result_array) > 0) // ensure only one record has been previously inserted
            {
                $result_array  = $result_array[0];
            }
        }                
        return $result_array;
		
	}
	
	
	public function show_address($return_as_strict_row,$select_array, $where_array = array())
	{
		$this->db->select($select_array);
        $this->db->from('employee_address');
        if(!empty($where_array)) {
           $this->db->where($where_array); 
        }
        $result_array = $this->db->get()->result_array();   
        if($return_as_strict_row)
        {
            if(count($result_array) > 0) // ensure only one record has been previously inserted
            {
                $result_array  = $result_array[0];
            }
        }                
        return $result_array;
		
	}
	
	public function search()
	{
	    $this->db->select(array('id','name'))->from('employee');
    	$this->db->like('name', $search_data);
    	$result  = $this->db->get();
        $result_array['Employee_details'] = $result->result_array();
		
		return $result_array;
	}
	
	
	
	
	
	

}