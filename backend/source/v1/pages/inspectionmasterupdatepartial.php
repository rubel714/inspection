<?php
try {

	apiLogWrite("\n\n========$PageName=======Called (" . date('Y_m_d_H_i_s') . ")===================");
	apiLogWrite("Params (" . date('Y_m_d_H_i_s') . "): " . json_encode($data));

	$db = new Db();
	$TransactionId = isset($data['TransactionId']) ? checkNull($data['TransactionId']) : "";
	$TemplateId = isset($data['TemplateId']) ? checkNull($data['TemplateId']) : "";
	$StatusId = isset($data['StatusId']) ? checkNull($data['StatusId']) : "";
	$InspectorUserId = isset($data['UserInfoId']) ? checkNull($data['UserInfoId']) : null;

	if ($TransactionId == "") {
		$apiResponse = json_encode(recordNotFoundMsg(0, "TransactionId param is missing"));
		apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
		echo $apiResponse;
		return;
	}

	if ($TemplateId == "") {
		$apiResponse = json_encode(recordNotFoundMsg(0, "TemplateId param is missing"));
		apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
		echo $apiResponse;
		return;
	}

	if ($StatusId == "") {
		$apiResponse = json_encode(recordNotFoundMsg(0, "StatusId param is missing"));
		apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
		echo $apiResponse;
		return;
	}

	

	//get old template id start
	$querydup = "SELECT ifnull(TemplateId,0) as TemplateId, InspectorUserId
	FROM t_transaction
	where TransactionId=$TransactionId;";		
	$resultdatadup = $db->query($querydup);
	$OldInspectorUserId = $resultdatadup[0]["InspectorUserId"];
	$OldTemplateId = $resultdatadup[0]["TemplateId"];
	if($OldTemplateId > 0){
		$InspectorUserId = $OldInspectorUserId;
	}
	//get old template id end



	$query = "UPDATE t_transaction set TemplateId=:TemplateId, StatusId=:StatusId, InspectorUserId=:InspectorUserId
	where TransactionId=:TransactionId;";
	$pList = array(
		'TemplateId' => $TemplateId,
		'StatusId' => $StatusId,
		'TransactionId' => $TransactionId,
		'InspectorUserId' => $InspectorUserId
	);


	$db->bindMore($pList);
	$resultdata = $db->query($query);

	if (is_object($resultdata)) {
		$errormsg = $resultdata->errorInfo;
		$apiResponse = json_encode(recordNotFoundMsg(0, $errormsg[2]));
		apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
		echo $apiResponse;
	} else {

		if ($TransactionId == "") {
			$TransactionId = $db->lastInsertId();
		}

		$response = array(["SysValue" => 1, "SysMessage" => "Data has been saved successfully", "TransactionId" => $TransactionId]);
		$apiResponse = json_encode($response);
		echo $apiResponse;
		apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
	}
} catch (PDOException $e) {
	$apiResponse = json_encode(recordNotFoundMsg(0, $e->getMessage()));
	apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
	echo $apiResponse;
}
