<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Shop_Admin_Controller {
  function Admin(){
   	parent::Shop_Admin_Controller();
   	// Check for access permission
	check('Courses');
   	// load modules/courses/model/MCourses
   	$this->load->module_model('courses','MCourses');
   	// Load modules/pages/models/MPages
	$this->load->module_model('pages','MPages');
        // Load modules/trainers/models/MTrainers
	$this->load->module_model('trainers','MTrainers');
        // Load moudles/fitness/MFitness and library
        $this->load->module_model('fitness','MFitness');
        $this->load->module_library('trainers','embedded_video');
	// Set breadcrumb
	$this->bep_site->set_crumb('Courses','courses/admin');
    		
    }


    function index(){
        
        if ($this->input->post('course_name')){
    // check if the same course does not exist.
    // find date_id, time, course_name
            $date_id = $this->input->post('date_id');
            $time = $this->input->post('time');
            $course_name = $this->input->post('course_name');
    // check if there is the same in omc_courses
            
            $check_course = $this->MCourses->check_course($date_id, $time, $course_name);
            //var_dump($check_course);
            if($check_course==TRUE){
    // there is the same date_id, time and course name, warn it
                $this->session->set_flashdata('warning','There is the same course at the same time');

            }else{
    // everything ok so insert a course
  		$this->MCourses->addnewcourse();
  		$this->session->set_flashdata('message','Course Created');
            }
               redirect('courses/admin/index','refresh');
  	}else{
   // there is no input, so let's display
   // change $week_id by $this->input->post('week_id')
        if($this->input->post('week_id')){
            $week_id = $this->input->post('week_id');
        }else{
   // need to get weeklist and get the smallest id's id for showing it
   // this returns an array of week_id =>1, name => Uke 41
        $firstweek = $this->MCourses->getfirstweekid();
        $data['firstweek'] = $firstweek;
   // assign week to show
        $week_id = $firstweek['week_id'];
      }
   // get the date which has $week_id as week_id
        $data['weekdatelist'] = $this->MCourses->getdateforweek($week_id);
   // get the time with date, where date id
        $data['courselist'] = $this->MCourses->getcourseforweek($week_id);
   // use this for dropdown to change week
        $data['weeklist'] = $this->MCourses->getweeks();
   // get dropdown for types
        $data['types'] = $this->MCourses->gettypes();
   // for forms
   // date_id
        $data['datelist'] = $this->MCourses->getdatelist();
   // trainer_id
        $data['trainers'] = $this->MTrainers->getAllTrainerDropdown();
   // type can be added to db as omc_types, and use it in the dropdown
         // general
        $data['title'] = "Manage Course";
        $data['header'] = $this->lang->line('backendpro_access_control');
        $data['page'] = $this->config->item('backendpro_template_admin') . "admin_course_home";
        $data['module'] = 'courses';
        $this->load->view($this->_container,$data);
        }
}



  function edit_course(){
  	if ($this->input->post('course_name')){
  		$this->MCourses->updateCourse();
  		$this->session->set_flashdata('message','Course updated');
  		redirect('courses/admin/index','refresh');
  	}else{		
		$data['title'] = "Edit Course";
		// $data['main'] = 'admin_course_edit';
		$data['page'] = $this->config->item('backendpro_template_admin') . "admin_course_edit";
                $id = $this->uri->segment(4);
		$data['course'] = $this->MCourses->getCourse($id);
		//$data['courses'] = $this->MCourses->getAllCoursesDisplay();
        // date_id
                $data['datelist'] = $this->MCourses->getdatelist();
                $data['trainers'] = $this->MTrainers->getAllTrainerDropdown();
		// $data['pages'] = $this->MPages->getAllPathwithnone();
		if (!count($data['course'])){
			redirect('courses/admin/index','refresh');
		}
                $data['header'] = $this->lang->line('backendpro_access_control');
		// Set breadcrumb
		$this->bep_site->set_crumb('Edit Course','courses/admin/edit');
		$data['module'] = 'courses';
		$this->load->view($this->_container,$data);
	}
  }

    function delete_course($id=NULL){
        // before deleting it, check if there is any bookings


        // if there are bookings warn it


        // if there is no booking, then delete

	$id = $this->uri->segment(4);
	$this->MCourses->delete_course($id);
	$this->session->set_flashdata('message','Course deleted');
	redirect('courses/admin/index','refresh');
	
  }

  /*
   * Home, CRUD for week and date
   *
   */

  function weekhome(){
      if ($this->input->post('name')){
  		$this->MCourses->addweek();
  		$this->session->set_flashdata('message','Week Added');
  		redirect('courses/admin/weekhome','refresh');
  	}else{

      // get all the weeks to display
        $data['weeks'] = $this->MCourses->getweeks();

        // Set breadcrumb
	$this->bep_site->set_crumb('Week Home','courses/admin/weekhome');
        $data['title'] = "Manage Week";
        $data['header'] = $this->lang->line('backendpro_access_control').'Week Home';
        $data['page'] = $this->config->item('backendpro_template_admin') . "weeks/admin_week_home";
        $data['module'] = 'courses';
        $this->load->view($this->_container,$data);
        }
  }

  

  function editweek(){
       if ($this->input->post('name')){
           
            $this->MCourses->updateweek();
            $this->session->set_flashdata('message','Week Edited');
            redirect('courses/admin/weekhome','refresh');
  	}else{
      // get the week info
        $id = $this->uri->segment(4);
        $data['week'] = $this->MCourses->getweek($id);

        // Set breadcrumb
	$this->bep_site->set_crumb('Edit Week','courses/admin/editweek');
        $data['title'] = "Edit Week";
        $data['header'] = $this->lang->line('backendpro_access_control').'Edit Week';
        $data['page'] = $this->config->item('backendpro_template_admin') . "weeks/admin_week_edit";
        $data['module'] = 'courses';
        $this->load->view($this->_container,$data);
        }
  }

  function deleteweek(){
      $id = $this->uri->segment(4);
       $this->MCourses->deleteweek($id);
       redirect('courses/admin/weekhome','refresh');
  }

  function datehome(){
      if ($this->input->post('date')){
  		$this->MCourses->adddate();
  		$this->session->set_flashdata('message','Date Added');
  		redirect('courses/admin/datehome','refresh');
  	}else{

      // get all the weeks to display
        $data['datelist'] = $this->MCourses->getalldatebyweek();

     // get weeklist

        $data['weeklist'] = $this->MCourses->getweeks();

        // Set breadcrumb
	$this->bep_site->set_crumb('Date Home','courses/admin/datehome');
        $data['title'] = "Manage Date";
        $data['header'] = $this->lang->line('backendpro_access_control').'Date Home';
        $data['page'] = $this->config->item('backendpro_template_admin') . "dates/admin_date_home";
        $data['module'] = 'courses';
        $this->load->view($this->_container,$data);
        }

  }


  function editdate(){
       if ($this->input->post('date')){

            $this->MCourses->updatedate();
            $this->session->set_flashdata('message','Date Edited');
            redirect('courses/admin/datehome','refresh');
  	}else{
      // get the week info
        $id = $this->uri->segment(4);
        $data['date'] = $this->MCourses->getdate($id);

      // get week list for dropdown
         $data['weeklist'] = $this->MCourses->getweeks();

        // Set breadcrumb
	$this->bep_site->set_crumb('Edit Date','courses/admin/editdate');
        $data['title'] = "Edit Date";
        $data['header'] = $this->lang->line('backendpro_access_control').'Edit Date';
        $data['page'] = $this->config->item('backendpro_template_admin') . "dates/admin_date_edit";
        $data['module'] = 'courses';
        $this->load->view($this->_container,$data);
        }

  }

  function deletedate(){
      $id = $this->uri->segment(4);
      $this->MCourses->deletedate($id);
      redirect('courses/admin/datehome','refresh');

  }

/*
 *
 */

  



  /*
   * testing for create
   *
   *
   */
function createnew(){

    // need to get weeklist and get the smallest id's id for showing it
    // use this for dropdown to change week
         $data['weeklist'] = $this->MCourses->getweeks();
    
       
       

    // This is used in admin/courses, when you click Create new course, then this is called
    // 'parentid' ,'0' is in hidden in views/admin_course_create.php
   	if ($this->input->post('course_name')){
  		$this->MCourses->addCoursenew();
  		$this->session->set_flashdata('message','Course Created');
  		redirect('courses/admin/index','refresh');
  	}else{
		$data['title'] = "Create Course";
    // get dropdown for dates
        $data['datelist'] = $this->MCourses->getdatelist();

	  //	$data['courses'] = $this->MCourses->getAllCoursesDisplay();
    // dropdwon for trainers
		$data['trainers'] = $this->MTrainers->getAllTrainerDropdown();
     // get dropdown for types
                $data['types'] = $this->MCourses->getcoursetypes();

    // Set breadcrumb
		$this->bep_site->set_crumb('Create Course','courses/admin/create');

		$data['header'] = $this->lang->line('backendpro_access_control');
		$data['page'] = $this->config->item('backendpro_template_admin') . "admin_course_createnew";
		$data['module'] = 'courses';

    // showing schedule in a calendar style
                $caltree = array();
                $weekid = $this->input->post('weekid');
                if ($weekid){
                   $calid= $weekid;
                }else{
                      $calid = 1;
                }
                $data['weeknav'] =   $this->MFitness->generateTree($caltree,$calid);
		$this->load->view($this->_container,$data);
	}
  }





function indexold(){
    // showing all inputs in a tree style
        $tree = array();
        $parentid = 0;
        $this->MCourses->generateallTree($tree,$parentid);
        $data['navlist'] = $tree;
   // get dropdown for types
        $data['types'] = $this->MCourses->getcoursetypes();

   // get dropdown for week, uke40, uke41 etc
        $data['weeklist'] = $this->MCourses->getcoursebyparentid($parentid);

   // general
        $data['title'] = "Manage Course";
        $data['header'] = $this->lang->line('backendpro_access_control');
        $data['page'] = $this->config->item('backendpro_template_admin') . "admin_course_homeold";
        $data['module'] = 'courses';

    // showing schedule in a calendar style
        $caltree = array();
        $weekid = $this->input->post('weekid');
        if ($weekid){
           $calid= $weekid;
        }else{
              $calid = 1;
        }
        $data['weeknav'] =   $this->MFitness->generateTree($caltree,$calid);
        $this->load->view($this->_container,$data);
}
/*
 * no need anymore
 */


  function create(){
      // Set breadcrumb
	$this->bep_site->set_crumb('Create Course','courses/admin/create');

    // get dropdown for week, uke40, uke41 etc
        $parentid = 0;
        $data['weeklist'] = $this->MCourses->getcoursebyparentid($parentid);

    // This is used in admin/courses, when you click Create new course, then this is called
    // 'parentid' ,'0' is in hidden in views/admin_course_create.php
   	if ($this->input->post('name')){
  		$this->MCourses->addCourse();
  		$this->session->set_flashdata('message','Course Created');
  		redirect('courses/admin/index','refresh');
  	}else{
		$data['title'] = "Create Course";
	  	$data['courses'] = $this->MCourses->getAllCoursesDisplay();
		//$data['pages'] = $this->MPages->getAllPathwithnone();
		$data['trainers'] = $this->MTrainers->getAllTrainerDropdown();
     // get dropdown for types
                $data['types'] = $this->MCourses->getcoursetypes();

    // Set breadcrumb
		$this->bep_site->set_crumb('Create Course','courses/admin/create');

		$data['header'] = $this->lang->line('backendpro_access_control');
		$data['page'] = $this->config->item('backendpro_template_admin') . "admin_course_create";
		$data['module'] = 'courses';

    // showing schedule in a calendar style
                $caltree = array();
                $weekid = $this->input->post('weekid');
                if ($weekid){
                   $calid= $weekid;
                }else{
                      $calid = 1;
                }
                $data['weeknav'] =   $this->MFitness->generateTree($caltree,$calid);
		$this->load->view($this->_container,$data);
	}
  }

  
  function deleteMenu($id){
    // This will be called to delete a course(not sub-course item).
	//$id = $this->uri->segment(4);
	
	$orphans = $this->MCourses->checkMenuOrphans($id);
	if (count($orphans)){
		$this->session->set_userdata('orphans',$orphans);
		redirect('mcourses/admin/reassign/'.$id,'refresh');
	}else{
		$this->MCourses->deleteMenu($id);
		$this->session->set_flashdata('message','course deleted');
		redirect('courses/admin/index','refresh');
	}
  }
  
  function changeCourseStatus($id){
    
	$orphans = $this->MCourses->checkCourseOrphans($id);
	if (count($orphans)){
		$this->session->set_userdata('orphans',$orphans);
		redirect('courses/admin/reassign/'.$id,'refresh');
	}else{
		$this->MCourses->changeCourseStatus($id);
		$this->session->set_flashdata('message','course status changed');
		redirect('courses/admin/index','refresh');
	}
  }
  
  
  function export(){
  	$this->load->helper('download');
  	$csv = $this->MCourses->exportCsv();
  	$name = "Menu_export.csv";
  	force_download($name,$csv);

  }

  function reassign($id=0){
    // This is called when you delete one of course from deleteMenu() function above.
	  if ($_POST){
		
		$this->MCourses->reassignMenus();
		$this->session->set_flashdata('message','Menu deleted and sub-course reassigned');
		redirect('courses/admin/index','refresh');
		}else{
		//$id = $this->uri->segment(4);
		
		$data['course'] = $this->MCourses->getMenu($id);
		$data['title'] = "Reassign Sub-course";
		$data['courses'] = $this->MCourses->getrootMenus();
		$this->MCourses->deleteMenu($id);
		
		// Set breadcrumb
		$this->bep_site->set_crumb($this->lang->line('userlib_course_reassign'),'courses/admin/reassign');
		
		$data['header'] = $this->lang->line('backendpro_access_control');
		$data['page'] = $this->config->item('backendpro_template_admin') . "admin_subcourse_reassign";
		$data['module'] = 'courses';
		$this->load->view($this->_container,$data);		
		}	
	}

	
}//end class
?>