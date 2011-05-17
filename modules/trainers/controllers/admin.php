<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Shop_Admin_Controller {
  function Admin(){
    parent::Shop_Admin_Controller();
    // Check for access permission
	check('Trainers');
	// load MTrainers model
	$this->load->model('MTrainers');
   // Set breadcrumb
	$this->bep_site->set_crumb($this->lang->line('backendpro_trainers'),'trainers/admin');
       
	
  }
  
  function index(){
	$data['title'] = "Manage Trainers";
	$data['trainers'] = $this->MTrainers->getAllTrainers();
	$data['header'] = $this->lang->line('backendpro_access_control');
       

	$data['page'] = $this->config->item('backendpro_template_admin') . "admin_trainers_home";
	$data['module'] = 'trainers';
	$this->load->view($this->_container,$data);
  }
  

  function create(){
   	if ($this->input->post('trainer_name')){
   		$rules['trainer_name'] = 'required';
		$this->validation->set_rules($rules);

   	if ($this->validation->run() == FALSE)
		{
			$this->validation->output_errors();
			redirect('trainers/admin/create','refresh');
		}
		else
		{
			$this->MTrainers->addTrainer();
	  		flashMsg('success','Trainer created');
	  		redirect('trainers/admin/index','refresh');
		}
  	}else{
		$data['title'] = "Create Trainer";
		// Set breadcrumb
		$this->bep_site->set_crumb('Trainer Create','trainers/admin/create');
		$data['header'] = $this->lang->line('backendpro_access_control');
		$data['page'] = $this->config->item('backendpro_template_admin') . "admin_trainers_create";
		$data['module'] = 'trainers';
		$this->load->view($this->_container,$data);  
	} 
  }
  
  
  function edit($id=0){
  	if ($this->input->post('trainer_name')){
  		$this->MTrainers->updateTrainer();
  		flashMsg('success','Trainer editted');
  		redirect('trainers/admin/index','refresh');
  	}else{
		$data['title'] = "Edit Trainer";
		$data['page'] = $this->config->item('backendpro_template_admin') . "admin_trainers_edit";
		$data['trainer'] = $this->MTrainers->getTrainer($id);
		if (!count($data['trainer'])){
			redirect('admin/trainers/index','refresh');
		}
		$data['header'] = $this->lang->line('backendpro_access_control');
		// Set breadcrumb
		$this->bep_site->set_crumb($this->lang->line('userlib_trainer_edit'),'trainers/admin/edit');
		$data['module'] = 'trainers';
		$this->load->view($this->_container,$data);    
	}
  }
  
  
	function delete($id){
	/**
	 * When you delete trainers, it will affect on omc_order table and it will affect omc_order_table_items
	 * Check if the trainer has orders, if yes, then go back with warning to delete the order first.
	 *
	 */
		$order_orphans = $this->MTrainers->checkOrphans($id);
		if (count($order_orphans)){
			// $this->session->set_userdata($order_orphans);
			flashMsg('warning','Trainer can\'t be deleted');
			flashMsg('warning',$order_orphans);
			redirect('trainers/admin/index/','refresh');
		}else{
		    $this->MTrainers->deleteTrainer($id);
			flashMsg('success','Trainer deleted');
			redirect('trainers/admin/index','refresh');
		}
  	}
 
  
	function changeUserStatus($id){
		$this->MAdmins->changeTrainerStatus($id);
		flashMsg('success','User status changed');
		redirect('admins/admin/index','refresh');
  	}
	
	
}


?>