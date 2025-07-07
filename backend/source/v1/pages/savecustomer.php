<?php
try {

	apiLogWrite("\n\n========$PageName=======Called (" . date('Y_m_d_H_i_s') . ")===================");
	apiLogWrite("Params (" . date('Y_m_d_H_i_s') . "): " . json_encode($data));

	$db = new Db();

	$ClientId = 1;
	$TransactionDate = date('Y-m-d H:i:s');

	$UserId = isset($data['UserInfoID']) ? checkNull($data['UserInfoID']) : null;
	$CustomerCode = isset($data['CustomerCode']) ? checkNull($data['CustomerCode']) : null;
	$CustomerName = isset($data['CustomerName']) ? checkNull($data['CustomerName']) : null;
	$Designation = isset($data['Designation']) ? checkNull($data['Designation']) : null;
	$ContactPhone = isset($data['ContactNumber']) ? checkNull($data['ContactNumber']) : null;

	$CompanyName = isset($data['CompanyName']) ? checkNull($data['CompanyName']) : null;
	$NatureOfBusiness = isset($data['NatureOfBusiness']) ? checkNull($data['NatureOfBusiness']) : null;
	$CompanyEmail = isset($data['CompanyEmail']) ? checkNull($data['CompanyEmail']) : null;
	$CompanyAddress = isset($data['CompanyAddress']) ? checkNull($data['CompanyAddress']) : null;
	$IsActive = 1;

	// {
	// 	"CustomerCode": "",
	// 	"CustomerName": "Rubel",
	// 	"Designation": "Manager",
	// 	"ContactNumber": "01538198763",
	// 	"CompanyName": "ACI Group Ltd",
	// 	"NatureOfBusiness": "Multiple type business",
	// 	"CompanyEmail": "",
	// 	"CompanyAddress": "",
	// 	"UserInfoID": 3,
	// 	"TerminalID": "",
	// 	"IPAddress": ""
	//   }
	if(!$CustomerCode){
		$CustomerCode = date('YmdHis');
	}

	$query = "INSERT INTO t_customer(ClientId, CustomerCode, CustomerName, Designation, 
		ContactPhone, CompanyName, NatureOfBusiness, CompanyEmail, 
		CompanyAddress, IsActive, UserId, UpdateTs, CreateTs) 
		VALUES (:ClientId, :CustomerCode, :CustomerName, :Designation, 
		:ContactPhone, :CompanyName, :NatureOfBusiness, :CompanyEmail,
		:CompanyAddress, :IsActive, :UserId, :UpdateTs, :CreateTs);";

	$pList = array(
		'ClientId' => $ClientId,
		'CustomerCode' => $CustomerCode,
		'CustomerName' => $CustomerName,
		'Designation' => $Designation,
		'ContactPhone' => $ContactPhone,
		'CompanyName' => $CompanyName,
		'NatureOfBusiness' => $NatureOfBusiness,
		'CompanyEmail' => $CompanyEmail,
		'CompanyAddress' => $CompanyAddress,
		'IsActive' => $IsActive,
		'UserId' => $UserId,
		'UpdateTs' => $TransactionDate,
		'CreateTs' => $TransactionDate
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
		apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
	}
} catch (PDOException $e) {
	$apiResponse = json_encode(recordNotFoundMsg(0, $e->getMessage()));
	apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
	echo $apiResponse;
}
