<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHTML::_('behavior.calendar');

?>
<h1><?php echo JText::_('COM_DDC_COLLECT_AND_DELIVER'); ?></h1>
<div class="row delivery_form_enquiry">
<form id="delivery_form_checker">
	<fieldset  id="dest_group" class="form-group row">
		<div class="col-sm-3">
			<input name="jform[from_postcode]" type="text" class="form-control" id="from_postcode" placeholder="Collection Postcode" />
		</div>
		<div class="col-sm-3">
			<input name="jform[to_postcode]" type="text" class="form-control" id="to_postcode" placeholder="Destination Postcode" />
		</div>
		<div class=" col-sm-6">
			<input type="button" class="btn btn-danger pull-left" id="btn_distcheck" value="Next" />
			<div class="col-xs-8" id="printText"></div>
		</div>
		<div class="clearfix"></div>
	</fieldset>
	<fieldset id="dims_group" class="form-group row hide">
		<div class="col-sm-4">
			<label><?php echo "Product Dimensions"; ?></label>
			<input name="jform[dim_weight]" type="number" class="form-control col-sm-6" id="dim_weight" placeholder="Weight (kg)" />
			<input name="jform[dim_length]" type="number" class="form-control col-sm-6" id="dim_length" placeholder="Length (cm)" />
			<input name="jform[dim_width]" type="number" class="form-control col-sm-6" id="dim_width" placeholder="Width (cm)" />
			<input name="jform[dim_height]" type="number" class="form-control col-sm-6" id="dim_height" placeholder="Height (cm)" />
		</div>
		<div class="labels_dims col-sm-2">
			<p>Weight (kg)</p>
			<p>Length (cm)</p>
			<p>Width (cm)</p>
			<p>Height (cm)</p>
		</div>
		<div class=" col-sm-6">
			<div class="col-xs-12" id="printText2"></div>
		
			<input type="button" class="btn btn-warning pull-left" value="Continue" id="btn_dimscheck" />
		</div>
		<div class="clearfix"></div>
	</fieldset>
	<fieldset id="service_group" class="form-group row hide">
		<div class="col-sm-6">
			<label><?php echo "Select a Service"; ?></label><br>
			<div class="col-sm-2" style="text-align:center;">
				<label><?php echo "Eco"; ?></label>
				<input name="jform[service_type]" type="radio" class="form-control" value="0" id="serivce_0" style="margin:0px 5px 0px 15px;"/>
			</div>
			<div class="col-sm-2" style="text-align:center;">
				<label><?php echo "Standard"; ?></label>
				<input name="jform[service_type]" type="radio" class="form-control" value="1" id="serivce_1" style="margin:0px 5px 0px 15px;"/>
			</div>
			<div class="col-sm-2" style="text-align:center;">
				<label><?php echo "Timed"; ?></label>
				<input name="jform[service_type]" type="radio" class="form-control" value="2" id="serivce_2" style="margin:0px 5px 0px 15px;" />
			</div>
			<div class="col-sm-2" style="text-align:center;">
				<label><?php echo "Express"; ?></label>
				<input name="jform[service_type]" type="radio" class="form-control" id="" value="3" style="margin:0px 5px 0px 15px;" />
			</div>
			<div class="clearfix"></div>
			<div id="collect_date" class="col-sm-4">
				<label>Collection Date</label>
				<?php echo JHtml::calendar("", "jform[req_collection_date]", "req_collection_date", "%d/%m/%Y", array('style'=>'width:100px;')); ?>
			</div>
			<div id="delivery_date" class="col-sm-4 hide">
				<label>Delivery Date</label>
				<?php echo JHtml::calendar("", "jform[req_delivery_date]", "req_delivery_date", "%d/%m/%Y", array('style'=>'width:100px;')); ?>
			</div>
			<div id="delivery_window" class="col-sm-4 hide">
				<label>Delivery Window</label><br>
				<input name="jform[delivery_time_from]" type="text" value="07:00" class="pull-left" style="width:50px" id="delivery_time_from" /> - 
				<input name="jform[delivery_time_to]" type="text" value="19:00" style="width:50px" id="delivery_time_to" />
			</div>
		</div>
		<div class=" col-sm-6">
			<div class="col-xs-12" id="printText3"></div>
			<input type="button" class="btn btn-success" value="Proceed" id="btn_sevicecheck" />
		</div>
		<div class="clearfix"></div>
	</fieldset>
	<fieldset id="email_group" class="form-group row hide">
		<div class="col-sm-6">
			<label for="jform[email_to]">E-mail</label>
			<input name="jform[email_to]" id="jform_email_to" type="email" placeholder="E-mail address" class="form-control" />
		</div>
		<div class=" col-sm-6">
			<p>Excellent, we have all your requirements, now just enter your e-mail address and we will send you a quote soon.</p>
			<p>The e-mail will also have a link where you can review your requirements and track the status of your request.</p>
			<input type="button" class="btn btn-success" value="Submit" id="btn_submitinfo" />
		</div>
		<div class="clearfix"></div>
	</fieldset>
	<?php echo JHTML::_('form.token'); ?>
	<input name="jform[table]" value="ddcshipping" class="hidden" type="hidden" />
