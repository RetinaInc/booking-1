<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MTrainers extends Model{

	function MTrainers(){
		parent::Model();
	}

        // array outputs
        // used in edit()

	function getTrainer($id){
      $data = array();
      $options = array('id' => id_clean($id));
      $Q = $this->db->getwhere('omc_trainer',$options,1);
      if ($Q->num_rows() > 0){
        $data = $Q->row_array();
      }
      $Q->free_result();    
      return $data;  		
	}
	
        // object outputs
        function getTrainerobj($id){
      $data = array();
      $options = array('id' => id_clean($id));
      $Q = $this->db->getwhere('omc_trainer',$options,1);
      if ($Q->num_rows() > 0){
        $data = $Q;
      }
      $Q->free_result();
      return $data;
	}

        /*
         *  used in edit()
         */

    function updateTrainer(){
        $data = array('trainer_name' => $this->input->post('trainer_name'),
            'trainer_image' =>  $this->input->post('trainer_image'),
            'video_url' =>  $this->input->post('video_url'),
            'desc' =>  $this->input->post('desc'),

                    );
	  $this->db->where('id',$this->input->post('id'));
	  $this->db->update('omc_trainer',$data);

	}

        /*
         * Used in admin/index
         */


         function getAllTrainers(){
        $data = array();
        $Q = $this->db->get('omc_trainer');
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
            $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

    /*
     * Used in schedule/admin/edit, and create
     *
     */
    function getAllTrainerDropdown(){
        $data = array();
        $this->db->select('id,trainer_name');
        $Q = $this->db->get('omc_trainer');
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
            $data[$row['id']] = $row['trainer_name'];
            }
        }
        $Q->free_result();
        return $data;
    }



        // returns obj
        // Used in fintess/index

        function getAllTrainersobj(){
     $data = array();
     $Q = $this->db->get('omc_trainer');
     if ($Q->num_rows() > 0){
       foreach ($Q->result() as $row){
         $data[] = $row;
       }
     }
     $Q->free_result();
     return $data;
	}

	/*
         *  used in create()
         */
	function addTrainer(){
             $data = array(
                'trainer_name' => $this->input->post('trainer_name'),
                 'trainer_image' => $this->input->post('trainer_image'),
                 'video_url' => $this->input->post('video_url'),
                 'desc' => $this->input->post('desc'),
             );
	  $this->db->insert('omc_trainer',$data);
	}






        


        /* not used yet*/

	function getTrainerByEmail($e){
      $data = array();
      $options = array('email' => $e);
      $Q = $this->db->getwhere('omc_trainer',$options,1);
      if ($Q->num_rows() > 0){
        $data = $Q->row_array();
      }
      $Q->free_result();    
      return $data;  		
	}
	
	// not used yet
        
	function getTrainers(){
     $data = array();
     $Q = $this->db->get('omc_trainer');
     if ($Q->num_rows() > 0){
       foreach ($Q->result_array() as $row){
         $data[] = $row;
       }
     }
     $Q->free_result();
     return $data;


	}
	

	
	
	function checkTrainer($e){
		$numrow = 0;
		$this->db->select('trainer_id');
		$this->db->where('email',db_clean($e));
		$this->db->limit(1);
		$Q = $this->db->get('omc_trainer');
		if ($Q->num_rows() > 0){
			$numrow = TRUE; 
			return $numrow;
		}else{
			$numrow = FALSE;
			return $numrow;
		}		
	}
	
	
	function verifyTrainer($e,$pw){
		$this->db->where('email',db_clean($e,50));
		$this->db->where('password', db_clean(dohash($pw),16));
		$this->db->limit(1);
		$Q = $this->db->get('omc_trainer');
		if ($Q->num_rows() > 0){
			$row = $Q->row_array();
			$_SESSION['trainer_id'] = $row['trainer_id'];
			$_SESSION['trainer_first_name'] = $row['trainer_first_name'];
			$_SESSION['trainer_last_name'] = $row['trainer_last_name'];
			$_SESSION['phone_number'] = $row['phone_number'];
			$_SESSION['email'] = $row['email'];
			$_SESSION['address'] = $row['address'];
			$_SESSION['city'] = $row['city'];
			$_SESSION['post_code'] = $row['post_code'];
		}else{
			// $_SESSION['trainer_id'] = 0; // this will eliminate error
		}		
	}
	

	
	
	function deleteTrainer($id){
 		$this->db->where('trainer_id', id_clean($id));
		$this->db->delete('omc_trainer');
	}
	
	
	function checkOrphans($id){
		$data = array();
		$this->db->where('trainer_id',id_clean($id));
		$Q = $this->db->get('omc_order');
		if ($Q->num_rows() > 0){
		   foreach ($Q->result_array() as $key=>$row){
			 $data[$key] = $row;
		   }
		$Q->free_result();
		return $data;
		}
    	
 }
	
 
	function changeTrainerStatus($id){
		// getting status
		$userinfo = array();
		$userinfo = $this->getUser($id);
		$status = $userinfo['status'];
		if($status =='active'){
			$data = array('status' => 'inactive');
			$this->db->where('id', id_clean($id));
			$this->db->update('omc_trainer', $data);
		}else{
			$data = array('status' => 'active');
			$this->db->where('id', id_clean($id));
			$this->db->update('omc_admin', $data);	
	}
 }
 
	
}


?>