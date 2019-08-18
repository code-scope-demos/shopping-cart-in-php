<?php require 'header.php'; ?>

<?php 

if (isset($_GET['cartAction'])) {
	if ($_GET['cartAction'] == 'clear') {
		unset($_SESSION['cart']);
	}
	elseif ($_GET['cartAction'] == 'remove') {
			foreach($_SESSION['cart'] as $subKey => $subArray){
	          if($subArray['item_id'] == $_GET['id']){
	               unset($_SESSION['cart'][$subKey]);
	          }
     		}
		header('location:'.basename($_SERVER['PHP_SELF']));

	}
	elseif ($_GET['cartAction'] == 'addQty') {

		foreach($_SESSION['cart'] as $subKey => $subArray){
	          if($subArray['item_id'] == $_GET['id']){
	               $_SESSION['cart'][$subKey]['item_qty'] ++;
	          }
     		}
		header('location:'.basename($_SERVER['PHP_SELF']));
	}
	elseif ($_GET['cartAction'] == 'lessQty') {
		
		foreach($_SESSION['cart'] as $subKey => $subArray){
	          if($subArray['item_id'] == $_GET['id']){
	               if ($_SESSION['cart'][$subKey]['item_qty'] > 1) {
	               	$_SESSION['cart'][$subKey]['item_qty'] --;
	               }
	               else{
	               	unset($_SESSION['cart'][$subKey]);
	               }
	          }
     		}
		header('location:'.basename($_SERVER['PHP_SELF']));
	}
}

 ?>

<main class="py-2">
	<div class="container">

		<div class="py-2 font-weight-bold d-flex justify-content-between">
			<a href="<?php echo basename($_SERVER['PHP_SELF']).'?cartAction=clear'; ?>" class="btn text-primary">
				<i class="material-icons align-bottom">delete_outline</i> Clear Cart
			</a>
			<a href="index.php" class="btn text-primary">
				<i class="material-icons align-middle">chevron_left</i> Back to Shop
			</a>
		</div>
		
		<div class="d-block">
			<table class="table align-middle">
				<tbody>
				<?php 
				
					$con = $dbconnection;
					$totalAmount = 0;
					if (isset($_SESSION['cart']) && count($_SESSION['cart']) != 0) {
						$cartItems['items'] = array_column($_SESSION['cart'], 'item_id');
						$cartItems['qty'] = array_column($_SESSION['cart'], 'item_qty','item_id');
						$getItemDetails = "SELECT * FROM products WHERE item_id IN (".implode(',', $cartItems['items']).")";
						$items = mysqli_query($con,$getItemDetails);
						while ($item = $items->fetch_assoc()) {
							echo '<tr>'.

								 '<td><img src="'.$item['item_image'].'" height="80px"/></td>'.
								 '<td>'.$item['item_name'].'</td>'.
								 '<td><a href="'.basename($_SERVER['PHP_SELF']).'?cartAction=lessQty&id='.$item['item_id'].'" class="rounded-circle border p-1">'.'<i class="material-icons align-bottom">remove</i>'.'</a>'.
								 '<span class="px-3">'.$cartItems['qty'][$item['item_id']].'</span>'.
								 '<a href="'.basename($_SERVER['PHP_SELF']).'?cartAction=addQty&id='.$item['item_id'].'" class="rounded-circle border p-1">'.'<i class="material-icons align-bottom">add</i>'.'</a>'.
								 '</td>'.
								 '<td> $'.$item['item_price'] * $cartItems['qty'][$item['item_id']].'</td>'.
								 '<td><a class="text-danger" href="'.basename($_SERVER['PHP_SELF']).'?cartAction=remove&id='.$item['item_id'].'">Remove</a></td>'.
								 '</tr>';

								 $totalAmount = $totalAmount + $item['item_price'] * $cartItems['qty'][$item['item_id']];
						}
						

					}
					else{
						echo '<tr>
						<div class="alert alert-danger text-center">Your cart is Empty</div>
						</tr>';
					}

				?>
			</tbody>
		</table>
		</div>

		<div class="container-fluid card my-2 col-12 col-md-6">
			<div class="card-header bg-white">
				Price Details
			</div>
			<div class="card-body">
				<div class="d-flex justify-content-between align-items-center">
					<span>Total Amount</span> <span><?php echo '$'.$totalAmount; ?></span>
				</div>
			</div>
		</div>
			
	</div>
</main>	

<?php require 'footer.php'; ?>]



