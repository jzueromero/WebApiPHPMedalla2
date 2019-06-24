<?php
include("connection.php");
	$db = new dbObj();
	$connection =  $db->getConnstring();
 
    $request_method=$_SERVER["REQUEST_METHOD"];

    switch($request_method)
	{
		case 'GET':
		// Retrive Pedidos
		if(!empty($_GET["id"]))
		{
		$id=intval($_GET["id"]);
		get_pedidosById($id);
		}
		else
		{
		get_pedidos();
		}
        break;
        case 'POST':
        // Insert Product
        insert_pedido();
        break;
		default:
		// Invalid Request Method
		header("HTTP/1.0 405 Method Not Allowed");
		break;
	}
  	
function get_pedidos()
	{
		global $connection;
		$query="SELECT * FROM pedido_test";
		$response=array();
		$result=mysqli_query($connection, $query);
		while($row=mysqli_fetch_array($result))
		{
		$response[]=$row;
		}
		header('Content-Type: application/json');
		echo json_encode($response);
    }
 function get_pedidosById($id=0)
{
	global $connection;
	$query="SELECT * FROM pedido_test";
	if($id != 0)
	{
		$query.=" WHERE id=".$id." LIMIT 1";
	}
	$response=array();
	$result=mysqli_query($connection, $query);
	while($row=mysqli_fetch_array($result))
	{
		$response[]=$row;
	}
	header('Content-Type: application/json');
	echo json_encode($response);
}

function insert_pedido()
	{
		global $connection;

		$data = json_decode(file_get_contents('php://input'), true);
		$Cliente=$data["Cliente"];
		echo $query="INSERT INTO pedido_test SET cliente='".$Cliente."'" ;
		if(mysqli_query($connection, $query))
		{
			$response=array(
				'status' => 1,
				'status_message' =>'Pedido Agregado Satisfactoriamente.'
			);
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>'Pedido No se puedo agregar.'
			);
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}

?>