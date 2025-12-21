<?php

$task = '';
if (isset($data->action)) {
	$task = trim($data->action);
}

switch ($task) {

	case "getDataList":
		$returnData = getDataList($data);
		break;
	default:
		echo "{failure:true}";
		break;
}

function getDataList($data)
{

	// $pTransactionId = $data->TransactionId ? $data->TransactionId : 0;
	// $pCategoryId = $data->CategoryId ? $data->CategoryId : 0;

	$StartDate = trim($data->StartDate);
	$EndDate = trim($data->EndDate) . " 23-59-59";

	try {
		$dbh = new Db();

		$query = "SELECT a.TransactionId, DATE(a.`TransactionDate`) TransactionDate, 
		a.InvoiceNo,a.BuyerName,a.SupplierName,a.FactoryName,b.CheckType,b.CheckName
		FROM `t_transaction` a
		inner join t_transaction_items b on a.TransactionId = b.TransactionId
		where (a.TransactionDate between '$StartDate' and '$EndDate')
		and b.CheckType != 'R'
		ORDER BY a.`TransactionDate` DESC, a.InvoiceNo ASC;";

		$resultdatalist = $dbh->query($query);

		$returnData = [
			"success" => 1,
			"status" => 200,
			"message" => "",
			"datalist" => $resultdatalist
		];
	} catch (PDOException $e) {
		$returnData = msg(0, 500, $e->getMessage());
	}

	return $returnData;
}
