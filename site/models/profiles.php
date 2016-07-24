<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxModelsProfiles extends DdcshopboxModelsDefault
{
 
    //Define class level variables
  	var $_user_id     = null;
  	var $_cat_id	  = null;
  	var $_published   = 1;

  function __construct()
  {

    $app = JFactory::getApplication();
    $jinput = JFactory::getApplication()->input;
    $this->data = $jinput->get('jform', array(),'array');

    //If no User ID is set to current logged in user
    $this->_user_id = $app->input->get('profile_id', JFactory::getUser()->id);

    parent::__construct();       
  }


  protected function _buildQuery()
  {
  	$this->db = JFactory::getDBO();
  	$query = $this->db->getQuery(TRUE);

    $query->select('u.id, u.username, u.email, u.registerDate');
    $query->from('#__users as u');

    $query->select('cd.name, cd.address, cd.telephone, cd.suburb, cd.postcode, cd.id as contact_id');
    $query->leftjoin('#__contact_details as cd on cd.user_id = u.id');
    $query->group("u.id");
    
    return $query;
  }

  protected function _buildWhere($query)
  {
    if($this->_user_id != null)
    {
    	$query->where('u.id = "'.(int)$this->_user_id.'"');
    }
        
    return $query;
  }
  
  public function saveAddress()
  {
  	$id = $this->data['contact_id'];
  	$address = $this->data['address'];
  	$suburb = $this->data['suburb'];
  	$state = $this->data['state'];
  	$postcode = $this->data['postcode'];
  	$country = $this->data['country'];
  	$telephone = $this->data['telephone'];
  	$mobile = $this->data['mobile'];
  	
  	$this->db = JFactory::getDBO();
  	$query = $this->db->getQuery(TRUE);
  	// Fields to update.
  	$fields = array(
  			$this->db->quoteName('address') .' = "'.$address. '"',
  			$this->db->quoteName('suburb') . ' = "'.$suburb. '" ',
  			$this->db->quoteName('state') . ' = "'.$state. '" ',
  			$this->db->quoteName('postcode') . ' = "'.$postcode. '" ',
  			$this->db->quoteName('country') . ' = "'.$country. '" ',
  			$this->db->quoteName('telephone') . ' = "'.$telephone. '" ',
  			$this->db->quoteName('mobile') . ' = "'.$mobile.'"'
  	);
  	
  	// Conditions for which records should be updated.
  	$conditions = array(
  			$this->db->quoteName('id') . ' = '.(int)$id
  	);
  	
  	$query->update($this->db->quoteName('#__contact_details'))->set($fields)->where($conditions);
  	$this->db->setQuery($query);
  	$result = $this->db->execute();
  	
  	return $result;
  }

}