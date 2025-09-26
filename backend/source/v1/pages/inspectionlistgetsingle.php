<?php

try {
	apiLogWrite("\n\n========$PageName=======Called (" . date('Y_m_d_H_i_s') . ")===================");
	apiLogWrite("Params (" . date('Y_m_d_H_i_s') . "): " . json_encode($data));

	$dbh = new Db();
	$TransactionId =  isset($data['TransactionId']) ? $data['TransactionId'] : '';
	$CategoryId =  isset($data['CategoryId']) ? $data['CategoryId'] : '';

	if ($TransactionId == "") {
		$apiResponse = json_encode(recordNotFoundMsg(0, "TransactionId param is missing"));
		apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
		echo $apiResponse;
		return;
	}

	if ($CategoryId == "") {
		$apiResponse = json_encode(recordNotFoundMsg(0, "CategoryId param is missing"));
		apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
		echo $apiResponse;
		return;
	}

	$query = "SELECT a.TransactionItemId as autoId,a.`TransactionItemId`, a.`TransactionId`,a.CategoryId, a.`CheckName`,
			a.CheckType,a.RowNo,a.ColumnNo,a.PhotoUrl,'' PhotoUrlChanged, '' PhotoUrlPreview, '' PhotoUrlUpload, a.SortOrder
			FROM t_transaction_items a
			where a.TransactionId=$TransactionId
			and (a.CategoryId = $CategoryId OR $CategoryId = 0)
			order by a.SortOrder ASC;";

	$resultdata = $dbh->query($query);

	if (is_object($resultdata)) {
		$errormsg = $resultdata->errorInfo;
		$apiResponse = json_encode(recordNotFoundMsg(0, $errormsg[2]));
		apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
		echo $apiResponse;
	} else if (count($resultdata) === 0) {
		$apiResponse = json_encode(recordNotFoundMsg());
		apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
		echo $apiResponse;
	} else {
		echo json_encode($resultdata);
		apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): Success");
	}
} catch (PDOException $e) {
	$apiResponse = json_encode(recordNotFoundMsg(0, $e->getMessage()));
	apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
	echo $apiResponse;
}
