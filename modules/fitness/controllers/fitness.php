<?php

class Fitness extends Fitness_Controller {
  
  function  Fitness(){
    parent::Fitness_Controller();
    
    // load the validation library
        $this->load->library('validation');
        // load MTrainers model
         $this->load->module_model('trainers','MTrainers');
         $this->load->module_model('fitness','MFitness');
         $this->load->module_model('courses','MCourses');
         $this->load->module_model('bookings','MBooking');
         $this->load->module_library('trainers','embedded_video');
         $this->load->helper('form');
	
  }

  function index(){
    // get dropdown for types
            $data['types'] = $this->MCourses->gettypes();
    // use this for dropdown to change week
            $data['weeklist'] = $this->MCourses->getweeks();

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

// general setting
	$data['page'] = 'fitness/frontpage';
        $data['title'] = 'Fitness front page';
	$data['module'] = 'fitness';
	$this->load->view('fitness/container',$data);
     
  }

  /*
   * Called by ajax. no need of page, module, and view.
   */

  function calltrainer($id = NULL){
      $id = $this->uri->segment(3);
        // get details from DB
      $trainer = $this->MFitness->getTrainerDetails($id);

        if(is_array($trainer)){
              // output them
            $output = "<div class='modal'>";
            //$output .= print_r($trainer);
     $output .= "<div>".$trainer['trainer_name']."</div>";
     $output .= "<div>".$trainer['desc']."</div>";
     $output .= "<div style='width: 160px; height: 96px;'>". $this->embedded_video->get_video($trainer['video_url'])."</div>";
      $output .= "</div>";
      echo $output;
       }
  }

function displaybooking(){
    
    // Check for access permission
	check('Customer booking');
   	$data['coursedetails'] = $this->MFitness->getcoursedetails();
        $course_id = $this->uri->segment(3);
        $user_email = $this->session->userdata('email');
    // find user_id or customer_id
        $user = $this->MFitness->getuser($user_email);
        $user_id = $user->id;
       
    // get booking details
        $data['bookings'] = $this->MFitness->getmybooking($user_id);
        $data['allbookings'] = $this->MFitness->getallmycourses($user_id);

	$data['page'] = 'fitness/displaybooking';
        $data['title'] = 'Fitness Class My Bookings';
	$data['module'] = 'fitness';
	$this->load->view('fitness/container',$data);
  }


/*
 * Customer should log in and they can see booking link in each course
 * when a customer book/delete, it should count the total number and update omc_courses.total
 */

    function booking(){
         // Check for access permission
	check('Customer booking');
   	$data['coursedetails'] = $this->MFitness->getcoursedetails();
        $course_id = $this->uri->segment(3);
        $user_email = $this->session->userdata('email');
        // find user_id or customer_id
        $user = $this->MFitness->getuser($user_email);
        $user_id = $user->id;
        if ($user_id){
            // check if there isn't the same booking
            $checkbooking = $this->MFitness->checkbooking($course_id,$user_id);
            if ($checkbooking){
                // there is the same booking in db, so warn it
                flashMsg('warning','Your Booking is already in the booking list.');
            }else{
    // there is no same booking. Check the total booking number
            $bookingnumbefore = $this->MFitness->countbooking($course_id);
            $numbefore = $bookingnumbefore['totalbooking'];
            // var_dump ($numbefore);
    // get the capacity number
            $capacity = $this->MFitness->getcoursecapacity($course_id);
            $capacitynum = $capacity['capacity'];
           // var_dump($capacitynum);
    // compare $bookingnumbefore and $capacity
            if($numbefore < $capacitynum){
    // if total booking number is less than capacity, then book it
    // there is no booking so book it
                $this->MFitness->bookcourse($course_id,$user_id);
                flashMsg('success','Your Booking Has Been Added');
            }else{
    // if total booking number is equal or more than the capacity then, warn it
                 flashMsg('warning','Booking is full. You are not able to book at the moment.');
            }
    // updating omc_courses.booked
    // count the booking from omc_bookings
               $booking = $this->MFitness->countbooking($course_id);
               $bookingnum = $booking['totalbooking'];
    // and add to omc_courses.booked
               $this->MCourses->updatebooking($course_id, $bookingnum);               
            }
        }else{
             
            flashMsg('warning','Your Email is not in our database. Contact administrator.');
        }
        redirect('fitness/displaybooking','refresh');
        // get booking details
        /*
        $data['bookings'] = $this->MFitness->getmybooking($user_id);
        $data['allbookings'] = $this->MFitness->getallmycourses($user_id);

	$data['page'] = 'fitness/booking';
        $data['title'] = 'Fitness Class Booking Page';
	$data['module'] = 'fitness';
	$this->load->view('fitness/container',$data);
         * 
         */
  }

