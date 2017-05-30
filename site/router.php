<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 

function DdcshopboxBuildRoute(&$query)
{
		
	$segments = array();
	if (isset($query['view']))
	{
		if($query['view'] == 'vendorproducts')
		{
			$query['view'] = 'products';
		}
		$segments[] = $query['view'];
		unset($query['view']);
	}
	if (isset($query['layout']))
	{
		$segments[] = $query['layout'];
		unset($query['layout']);
	}
	if (isset($query['vendor_id']))
	{
		// Make sure we have the id and the alias
		if (strpos($query['vendor_id'], ':') === false)
		{
			$db = JFactory::getDbo();
			$dbQuery = $db->getQuery(true)
			->select('ddc_vendor_id,alias')
			->from('#__ddc_vendors')
			->where('ddc_vendor_id=' . (int) $query['vendor_id']);
			$db->setQuery($dbQuery);
			$alias = $db->loadObject();
			$query['vendor_id'] = $alias->ddc_vendor_id.":".$alias->alias;
				
			$segments[] = $query['vendor_id'];
			unset($query['vendor_id']);
		}
	
	}
	if (isset($query['vendorproduct_id']))
	{
		// Make sure we have the id and the alias
		if (strpos($query['vendorproduct_id'], ':') === false)
		{
			$db = JFactory::getDbo();
			$dbQuery = $db->getQuery(true)
			->select('ddc_vendor_product_id, vendor_product_alias')
			->from('#__ddc_vendor_products')
			->where('ddc_vendor_product_id = ' . (int) $query['vendorproduct_id']);
			$db->setQuery($dbQuery);
			$alias = $db->loadObject();
			$query['vendorproduct_id'] = $alias->ddc_vendor_product_id.":".$alias->vendor_product_alias;
	
			$segments[] = $query['vendorproduct_id'];
			unset($query['vendorproduct_id']);
		}
	
	}
	if (isset($query['recipeid']))
	{
		// Make sure we have the id and the alias
		if (strpos($query['recipeid'], ':') === false)
		{
			$db = JFactory::getDbo();
			$dbQuery = $db->getQuery(true)
			->select('ddc_recipe_header_id, alias')
			->from('#__ddc_recipe_headers')
			->where('ddc_recipe_header_id = ' . (int) $query['recipeid']);
			$db->setQuery($dbQuery);
			$alias = $db->loadObject();
			$query['recipeid'] = $alias->ddc_recipe_header_id.":".$alias->alias;
	
			$segments[] = $query['recipeid'];
			unset($query['recipeid']);
		}
	
	}
	return $segments;
}

function DdcshopboxParseRoute($segments) 
{
	$vars = array();
	switch($segments[0])
	{
		case 'products':
			$vars['view'] = 'vendorproducts';
				if(count($segments)>1) 
				{
					$vars['layout'] = $segments[1];
					if(count($segments)>2):
						$vars['vendorproduct_id'] = $segments[2];
					endif;
				}
			break;
		case 'category':
			//$vars['view'] = 'category';
			$id = explode(':', $segments[2]);
			$vars['id'] = (int) $id[0];
			break;
			case 'shopcart':

				$vars['view'] = 'shopcart';
				//$vars['layout'] = 'shopcart';
				break;
		case 'vendors':
			$vars['view'] = 'vendors';
			if(count($segments)>1)
			{
				$vars['layout'] = $segments[1];
				if(count($segments)>2):
					$vars['vendor_id'] = $segments[2];
				endif;
			}
			
			break;
		case 'cities':
			$vars['view'] = 'cities';
			if(count($segments)>1)
			{
				$vars['layout'] = $segments[1];
				if(count($segments)>2):
					$vars['vendor_id'] = $segments[2];
				endif;
			}	
		break;
		case 'shipping':
			$vars['view'] = 'shipping';
			if(count($segments)>1)
			{
				$vars['layout'] = $segments[1];
				if(count($segments)>2):
					$vars['vendor_id'] = $segments[2];
				endif;
			}
		break;
		case 'recipes':
			$vars['view'] = $segments[0];
			if(count($segments)>1)
			{
				$vars['layout'] = $segments[1];
				if(count($segments)>2):
					$vars['recipeid'] = $segments[2];
				endif;
			}
			break;
	}
	return $vars;
}