<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class DdcshopboxViewProductsRaw extends JViewHtml
{
  function render()
  {
    $app = JFactory::getApplication();
    $type = $app->input->get('type');
    $id = $app->input->get('id');
    $view = $app->input->get('view');
 
    //retrieve task list from model
    $model = new DdcshopboxModelsProducts();
 
    $this->item = $model->getItem($id,$view,FALSE);
    
    //display
    echo $this->item;
  } 
}