  /*
   * when a customer book/delete, it should count the total number and update omc_courses.total
   */

function deletebooking(){
        $booking_id = $this->uri->segment(3);
    // check if booking's cutomer_id match the same user_id
        $user_email = $this->session->userdata('email');
    // find user_id or customer_id
        $user = $this->MFitness->getuser($user_email);
        $user_id = $user->id;
        $check_booking = $this->MFitness->check_booking_id($user_id, $booking_id);
    
    // if there is $check_booking=TRUE, then delete it
        if($check_booking){
           
    // find course_id. It will be used to count the total booking
    // first get details of booking
         //   print_r ($booking_id);
        $bookingdetails = $this->MBooking->getbookingdetails($booking_id);
         // var_dump ($bookingdetails);
        $course_id =  $bookingdetails->course_id;
     //   print_r ($course_id);
 
    // delete it
        $this->MFitness->deletebooking($booking_id);
    // after deleting completed, updating omc_courses.booked
    // count the booking from omc_bookings
        $booking = $this->MFitness->countbooking($course_id);
        $bookingnum = $booking['totalbooking'];
    // and add to omc_courses.booked
        $this->MCourses->updatebooking($course_id, $bookingnum);
        flashMsg('success','Your booking has been deleted.');
            
        }else{
    // if not warn them
             flashMsg('warning','Something went wrong. Your booking is not in our database. Contact administrator.');

        }
        redirect('fitness/displaybooking','refresh');
    
}












  



	
  	function cat($id){
		$cat = $this->MCats->getCategory($id);
		/**
	      * $id is the third(3) in URI which represents the ID and any 
	      * variables that will be passed to the controller.
	      */
		if (!count($cat)){
			// if there is no such a category id, then redirect.
			redirect( 'fitness'.'/index','refresh');
		}
		$data['title'] = lang('webshop_shop_name')." | ". $cat['name'];
		
		if ($cat['parentid'] < 1){
			/**
	          * If a parent id is 0, it must be a root category, so show children/sub-categories
	          */
			$data['listing'] = $this->MCats->getSubCategories($id);
			/**
	         * this will receive a series of array with id, name, shortdesc and thumbnail
			 * and store them in listing. Array ([0]=>array([id]=>14 [name]=>long-sleeve...))
	         */
			$data['level'] = 1;
		}else{
			// otherwise, it must be a category, so let's show products
			$data['listing'] = $this->MProducts->getProductsByCategory($id);
			// this will receive a series of product with array.id,name,shortdesc,thumbnail
			$data['level'] = 2;
		}
		$data['category'] = $cat;
		$data['page'] = 'fitness/category';
		$data['module'] = 'fitness';
		$this->load->view('fitness/container',$data);
 	}



	function product($id){
		$product = $this->MProducts->getProduct($id);
		/** this returns all, i.e. id, name, shortdesc, longdesc, thumbnail,
		 * image, grouping, status, category_id, featured and price
		 * from product db.
		 */
		if (!count($product)){
			// no product so redirect
			redirect( 'fitness'.'/index','refresh');
		}
		$data['product'] = $product;
		$data['title'] = lang('webshop_shop_name')." | ". $product['name'];
		
		// I am not using colors and sizes, but you can. 
		$data['assigned_colors'] = $this->MProducts->getAssignedColors($id);
		$data['assigned_sizes'] = $this->MProducts->getAssignedSizes($id);
		
		$data['page'] = 'fitness/product';
		$data['module'] = 'fitness';
		$this->load->view('fitness/container',$data);
  	}
  

