<?php

$task = '';
if (isset($data->action)) {
	$task = trim($data->action);
}

switch ($task) {

	case "getDataList":
		$returnData = getDataList($data);
		break;
	case "getBuyerList":
		$returnData = getBuyerList($data);
		break;
	case "getFactoryList":
		$returnData = getFactoryList($data);
		break;
	default:
		echo "{failure:true}";
		break;
}

function getDataList($data)
{
	$StartDate = trim($data->StartDate);
	$EndDate = trim($data->EndDate) . " 23-59-59";

	$BuyerName = trim($data->BuyerId->id);
	$FactoryName = trim($data->FactoryId->id);

	try {
		$dbh = new Db();

		$query = "SELECT a.TransactionId, DATE(a.`TransactionDate`) TransactionDate, 
		a.InvoiceNo,a.BuyerName,a.SupplierName,a.FactoryName,b.CheckType,b.CheckName
		FROM `t_transaction` a
		inner join t_transaction_items b on a.TransactionId = b.TransactionId
		where (a.TransactionDate between '$StartDate' and '$EndDate')
		and b.CheckType != 'R'
		and (a.BuyerName = '$BuyerName' or '$BuyerName' = '0')
		and (a.FactoryName = '$FactoryName' or '$FactoryName' = '0')
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


function getBuyerList($data)
{
	try {

		$dbh = new Db();

		$StartDate = trim($data->StartDate);
		$EndDate = trim($data->EndDate) . " 23-59-59";

		$query = "SELECT distinct BuyerName id, BuyerName name
			FROM `t_transaction`
			where (TransactionDate between '$StartDate' and '$EndDate')
			and BuyerName is not null 
			and BuyerName != ''
			ORDER BY BuyerName ASC;";

		$resultdata = $dbh->query($query);

		$returnData = [
			"success" => 1,
			"status" => 200,
			"message" => "",
			"datalist" => $resultdata
		];
	} catch (PDOException $e) {
		$returnData = msg(0, 500, $e->getMessage());
	}

	return $returnData;
}


function getFactoryList($data)
{
	try {

		$dbh = new Db();

		$StartDate = trim($data->StartDate);
		$EndDate = trim($data->EndDate) . " 23-59-59";

		$query = "SELECT distinct FactoryName id, FactoryName name
			FROM `t_transaction`
			where (TransactionDate between '$StartDate' and '$EndDate')
			and FactoryName is not null 
			and FactoryName != ''
			ORDER BY FactoryName ASC;";

		$resultdata = $dbh->query($query);

		$returnData = [
			"success" => 1,
			"status" => 200,
			"message" => "",
			"datalist" => $resultdata
		];
	} catch (PDOException $e) {
		$returnData = msg(0, 500, $e->getMessage());
	}

	return $returnData;
}