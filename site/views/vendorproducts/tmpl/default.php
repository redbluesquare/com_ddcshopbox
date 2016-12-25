<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

if(count($this->items)>0):
?>
<table cellpadding="0" cellspacing="0" width="100%" class="table table-striped">
	<tbody id="product-list">
		<?php for($i=0, $n = count($this->items);$i<$n;$i++) { 
		        $this->_productsListView->item = $this->items[$i];
		        $this->_productsListView->type = 'item';
		        echo $this->_productsListView->render();
		} ?>
	</tbody>
</table>
<?php
endif;
?>