</form>
</div>
<div class="row del_request_complete hide">
	<div class="col-sm-12">
		<h2>Your request is now submitted</h2>
		<p>Thank you for your request. We will be in contact soon!</p>
		<h3>Did you know!</h3>
		<p>We also offer a delivery service from your favourite independant High Street stores</p>
		<p>Please feel free to browse the shops now. <a class="btn btn-success" href="https:\\www.ushbub.co.uk\products.html">Let's go</a>
	</div>
</div>
<div class="row delivery_parcel_destination">
	<div class="col-sm-6">
		<h2>Our Door to Door Service</h2>
		<p>We offer a door to door service where we will collect your parcel from your requested collection point and deliver it to it's final destination, on time and in a satisfactory condition.</p>
		<h2>Signed for Service</h2>
		<img src="https://www.ushbub.co.uk/images/signed_for_image.png" class="pull-right col-xs-6" />
		<p>It is important that your delivery reaches it's destination and to maximise the possibility, we offer a "Signed for" service.</p>
	</div>
	<div class="col-sm-6">
		<h2>Our Local Delivery Service</h2>
		<p>We specialise in deliveries 10 miles and under. This provides a sameday delivery service in most cases and we can then ensure we have a driver collect and deliver your parcel(s).</p>
		<p>Sometimes, moving parcels through networks can lead to damage and we simply try to minimise the amount of times your parcel(s) are transferred between vehicles.</p>
		<h2>Our National Delivery Service</h2>
		<p>For all national deliveries, we currently use suitable providers to carry out the deliveries on our behalf.</p>
		<p>We are constantly reviewing our national delivery options and once we can integrate a suitable service, we will keep all our customers informed.</p>
	</div>
</div>

<div class="row delivery_parcel_sizes">
	<div class="col-sm-6">
		<h2>How we define parcel sizes</h2>
		<table class="table table-condensed">
			<thead>
				<th style="color:#efefef;">Category</th>
				<th style="color:#efefef;">Max Length</th>
				<th style="color:#efefef;">Max Width</th>
				<th style="color:#efefef;">Max Height</th>
				<th style="color:#efefef;">Max Weight</th>
			</thead>
			<tbody>
				<tr style="color:#efefef;">
					<td>Small</td><td>45 cm</td><td>35 cm</td><td>16 cm</td><td>5 kg</td>
				</tr>
				<tr style="color:#efefef;">
					<td>Medium</td><td>61 cm</td><td>45 cm</td><td>45 cm</td><td>12 kg</td>
				</tr>
				<tr style="color:#efefef;">
					<td>Large</td><td>100 cm</td><td>80 cm</td><td>80 cm</td><td>25 kg</td>
				</tr>
				<tr style="color:#efefef;">
					<td>X-Large</td><td>1200 cm</td><td>80 cm</td><td>100 cm</td><td>300 kg</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="col-sm-6">
		<h2>Why are parcel sizes relevant?</h2>
		<p>Our parcel sizes allow us to best match you to the type of delivery service required.</p>
		<p>Based on the product size we may also need to ensure there two people collecting your parcel(s) and we have the correct type of vehicle and equipment.</p>
	</div>
</div>
<div class="row delivery_parcel_services">
	<div class="col-sm-6">
		<h2>Economic Delivery Service</h2>
		<p>Our economic delivery service is designed to offer you a discounted service where we provide a delivery which is best priced based on your requirements. The service is typically 5 to 7 days from collection to delivery.</p>
		<h2>Standard Delivery Service</h2>
		<p>Our Standard delivery service is designed to offer you a service where we provide a delivery which is not only priced based on your requirements but also in 2 to 4 days from collection to delivery.</p>
	</div>
	<div class="col-sm-6">
		<h2>Timed Delivery Service</h2>
		<p>Our timed delivery service is here to offer you a delivery window where we ensure your parcel(s) are delivered within a timed window best suited to your requirements.</p>
		<h2>Express Delivery Service</h2>
		<p>If you need a parcel delivered by a certain time, then our express delivery service is your best option.</p>
		<p>Perhaps you need your parcel delivered by 12:00pm midday. Select our Express service in this case.</p>
	</div>
</div>
<?php echo $this->_customloginShopboxView->render(); ?>