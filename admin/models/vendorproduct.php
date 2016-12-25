<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

class DdcshopboxModelsVendorproduct extends JModelForm
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
			$temp = (array) $app->getUserState('com_ddcshopbox.vendorproduct.data', array());
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
		$form = $this->loadForm('com_ddcshopbox.vendorproduct', 'vendorproduct', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form))
		{
			return false;
		}
	
		return $form;
	}
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_ddcshopbox.vendorproduct.data', array());
		if (empty($data))
		{
			$jinput = JFactory::getApplication()->input;
			$task = $jinput->get('task', "", 'STR' );
			if($task != 'vendorproduct.add')
			{
				$vproductModel = new DdcshopboxModelsVendorproducts();
				$data = $vproductModel->getItem();
				$prod_params = json_decode($data->product_params, true);
				$data->min_order_level = $prod_params['min_order_level'];
				$data->max_order_level = $prod_params['max_order_level'];
				$data->step_order_level = $prod_params['step_order_level'];
				$data->product_box = $prod_params['product_box'];
				return $data;
			}
		}
	}

	public function getInput()
	{
		parent::__construct();
	}

}
	