	function pages($path){
	
		if($path=='fitness'){
			redirect('','refresh');
		}elseif($path =='contact_us'){
			redirect('fitness'.'/contact','refresh');
		}elseif($path =='cart'){
		  	redirect('fitness'.'/cart','refresh');
		}elseif($path =='checkout'){
		 	redirect('fitness'.'/checkout','refresh');
		}else{
			$page = $this->MPages->getPagePath($path);
				if (!empty($page)){//$page will return empty array if there is no page
			$data['pagecontent'] = $page;
			$data['title'] = lang('webshop_shop_name')." | ".$page['name'];
				}else{
					// if there is no page redirect
					redirect('fitness'.'/index','refresh');
				}
			$data['page'] = 'fitness/page';
			$data['module'] = 'fitness';
			$this->load->view('fitness/container',$data);
		}
  }
  	
  
  function contact(){
	  	
		$data['title'] = lang('webshop_shop_name')." | "."Contact us";
		$data['cap_img'] = $this->_generate_captcha();	
		$data['page'] = 'fitness/contact';
		$data['module'] = 'fitness';
		$this->load->view('fitness/container',$data);
  	}
  
  
	function _generate_captcha(){
		$this->bep_assets->load_asset('recaptcha');
		$this->load->module_library('recaptcha','Recaptcha');
		return $this->recaptcha->recaptcha_get_html();
	}
  
  
	
  
	function message(){
		
		$rules['name'] = 'trim|required|max_length[32]';
		$rules['email'] = 'trim|required|max_length[254]|valid_email';
		$rules['message'] = 'trim|required';
		$rules['recaptcha_response_field'] = 'trim|required|valid_captcha';
		
		$this->validation->set_rules($rules);
		
		$fields['name']	= lang('general_name');
		$fields['email']	= lang('webshop_email');
		$fields['message']	= lang('message_message');
		$fields['recaptcha_response_field']	= 'Recaptcha';
		
		$this->validation->set_fields($fields);
	    /**
		 * form_validation, next version of Bep will update to form_validation
		 */
		//$this->form_validation->set_rules('name', 'Name', 'required');
		//$this->form_validation->set_rules('email', 'Email',  'required|valid_email');
		//$this->form_validation->set_rules('message', 'Message', 'required');
		//$this->form_validation->set_rules('captcha', 'Captcha', 'required');
	
	
        if ($this->validation->run() == FALSE)
		{
			// if any validation errors, display them
			$this->validation->output_errors();
			
			$captcha_result = '';
			$data['cap_img'] = $this->_generate_captcha();
			
			$data['title'] = lang('webshop_shop_name')." | ". lang('webshop_message_contact_us');
			$data['page'] = 'fitness/contact';
			$data['module'] = 'fitness';
			$this->load->view('fitness/container',$data);
		}
		else
		{
		    // you need to send email
		    // validation has passed. Now send the email
			$name = $this->input->post('name');
			$email = $this->input->post('email');
			$message = $this->input->post('message');
			// get email from preferences/settings
			$myemail = $this->preference->item('admin_email');
			$this->load->library('email');
			$this->email->from($email.$name);
			$this->email->to($myemail);
			$this->email->subject(lang('webshop_message_subject'));		
			$this->email->message(lang('webshop_message_sender'). 
			$name."\r\n".lang('webshop_message_sender_email').": ". 
			$email. "\r\n".lang('webshop_message_message').": " . $message);
			$this->email->send();
			flashMsg('success', lang('webshop_message_thank_for_message'));
		    // $this->session->set_flashdata('subscribe_msg', lang('webshop_message_thank_for_message'));
		    redirect('fitness'.'/contact');
		}  	
  	}  
  
  	
  
