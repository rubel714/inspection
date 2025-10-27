<?php
try {

	apiLogWrite("\n\n========$PageName=======Called (" . date('Y_m_d_H_i_s') . ")===================");
	apiLogWrite("Params (" . date('Y_m_d_H_i_s') . "): " . json_encode($data));

	$db = new Db();
	$TransactionId = isset($data['TransactionId']) ? checkNull($data['TransactionId']) : "";
	$PhotoUrl = isset($data['PhotoUrl']) ? checkNull($data['PhotoUrl']) : "";

	if ($TransactionId == "") {
		$apiResponse = json_encode(recordNotFoundMsg(0, "TransactionId param is missing"));
		apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
		echo $apiResponse;
		return;
	}

	if ($PhotoUrl == "") {
		$apiResponse = json_encode(recordNotFoundMsg(0, "PhotoUrl param is missing"));
		apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
		echo $apiResponse;
		return;
	}


	$query = "SELECT ManyImgPrefix
	FROM t_transaction a
	where a.TransactionId=$TransactionId;";
	$resultdatalist = $db->query($query);
	$ManyImgPrefix = $resultdatalist[0]["ManyImgPrefix"];

	$result = $PhotoUrl ? ConvertImageAPIBulk($PhotoUrl, $ManyImgPrefix) : "";

	if ($result == "") {
		$apiResponse = json_encode(recordNotFoundMsg(0, "Image is not valid"));
		apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
		echo $apiResponse;
	} else {
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