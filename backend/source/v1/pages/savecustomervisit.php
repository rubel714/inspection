<?php
try {

	apiLogWrite("\n\n========$PageName=======Called (" . date('Y_m_d_H_i_s') . ")===================");
	apiLogWrite("Params (" . date('Y_m_d_H_i_s') . "): " . json_encode($data));

	$db = new Db();

	$ClientId = 1;
	$TransactionTypeId = 1;
	$TransactionDate = date('Y-m-d H:i:s');
	$InvoiceNo = date('YmdHis');

	$UserId = isset($data['UserInfoID']) ? checkNull($data['UserInfoID']) : null;
	$PunchLocation = isset($data['PunchLocation']) ? checkNull($data['PunchLocation']) : null;
	$Longitude = isset($data['Longitude']) ? checkNull($data['Longitude']) : null;
	$Latitude = isset($data['Latitude']) ? checkNull($data['Latitude']) : null;
	$CustomerId = isset($data['CustomerID']) ? checkNull($data['CustomerID']) : "NULL";
	$DropDownListIDForPurpose = isset($data['DropDownListIDForPurpose']) ? checkNull($data['DropDownListIDForPurpose']) : null;
	$DropDownListIDForTransportation = isset($data['DropDownListIDForTransportation']) ? checkNull($data['DropDownListIDForTransportation']) : null;
	$ConveyanceAmount = isset($data['ConveyanceAmount']) ? checkNull($data['ConveyanceAmount']) : null;
	$RefreshmentAmount = isset($data['RefreshmentAmount']) ? checkNull($data['RefreshmentAmount']) : null;
	$PublicTransportDesc = isset($data['PublicTransportDesc']) ? checkNull($data['PublicTransportDesc']) : null;
	$DummyCustomerDesc = isset($data['DummyCustomerDesc']) ? checkNull($data['DummyCustomerDesc']) : null;
	$MachineId = isset($data['MachineId']) ? checkNull($data['MachineId']) : null;
	$MachineModelId = isset($data['MachineModelId']) ?  checkNull($data['MachineModelId']) : null;
	$MachineSerial = isset($data['MachineSerial']) ?  checkNull($data['MachineSerial']) : null;
	$MachineComplain = isset($data['MachineComplain']) ?  checkNull($data['MachineComplain']) : null;
	$visitStartLocation = isset($data['visitStartLocation']) ?  checkNull($data['visitStartLocation']) : null;
	$visitStartTime = isset($data['visitStartTime']) ?  checkNull($data['visitStartTime']) : null;
	$StatusId = 1;
	/**Draft */
// echo "===".$MachineId."====";
	$query = "INSERT INTO t_transaction(ClientId, TransactionTypeId, TransactionDate, InvoiceNo, visitStartLocation,
		visitStartTime,PunchLocation, Longitude, Latitude, CustomerId, DropDownListIDForPurpose, DropDownListIDForTransportation, 
		ConveyanceAmount, RefreshmentAmount, PublicTransportDesc, DummyCustomerDesc, 
		MachineId, MachineModelId, MachineSerial, MachineComplain, 
		UserId, UpdateTs, CreateTs) VALUES (:ClientId, :TransactionTypeId, :TransactionDate, :InvoiceNo, :visitStartLocation,
		:visitStartTime,:PunchLocation, :Longitude, :Latitude, :CustomerId, :DropDownListIDForPurpose, :DropDownListIDForTransportation, 
		:ConveyanceAmount, :RefreshmentAmount, :PublicTransportDesc, :DummyCustomerDesc, 
		:MachineId, :MachineModelId, :MachineSerial, :MachineComplain, 
		:UserId, :UpdateTs, :CreateTs);";

$pList = array(
	'ClientId' => $ClientId,
	'TransactionTypeId' => $TransactionTypeId,
	'TransactionDate' => $TransactionDate,
	'InvoiceNo' => $InvoiceNo,
	'visitStartLocation' => $visitStartLocation,
	'visitStartTime' => $visitStartTime,
	'PunchLocation' => $PunchLocation,
	'Longitude' => $Longitude,
	'Latitude' => $Latitude,
	'CustomerId' => $CustomerId,
	'DropDownListIDForPurpose' => $DropDownListIDForPurpose,
	'DropDownListIDForTransportation' => $DropDownListIDForTransportation,
	'ConveyanceAmount' => $ConveyanceAmount,
	'RefreshmentAmount' => $RefreshmentAmount,
	'PublicTransportDesc' => $PublicTransportDesc,
	'DummyCustomerDesc' => $DummyCustomerDesc,
	'MachineId' => $MachineId,
	'MachineModelId' => $MachineModelId,
	'MachineSerial' => $MachineSerial,
	'MachineComplain' => $MachineComplain,
	'UserId' => $UserId,
	'UpdateTs' => $TransactionDate,
	'CreateTs' => $TransactionDate
);
// echo "<pre>";
// print_r($data);
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