<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxModelsVendors extends DdcshopboxModelsDefault
{
 
    //Define class level variables
  	var $_user_id     = null;
  	var $_vendor_id  = null;
  	var $_cat_id	  = null;
  	var $_published   = 1;

  function __construct()
  {

    $app = JFactory::getApplication();

    $this->_vendor_id = $app->input->get('vendor_id', null);

    parent::__construct();       
  }
 

  protected function _buildQuery()
  {
    $db = JFactory::getDBO();
    $query = $db->getQuery(TRUE);

    $query->select('v.*');
    $query->select('u.name as owner_name');
    $query->from('#__ddc_vendors as v');
    $query->leftJoin('#__users as u on v.owner = u.id');
    $query->group("v.ddc_vendor_id");


    return $query;
  }

  protected function _buildWhere(&$query)
  {
    if($this->_vendor_id!=null)
    {
    	$query->where('v.ddc_vendor_id = "'. (int)$this->_vendor_id .'"');
    }
        
    return $query;
  }
  
	public function store($formdata = null)
 	{
  		$formdata = $formdata ? $formdata : JRequest::getVar('jform', array(), 'post', 'array');
  		
  		if($formdata['alias'] == null)
  		{
  			$formdata['alias'] = JFilterOutput::stringURLSafe($formdata['title']);
  		}
  		$contact_numbers = array(
  				'contact_tel' => $formdata['contact_tel']
  		);
  		$formdata['contact_numbers'] = json_encode($contact_numbers);
  		$shop_details = array(
  				'day_1_open' => $formdata['day_1_open'],
  				'day_1_open_time' => $formdata['day_1_open_time'],
  				'day_1_close_time' => $formdata['day_1_close_time'],
  				'day_2_open' => $formdata['day_2_open'],
  				'day_2_open_time' => $formdata['day_2_open_time'],
  				'day_2_close_time' => $formdata['day_2_close_time'],
  				'day_3_open' => $formdata['day_3_open'],
  				'day_3_open_time' => $formdata['day_3_open_time'],
  				'day_3_close_time' => $formdata['day_3_close_time'],
  				'day_4_open' => $formdata['day_4_open'],
  				'day_4_open_time' => $formdata['day_4_open_time'],
  				'day_4_close_time' => $formdata['day_4_close_time'],
  				'day_5_open' => $formdata['day_5_open'],
  				'day_5_open_time' => $formdata['day_5_open_time'],
  				'day_5_close_time' => $formdata['day_5_close_time'],
  				'day_6_open' => $formdata['day_6_open'],
  				'day_6_open_time' => $formdata['day_6_open_time'],
  				'day_6_close_time' => $formdata['day_6_close_time'],
  				'day_0_open' => $formdata['day_0_open'],
  				'day_0_open_time' => $formdata['day_0_open_time'],
  				'day_0_close_time' => $formdata['day_0_close_time'],
  				'social_site_1' => $formdata['social_site_1'],
  				'social_url_1' => $formdata['social_url_1']
  		);
  		$formdata['vendor_details'] = json_encode($shop_details);
  		
  		return parent::store($formdata);
  	}
  
  
}