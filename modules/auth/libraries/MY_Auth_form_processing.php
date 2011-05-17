<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// not used yet
class MY_Auth_form_processing extends Auth_form_processing
{
	function MY_Auth_form_processing()
	{
            parent::Auth_form_processing();
		
	}

	function fitness_login_form($container)
	{
		// First lets see if they are logged in, if so run action for that user
		if ( is_user() )
		{
			// If they have access to the control panel panel send them there
			if( check('Control Panel',NULL,FALSE))
			{
				redirect($this->CI->config->item('userlib_action_admin_login'),'location');
			}
			// Otherwise run user action
			redirect($this->CI->config->item('userlib_action_login'),'location');
		}

		// Lets see what login methods are allowed and setup the form as so
		switch($this->CI->preference->item('login_field'))
		{
			case 'email':
				$fields['login_field'] = $this->CI->lang->line('userlib_email');
				$rules['login_field']  = 'trim|required|valid_email';
				break;
			case 'username':
				$fields['login_field'] = $this->CI->lang->line('userlib_username');
				$rules['login_field']  = 'trim|required';
				break;

			default:
				$fields['login_field'] = $this->CI->lang->line('userlib_email_username');
				$rules['login_field']  = 'trim|required';
				break;
		}

		// Setup fields
		$fields['password'] = $this->CI->lang->line('userlib_password');
		$fields['recaptcha_response_field'] = $this->CI->lang->line('userlib_captcha');
		$this->CI->validation->set_fields($fields);

		// Set Rules
		// Only run captcha check if needed
		$rules['password'] = 'trim|required';
		if($this->CI->preference->item('use_login_captcha'))
		{
			$rules['recaptcha_response_field'] = 'trim|required|valid_captcha';
		}
		$this->CI->validation->set_rules($rules);

		if ( $this->CI->validation->run() === FALSE )
		{
			// Output any errors
			$this->CI->validation->output_errors();

			// TODO: There must be a better way to do this
			$data['login_field'] = $fields['login_field'];

			// Display page
			$data['header'] = $this->CI->lang->line('userlib_login');
			$data['captcha'] = ($this->CI->preference->item('use_login_captcha')?$this->_generate_captcha():'');
			$data['page'] = $this->CI->config->item('backendpro_template_public') . 'form_login';
			$data['module'] = 'auth';
			$this->CI->load->view($container,$data);

			if($this->CI->session->flashdata('requested_page') != "")
			{
				// Only remember the flashData if there was some in the first place
				$this->CI->session->keep_flashdata('requested_page');
			}
		}
		else
		{
			// Submit form
			$this->_login();
		}
	}

}
/* End of file Auth_form_processing.php */
/* Location: ./modules/auth/libraries/Auth_form_processing.php */