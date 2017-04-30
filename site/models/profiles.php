<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxModelsProfiles extends DdcshopboxModelsDefault
{
 
    //Define class level variables
  	var $_user_id		= null;
  	var $_cat_id		= null;
  	var $_published		= 1;
  	var $_data			= null;

  function __construct()
  {

    $app = JFactory::getApplication();
    $jinput = JFactory::getApplication()->input;
    $this->_data = $jinput->get('jform', array(),'array');

    //If no User ID is set to current logged in user
    $this->_user_id = JFactory::getUser()->id;

    parent::__construct();       
  }


  protected function _buildQuery()
  {
  	$this->db = JFactory::getDBO();
  	$query = $this->db->getQuery(TRUE);

    $query->select('u.id, u.username, u.email, u.registerDate');
    $query->select('ui.*');
    $query->from('#__users as u');
    $query->leftjoin('#__ddc_userinfos as ui on ui.user_id = u.id');
    $query->group("u.id");
    
    return $query;
  }

  protected function _buildWhere($query)
  {

    $query->where('u.id = "'.(int)$this->_user_id.'"');
        
    return $query;
  }
  
  
  public function store($formdata = null)
  {
  	$formdata = array(
  			'ddc_userinfo_id' => $this->_data['ddc_userinfo_id'],
  			'user_id' => (int)$this->_user_id,
  			'vendor_id' => (int)$this->_data['vendor_id'],
  			'company' => $this->_data['company'],
  			'title' => $this->_data['title'],
  			'first_name' => $this->_data['first_name'],
  			'middle_name' => $this->_data['middle_name'],
  			'last_name' => $this->_data['last_name'],
  			'address_type' => $this->_data['address_type'],
  			'address_type_name' => $this->_data['address_type_name'],
  			'address_1' => $this->_data['address_1'],
  			'address_2' => $this->_data['address_2'],
  			'city' => $this->_data['city'],
  			'county' => $this->_data['county'],
  			'zip' => $this->_data['zip'],
  			'country_id' => $this->_data['country_id'],
  			'phone_1' => $this->_data['phone_1'],
  			'phone_2' => $this->_data['phone_2'],
  			'fax' => $this->_data['fax'],
  			'agreed' => $this->_data['agreed'],
  			'tos' => $this->_data['tos'],
  			'table' => 'profiles',
  			'customer_note' => $this->_data['customer_note']
  	);
  	
  	return parent::store($formdata);
  }

}