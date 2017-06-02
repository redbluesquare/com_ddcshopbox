<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxModelsImages extends DdcshopboxModelsDefault
{
 
    //Define class level variables
  	var $_user_id     	= null;
  	var $_image_id  	= null;
  	var $_vendor_id  	= null;
  	var $_cat_id	  	= null;
  	var $_session	  	= null;
  	var $_app			= null;
  	var $_published   = 1;

  function __construct()
  {

    $this->_app = JFactory::getApplication();
	$this->_session = JFactory::getSession();

    //If no User ID is set to current logged in user
    $this->_user_id = $this->_app->input->get('profile_id', JFactory::getUser()->id);
    $this->_image_id = $this->_app->input->get('image_id', null);
    $this->_vendor_id = $this->_app->input->get('vendor_id', null);

    parent::__construct();       
  }
 

  protected function _buildQuery()
  {
    $db = JFactory::getDBO();
    $query = $db->getQuery(TRUE);

    $query->select('i.*');
    $query->from('#__ddc_images as i');
    $query->group("p.ddc_image_id");


    return $query;
  }

  protected function _buildWhere(&$query,$id=null)
  {
  	if($this->_vendor_id!=null)
  	{
  		$query->where('p.vendor_id = "'. (int)$this->_vendor_id .'"');
  	}
  	if($this->_image_id!=null)
  	{
  		$query->where('i.ddc_image_id = "'. (int)$this->_image_id .'"');
  	}
  	if(($id!=null) And ($id > 0))
  	{
  		$query->where('p.ddc_image_id = "'. (int)$id .'"');
  	}   
    return $query;
  }
  
  public function store($formdata = null)
  {
  	$formdata = $formdata ? $formdata : $this->_app->input->get('jform', array(),'array');

  	$data = array(
  		'ddc_image_id'=>$formdata['ddc_image_id'],
  		'link_table' => $formdata['link_table'],
  		'link_id' => $formdata['link_id'],
  		'image_link' => $formdata['image_link'],
  		//'details' => $formdata['details'],
  		'state' => $formdata['state'],
  		'table' => 'images'
  	);
  	
  	return parent::store($data);
  }

}