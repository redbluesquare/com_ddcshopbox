<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxModelsDefault extends JModelBase
{
  protected $__state_set  = null;
  protected $_total       = null;
  protected $_pagination  = null;
  protected $_db          = null;
  protected $id           = null;
  protected $catid        = null;
  protected $limitstart   = 0;
  protected $limit        = 100;
  protected $session	  = null;
 
  function __construct()
  {
  	parent::__construct();
  	$this->_db = JFactory::getDBO();
  	
  	$app = JFactory::getApplication();
  	$ids = $app->input->get("cids",null,'array');
  	
  	$this->session = JFactory::getSession();
  	
  	$id = $app->input->get("id");
  	if ( $id && $id > 0 ){
  		$this->id = $id;
  	}else if ( count($ids) == 1 ){
  		$this->id = $ids[0];
  	}else{
  		$this->id = $ids;
  	}
  
  }
  public function store($data=null)
  {
  	$data = $data ? $data : JRequest::getVar('jform', array(), 'post', 'array');
  	$row = JTable::getInstance($data['table'],'Table');
  
  	$date = date("Y-m-d H:i:s");
  	
  	// Bind the form fields to the table
  	if (!$row->bind($data))
  	{
  		return false;
  	}
  
  	$row->modified_on = $date;
  	if ( !$row->created_on )
  	{
  		$row->created_on = $date;
  	}
  
  	// Make sure the record is valid
  	if (!$row->check())
  	{
  		return false;
  	}
  
  	if (!$row->store())
  	{
  		return false;
  	}
  	return $row;
  
  }
  
  /**
   * Modifies a property of the object, creating it if it does not already exist.
   *
   * @param   string  $property  The name of the property.
   * @param   mixed   $value     The value of the property to set.
   *
   * @return  mixed  Previous value of the property.
   *
   * @since   11.1
   */
  public function set($property, $value = null)
  {
  	$previous = isset($this->$property) ? $this->$property : null;
  	$this->$property = $value;
  
  	return $previous;
  }
  
  public function get($property, $default = null)
  {
  	return isset($this->$property) ? $this->$property : $default;
  }
  
  /**
   * Build a query, where clause and return an object
   *
   */
  public function getItem($id=null)
  {
  	$db = JFactory::getDBO();
  
  	$query = $this->_buildQuery();
  	$this->_buildWhere($query,$id);
  	$db->setQuery($query);
  
  	$item = $db->loadObject();
  	return $item;
  }
  
  /**
   * Build query and where for protected _getList function and return a list
   *
   * @return array An array of results.
   */
  public function listItems()
  {
  	$query = $this->_buildQuery();
  	$this->_buildWhere($query);
  
  	$list = $this->_getList($query, $this->limitstart, $this->limit);
  	return $list;
  }
  
  /**
   * Gets an array of objects from the results of database query.
   *
   * @param   string   $query       The query.
   * @param   integer  $limitstart  Offset.
   * @param   integer  $limit       The number of records.
   *
   * @return  array  An array of results.
   *
   * @since   11.1
   */
  protected function _getList($query, $limitstart = 0, $limit = 0)
  {
  	$db = JFactory::getDBO();
  	$db->setQuery($query, $limitstart, $limit);
  	$result = $db->loadObjectList();
  
  	return $result;
  }
  
  /**
   * Returns a record count for the query
   *
   * @param   string  $query  The query.
   *
   * @return  integer  Number of rows for query
   *
   * @since   11.1
   */
  protected function _getListCount($query)
  {
  	$db = JFactory::getDBO();
  	$db->setQuery($query);
  	$db->query();
  
  	return $db->getNumRows();
  }
  
  /* Method to get model state variables
   *
  * @param   string  $property  Optional parameter name
  * @param   mixed   $default   Optional default value
  *
  * @return  object  The property where specified, the state object where omitted
  *
  * @since   11.1
  */
  public function getState($property = null, $default = null)
  {
  	if (!$this->__state_set)
  	{
  		// Protected method to auto-populate the model state.
  		$this->populateState();
  
  		// Set the model state set flag to true.
  		$this->__state_set = true;
  	}
  
  	return $property === null ? $this->state : $this->state->get($property, $default);
  }
  
  /**
   * Get total number of rows for pagination
   */
  function getTotal()
  {
  	if ( empty ( $this->_total ) )
  	{
  		$query = $this->_buildQuery();
  		$this->_total = $this->_getListCount($query);
  	}
  
  	return $this->_total;
  }
  
  /**
   * Generate pagination
   */
  function getPagination()
  {
  	// Lets load the content if it doesn't already exist
  	if (empty($this->_pagination))
  	{
  		$this->_pagination = new JPagination( $this->getTotal(), $this->getState($this->_view.'_limitstart'), $this->getState($this->_view.'_limit'),null,JRoute::_('index.php?view='.$this->_view.'&layout='.$this->_layout));
  	}
  
  	return $this->_pagination;
  }
  function dateDiff($start, $end) {
  	$start_ts = strtotime($start);
  	$end_ts = strtotime($end);
  	$diff = $end_ts - $start_ts;
  	return round($diff / 86400);
  }
  /**
   * Method to auto-populate the model state.
   *
   * This method should only be called once per instantiation and is designed
   * to be called on the first call to the getState() method unless the model
   * configuration flag to ignore the request is set.
   *
   * @return  void
   *
   * @note    Calling getState in this method will result in recursion.
   * @since   12.2
   */
  protected function populateState()
  {
  }
  
  public function setLocation($user_id = null,$pc = null)
  {
  	
  	if($user_id!=null)
  	{
  		//Get postcode is user is logged in
  		$this->db = JFactory::getDBO();
  		 
  		$query = $this->db->getQuery(TRUE);
  		$query->select('cd.postcode')
  		->from('#__contact_details as cd')
  		->where('cd.user_id = "'.$user_id.'"');
  		$this->db->setQuery($query);
  		$item = $this->db->loadObject();
  		$pc = $item->postcode;
  	}
  	
  	//check if postcode is set
  	if($pc!=null)
  	{
  		//set session with location
  		$this->session->set('ddclocation', $pc);
  		return true;
  	}
  	else 
  	{
  		return false;
  	}
  	
  	
  	
  }
  
  public function getShopCart_contents()
  {
  	$result = array();
  	$prodModel = new DdcshopboxModelsVendorproducts();
  	$scModel = new DdcshopboxModelsShopcart();
  	$cartdata = $scModel->listItems();
  	foreach($cartdata as $cart_item)
  	{
  		if($cart_item->ddc_vendor_product_id!=0)
  		{
  			$result[0] .='<tr>';
  			$result[0] .='<td>'.$cart_item->product_quantity.' x </td>';
  			$result[0] .='<td>'.$cart_item->vendor_product_name.'</td>';
  			$result[0] .='<td id="#cartItem'.$cart_item->ddc_shoppingcart_id.'">'.$cart_item->currency_symbol." ".number_format(($cart_item->product_quantity*$cart_item->product_price),2).'</td>';
  			$result[0] .='</tr>';
  			$result[1] +=($cart_item->product_quantity*$cart_item->product_price);
  		}
  		
  	}
  	
  	return $result;
  }
  
  public function ddcnumber($number)
  {
  	if(($number==null) || ($number==0))
  	{
  		$number = "-";
  	}
  	return $number;
  }
  
  public function getpartjsonfield($string,$part)
  {
  	$prod_params = json_decode($string, true);
	$item = $prod_params[$part];  	
  	return $item;
  }
  
  // Function for resizing jpg, gif, or png image files
  public function profile_img_resize($target, $newcopy, $w, $h, $ext) {
  	list($w_orig, $h_orig) = getimagesize($target);
  	$scale_ratio = $w_orig / $h_orig;
  	if (($w / $h) > $scale_ratio) {
  		$w = $h * $scale_ratio;
  	} else {
  		$h = $w / $scale_ratio;
  	}
  	$img = "";
  	$ext = strtolower($ext);
  	if ($ext == "gif"){
  		$img = imagecreatefromgif($target);
  	} else if($ext =="png"){
  		$img = imagecreatefrompng($target);
  	} else {
  		$img = imagecreatefromjpeg($target);
  	}
  	$tci = imagecreatetruecolor($w, $h);
  	// imagecopyresampled(dst_img, src_img, dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h)
  	imagecopyresampled($tci, $img, 0, 0, 0, 0, $w, $h, $w_orig, $h_orig);
  	imagejpeg($tci, $newcopy, 80);
  }
  
  public function uploadPhoto($dest,$id,$linkedtable)
  {
  	$user = JFactory::getUser()->id;
  	if($user!=0)
  	{
  		$date = date("Y-m-d H:i:s");
  		//If you wish to delete all linked images
//   		$db = JFactory::getDbo();
//   		$query = $db->getQuery(TRUE);
//   		// delete all custom keys for user 1001.
//   		$conditions = array(
//   				$db->quoteName('linked_id') . ' = '.(int)$id,
//   				$db->quoteName('linked_table') . ' = ' . $db->quote($linkedtable)
//   		);
  
//   		$query->delete($db->quoteName('#__ddc_images'));
//   		$query->where($conditions);
  
//   		$db->setQuery($query);
//   		$db->execute();
  
  		$db = JFactory::getDbo();
  		$query = $db->getQuery(TRUE);
  		// Insert columns.
  		$columns = array('link_id', 'linked_table', 'image_link', 'state', 'modified_on', 'created_on');
  
  		// Insert values.
  		$values = array($id, $db->quote($linkedtable), $db->quote($dest), 1, $db->quote($date), $db->quote($date));
  
  		// Prepare the insert query.
  		$query
  		->insert($db->quoteName('#__ddc_images'))
  		->columns($db->quoteName($columns))
  		->values(implode(',', $values));
  		$db->setQuery($query);
  		$result = $db->execute();
  
  		return true;
  	}
  	return false;
  }
  
  /**
   * Calculates the great-circle distance between two points, with
   * the Haversine formula.
   * @param float $latitudeFrom Latitude of start point in [deg decimal]
   * @param float $longitudeFrom Longitude of start point in [deg decimal]
   * @param float $latitudeTo Latitude of target point in [deg decimal]
   * @param float $longitudeTo Longitude of target point in [deg decimal]
   * @param float $earthRadius Mean earth radius in [m]
   * @return float Distance between points in [m] (same as earthRadius)
   */
  public static function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
  {
  	// convert from degrees to radians
  	$latFrom = deg2rad($latitudeFrom);
  	$lonFrom = deg2rad($longitudeFrom);
  	$latTo = deg2rad($latitudeTo);
  	$lonTo = deg2rad($longitudeTo);
  
  	$latDelta = $latTo - $latFrom;
  	$lonDelta = $lonTo - $lonFrom;
  
  	$angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
  			cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
  	return $angle * $earthRadius;
  }
  
  public static function isValidPostCodeFormat($postcode){
  
  	// return whether the postcode is in a valid format
  	return preg_match('/^\s*(([A-Z]{1,2})[0-9][0-9A-Z]?)\s*(([0-9])[A-Z]{2})\s*$/', strtoupper($postcode));
  
  }
  
  /* Parses a postcode and returns an array with the following components:
   *
   * 1 - the outward code
   * 2 - the area from the outward code
   * 3 - the inward code
   * 4 - the sector from the inward code
   *
   * The parameter is:
   *
   * $postcode - the postcode to parse
   */
  private static function parse($postcode){
  
  	// parse the postcode and return the result
  	preg_match('/^\s*(([A-Z]{1,2})[0-9][0-9A-Z]?)\s*(([0-9])[A-Z]{2})\s*$/', strtoupper($postcode), $matches);
  	return $matches;
  
  }
  
  /* Returns the district for a postcode - for example, SW1A for SW1A 0AA - or
   * false if the postcode was not in a valid format. The parameter is:
   *
   * $postcode - the postcode whose district should be returned
   */
  public static function getDistrict($postcode){
  
  	// parse the postcode and return the district
  	$parts = self::parse($postcode);
  	return (count($parts) > 0 ? $parts[1] : false);
  
  }
  
  public function uploadpostcodes($filename,$table)
  {
  	$filename = 'postcodes.csv';
  	$file = fopen(JPATH_SITE."/media/com_ddcshopbox/".$filename,"r");
  	$rows = array();
  	$headers = array();
  	array_push($headers,fgetcsv($file,null,','));
  	while (!feof($file))
  	{
  		array_push($rows,fgetcsv($file,null,','));
  	}
  	
   	for($i=0;$i<count($rows);$i++):
   		$db = JFactory::getDBO();
   		$query = $db->getQuery(true);
	   	$query
	   		->insert($db->quoteName('#__ddc_outcodes'))
	   		->columns($db->quoteName($headers[0]))
	   		->values('"'.implode('","',$rows[$i]).'"');
	   	$db->setQuery($query);
	  	$db->execute();
	endfor;
  }
  
  /* Returns the following for a postcode: 
   * - district
   * - latitude
   * - longatude
   *
   * $result - the array with 3 pieces data
   */
  public function getPostCodeDetails($postcode)
  {
  	$db = JFactory::getDBO();
   	$query = $db->getQuery(true);
	$query
	   	->select('o.postcode,o.latitude,o.longitude')
	   	->from('#__ddc_outcodes as o')
	   	->where('o.postcode = "'.$this->getDistrict($postcode).'"');
	$db->setQuery($query);
	   	
	$item = $db->loadObject();
	return $item;
  }
  
  /* Get straightline distance between two postcode districts
   * 
   */
  public function getPostcodesDistance($postcode1, $postcode2)
  {
  	if(($this->isValidPostCodeFormat($postcode1)==true) AND ($this->isValidPostCodeFormat($postcode2)==true))
  	{
  		$pc1 = $this->getPostCodeDetails($postcode1);
  		$pc2 = $this->getPostCodeDetails($postcode2);
  		return $this->haversineGreatCircleDistance($pc1->latitude, $pc1->longitude, $pc2->latitude, $pc2->longitude);
  	}
  	else
  	{
  		return false;
  	}	
  }
  
  public function sort_objects_by_distance($a, $b) {
  	if($a->distance == $b->distance){ return 0 ; }
  	return ($a->distance < $b->distance) ? -1 : 1;
  }
}