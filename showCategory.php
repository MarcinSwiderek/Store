<?php

$_SESSION['category_id']=$category['category_id'];
if(isset($_SESSION['category_id'])){
	$catID=$_SESSION['category_id'];
?>
	<div>
		<?php $items=category::getAllItemsIDs($catID, $conn);
			  foreach($items as $item) {
			  	echo $item['item_id'];
			  }
		?>
	
	</div>



<?php }?>