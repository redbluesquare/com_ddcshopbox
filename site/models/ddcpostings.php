<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxModelsDdcpostings extends DdcshopboxModelsDefault
{
 
    //Define class level variables
  	var $_user_id     = null;
  	var $_review_id  = null;
  	var $_vendor_id  = null;
  	var $_cat_id	  = null;
  	var $_published   = 1;

  function __construct()
  {

    $app = JFactory::getApplication();

    //If no User ID is set to current logged in user
    $this->_user_id = $app->input->get('profile_id', JFactory::getUser()->id);
    $this->_product_id = $app->input->get('product_id', null);
    $this->_posting_id = $app->input->get('ddcposting_id', null);
    $this->_vendor_id = $app->input->get('vendor_id', null);

    parent::__construct();       
  }
 

  protected function _buildQuery()
  {
    $db = JFactory::getDBO();
    $query = $db->getQuery(TRUE);

    $query->select('p.*');
    $query->from('#__ddc_postings as p');
    $query->leftJoin('#__ddc_user_vendor as uv on uv.vendor_id = p.vendor_id');
    $query->group("p.ddc_posting_id");
    $query->order("p.state asc");

    return $query;
  }

  protected function _buildWhere(&$query,$id=null)
  {
  	if($this->_vendor_id!=null)
  	{
  		$query->where('p.vendor_id = "'. (int)$this->_vendor_id .'"');
  	}
  	if($this->_posting_id!=null)
  	{
  		$query->where('p.ddc_posting_id = "'. (int)$this->_product_id .'"');
  	}
  	if($id!=null)
  	{
  		$query->where('p.ddc_product_id = "'. (int)$id .'"');
  	}
  	if($this->_user_id!=0)
  	{
  		$query->where('((p.state = 0) Or (p.state = '.(int)$this->_published.'))');
  		$query->where('uv.user_id = "'. (int)$this->_user_id .'"');
  	}
  	else 
  	{
  		$query->where('p.state = "1"');
  	}
        
    return $query;
  }
  
  public function store($formdata = null)
  {
  	$formdata = $formdata ? $formdata : JRequest::getVar('jform', array(), 'post', 'array');
  	if(($formdata['state']==1) ||($formdata['state']==-2)):
  		$data = array(
  			'ddc_posting_id'=>$formdata['ddc_posting_id'],
  			'state' => $formdata['state'],
  			'table' => 'ddcpostings');
  	else:
	  	$data = array(
	  		'ddc_posting_id'=>$formdata['ddc_posting_id'],
	  		'message' => $formdata['message'],
	  		'vendor_id' => $formdata['vendor_id'],
	  		'lastip' => $_SERVER['REMOTE_ADDR'],
	  		'state' => $formdata['state'],
	  		'table' => 'ddcpostings');
  	endif;
  	return parent::store($data);
  }

}