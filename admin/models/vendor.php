<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

class DdcshopboxModelsVendor extends JModelForm
{
	var $form    		  = null;
	var $_user_id 		  = null;

	function __construct()
	{

		parent::__construct();
	}
	
	public function getData()
	{
		if ($this->data === null)
		{
			$this->data = new stdClass;
			$app = JFactory::getApplication();
			$params = JComponentHelper::getParams('com_ddcshopbox');
	
			// Override the base user data with any data in the session.
			$temp = (array) $app->getUserState('com_ddcshopbox.vendor.data', array());
			foreach ($temp as $k => $v)
			{
				$this->data->$k = $v;
			}
	
		}
		return $this->data;
	}
	
	/**
	 * Method to get the package form.
	 *
	 * The base form is loaded from XML and then an event is fired
	 * for users plugins to extend the form with extra fields.
	 *
	 * @param   array    $data      An optional array of data for the form to interogate.
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
	 *
	 * @return  JForm  A JForm object on success, false on failure
	 *
	 * @since   1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_ddcshopbox.vendor', 'vendor', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form))
		{
			return false;
		}
	
		return $form;
	}
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_ddcshopbox.vendor.data', array());
		if (empty($data))
		{
			$jinput = JFactory::getApplication()->input;
			$task = $jinput->get('task', "", 'STR' );
			if($task != 'vendor.add')
			{
				$vendorModel = new DdcshopboxModelsVendors();
				$data = $vendorModel->getItem();
				$contact_numbers = json_decode($data->contact_numbers, true);
				$data->contact_tel = $contact_numbers['contact_tel'];
				$shop_details = json_decode($data->vendor_details, true);
				$data->day_1_open = $shop_details['day_1_open'];
				$data->day_1_open_time = $shop_details['day_1_open_time'];
				$data->day_1_close_time = $shop_details['day_1_close_time'];
				$data->day_2_open = $shop_details['day_2_open'];
				$data->day_2_open_time = $shop_details['day_2_open_time'];
				$data->day_2_close_time = $shop_details['day_2_close_time'];
				$data->day_3_open = $shop_details['day_3_open'];
				$data->day_3_open_time = $shop_details['day_3_open_time'];
				$data->day_3_close_time = $shop_details['day_3_close_time'];
				$data->day_4_open = $shop_details['day_4_open'];
				$data->day_4_open_time = $shop_details['day_4_open_time'];
				$data->day_4_close_time = $shop_details['day_4_close_time'];
				$data->day_5_open = $shop_details['day_5_open'];
				$data->day_5_open_time = $shop_details['day_5_open_time'];
				$data->day_5_close_time = $shop_details['day_5_close_time'];
				$data->day_6_open = $shop_details['day_6_open'];
				$data->day_6_open_time = $shop_details['day_6_open_time'];
				$data->day_6_close_time = $shop_details['day_6_close_time'];
				$data->day_7_open = $shop_details['day_7_open'];
				$data->day_7_open_time = $shop_details['day_7_open_time'];
				$data->day_7_close_time = $shop_details['day_7_close_time'];
				$data->social_site_1 = $shop_details['social_site_1'];
				$data->social_url_1 = $shop_details['social_url_1'];
				
				return $data;
			}
		}
	}

	public function getInput()
	{
		parent::__construct();
	}

}
	