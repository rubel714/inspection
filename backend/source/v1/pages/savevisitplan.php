<?php
try {

	apiLogWrite("\n\n========$PageName=======Called (" . date('Y_m_d_H_i_s') . ")===================");
	apiLogWrite("Params (" . date('Y_m_d_H_i_s') . "): " . json_encode($data));

	$db = new Db();

	$ClientId = 1;
	$TransactionTypeId = 2; //Visit Plan
	$CurrentDateTime = date('Y-m-d H:i:s');
	$InvoiceNo = date('YmdHis');

	$UserId = isset($data['UserInfoID']) ? checkNull($data['UserInfoID']) : null;
	$TransactionDate = isset($data['NextVisitDateTime']) ? convertAppToDBDateTime(checkNull($data['NextVisitDateTime'])) : null; //21-Aug-2024 5:15 AM
	$CustomerId = isset($data['CustomerID']) ? checkNull($data['CustomerID']) : "NULL";
	$SelfDiscussion = isset($data['VisitPurpose']) ? checkNull($data['VisitPurpose']) : null;


	if ($TransactionDate == "" ) {
		$apiResponse = json_encode(recordNotFoundMsg(0, "NextVisitDateTime param is missing"));
		apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
		echo $apiResponse;
		return;
	}

	// {
	// 	"SalesForceCustomerVisitID": "",
	// 	"UserInfoID": 3,
	// 	"NextVisitDateTime": "21-Aug-2024 5:15 AM",
	// 	"CustomerID": 2,
	// 	"VisitPurpose": ""
	//   }

	$query = "INSERT INTO t_transaction(ClientId, TransactionTypeId, TransactionDate, InvoiceNo, 
		CustomerId, SelfDiscussion,	UserId, UpdateTs, CreateTs) 
		VALUES (:ClientId, :TransactionTypeId, :TransactionDate, :InvoiceNo, 
		:CustomerId, :SelfDiscussion, :UserId, :UpdateTs, :CreateTs);";

$pList = array(
	'ClientId' => $ClientId,
	'TransactionTypeId' => $TransactionTypeId,
	'TransactionDate' => $TransactionDate,
	'InvoiceNo' => $InvoiceNo,
	'CustomerId' => $CustomerId,
	'SelfDiscussion' => $SelfDiscussion,
	'UserId' => $UserId,
	'UpdateTs' => $CurrentDateTime,
	'CreateTs' => $CurrentDateTime
);

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