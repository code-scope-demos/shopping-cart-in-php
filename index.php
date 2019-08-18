<?php require 'header.php'; ?>

<?php 

$con = $dbconnection;

$getProducts = 'SELECT * FROM products';

$products = mysqli_query($con,$getProducts);

$cartItems = array();

if (isset($_GET['cartAction'])) {
	
	if ($_GET['cartAction'] == 'add') {
		if (!in_array($_GET['id'], $_SESSION['cart'])) {
			$_SESSION['cart'][] =   array(
		    'item_id' => $_GET['id'],
		    'item_qty' => 1,
		  	);
			header('location:'.basename($_SERVER['PHP_SELF']));
		}
		else{
			header('location:'.basename($_SERVER['PHP_SELF']));
		}

	}
	elseif ($_GET['cartAction'] == 'remove') {
		
	}
}

if (isset($_SESSION['cart'])) {
	$cartItems = $_SESSION['cart'];
}

$cartItems = array_column($cartItems,'item_id');
function cartBtn($id,$cartItems)
{
	if (!in_array($id, $cartItems)) {
		$button = '<a href="'.basename($_SERVER['PHP_SELF']).'?cartAction=add&id='.$id.'">Add to Cart</a>';
	}
	else{
		$button = '<span class="d-flex justify-content-center"><i class="material-icons font-weight-bold">check</i></span>';
	}
	return $button;
}

 ?>

	<main class="py-2">
		<div class="container">

			<div class="py-2 font-weight-bold text-right">
				<i class="material-icons align-middle">shopping_cart</i> (<span class="px-1"><?php echo count($cartItems); ?></span>) Items in Cart
			</div>
			
			<div class="row">

				<?php 

				while ($product = $products->fetch_assoc()) {
					echo '
					<div class="col-md-3 py-2">
						<div class="card text-center">
							<div class="card-body">
								<div class="d-flex flex-column font-weight-bold">
									<div><img src="'.$product["item_image"].'"style="max-height:180px; max-width:180px;"/></div>
									<div class="p-1 text-muted">'.$product["item_name"].'</div>
									<div class="p-1">$'.$product["item_price"].'</div>
								</div>
							</div>
							<div class="card-footer bg-white text-primary">
								'.cartBtn($product['item_id'],$cartItems).'
							</div>
						</div>
					</div>
					';
				}

				 ?>
				
			</div>

			<div class="py-5 font-weight-bold text-center">
				<a href="cart.php" class="btn font-weight-bold text-primary">Continue</a>
			</div>

		</div>
	</main>	

<?php require 'footer.php'; ?>
