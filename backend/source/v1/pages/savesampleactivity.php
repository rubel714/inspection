<?php
try {

	apiLogWrite("\n\n========$PageName=======Called (" . date('Y_m_d_H_i_s') . ")===================");
	apiLogWrite("Params (" . date('Y_m_d_H_i_s') . "): " . json_encode($data));

	$db = new Db();

	$ClientId = 1;
	$TransactionTypeId = 4; //Sample
	$TransactionDate = date('Y-m-d H:i:s');
	$InvoiceNo = date('YmdHis');

	$UserId = isset($data['UserInfoID']) ? checkNull($data['UserInfoID']) : null;
	$DropDownListIDForPurpose = isset($data['DropDownListIDForPurpose']) ? checkNull($data['DropDownListIDForPurpose']) : null;
	$CustomerId = isset($data['CustomerID']) ? checkNull($data['CustomerID']) : "NULL";
	$ContactPersonName = isset($data['ContactPersonName']) ?  checkNull($data['ContactPersonName']) : null;
	$ContactPersonDesignation = isset($data['ContactPersonDesignation']) ?  checkNull($data['ContactPersonDesignation']) : null;
	$ContactPersonMobileNumber = isset($data['ContactPersonMobileNumber']) ?  checkNull($data['ContactPersonMobileNumber']) : null;
	$ProductDetails = isset($data['ProductDetails']) ? checkNull($data['ProductDetails']) : null;
	$TargetPrice = isset($data['TargetPrice']) ? checkNull($data['TargetPrice']) : null;
	$SalesOrderVolume = isset($data['SalesOrderVolume']) ? checkNull($data['SalesOrderVolume']) : null;
	$DropDownListIDForVisitAction = isset($data['DropDownListIDForAction']) ? checkNull($data['DropDownListIDForAction']) : null;
	$DropDownListIDForActivityResult = isset($data['DropDownListIDForResult']) ? checkNull($data['DropDownListIDForResult']) : null;

	// {
	// 	"UserInfoID": 124,
	// 	"CustomerID": 4074,
	// 	"DropDownListIDForPurpose": 8,
	// 	"DropDownListIDForAction": 12

	// 	"ContactPersonName": "kk",
	// 	"ContactPersonDesignation": "dev",
	// 	"ContactPersonMobileNumber": "019",
	// 	"ProductDetails": "kk",
	// 	"TargetPrice": 128,
	// 	"SalesOrderVolume": 1281,
	// 	"DropDownListIDForResult": 12,
	//   }

	/**Draft */
// echo "===".$MachineId."====";
	$query = "INSERT INTO t_transaction(ClientId, TransactionTypeId, TransactionDate, InvoiceNo, 
		CustomerId, DropDownListIDForPurpose, DropDownListIDForVisitAction, 
		ContactPersonName, ContactPersonDesignation, ContactPersonMobileNumber, ProductDetails, 
		TargetPrice, SalesOrderVolume,DropDownListIDForActivityResult, UserId, UpdateTs, CreateTs) 
		VALUES (:ClientId, :TransactionTypeId, :TransactionDate, :InvoiceNo, 
		:CustomerId, :DropDownListIDForPurpose, :DropDownListIDForVisitAction, 
		:ContactPersonName, :ContactPersonDesignation, :ContactPersonMobileNumber, :ProductDetails, 
		:TargetPrice, :SalesOrderVolume,:DropDownListIDForActivityResult, :UserId, :UpdateTs, :CreateTs);";

$pList = array(
	'ClientId' => $ClientId,
	'TransactionTypeId' => $TransactionTypeId,
	'TransactionDate' => $TransactionDate,
	'InvoiceNo' => $InvoiceNo,
	'CustomerId' => $CustomerId,
	'DropDownListIDForPurpose' => $DropDownListIDForPurpose,
	'DropDownListIDForVisitAction' => $DropDownListIDForVisitAction,
	'ContactPersonName' => $ContactPersonName,
	'ContactPersonDesignation' => $ContactPersonDesignation,
	'ContactPersonMobileNumber' => $ContactPersonMobileNumber,
	'ProductDetails' => $ProductDetails,
	'TargetPrice' => $TargetPrice,
	'SalesOrderVolume' => $SalesOrderVolume,
	'DropDownListIDForActivityResult' => $DropDownListIDForActivityResult,
	'UserId' => $UserId,
	'UpdateTs' => $TransactionDate,
	'CreateTs' => $TransactionDate
);
// echo "<pre>";
// print_r($pList);
	$db->bindMore($pList);

	$resultdata = $db->query($query);

	if (is_object($resultdata)) {
		$errormsg = $resultdata->errorInfo;
		$apiResponse = json_encode(recordNotFoundMsg(0, $errormsg[2]));
		apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
		echo $apiResponse;
	} else {
		$response = array(["SysValue" => 1, "SysMessage" => "Data has been saved successfully"]);
		$apiResponse = json_encode($response);
		echo $apiResponse;
		apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): ".$apiResponse);
	}
} catch (PDOException $e) {
	$apiResponse = json_encode(recordNotFoundMsg(0, $e->getMessage()));
	apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
	echo $apiResponse;
}