	function registration(){
	/* If you are using recaptcha, don't forget to configure modules/recaptcha/config/recaptcha.php
	 * Add your own key
	 * */	
		$captcha_result = '';
		$data['cap_img'] = $this->_generate_captcha();
		
	if ($this->input->post('email')){
		
	 	$data['title'] = lang('webshop_shop_name')." | "."Registration";
		
		// set rules
		$rules['email'] = 'trim|required|matches[emailconf]|valid_email';
		$rules['emailconf'] = 'trim|required|valid_email';
		$rules['password'] = 'trim|required';
		$rules['customer_first_name'] = 'trim|required|min_length[3]|max_length[20]';
		$rules['customer_last_name'] = 'trim|required|min_length[3]|max_length[20]';
		$rules['phone_number'] = 'trim|required|min_length[8]|max_length[12]|numeric';
		$rules['address'] = 'trim|required';
		$rules['city'] = 'trim|required|alpha_dash';
		$rules['post_code'] = 'trim|required|numeric';
		// if you want to use recaptcha, set modules/recaptcha/config and uncomment the following
		$rules['recaptcha_response_field'] = 'trim|required|valid_captcha';
		
		$this->validation->set_rules($rules);
		
		// set fields. This will be used for error messages
		// for example instead of customer_first_name, First Name will be used in errors
		$fields['email']	= lang('webshop_email');
		$fields['emailconf']	= lang('webshop_email_confirm');
		$fields['password']	= lang('webshop_pass_word');
		$fields['customer_first_name']	= lang('webshop_first_name');
		$fields['customer_last_name']	= lang('webshop_last_name');
		$fields['phone_number']	= lang('webshop_mobile_tel');
		$fields['address']	= lang('webshop_shipping_address');
		$fields['city']	= lang('webshop_city');
		$fields['post_code']	= lang('webshop_post_code');
		$fields['recaptcha_response_field']	= 'Recaptcha';
		
		$this->validation->set_fields($fields);
		
		// run validation 
		if ($this->validation->run() == FALSE)
			{	
				// if false outputs errors
				$this->validation->output_errors();
				// and take them to registration page to show errors
				$data['page'] = 'fitness/registration';
				$data['module'] = 'fitness';
				$this->load->view('fitness/container',$data);
			}
			else
			{	
				$e = $this->input->post('email');
				// otherwise check if the customer's email is in the database
				$numrow = $this->MCustomers->checkCustomer($e);
				if ($numrow == TRUE){
					// you have registered before, set the message and redirect to login page.
					flashMsg('info', lang('webshop_registed_before'));
					// $this->session->set_flashdata('msg', lang('webshop_registed_before'));
					redirect( 'fitness'.'/login','refresh');
				}
			// a customer is new, so create the new customer, set message and redirect to login page.
			$this->MCustomers->addCustomer();
			flashMsg('success', lang('webshop_thank_registration'));
			// $this->session->set_flashdata('msg', lang('webshop_thank_registration'));
			redirect( 'fitness'.'/login');
			}
	}// end of if($this->input->post('email'))
		
	$data['title'] = lang('webshop_shop_name')." | ". "Registration";
	$data['page'] = 'fitness/registration';
	$data['module'] = 'fitness';
	$this->load->view('fitness/container',$data);
	
  }

  
	function login(){
		if ($this->input->post('email')){
			$e = $this->input->post('email');
			$pw = $this->input->post('password');
			$this->MCustomers->verifyCustomer($e,$pw);
			if (isset($_SESSION['customer_id'])){
				flashMsg('info',lang('login_logged_in'));
				redirect( 'fitness'.'/login','refresh');
			}
			flashMsg('info',lang('login_email_pw_incorrect'));
			redirect( 'fitness'.'/login','refresh');
		}			
		$data['title'] = lang('webshop_shop_name')." | "."Customer Login";
		$data['page'] = 'fitness/customerlogin';
		$data['module'] = 'fitness';
		$this->load->view('fitness/container',$data);
  }
  
  
	function logout(){
		// this would remove all the variable in the session
		session_unset();

		//destroy the session
		session_destroy(); 
		
		redirect( 'fitness'.'/index','refresh');
	 }
  
  	function subscribe(){
		$data['title']=lang('webshop_shop_name')." | ".'Subscribe to our News letter';
		
		$captcha_result = '';
		$data['cap_img'] = $this->_generate_captcha();
		if ($this->input->post('name')){
			$rules['name'] = 'required';
			$rules['email'] = 'required|valid_email';
			$rules['recaptcha_response_field'] = 'trim|required|valid_captcha';
			
			$this->validation->set_rules($rules);
			
			$fields['email']	= lang('webshop_email');
			$fields['name']	= lang('subscribe_name');
			$fields['recaptcha_response_field']	= 'Recaptcha';
			
			$this->validation->set_fields($fields);
			
					if ($this->validation->run() == FALSE)
					{
						// if false outputs errors
						$this->validation->output_errors();
					}
					else
					{
						$email = $this->input->post('email');
						// otherwise check if the customer's email is in the database
						$numrow = $this->MSubscribers->checkSubscriber($email);
						if ($numrow == TRUE){
						// you have registered before, set the message and redirect to login page.
						flashMsg('info',lang('subscribe_registed_before'));
						redirect( 'fitness'.'/subscribe','refresh');
						}
						$this->MSubscribers->createSubscriber();
						flashMsg('success',lang('subscribe_thank_for_subscription'));
						redirect( 'fitness'.'/subscribe','refresh');
					}	
		}
		$data['page'] = 'fitness/subscribe';
		$data['module'] = 'fitness';
		$this->load->view('fitness/container',$data);
  	}
  

