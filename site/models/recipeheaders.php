<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxModelsRecipeheaders extends DdcshopboxModelsDefault
{
 
	//Define class level variables
	var $_user_id     				= null;
	var $_app		  				= null;
	var $_data						= null;
	var $_cat_id	  				= null;
	var $_session					= null;
	var $_recipe_header_id			= null;
	var $_recipe_detail_id			= null;
	var $_published   				= 1;

	function __construct()
	{
		$this->_app = JFactory::getApplication();
		$this->_session = JFactory::getSession();
		$this->_recipe_header_id = $this->_app->input->get('recipeid',null);
		$this->_cat_id = $this->_app->input->get('catid',null);
		$this->_data = $this->_app->input->get('jform', array(),'array');
		parent::__construct();       
	}

	protected function _buildQuery()
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(TRUE);
		$query->select('rh.*');
		$query->select('i.*');
		$query->from('#__ddc_recipe_headers as rh');
		$query->leftJoin('#__ddc_images as i on (i.link_id = rh.ddc_recipe_header_id) AND (i.linked_table = "ddc_recipe")');
		$query->group('rh.ddc_recipe_header_id');
		return $query;
	}

	protected function _buildWhere(&$query)
	{
		if($this->_recipe_header_id!=null)
		{
			$query->where('rh.ddc_recipe_header_id = "'. (int)$this->_recipe_header_id .'"');
		}
		if($this->_cat_id!=null)
		{
			$query->where('rh.catid = "'. (int)$this->_cat_id .'"');
		}
		return $query;
	}
  
	public function store($formdata = null)
 	{
  		$formdata = $formdata ? $formdata : $this->_data;
  		if($formdata['alias'] == null)
  		{
  			$formdata['alias'] = JFilterOutput::stringURLSafe($formdata['title']);
  		}
  		$data = array(
  				'ddc_recipe_header_id'=>$formdata['ddc_recipe_header_id'],
  				'title' => $formdata['title'],
  				'alias' => $formdata['alias'],
  				'description' => $formdata['description'],
  				'prep_time' => $formdata['prep_time'],
  				'cook_time' => $formdata['cook_time'],
  				'serving_qty' => $formdata['serving_qty'],
  				'method' => $formdata['method'],
  				'author' => $formdata['author'],
  				'author_id' => $this->_user_id,
  				'catid' => $formdata['catid'],
  				'state' => $formdata['state'],
  				'table' => 'recipeheaders');
  		
  		return parent::store($data);
  	}
}