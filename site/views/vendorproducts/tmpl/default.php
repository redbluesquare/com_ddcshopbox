<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
echo $this->_catsListView->render();
if(count($this->items)>0):
?>
<div id="product-list">
	<?php for($i=0, $n = count($this->items);$i<$n;$i++) { 
		  	$this->_productsListView->item = $this->items[$i];
		    $this->_productsListView->session = $this->session;
		    $this->_productsListView->vendorModel = $this->vendorModel;
		    $this->_productsListView->type = 'item';
		    echo $this->_productsListView->render();
	}
	?>
</div>
<?php
endif;
?>