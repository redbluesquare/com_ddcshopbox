<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 

class DdcshopboxControllersEdit extends DdcshopboxControllersDefault {
	
	function __construct()
	{
		parent::__construct();
	}
	
	public function execute() {
		
		$app = JFactory::getApplication ();
		$return = array ("success" => false	);
		$jinput = JFactory::getApplication()->input;
		$this->data = $jinput->get('jform', array(),'array');
		
		
		if($this->data['table']=='vendors')
		{
			$task = $jinput->get('task', "", 'STR' );
			if($task=='vendor.add')
			{
				$viewName = $app->input->getWord('view', 'vendors');
				$app->input->set('layout','edit');
				$app->input->set('view', $viewName);
    			
			}
			if($task=='vendor.edit')
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
		
		if($this->data['table']=='products')
		{
			$task = $jinput->get('task', "", 'STR' );
			if($task=='product.add')
			{

				 
			}
			if($task=='product.edit')
			{

					
			}
			if($task=="product.save")
			{
				$modelName  = $app->input->get('models', 'products');
				$modelName  = 'DdcshopboxModels'.ucwords($modelName);
				$model = new $modelName();

				if( $row = $model->store() )
				{
					$modelName  = $app->input->get('models', 'productprices');
					$modelName  = 'DdcshopboxModels'.ucwords($modelName);
					$model = new $modelName();
					$model->store();
					
					$url = 'index.php?option=com_ddcshopbox&view=products&layout=default&product_id='.$row->ddc_product_id;
					$return['data'] = JRoute::_($url);
					$return['success'] = true;
					$return['msg'] = JText::_('COM_DDC_SAVE_SUCCESS');
					echo json_encode($return);
				}else{
					$return['msg'] = JText::_('COM_DDC_SAVE_FAILURE');
				}

			}
			if($task=="product.cancel")
			{

			}

			
		}
		if($this->data['table']=='profiles')
		{
			if($this->data['task']=="edit")
			{
				$modelName  = $app->input->get('models', 'profiles');
				$modelName  = 'DdcshopboxModels'.ucwords($modelName);
				$model = new $modelName();
				if($row = $model->store())
				{
					$return['success'] = true;
					$return['msg'] = JText::_('COM_DDC_SAVE_SUCCESS');
				}
				else
				{
					$return['success'] = false;
					$return['msg'] = JText::_('COM_DDC_SAVE_FAILURE');
				}
			}
			$return['data'] = $row;
			echo json_encode($return);
			
		}
		else if($this->data['table']=='images')
		{
			if($_FILES["upload_photo"]["error"] == 0)
			{
		
				$item_id = $this->data['item_id'];
				$linkedtable = $this->data['linkedtable'];
				$modelName  = $app->input->get('models', 'default');
				$modelName  = 'DdcshopboxModels'.ucwords($modelName);
				$model = new $modelName();
					
				$fileName = $_FILES["upload_photo"]["name"];
				$fileTmpLoc = $_FILES["upload_photo"]["tmp_name"];
				$fileType = $_FILES["upload_photo"]["type"];
				$fileSize = $_FILES["upload_photo"]["size"];
				$fileErrorMsg = $_FILES["upload_photo"]["error"];
				$ext = explode(".", $fileName);
				$ext = $ext[1];
				$fname = date("Ymdhhiiss").$linkedtable.$item_id."_temp.".$ext;
				$newName = date("Ymdhhiiss").$linkedtable.$item_id.".".$ext;
				$path = 'media/com_ddcshopbox/images/';
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
				$wmax = 800;
				$hmax = 600;
				$model->profile_img_resize($target_file, $resized_file, $wmax, $hmax, $ext);
				unlink(JPATH_ROOT."/media/com_ddcshopbox/images/".$dest);
				// ----------- End Universal Image Resizing Function -----------
				if ( $row = $model->uploadPhoto($path.$dest1,$item_id,$linkedtable) )
				{
					$return['success'] = true;
					$return['msg'] = JText::_('COM_DDC_SAVE_SUCCESS');
					$return['html'] = JPATH."/media/com_ddcshopbox/images/".$dest1;
		
				}else{
					$return['html'] = JText::_('COM_DDC_SAVE_FAILURE');
				}
			}
			echo $return["html"];
		}
		
		if($this->data['table']=='ddcshipping')
		{
			$modelName  = $app->input->get('models', 'shipping');
			$modelName  = 'DdcshopboxModels'.ucwords($modelName);
			$model = new $modelName();
			if($row = $model->store())
			{
				$return['success'] = true;
				$return['msg'] = $row;
				
			}
			else
			{
				$return['msg'] = JText::_('COM_DDC_SAVE_FAILURE');
			}
			echo json_encode($return);
				
		}
		
		else
		{

		}
	}
		
}
