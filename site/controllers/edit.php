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
				elseif($fileSize > 5242880)
				{ // if file size is larger than 5 Megabytes
					$return["html"] = "ERROR: Your file was larger than 5 Megabytes in size.";
					unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
					exit();
				}
				elseif (!preg_match("/.(gif|jpg|png|jpeg)$/i", $fileName) )
				{
					// This condition is only if you wish to allow uploading of specific file types
					$return["html"] = "ERROR: Your image was not .gif, .jpg, or .png.";
					unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
					exit();
				}
				elseif ($fileErrorMsg == 1)
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
		
		elseif($this->data['table']=='ddcshipping')
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
		elseif($this->data['table']=='ddcfavshop')
		{
			$modelName  = $app->input->get('models', 'default');
			$modelName  = 'DdcshopboxModels'.ucwords($modelName);
			$model = new $modelName();
			$emaildata = array(
					'town'=>$this->data['town'],
					'local_shop_1' => $this->data['local_shop_1'],
					'local_shop_2' => $this->data['local_shop_2'],
					'local_shop_3' => $this->data['local_shop_3'],
					'comment' => $this->data['comment'],
					'email_to' => $this->data['email_to'],
					'table' => $this->data['table']
				);
			if($row = $model->sendEmail('Email from user Interest',$emaildata))
			{
				$return['success'] = true;
				$return['msg'] = JText::_('COM_DDC_THANKS_FOR_INTEREST');
		
			}
			else
			{
				$return['msg'] = JText::_('COM_DDC_SAVE_FAILURE');
			}
			echo json_encode($return);
		}
		elseif($this->data['table']=='ddcevent')
		{
			$modelName  = $app->input->get('models', 'default');
			$modelName  = 'DdcshopboxModels'.ucwords($modelName);
			$model = new $modelName();
			$emaildata = array(
					'ddctitle'=>$this->data['ddctitle'],
					'location' => $this->data['location'],
					'start_date' => $this->data['start_date'],
					'start_time' => $this->data['start_time'],
					'end_date' => $this->data['end_date'],
					'end_time' => $this->data['end_time'],
					'description' => $this->data['description'],
					'organiser' => $this->data['organiser'],
					'email_to' => $this->data['email_to'],
					'table' => $this->data['table']
			);
			if($row = $model->sendEmail('Email about new Event',$emaildata))
			{
				$return['success'] = true;
				$return['msg'] = JText::_('COM_DDC_THANKS_FOR_INTEREST');
		
			}
			else
			{
				$return['msg'] = JText::_('COM_DDC_SAVE_FAILURE');
			}
			echo json_encode($return);
		}
		elseif($this->data['table']=='ddcwtd')
		{
			$modelName  = $app->input->get('models', 'default');
			$modelName  = 'DdcshopboxModels'.ucwords($modelName);
			$model = new $modelName();
			$emaildata = array(
					'ddctitle'=>$this->data['ddctitle'],
					'location' => $this->data['location'],
					'description' => $this->data['description'],
					'organiser' => $this->data['organiser'],
					'email_to' => $this->data['email_to'],
					'table' => $this->data['table']
			);
			if($row = $model->sendEmail('Email about new Event',$emaildata))
			{
				$return['success'] = true;
				$return['msg'] = JText::_('COM_DDC_THANKS_FOR_INTEREST');
		
			}
			else
			{
				$return['msg'] = JText::_('COM_DDC_SAVE_FAILURE');
			}
			echo json_encode($return);
		}
		if($this->data['table']=='ddcpostings')
		{
			$task = $jinput->get('task', "", 'STR' );
			if($task=='review.add')
			{
				
			}
			if($task=='review.edit')
			{
				
			}
			if($task=="review.save")
			{
				$modelName  = $app->input->get('models', 'ddcpostings');
				$modelName  = 'DdcshopboxModels'.ucwords($modelName);
				$model = new $modelName();
				if( $row = $model->store() )
				{
					$model->sendEmail('New review posted',$this->data['message']);
					$return['success'] = true;
					$return['msg'] = JText::_('COM_DDC_REVIEW_SAVE_SUCCESS');
				}else{
					$return['msg'] = JText::_('COM_DDC_REVIEW_SAVE_FAILURE');
				}
			}
			if($task=="review.cancel")
			{
		
			}
			if($task=="review.approval")
			{
				$modelName  = $app->input->get('models', 'ddcpostings');
				$modelName  = 'DdcshopboxModels'.ucwords($modelName);
				$model = new $modelName();
				if( $row = $model->store($this->data) )
				{
					$return['success'] = true;
					$return['msg'] = JText::_('COM_DDC_REVIEW_SAVE_SUCCESS');
				}else{
					$return['msg'] = JText::_('COM_DDC_REVIEW_SAVE_FAILURE');
				}
			}
			echo json_encode($return);
		}
		if($this->data['table']=='serviceheaders')
		{
			$task = $jinput->get('task', "", 'STR' );
			if($task=='serviceheader.add')
			{
		
			}
			if($task=='serviceheader.edit')
			{
		
			}
			if($task=="serviceheader.save")
			{
				$return['emailsent'] = false;
				$return['payment'] = false;
				$return['bookmsg'] = JText::_('COM_DDC_BOOKING_SAVE_FAILURE');
				$modelName  = $app->input->get('models', 'serviceheaders');
				$modelName  = 'DdcshopboxModels'.ucwords($modelName);
				$model = new $modelName();
				if( $row = $model->store() )
				{
					$jinput->set('service_header_id',$row->ddc_service_header_id);
					$sdmodelName  = $app->input->get('models', 'servicedetails');
					$sdmodelName  = 'DdcshopboxModels'.ucwords($sdmodelName);
					$sdmodel = new $sdmodelName();
					if($sdmodel->store())
					{
						if($model->sendShopEmail('Booking Confirmation',$model->getService($row->ddc_service_header_id),array($this->data['email_to'],$this->data['first_name'].' '.$this->data['last_name'])))
						{
							$return['emailsent'] = true;
						}
						if($model->storePayment('vendor'.$this->data['vendorid'],$row->ddc_service_header_id))
						{
							$return['payment'] = true;
						}
						$return['success'] = true;
						$return['bookmsg'] = JText::_('COM_DDC_BOOKING_SAVE_SUCCESS');
					}
				}
			}
			if($task=="serviceheader.cancel")
			{
		
			}
			if($task=="serviceheader.approval")
			{
				
			}
			echo json_encode($return);
		}
		if($this->data['table']=='recipeheaders')
		{
			$task = $jinput->get('task', "", 'STR' );
			if($task=='recipeheader.add')
			{
		
			}
			if($task=='recipeheader.edit')
			{
		
			}
			if($task=="recipeheader.save")
			{
				$return['msg'] = JText::_('COM_DDC_BOOKING_SAVE_FAILURE');
				$return['id'] = null;
				$modelName  = $app->input->get('models', 'recipeheaders');
				$modelName  = 'DdcshopboxModels'.ucwords($modelName);
				$model = new $modelName();
				if( $row = $model->store() )
				{
					$return['id'] = $row->ddc_recipe_header_id;
					$imodelName  = $app->input->get('models', 'images');
					$imodelName  = 'DdcshopboxModels'.ucwords($imodelName);
					$iModel = new $imodelName();
					if($irow = $iModel->store()){
						$return['image'] = $irow->ddc_image_id;
					}
					$return['success'] = true;
					$return['msg'] = JText::_('COM_DDC_RH_SAVE_SUCCESS');
				}
			}
			if($task=="recipeheader.cancel")
			{
		
			}
			if($task=="recipeheader.approval")
			{
		
			}
			echo json_encode($return);
		}
		if($this->data['table']=='recipedetails')
		{
			$return['msg'] = JText::_('COM_DDC_BOOKING_SAVE_FAILURE');
			$task = $jinput->get('task', "", 'STR' );
			if($task=='recipedetail.add')
			{
		
			}
			if($task=='recipedetail.edit')
			{
		
			}
			if($task=="recipedetail.save")
			{
				$return['result'] = null;
				$modelName  = $app->input->get('models', 'recipedetails');
				$modelName  = 'DdcshopboxModels'.ucwords($modelName);
				$model = new $modelName();
				if( $row = $model->store() )
				{
					$result = $model->getItem(null,$row->ddc_recipe_detail_id);
					$return['result'] = '<p><span id="ingredientName">'.$result->item_detail.'</span><span class="pull-right btn btn-success" onclick="getIngredient('.$result->ddc_recipe_detail_id.')"><i class="glyphicon glyphicon-pencil"></i></span></p>';
					$return['success'] = true;
					$return['msg'] = JText::_('COM_DDC_RH_SAVE_SUCCESS');
				}
			}
			if($task=="recipedetail.cancel")
			{
			}
			if($task=="recipedetail.approval")
			{
			}
			echo json_encode($return);
		}
		else
		{

		}
	}
		
}