  	function unsubscribe($email=''){
  		if (!$this->input->post('email')){
  			$data['title']=lang('webshop_shop_name')." | ".'Unsubscribe our Newsletter';
  			$captcha_result = '';
			$data['cap_img'] = $this->_generate_captcha();
  			$data['page'] = 'fitness/unsubscribe';
			$data['module'] = 'fitness';
			$this->load->view('fitness/container',$data);
  		}else{
  			
  			$rules['email'] = 'trim|required|max_length[254]|valid_email';
			$rules['recaptcha_response_field'] = 'trim|required|valid_captcha';
			
			$this->validation->set_rules($rules);
			
			$fields['email']	= lang('webshop_email');
			$fields['recaptcha_response_field']	= 'Recaptcha';
			
			$this->validation->set_fields($fields);
  			
			if ($this->validation->run() == FALSE)
					{
						// if false outputs errors
						$this->validation->output_errors();
						redirect( 'fitness'.'/unsubscribe','refresh');
					}
					else
					{
						$email = $this->input->post('email');
						$this->MSubscribers->removeSubscriber($email);
						flashMsg('success',lang('subscribe_you_been_unsubscribed'));
						redirect( 'fitness'.'/index','refresh');
					}
  		}
  	}
  
  
	function cart($productid=0){
		$shippingprice = $this-> shippingprice();
		$data['shippingprice']=$shippingprice['shippingprice'];
		if ($productid > 0){
			$fullproduct = $this->MProducts->getProduct($productid);
			$this->MOrders->updateCart($productid,$fullproduct);
			redirect( 'fitness'.'/product/'.$productid, 'refresh');
		}else{
			$data['title'] = lang('webshop_shop_name')." | ". "Shopping Cart";
		
			if (isset($_SESSION['cart'])){
				$data['page'] = 'fitness/shoppingcart';
				$data['module'] = 'fitness';
				$this->load->view('fitness/container',$data);
			}else{
				flashMsg('info',lang('orders_no_item_yet'));
				// $this->session->set_flashdata('msg',lang('orders_no_item_yet'));
				$data['page'] = 'fitness/shoppingcart';
				$data['module'] = 'fitness';
				$this->load->view('fitness/container',$data);
			}
		}
  }
  

  	function ajax_cart(){
	  	// this is called by assets/js/shopcustomtools.js 
	  	// this is used when a customer click a update button in /index.php/webshop/cart page 
	   	$this->MOrders->updateCartAjax($this->input->post('ids'));
  	}

  
	function ajax_cart_remove(){
		// this is called by assets/js/shopcustomtools.js 
	  	// this is used when a customer click a delete button in /index.php/webshop/cart page
	   	$this->MOrders->removeLineItem($this->input->post('id'));
	}
  
  
  
  	function shippingprice(){
		// You need to modify this. This is for Norwegian system. At the moment, if a max of individual product is more
		// than 268 kr, then shipping price will be 65 kr otherwise 0 kr or 25 kr. 
		$maxprice = 0;
		if(isset($_SESSION['cart'])){
		foreach ($_SESSION['cart'] as $item) {
					    if ($item['price'] > $maxprice) {
					        $maxprice = $item['price'];
					    }
					}
		$data['maxprice']=$maxprice;
		$shippingprice = 0;
		if ($maxprice > 268 ){
			  $shippingprice = 65.0;
		}elseif($maxprice == 0){
			  $shippingprice = 0;
		}else{
			  $shippingprice = 25.0;
		}
		$_SESSION['shippingprice'] = $shippingprice;
		$data['shippingprice']=$shippingprice;
		return $data;
		}
  	}
  
  
  function checkout(){
  	
	// $this->MOrders->verifyCart();
	//$data['main'] = 'webshop/confirmorder';// this is using views/confirmaorder.php
	$data['page'] = 'fitness/confirmorder';
	$data['title'] = lang('webshop_shop_name')." | ". "Order Confirmation";
	
	
	$shippingprice = $this-> shippingprice();
	$data['shippingprice']=$shippingprice['shippingprice'];
	
	$data['grandtotal']= 0;
	
	if(isset($_SESSION['customer_id'])){
		$data['fname'] = $_SESSION['customer_first_name'];
		$data['lname'] = $_SESSION['customer_last_name'];
		$data['telephone'] = $_SESSION['phone_number'];
		$data['email'] = $_SESSION['email'];
		$data['address'] = $_SESSION['address'];
		$data['city'] = $_SESSION['city'];
		$data['pcode'] = $_SESSION['post_code'];
	}
	
	$data['module'] = 'fitness';
	$this->load->view('fitness/container',$data);
  }
  


