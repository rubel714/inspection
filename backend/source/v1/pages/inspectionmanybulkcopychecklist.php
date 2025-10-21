<?php
try {

	apiLogWrite("\n\n========$PageName=======Called (" . date('Y_m_d_H_i_s') . ")===================");
	apiLogWrite("Params (" . date('Y_m_d_H_i_s') . "): " . json_encode($data));

	$db = new Db();
	$TransactionId = isset($data['TransactionId']) ? checkNull($data['TransactionId']) : "";
	$CheckType = "R";

	if ($TransactionId == "") {
		$apiResponse = json_encode(recordNotFoundMsg(0, "TransactionId param is missing"));
		apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
		echo $apiResponse;
		return;
	}

		/**Get max sortorder*/
		$query = "SELECT TemplateId	FROM `t_transaction` where TransactionId = $TransactionId;";
		$resultdatalist = $db->query($query);
		$TemplateId = $resultdatalist[0]["TemplateId"];


		/**Get max sortorder*/
		$query = "SELECT ifnull(max(SortOrder),0) as MaxSortOrder
			FROM `t_transaction_items`
			where TransactionId = $TransactionId;";
		$resultdatalist = $db->query($query);
		$MaxSortOrder = $resultdatalist[0]["MaxSortOrder"];

		$RowNo = "reportcheckblock-width-half";
		$ColumnNo = "reportcheckblock-height-onethird";
		$PhotoUrl = "placeholder.jpg";

		$query = "INSERT INTO t_transaction_items (TransactionId,CategoryId,CheckId, CheckName, RowNo, ColumnNo, 
				PhotoUrl,CheckType, SortOrder) 
				select $TransactionId TransactionId, b.CategoryId, b.CheckId, b.CheckName, :RowNo, :ColumnNo,
				:PhotoUrl, :CheckType, (ROW_NUMBER() OVER (ORDER BY a.TemplateCheckListMapId))+$MaxSortOrder AS SortOrder
				from t_template_checklist_map a
				inner join t_checklist b on a.CheckId=b.CheckId
				where a.TemplateId=:TemplateId ORDER BY a.SortOrder ASC;";

		$pList = array(
			'RowNo' => $RowNo,
			'ColumnNo' => $ColumnNo,
			'PhotoUrl' => $PhotoUrl,
			'CheckType' => $CheckType,
			'TemplateId' => $TemplateId
		);

		$db->bindMore($pList);
		$resultdata = $db->query($query);

		// echo "<pre>";
		// print_r($resultdata);
		// echo "</pre>";


	$response = array(["SysValue" => 1, "SysMessage" => "Data has been copied successfully", "TransactionId" => $TransactionId]);
	$apiResponse = json_encode($response);
	echo $apiResponse;
	apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
} catch (PDOException $e) {
	$apiResponse = json_encode(recordNotFoundMsg(0, $e->getMessage()));
	apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
	echo $apiResponse;
}
