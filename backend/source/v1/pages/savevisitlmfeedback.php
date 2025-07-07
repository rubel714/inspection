<?php
try {

	apiLogWrite("\n\n========$PageName=======Called (" . date('Y_m_d_H_i_s') . ")===================");
	apiLogWrite("Params (" . date('Y_m_d_H_i_s') . "): " . json_encode($data));

	$db = new Db();

	$TransactionId = isset($data['SalesForceCustomerVisitID']) ? checkNull($data['SalesForceCustomerVisitID']) : null;
	$ApprovedRefreshmentAmount = isset($data['ApprovedRefreshmentAmount']) ? checkNull($data['ApprovedRefreshmentAmount']) : null;
	$ApprovedConveyanceAmount = isset($data['ApprovedConveyanceAmount']) ? checkNull($data['ApprovedConveyanceAmount']) : null;
	$ApprovedDinnerBillAmount = isset($data['ApprovedDinnerBillAmount']) ? checkNull($data['ApprovedDinnerBillAmount']) : null;
	$LMAdvice = isset($data['LMAdvice']) ? checkNull($data['LMAdvice']) : NULL;
	$LMFollowUpDate = isset($data['LMFollowUpDate']) ? convertAppToDBDate(checkNull($data['LMFollowUpDate'])) : null; //'20-Aug-2024'
	$IsLinemanFeedback = "Y";


	$query = "UPDATE t_transaction set ApprovedRefreshmentAmount=:ApprovedRefreshmentAmount,
	ApprovedConveyanceAmount=:ApprovedConveyanceAmount,ApprovedDinnerBillAmount=:ApprovedDinnerBillAmount,
	LMAdvice=:LMAdvice,LMFollowUpDate=:LMFollowUpDate,IsLinemanFeedback=:IsLinemanFeedback
 	where TransactionId=:TransactionId;";
	
	$pList = array(
		'ApprovedRefreshmentAmount' => $ApprovedRefreshmentAmount,
		'ApprovedConveyanceAmount' => $ApprovedConveyanceAmount,
		'ApprovedDinnerBillAmount' => $ApprovedDinnerBillAmount,
		'LMAdvice' => $LMAdvice,
		'LMFollowUpDate' => $LMFollowUpDate,
		'IsLinemanFeedback' => $IsLinemanFeedback,
		'TransactionId' => $TransactionId
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
