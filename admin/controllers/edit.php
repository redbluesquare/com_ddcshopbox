<?php
defined ( '_JEXEC' ) or die ( 'Restricted access' );

/**
 *
 * @author Darryl
 *        
 */
class DdcshopboxControllersEdit extends DdcshopboxControllersDefault {
	
	function __construct()
	{
		parent::__construct();
	}
	
	public function execute() {
		
		$app = JFactory::getApplication ();
		$return = array ("success" => false	);
		$jinput = new JInput();
		$this->data = $jinput->get('jform', array(),'array');
		
		
		if($this->data['table']=='vendors')
		{
			$task = $jinput->get('task', "", 'STR' );
			if(($task=='vendor.add') or ($task=='vendor.edit'))
			{
				$viewName = $app->input->getWord('view', 'vendors');
				$app->input->set('layout','edit');
				$app->input->set('view', $viewName);
    			
			}

			if($task=="vendor.save")
			{
				$modelName  = $app->input->get('models', 'vendors');
				$modelName  = 'DdcshopboxModels'.ucwords($modelName);
				$model = new $modelName();

				if( $row = $model->store() )
				{
					$return['success'] = true;
					$msg = JText::_('COM_DDC_SAVE_SUCCESS');
				}else{
					$return['msg'] = JText::_('COM_DDC_SAVE_FAILURE');
				}
     			$viewName = $app->input->getWord('view', 'vendors');
    			$app->input->set('layout','default');
    			$app->input->set('view', $viewName);
			}
			if($task=="vendor.cancel")
			{
     			$viewName = $app->input->getWord('view', 'vendors');
    			$app->input->set('layout','default');
    			$app->input->set('view', $viewName);
			}
			//display view
			return parent::execute();
		}
		if($this->data['table']=='contactaddress')
		{
			if($task=="contactAddress.edit")
			{
				$modelName  = $app->input->get('models', 'profiles');
				$modelName  = 'DdcshopboxModels'.ucwords($modelName);
				$model = new $modelName();
				if($model->saveAddress())
				{
					$return['success'] = true;
					$return['msg'] = JText::_('COM_DDCBOOKIT_SAVE_SUCCESS');
				}
			}
			
		}
		
		if($this->data['table']=='products')
		{
			$task = $jinput->get('task', "", 'STR' );
			if(($task=='product.add') or ($task=='product.edit'))
			{
				$viewName = $app->input->getWord('view', 'products');
				$app->input->set('layout','edit');
				$app->input->set('view', $viewName);
			}

			if($task=="product.save")
			{
				$modelName  = $app->input->get('models', 'products');
				$modelName  = 'DdcshopboxModels'.ucwords($modelName);
				$model = new $modelName();
		
				if( $row = $model->store() )
				{
					$viewName = $app->input->getWord('view', 'products');
					$app->input->set('layout','default');
					$app->input->set('view', $viewName);
				}else{
					$return['msg'] = JText::_('COM_DDC_SAVE_FAILURE');
				}
			}
			if($task=="product.cancel")
			{
				$viewName = $app->input->getWord('view', 'products');
				$app->input->set('layout','default');
				$app->input->set('view', $viewName);
			}
			//display view
			return parent::execute();
		}
		
		if($this->data['table']=='vendorproducts')
		{
			$task = $jinput->get('task', "", 'STR' );
			if(($task=='vendorproduct.add') or ($task=='vendorproduct.edit'))
			{
				$viewName = $app->input->getWord('view', 'vendorproducts');
				$app->input->set('layout','edit');
				$app->input->set('view', $viewName);
			}
		
			if($task=="vendorproduct.save")
			{
				$modelName  = $app->input->get('models', 'vendorproducts');
				$modelName  = 'DdcshopboxModels'.ucwords($modelName);
				$model = new $modelName();
		
				if( $row = $model->store() )
				{
					$this->data['ddc_vendor_product_id'] = $row->ddc_vendor_product_id;
					$modelName  = $app->input->get('models', 'productprices');
					$modelName  = 'DdcshopboxModels'.ucwords($modelName);
					$model = new $modelName();
					if($model->store())
					{
						$viewName = $app->input->getWord('view', 'vendorproducts');
						$app->input->set('layout','default');
						$app->input->set('view', $viewName);
					}else{
						$viewName = $app->input->getWord('view', 'vendorproducts');
						$app->input->set('layout','edit');
						$app->input->set('view', $viewName);
						$app->input->set('vendorproduct_id', $this->data['ddc_vendor_product_id']);
						
					}
				}else{
					$return['msg'] = JText::_('COM_DDC_SAVE_FAILURE');
				}
			}
			if($task=="vendorproduct.cancel")
			{
				$viewName = $app->input->getWord('view', 'vendorproducts');
				$app->input->set('layout','default');
				$app->input->set('view', $viewName);
			}
			//display view
			return parent::execute();
		}
		
		if($this->data['table']=='uservendors')
		{
			$task = $jinput->get('task', "", 'STR' );
			if($task=='uservendor.add')
			{
				$viewName = $app->input->getWord('view', 'uservendors');
				$app->input->set('layout','edit');
				$app->input->set('view', $viewName);
				 
			}
			if($task=='uservendors.edit')
			{
				$viewName = $app->input->getWord('view', 'uservendors');
				$app->input->set('layout','edit');
				$app->input->set('view', $viewName);
					
			}
			if($task=="uservendor.save")
			{
				$modelName  = $app->input->get('models', 'uservendors');
				$modelName  = 'DdcshopboxModels'.ucwords($modelName);
				$model = new $modelName();
		
				if( $row = $model->store() )
				{
					$return['success'] = true;
					$msg = JText::_('COM_DDC_SAVE_SUCCESS');
				}else{
					$return['msg'] = JText::_('COM_DDC_SAVE_FAILURE');
				}
				$viewName = $app->input->getWord('view', 'uservendors');
				$app->input->set('layout','default');
				$app->input->set('view', $viewName);
			}
			if($task=="uservendors.cancel")
			{
				$viewName = $app->input->getWord('view', 'uservendors');
				$app->input->set('layout','default');
				$app->input->set('view', $viewName);
			}
			//display view
			return parent::execute();
		}
		else if($this->data['table']=='images')
		{
			//Initialize model
			$modelName  = $app->input->get('models', 'default');
			$modelName  = 'DdcshopboxModels'.ucwords($modelName);
			$model = new $modelName();
			
			if($jinput->getMethod() == 'DELETE')
			{
				//Get the filename
				if($row = $model->getImageName($this->data['ddc_image_id']))
				{
					var_dump($row->image_link);
					unlink(JRoute::_($row->image_link));
					$model->removeImageName($this->data['ddc_image_id']);
					return true;
				}
				else{
					return false;
				}
			}
			if($_FILES["upload_photo"]["error"] == 0)
			{
				//TO DELETE the existing photo
				// 				$db = JFactory::getDbo();
				// 				$query = $db->getQuery(true);
				// 				$query->select('profile_value');
				// 				$query->from($db->quoteName('#__user_profiles'));
				// 				$query->where($db->quoteName('user_id')." = ".JFactory::getUser()->id);
				// 				$query->where($db->quoteName('profile_key')." = 'ddcpss.photo'");
				// 				$db->setQuery($query);
				// 				$result = $db->loadResult();
		
				// 				unlink("/media/ddcpss/images/".$result);
		
				$item_id = $this->data['item_id'];
				$linkedtable = $this->data['linkedtable'];
					
				$fileName = $_FILES["upload_photo"]["name"];
				$fileTmpLoc = $_FILES["upload_photo"]["tmp_name"];
				$fileType = $_FILES["upload_photo"]["type"];
				$fileSize = $_FILES["upload_photo"]["size"];
				$fileErrorMsg = $_FILES["upload_photo"]["error"];
				$ext = explode(".", $fileName);
				$ext = $ext[1];
				$fname = date("Ymdhhiiss").$linkedtable.$item_id."_temp.".$ext;
				$newName = date("Ymdhhiiss").$linkedtable.$item_id.".".$ext;
				$path = JRoute::_('media/com_ddcshopbox/images/');
				$dest = $fname;
				$dest1 = $newName;
					
				if(!$fileTmpLoc)
				{
					$return["html"] = "Error, please first select a file!";
					exit();
				}
				else if($fileSize > 5242880)
				{ // if file size is larger than 5 Megabytes
					$return["html"] = "ERROR: Your file was larger than 5 Megabytes in size.";
					unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
					exit();
				}
				else if (!preg_match("/.(gif|jpg|png|jpeg)$/i", $fileName) )
				{
					// This condition is only if you wish to allow uploading of specific file types
					$return["html"] = "ERROR: Your image was not .gif, .jpg, or .png.";
					unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
					exit();
				}
				else if ($fileErrorMsg == 1)
				{ // if file upload error key is equal to 1
					$return["html"] = "ERROR: An error occured while processing the file. Try again.";
					exit();
				}
				// Place it into your "uploads" folder mow using the move_uploaded_file() function
				$moveResult = move_uploaded_file($fileTmpLoc, JPATH_ROOT."/media/com_ddcshopbox/images/".$dest);
				// Check to make sure the move result is true before continuing
				if ($moveResult != true)
				{
					echo "ERROR: File not uploaded. Try again.";
					unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
					exit();
				}
				//unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
				// ---------- Include Universal Image Resizing Function --------
					
				$target_file = JPATH_ROOT."/media/com_ddcshopbox/images/".$dest;
				$resized_file = JPATH_ROOT."/media/com_ddcshopbox/images/".$dest1;
				$wmax = 200;
				$hmax = 150;
				$model->profile_img_resize($target_file, $resized_file, $wmax, $hmax, $ext);
				unlink(JPATH_ROOT."/media/com_ddcshopbox/images/".$dest);
				// ----------- End Universal Image Resizing Function -----------
				if ( $row = $model->uploadPhoto($path.$dest1,$item_id,$linkedtable) )
				{
					$return['success'] = true;
					$return['msg'] = JText::_('COM_DDC_SAVE_SUCCESS');
					$return['html'] = JPATH_ROOT."/media/com_ddcshopbox/images/".$dest1;
		
				}else{
					$return['html'] = JText::_('COM_DDC_SAVE_FAILURE');
				}
			}
			echo $return["html"];
		}
		else
		{
			$viewName = $app->input->getWord('view', 'dashboard');
			$app->input->set('layout','default');
			$app->input->set('view', $viewName);
			//display view
			return parent::execute();
		}
	}
		
}
