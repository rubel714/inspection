<?php
try {

	apiLogWrite("\n\n========$PageName=======Called (" . date('Y_m_d_H_i_s') . ")===================");
	apiLogWrite("Params (" . date('Y_m_d_H_i_s') . "): " . json_encode($data));

	$db = new Db();

	$ClientId = 1;
	$TransactionTypeId = 5; //Funnel Status
	$TransactionDate = date('Y-m-d H:i:s');
	$InvoiceNo = date('YmdHis');

	$UserId = isset($data['UserInfoID']) ? checkNull($data['UserInfoID']) : null;
	$CustomerId = isset($data['CustomerID']) ? checkNull($data['CustomerID']) : "NULL";
	$ContactPersonName = isset($data['ContactPersonName']) ?  checkNull($data['ContactPersonName']) : null;
	$ContactPersonDesignation = isset($data['ContactPersonDesignation']) ?  checkNull($data['ContactPersonDesignation']) : null;
	$ContactPersonMobileNumber = isset($data['ContactPersonMobileNumber']) ?  checkNull($data['ContactPersonMobileNumber']) : null;
	$ProductName = isset($data['ProductName']) ? checkNull($data['ProductName']) : null;
	$ExpectedPrice = isset($data['ExpectedPrice']) ? checkNull($data['ExpectedPrice']) : null;
	$FinalPrice = isset($data['FinalPrice']) ? checkNull($data['FinalPrice']) : null;
	$DropDownListIDForFunnelStatus = isset($data['FunnelStatusID']) ? checkNull($data['FunnelStatusID']) : null;
	$NegotiablePrice = isset($data['NegotiablePrice']) ? checkNull($data['NegotiablePrice']) : null;
	$OfferQuantity = isset($data['OfferQuantity']) ? checkNull($data['OfferQuantity']) : null;
	$RequiredQuantity = isset($data['RequiredQuantity']) ? checkNull($data['RequiredQuantity']) : null;

	// {
	// 	"UserInfoID": 3,
	// 	"CustomerID": 1,
	// 	"ContactPersonName": "kk 254",
	// 	"ContactPersonDesignation": "dev 01",
	// 	"ContactPersonMobileNumber": "01921232956",
	// 	"ExpectedPrice": "1000",
	// 	"FinalPrice": "2000",
	// 	"FunnelStatusID": "5",
	// 	"NegotiablePrice": "1500",
	// 	"OfferQuantity": "5",
	// 	"ProductName": "lin45 ef",
	// 	"RequiredQuantity": "4",
	//   }

$query = "INSERT INTO t_transaction(ClientId, TransactionTypeId, TransactionDate, InvoiceNo, 
	CustomerId, DropDownListIDForFunnelStatus, ProductName, 
	ContactPersonName, ContactPersonDesignation, ContactPersonMobileNumber, ExpectedPrice, 
	FinalPrice, NegotiablePrice,OfferQuantity,RequiredQuantity, UserId, UpdateTs, CreateTs) 
	VALUES (:ClientId, :TransactionTypeId, :TransactionDate, :InvoiceNo, 
	:CustomerId, :DropDownListIDForFunnelStatus, :ProductName, 
	:ContactPersonName, :ContactPersonDesignation, :ContactPersonMobileNumber, :ExpectedPrice, 
	:FinalPrice, :NegotiablePrice,:OfferQuantity,:RequiredQuantity, :UserId, :UpdateTs, :CreateTs);";

$pList = array(
	'ClientId' => $ClientId,
	'TransactionTypeId' => $TransactionTypeId,
	'TransactionDate' => $TransactionDate,
	'InvoiceNo' => $InvoiceNo,
	'CustomerId' => $CustomerId,
	'DropDownListIDForFunnelStatus' => $DropDownListIDForFunnelStatus,
	'ProductName' => $ProductName,
	'ContactPersonName' => $ContactPersonName,
	'ContactPersonDesignation' => $ContactPersonDesignation,
	'ContactPersonMobileNumber' => $ContactPersonMobileNumber,
	'ExpectedPrice' => $ExpectedPrice,
	'FinalPrice' => $FinalPrice,
	'NegotiablePrice' => $NegotiablePrice,
	'OfferQuantity' => $OfferQuantity,
	'RequiredQuantity' => $RequiredQuantity,
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