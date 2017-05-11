<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxModelsUservendorinterests extends DdcshopboxModelsDefault
{
 
    //Define class level variables
  	var $_user_id					= null;
  	var $_app					= null;
  	var $_vendor_id					= null;
  	var $_user_vendor_interest_id	= null;
  	var $_cat_id					= null;
  	var $_published					= 1;

  function __construct()
  {

    $this->_app = JFactory::getApplication();

    $this->_user_vendor_interest_id = $this->_app->input->get('uservendorinterest_id', null);
    $this->_user_id = JFactory::getUser()->id;
    $this->_vendor_id = $this->_app->input->get('vendor_id', null);

    parent::__construct();       
  }
 

  protected function _buildQuery()
  {
    $db = JFactory::getDBO();
    $query = $db->getQuery(TRUE);
	$query->select('uvi.*');
    $query->from('#__ddc_user_vendor_interests as uvi');
    $query->group("uvi.ddc_user_vendor_interest_id");

    return $query;
  }

  protected function _buildWhere(&$query,$id, $user_id)
  {
    if($this->_user_vendor_interest_id!=null)
    {
    	$query->where('uvi.ddc_user_vendor_interest_id = "'. (int)$this->_user_vendor_interest_id .'"');
    }
    if($user_id != null)
    {
    	$query->where('uvi.user_id = "'. (int)$user_id .'"');
    }
    if($id != null)
    {
    	$query->where('uvi.ddc_vendor = "'. (int)$id .'"');
    }
    return $query;
  }

  public function checkUserVendorInterests($vendor_id = null)
  {
  	//get User IP address
  	$ip = JFactory::getApplication()->input->server->get('REMOTE_ADDR');

  	
  	//get user id
  	$user_id = JFactory::getUser()->id;
	
  	$uvResult = $this->listItems($vendor_id,$user_id);
  	$result = false;
  	if(count($uvResult)>0)
  	{
  		if($user_id==0)
  		{
  			$result = false;
  			$check = true;
  		}else{
  			$check = false;
  		}
  		$i = 0;
  		while(!$check)
  		{
  			//check if vendor is set
  			if((int)$uvResult[$i]->ddc_vendor == (int)$vendor_id)
  			{
  				$result = true;
  				$check = true;
  			}
  			$i++;
  			if(count($uvResult) <= $i)
  			{
  				$check = true;
  			}
  		}
  	}
  	return $result;
  }
  
  public function store($formdata = null)
  {
  	$formdata = $formdata ? $formdata : JRequest::getVar('jform', array(), 'post', 'array');
  	$profile = new DdcshopboxModelsProfiles();
  	$profile = $profile->getItem(JFactory::getUser()->id);
  	$data = array(
  			'ddc_vendor' => $formdata['vendor_id'],
  			'user_id' => JFactory::getUser()->id,
  			'firstname' => $profile->first_name,
  			'lastname' => $profile->last_name,
  			'email_to' => $profile->email,
  			'town' => $profile->city,
  			'ip_address' => JFactory::getApplication()->input->server->get('REMOTE_ADDR'),
  			'comment' => $formdata['comment'],
  			'state' => 1,
  			'table' => $formdata['table']);
  	 
  	return parent::store($data);
  }
}