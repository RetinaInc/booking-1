<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BackendPro
 *
 * A website backend system for developers for PHP 4.3.2 or newer
 *
 * @package         BackendPro
 * @author          Adam Price
 * @copyright       Copyright (c) 2008
 * @license         http://www.gnu.org/licenses/lgpl.html
 * @link            http://www.kaydoo.co.uk/projects/backendpro
 * @filesource
 */

// ---------------------------------------------------------------------------

/**
 * Public_Controller
 *
 * Extends the Site_Controller class so I can declare special Public controllers
 *
 * @package        BackendPro
 * @subpackage     Controllers
 */
class Fitness_Controller extends Site_Controller
{
	function Fitness_Controller()
	{
		parent::Site_Controller();

		// Set container variable
		$this->_container = "fitness/container.php";

		// Set public meta tags
		//$this->bep_site->set_metatag('name','content',TRUE/FALSE);

                // Load the PUBLIC asset group in bep_assets.php
		$this->bep_assets->load_asset_group('FITNESS');

		// Load the PUBLIC asset group
		$this->bep_assets->load_asset_group('PUBLIC');

		log_message('debug','BackendPro : Public_Controller class loaded');
	}
}

/* End of Public_controller.php */
/* Location: ./system/application/libraries/Public_controller.php */