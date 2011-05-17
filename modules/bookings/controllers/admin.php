<?php

class Admin extends Shop_Admin_Controller {
  
  function  Admin(){
    parent::Shop_Admin_Controller();
    // Check for access permission
	check('Bookings');
    // load the validation library
        $this->load->library('validation');
    // load MBooking model
        $this->load->module_model('trainers','MTrainers');
        $this->load->module_model('bookings','MBooking');
    // Set breadcrumb
        $this->bep_site->set_crumb('Bookings','bookings/admin');
                 
  }

   function index(){

        // getting all the bookins
	$data['bookings'] = $this->MBooking->getAllBookings();
        // get all the booked number by course
        $data['bookingnum'] = $this->MBooking->getAllBookingnum();

        $data['title'] = "Manage Bookings";
	$data['header'] = $this->lang->line('backendpro_access_control');
        $data['page'] = $this->config->item('backendpro_template_admin') . "admin_bookings_home";
	$data['module'] = 'bookings';
	$this->load->view($this->_container,$data);
  }


  function bookingdetails(){
        
      // getting all the bookins by course
	$data['bookingdetails'] = $this->MBooking->getAllBookings();
        // get the booked number by course id
        $data['bookingnum'] = $this->MBooking->getAllBookingnum();


        $this->bep_site->set_crumb('Booking Details','bookings/bookingdetails');
        $data['title'] = "Manage Bookings";
        $data['header'] = $this->lang->line('backendpro_access_control');
        $data['page'] = $this->config->item('backendpro_template_admin') . "admin_bookings_details";
        $data['module'] = 'bookings';
        $this->load->view($this->_container,$data);
  }


  function edit_booking(){

  }


  function delete_booking(){
      // recalculate the total booking after deleting
  }









  /*
   * not used yet
   */


  function create(){
   	if ($this->input->post('trainer_name')){
   		$rules['trainer_name'] = 'required';
		$this->validation->set_rules($rules);

   	if ($this->validation->run() == FALSE)
		{
			$this->validation->output_errors();
			redirect('bookings/admin/create','refresh');
		}
		else
		{
			$this->MBooking->addBooking();
	  		flashMsg('success','Booking created');
	  		redirect('bookings/admin/index','refresh');
		}
  	}else{
		$data['title'] = "Create Booking";
		// Set breadcrumb
		$this->bep_site->set_crumb('Booking Create','bookings/admin/create');
		$data['header'] = $this->lang->line('backendpro_access_control');
		$data['page'] = $this->config->item('backendpro_template_admin') . "admin_bookings_create";
		$data['module'] = 'bookings';
		$this->load->view($this->_container,$data);
	}
  }


  function edit($id=0){
  	if ($this->input->post('trainer_name')){
  		$this->MBooking->updateBooking();
  		flashMsg('success','Booking editted');
  		redirect('bookings/admin/index','refresh');
  	}else{
		$data['title'] = "Edit Booking";
		$data['page'] = $this->config->item('backendpro_template_admin') . "admin_bookings_edit";
		$data['trainer'] = $this->MBooking->getBooking($id);
		if (!count($data['trainer'])){
			redirect('admin/bookings/index','refresh');
		}
		$data['header'] = $this->lang->line('backendpro_access_control');
		// Set breadcrumb
		$this->bep_site->set_crumb($this->lang->line('userlib_trainer_edit'),'bookings/admin/edit');
		$data['module'] = 'bookings';
		$this->load->view($this->_container,$data);
	}
  }


	function delete($id){
	/**
	 * When you delete bookings, it will affect on omc_order table and it will affect omc_order_table_items
	 * Check if the trainer has orders, if yes, then go back with warning to delete the order first.
	 *
	 */
		$order_orphans = $this->MBooking->checkOrphans($id);
		if (count($order_orphans)){
			// $this->session->set_userdata($order_orphans);
			flashMsg('warning','Booking can\'t be deleted');
			flashMsg('warning',$order_orphans);
			redirect('bookings/admin/index/','refresh');
		}else{
		    $this->MBooking->deleteBooking($id);
			flashMsg('success','Booking deleted');
			redirect('bookings/admin/index','refresh');
		}
  	}


	function changeUserStatus($id){
		$this->MAdmins->changeBookingStatus($id);
		flashMsg('success','User status changed');
		redirect('admins/admin/index','refresh');
  	}


}


?>