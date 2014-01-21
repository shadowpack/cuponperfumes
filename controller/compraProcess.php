<?php
	@session_start();
	@require_once("../model/db_core.php");
	@require_once("../model/checkout.php");
	$checkout = new checkout();
	switch($_POST['action'])
	{
		case 0:
			$checkout->newProduct($_POST['id']);
			echo "true";
			break;
		case 1:
			$checkout->addProduct();
			$con['status'] = true;
			$con['total'] = $checkout->getTotal();
			echo json_encode((object)$con);
			break;	
		case 2:
			$checkout->removeProduct();
			$con['status'] = true;
			$con['total'] = $checkout->getTotal();
			echo json_encode((object)$con);
			break;
		case 3:
			$checkout->setDelivery(filter_var($_POST['delivery'], FILTER_VALIDATE_BOOLEAN));
			$con['status'] = true;
			$con['total'] = $checkout->getTotal();
			echo json_encode((object)$con);
			break;
	}
?>
