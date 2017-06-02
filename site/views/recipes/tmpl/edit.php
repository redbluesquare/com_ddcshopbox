<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
$component = new JComponentHelper();
$params = $component->getParams('com_ddcshopbox');
$this->session = JFactory::getSession();
$rdModel = new DdcshopboxModelsRecipedetails();
if(isset($this->profile->user_id)):
if($this->form->getFieldset('main_top')['jform_ddc_recipe_header_id']->value==""):
$id = '';
$class = 'hide';
else:
$id = $this->form->getFieldset('main_top')['jform_ddc_recipe_header_id']->value;
$btnclass = 'hide';
endif;
?>
	<legend><?php echo JText::_( 'COM_DDC_RECIPE_CREATOR' ); ?></legend>
	<ul class="nav nav-tabs">
  		<li class="active"><a data-toggle="tab" href="#recipeheader"><?php echo JText::_('COM_DDC_BASIC_INFORMATION'); ?></a></li>
  		<li id="recipeingredients" class="<?php echo $class?>"><a data-toggle="tab" href="#recipe_ingredients"><?php echo JText::_('COM_DDC_RECIPE_INGREDIENTS'); ?></a></li>
  		<li id="recipemethod" class="<?php echo $class?>"><a data-toggle="tab" href="#recipe_method"><?php echo JText::_('COM_DDC_RECIPE_METHOD'); ?></a></li>
  		<li id="recipeimages" class="hide"><a data-toggle="tab" href="#recipe_images"><?php echo JText::_('COM_DDC_RECIPE_IMAGES'); ?></a></li>
  		<button id="saveRecipeHeader" class="pull-right btn btn-primary <?php echo $btnclass; ?>" onclick="addRecipe()"><?php echo JText::_('COM_DDC_SAVE_AND_ADD_INGREDIENTS'); ?></button>
	</ul>
		<div class="tab-content">
			<div  id="recipeheader" class="tab-pane fade in active">
			<h2><?php echo JText::_('COM_DDC_BASIC_INFORMATION'); ?></h2>
			<form id="ddcrecipeheader">
			<div class="row">
				<div class="col-xs-9">
					<?php foreach($this->form->getFieldset('main_top') as $field): ?>
						<?php if ($field->hidden):// If the field is hidden, just display the input.?>
							<?php echo $field->input;?>
						<?php else:?>
						<div>
							<div>
							<?php echo $field->label; ?>
							<?php if (!$field->required && $field->type != 'Spacer') : ?>
								<span><?php //echo JText::_('COM_USERS_OPTIONAL');?></span>
							<?php endif; ?>
							</div>
							<div>
								<?php echo $field->input;?>
							</div>
						</div>
						<?php endif;?>
					<?php endforeach; ?>
					<div class="clearfix"></div>
				</div>
				<div class="col-xs-3">
					<?php foreach($this->form->getFieldset('main_right') as $field): ?>
						<?php if ($field->hidden):// If the field is hidden, just display the input.?>
							<?php echo $field->input;?>
						<?php else:?>
						<div>
							<div>
							<?php echo $field->label; ?>
							<?php if (!$field->required && $field->type != 'Spacer') : ?>
								<span><?php //echo JText::_('COM_USERS_OPTIONAL');?></span>
							<?php endif; ?>
							</div>
							<div>
								<?php echo $field->input;?>
							</div>
						</div>
						<?php endif;?>
					<?php endforeach; ?>
					<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
			<input type="hidden" name="option" value="com_ddcshopbox" />
            <input type="hidden" name="controller" value="edit" />
            <input type="hidden" name="format" value="raw" />
            <input type="hidden" name="task" value="recipeheader.save" />
        </div>
        </form>
        </div>
        	<div  id="recipe_ingredients" class="tab-pane fade">
        	<h2><?php echo JText::_('COM_DDC_RECIPE_INGREDIENTS'); ?></h2>
        		<div class="row">
        			<div class="col-xs-12 clearfix">
						<div class="col-xs-6 ingredientDetails">
							<?php 
							$rdModel = new DdcshopboxModelsRecipedetails();
							$ingredients = $rdModel->listItems($id);
							foreach($ingredients as $ingredient):
							?>
							<p id="ingredient<?php echo $ingredient->ddc_recipe_detail_id?>">
								<span id="ingredientName"><?php echo $ingredient->item_detail; ?></span>
								<span class="pull-right btn btn-success" onclick="getIngredient(<?php echo $ingredient->ddc_recipe_detail_id?>)"><i class="glyphicon glyphicon-pencil"></i></span>
							</p>
							<?php 
							endforeach;
							?>
						</div>
						<div class="col-xs-6">
							<form id="ingredientForm">
								<input name="jform[item_detail]" type="text" id="jform_item_detail" value="" class="form-control" placeholder="Ingredient Detail" />
								<input name="jform[product_id]" type="" id="jform_product_id" value="" class="form-control" placeholder="product" />
								<input name="jform[product_quantity]" type="text" id="jform_product_quantity" value="" class="form-control" placeholder="Quantity" />
								<input name="jform[weight]" type="text" id="jform_weight" value="" class="form-control" placeholder="Weight" />
								<select name="jform[weight_uom]" id="jform_weight_uom" class="form-control" placeholder="weight unit">
									<option value="">-</option>
									<option value="1">grams</option>
									<option value="2">kilograms</option>
									<option value="3">ounces</option>
								</select>
								<input name="jform[volume]" type="" id="jform_volume" value="" class="form-control" placeholder="Volume" />
								<select name="jform[volume_uom]" id="jform_volume_uom" class="form-control" placeholder="volume unit">
									<option value="">-</option>
									<option value="1">ml</option>
									<option value="2">litres</option>
								</select>
								<input name="jform[ddc_recipe_detail_id]" type="hidden" id="jform_ddc_recipe_detail_id" value="" class="form-control" />
								<input name="jform[recipe_header_id]" type="hidden" id="jform_recipe_header_id" value="<?php echo $id?>" class="form-control" />
								<input name="jform[table]" type="hidden" id="jform_table" value="recipedetails" />
								<input type="hidden" name="option" value="com_ddcshopbox" />
            					<input type="hidden" name="controller" value="edit" />
            					<input type="hidden" name="format" value="raw" />
            					<input type="hidden" name="task" value="recipedetail.save" />
							</form>
							<button onclick="addIngredient()" class="btn btn-success pull-right">Save Ingredient</button>
						</div>
					</div>
        		</div>
        	</div>
        	<div  id="recipe_method" class="tab-pane fade">
        	<h2><?php echo JText::_('COM_DDC_RECIPE_METHOD'); ?></h2>
        	<div class="row">
        		<div class="col-xs-12">
        			<form id="recipemethodForm">
					<?php foreach($this->form->getFieldset('main_bottom') as $field): ?>
						<?php if ($field->hidden):// If the field is hidden, just display the input.?>
							<?php echo $field->input;?>
						<?php else:?>
							<div>
							<?php echo $field->label; ?>
							<?php if (!$field->required && $field->type != 'Spacer') : ?>
								<span><?php //echo JText::_('COM_USERS_OPTIONAL');?></span>
							<?php endif; ?>
							</div>
							<div>
								<?php echo $field->input;?>
							</div>
						<?php endif;?>
					<?php endforeach; ?>	
					</form>
				</div>
        	</div>
        	</div>
        	<div  id="recipe_images" class="tab-pane fade">
        	
        	</div>
        	</div>
        	</div>
	<button onclick="saveRecipe('recipe.save')" class="btn btn-success"><?php echo JText::_('COM_DDC_SAVE'); ?></button>

<?php 
else:
?>
<div>
	<p><?php echo JText::_('COM_DDC_USER_UNATHORISED');?></p>
</div>
<?php 
endif;
?>