  function search(){
  	/**
	 * form in views/header.php point to this search
	 * form_open("webshop/search");
	 * This will look in name, shortdesc and longdesc
	 *
	 */
	if ($this->input->post('term')){
	  /**
	   * In CodeIgniter, the way to check for form input is to use the $this - > input - > post() method
	   */
		$data['results'] = $this->MProducts->search($this->input->post('term'));
		/**
		 * This output id,name,shortdesc,thumbnail
		 */
	}else{
		redirect( 'fitness'.'/index','refresh');
		/**
		 * if nothing in search form, then redirect to index
		 */
	}
	//$data['main'] = 'webshop/search';// this is using views/search.php. Output will be displayed in views/search.php
	$data['title'] = lang('webshop_shop_name')." | ". "Search Results";
	
	//$this->load->vars($data);
	//$this->load->view('webshop/template');  
	
	
	$data['page'] = 'fitness/search';
	$data['module'] = 'fitness';
	$this->load->view('fitness/container',$data);
			
  }

	
  
  
  
  function gallery($id){
	$data['title'] = lang('webshop_shop_name')." | ". "Gallery " . $id;
	$data['products'] = $this->MProducts->getGallery($id);
	// getGalleryone returns id, name shortdesc thumbnail image class grouping category
	$data['main'] = 'gallery';// this is using views/galleryone.php etc
	$data['galleriid']=$id; // used for if statement to add top sub-category 
	$this->load->vars($data);
	$this->load->view('webshop/template'); 
  }
  
  
  function emailorder(){
  	
		$data['title'] = lang('webshop_shop_name')." | ". "checkout";
		
		// old way of validation, I hope Bep will update to CI 1.7.2 
		$fields['customerr_first_name'] = lang('orders_first_name');
		$fields['customerr_last_name'] = lang('orders_last_name');
		$fields['telephone'] = lang('orders_mobile_tel');
		$fields['email'] = lang('orders_email');
		$fields['emaildonf'] = lang('orders_email_confirm');
		$fields['shippingaddress'] = lang('orders_shipping_address');
		$fields['city'] = lang('orders_post_code');
		$fields['post_code'] = lang('orders_city');
		
		$this->validation->set_fields($fields);	
		
		$rules['customer_first_name'] = 'trim|required|min_length[3]|max_length[20]';
		$rules['customer_last_name'] = 'trim|required|min_length[3]|max_length[20]';
		$rules['telephone'] = 'trim|required|min_length[8]|max_length[12]|numeric';
		$rules['email'] = 'trim|required|matches[emailconf]|valid_email';
		$rules['emailconf'] = 'trim|required|valid_email';
		$rules['shippingaddress'] = 'required';
		$rules['city'] = 'trim|required';
		$rules['post_code'] = 'trim|required';
		
		$this->validation->set_rules($rules);
		
		$shippingprice = $this-> shippingprice();
		$data['shippingprice']=$shippingprice['shippingprice'];
		
		if ($this->validation->run() == FALSE)
		{
			// $this->session->set_flashdata('msg', 'Please fill all the fields. Please try again!');
				
			// send back to confirmorder. validation error will be displayed automatically

			$this->validation->output_errors();
			$data['page'] = 'fitness/confirmorder';
			$data['module'] = 'fitness';
			$this->load->view('fitness/container',$data);
			}
			else
			{
			/*
			 * If validation is ok, then
			 * 1. enter customer info to db through $this->MOrders->entercustomerinfo();
			 * 2. enter oder info to db through $this->MOrders->enterorderinfo();
			 * 3. enter oder items to db $this->MOrders->enterorderitems();
			 * 4. send email to the customer and me
			 * 5. redirect to ordersuccess page and display thanks message
			 *
			 */
			$totalprice = $_SESSION['totalprice'];
			
			$this->MOrders->enterorder($totalprice);
			
			//Create body of message by cleaning each field and then appending each name and value to it
			
			$body = "<h1>".lang('email_here_is')."</h1><br />";
			$email = db_clean($this->input->post('email'));
			$lastname = db_clean($this->input->post('lname'));
			$firstname = db_clean($this->input->post('fname'));
			$name = $firstname + " " + $lastname;
			
			// $shipping= 65;
			$shipping = $_SESSION['shippingprice'];
			$body .= "<table border='1' cellspacing='0' cellpadding='5' width='80%'><tr><td><b>".lang('email_number_of_order')."</b></td><td><b>".lang('email_product_name')."</b></td><td><b>".lang('email_product_price')."</b></td></tr>";
			if (count($_SESSION['cart'])){
				$count = 1;
				foreach ($_SESSION['cart'] as $PID => $row){
				  
					$body .= "<tr><td><b>". $row['count'] . "</b></td><td><b>" . $row['name'] . "</b></td><td><b>" . $row['price']."</b></td></tr>";
				}
			}
			$grandtotal = (int)$totalprice + $shipping;
			$body .= "<tr><td colspan='2'><b>".lang('orders_sub_total_nor')." </b></td><td colspan='1'><b>".number_format($totalprice,2,'.',','). "</b></td></tr>";
			$body .= "<tr><td colspan='2'><b>".lang('orders_shipping_nor')." </b></td><td colspan='1'><b>". number_format($shipping ,2,'.',',') . "</b></td></tr>";
			$body .= "<tr><td colspan='2'><b>".lang('orders_total_with_shipping')." </b></td><td colspan='1'><b>".number_format($grandtotal,2,'.',','). "</b></td></tr>";
			$body .= "</table><br />";
			
			$body .= "<table border=\"1\" cellspacing='0' cellpadding='5' width='80%'>";
			$body .= "<tr><td><b>".lang('orders_name').": </b></td><td><b>". $_POST['customer_first_name']." ". $_POST['customer_last_name']."</b></td></tr>";
			$body .= "<tr><td><b>".lang('orders_email').": </b></td><td><b>". $_POST['email']. "</b></td></tr>";
			$body .= "<tr><td><b>".lang('orders_mobile_tel').": </b></td><td><b>". $_POST['telephone']. "</b></td></tr>";
			$body .= "<tr><td><b>".lang('orders_shipping_address').": </b></td><td><b>". $_POST['shippingaddress']. "</b></td></tr>";
			$body .= "<tr><td><b>".lang('orders_post_code').": </b></td><td><b>". $_POST['post_code']. "</b></td></tr>";
			$body .= "<tr><td><b>".lang('orders_city').": </b></td><td><b>". $_POST['city']. "</b></td></tr>";
			$body .= "</table>";
			$body .= "<p><b>".lang('email_we_will_call')."</b></p>";
			extract($_POST);
			//removes newlines and returns from $email and $name so they can't smuggle extra email addresses for spammers
			
			$headers = "Content-Type: text/html; charset=UTF-8\n";
			$headers .= "Content-Transfer-Encoding: 8bit\n\n";
			
			//Create header that puts email in From box along with name in parentheses and sends bcc to alternate address
			$from='From: '. $email . "(" . $name . ")" . "\r\n" . 'Bcc: admin@gmail.com' . "\r\n";
			
			
			//Creates intelligible subject line that also shows me where it came from
			$subject = 'webshop.com Order confirmation';
			
			//Sends mail to me, with elements created above
			 mail ('admin@gmail.com', $subject, $body, $headers, $from);
			// Send confirmation email to the customer
			 mail ($email, $subject, $body, $headers, 'post@webshop.com');
	
			// $this->session->set_flashdata('msg', 'Thank you for your order! We will get in touch as soon as possible.');
			redirect('fitness'.'/ordersuccess');
		}
  	}
	
  
  function ordersuccess(){
	
	unset($_SESSION['cart']);
	unset($_SESSION['totalprice']);
	$data['title'] = lang('webshop_shop_name')." | ". "Contact us";
	$data['page'] = 'fitness/ordersuccess';
	$data['module'] = 'fitness';
	$this->load->view('fitness/container',$data);
  }
  
  
  
}//end controller class

?>