<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

class DdcshopboxModelsPaymentmethod extends JModelForm
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
			$temp = (array) $app->getUserState('com_ddcshopbox.paymentmethod.data', array());
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
		$form = $this->loadForm('com_ddcshopbox.paymentmethod', 'paymentmethod', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form))
		{
			return false;
		}
	
		return $form;
	}
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_ddcshopbox.paymentmethod.data', array());
		if (empty($data))
		{
			$jinput = JFactory::getApplication()->input;
			$task = $jinput->get('task', "", 'STR' );
			if($task != 'paymentmethod.add')
			{
				$pmethodModel = new DdcshopboxModelsPaymentmethods();
				$data = $pmethodModel->getItem();
				
				$formdata = json_decode($data->payment_params, true);
				$data->paymentmethod_mode = $formdata['paymentmethod_mode'];
				$data->test_api_key = $formdata['test_api_key'];
				$data->test_api_secret = $formdata['test_api_secret'];
				$data->test_paymentmethod_url = $formdata['test_paymentmethod_url'];
				$data->test_paymentmethod_url_success = $formdata['test_paymentmethod_url_success'];
				$data->test_paymentmethod_url_failure = $formdata['test_paymentmethod_url_cancel'];
				$data->api_key = $formdata['api_key'];
				$data->api_secret = $formdata['api_secret'];
				$data->paymentmethod_url = $formdata['paymentmethod_url'];
				$data->paymentmethod_url_success = $formdata['paymentmethod_url_success'];
				$data->paymentmethod_url_failure = $formdata['paymentmethod_url_cancel'];
				$data->paymentmethod_logo = $formdata['paymentmethod_logo'];
				
				return $data;
			}
		}
	}

	public function getInput()
	{
		parent::__construct();
	}

}
	