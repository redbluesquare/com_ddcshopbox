<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxModelsVendors extends DdcshopboxModelsDefault
{
 
    //Define class level variables
  	var $_user_id     	= null;
  	var $_vendor_id  	= null;
  	var $_localonly	  	= null;
  	var $_session	  	= null;
  	var $_mypostcode 	= null;
  	var $_ddclocation	= null;
  	var $_published   	= 1;
  	var $_vendor_auth 	= 0;

  function __construct()
  {

    $app = JFactory::getApplication();
	$this->_session = JFactory::getSession();
    $this->_vendor_id = $app->input->get('vendor_id', null);
    $this->_ddclocation = $app->input->get('ddclocation', $this->_session->get('ddclocation',null));
    $this->_localonly = $app->input->get('localonly', null);
  	if($this->isValidPostCodeFormat($this->_ddclocation))
    {
    	$this->_ddclocation = $this->getDistrict($this->_ddclocation);
    }
    $layoutName = $app->input->getWord('layout', 'default');
    if($layoutName=='edit')
    {
    	$this->_vendor_auth = 1;
    }
    
    $this->_user_id = JFactory::getUser()->id;
    parent::__construct();       
  }
 

  protected function _buildQuery()
  {
    $db = JFactory::getDBO();
    $query = $db->getQuery(TRUE);

    $query->select('v.*');
    $query->select('o.*');
    $query->select('u.name as owner_name');
    $query->select('uv.user_id');
    $query->select('((ACOS(SIN(o2.latitude* PI() / 180) * SIN(o.latitude* PI() / 180) + COS(o2.latitude* PI() / 180) * COS(o.latitude* PI() / 180) 
    		* COS((o2.longitude-o.longitude) *PI() /180)) * 180 / PI()) * 60 * 1.1515*1.64) as distance');
    $query->select('cou.country_name');
    $query->from('#__ddc_vendors as v');
    $query->leftJoin('#__ddc_outcodes as o2 on o2.postcode = "'.$this->getDistrict($this->_session->get('ddclocation',null)).'"');
    $query->leftJoin('#__ddc_outcodes as o on o.postcode = LEFT(v.post_code,INSTR(v.post_code," ")-1)');
    $query->leftJoin('#__users as u on v.owner = u.id');
    $query->leftJoin('#__ddc_user_vendor as uv on v.ddc_vendor_id = uv.vendor_id');
    $query->leftJoin('#__ddc_countries as cou on v.country = cou.ddc_country_id');
    $query->group("v.ddc_vendor_id");
    $query->order('distance ASC, v.hits desc');

    return $query;
  }

  protected function _buildWhere(&$query)
  {
    if($this->_vendor_id!=null)
    {
    	$query->where('v.ddc_vendor_id = "'. (int)$this->_vendor_id .'"');
    }
    if($this->_localonly == true)
    {
    	$query->where('v.post_code LIKE "%'.$this->_ddclocation.'%" OR v.city LIKE "%'.$this->_ddclocation.'%"');
    }
    if($this->_vendor_auth==1)
    {
    	$query->where('uv.user_id = "'. (int)$this->_user_id .'"');
    }
    if($this->_published!=null)
    {
    	$query->where('v.state = "'. (int)$this->_published .'"');
    }   
    return $query;
  }
  
  public function hit($pk)
  {
  	$hitcount = new JInput();
  	$hitcount->getInt('hitcount', 1);
  	if ($hitcount)
  	{
  		// Initialise variables.
  		$db = JFactory::getDBO();
  		$db->setQuery( 'UPDATE #__ddc_vendors SET hits = hits + 1 WHERE ddc_vendor_id = '.(int) $pk );
  		if (!$db->query()) {
  			$this->setError($db->getErrorMsg());
  			return false;
  		}
  	}
  	return true;
  }
  
  public function getVendorDistance($vendor_pc )
  {
  	$ddcloc = $this->_session->get('ddclocation',null);
  	if($ddcloc!=null)
  	{
  		$oc = new DdcshopboxModelsDdcoutcodes();
  		$mypc = $oc->getItem($ddcloc);
  		$shoppc = $oc->getItem($vendor_pc);
  		echo '<pre>';
  		print_r($mypc);
  		echo '</pre>';
  		
  		echo '<pre>';
  		print_r($shoppc);
  		echo '</pre>';
  		
  		$dist = $this->haversineGreatCircleDistance($mypc->latitude, $mypc->longitude, $shoppc->latitude, $shoppc->longitude);
  		echo number_format($dist/1000,3);
  	}
  }
  
  public function store($formdata = null)
  {
  	$formdata = $formdata ? $formdata : JRequest::getVar('jform', array(), 'post', 'array');
  	var_dump( $formdata['alias'] );
  	if($formdata['alias'] == null)
  	{
  		$formdata['alias'] = JFilterOutput::stringURLSafe($formdata['title']);
  	}
  	 
  	return parent::store($formdata);
  }
  
}