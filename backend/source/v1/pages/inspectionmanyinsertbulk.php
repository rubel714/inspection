<?php
try {

	apiLogWrite("\n\n========$PageName=======Called (" . date('Y_m_d_H_i_s') . ")===================");
	apiLogWrite("Params (" . date('Y_m_d_H_i_s') . "): " . json_encode($data));

	$db = new Db();
	$TransactionId = isset($data['TransactionId']) ? checkNull($data['TransactionId']) : "";
	$CategoryId = isset($data['CategoryId']) ? checkNull($data['CategoryId']) : "";
	$CheckType = "R";

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

	/**Check Check list exist under this reports */
	$query = "SELECT count(TransactionItemId) as ChkCount
			FROM `t_transaction_items` a
			where a.TransactionId = $TransactionId
			and a.CategoryId = $CategoryId;";

	$resultdatalist = $db->query($query);
	$ChkCount = $resultdatalist[0]["ChkCount"];
	if ($ChkCount == 0) {

		/**Get transaction master information */
		$query = "SELECT TemplateId, ManyImgPrefix
			FROM `t_transaction` a
			where a.TransactionId = $TransactionId;";
		$resultdatalist = $db->query($query);
		$TemplateId = $resultdatalist[0]["TemplateId"];
		$ManyImgPrefix = $resultdatalist[0]["ManyImgPrefix"];

		$query = "SELECT ifnull(max(a.SortOrder),0) as MaxSortOrder
		FROM t_transaction_items a
		where a.TransactionId=$TransactionId;";
		$resultdatalist = $db->query($query);
		$SortOrder = $resultdatalist[0]["MaxSortOrder"];

		$query = "SELECT a.CheckId,b.CheckName,a.SortOrder
		FROM t_template_checklist_map a
		inner join t_checklist b on a.CheckId=b.CheckId and b.CategoryId=$CategoryId
		WHERE a.TemplateId = $TemplateId
		order by a.SortOrder;";
		$resultdatalist = $db->query($query);

		foreach ($resultdatalist as $Item) {

			$CheckId = $Item["CheckId"];
			$CheckName = $Item["CheckName"];
			$SortOrder = $SortOrder + 1;

			$RowNo = "reportcheckblock-width-half";
			$ColumnNo = "reportcheckblock-height-onethird";
			$PhotoUrl = "placeholder.jpg";

			$query = "INSERT INTO t_transaction_items (TransactionId,CategoryId,CheckId, CheckName, RowNo, ColumnNo, PhotoUrl,CheckType, SortOrder) 
					VALUES (:TransactionId, :CategoryId, :CheckId, :CheckName,:RowNo, :ColumnNo, :PhotoUrl, :CheckType, :SortOrder);";

			$pList = array(
				'TransactionId' => $TransactionId,
				'CategoryId' => $CategoryId,
				'CheckId' => $CheckId,
				'CheckName' => $CheckName,
				'RowNo' => $RowNo,
				'ColumnNo' => $ColumnNo,
				'PhotoUrl' => $PhotoUrl,
				'CheckType' => $CheckType,
				'SortOrder' => $SortOrder
			);

			$db->bindMore($pList);
			$resultdata = $db->query($query);
		}
	}

	$response = array(["SysValue" => 1, "SysMessage" => "Data has been saved successfully", "TransactionId" => $TransactionId, "CategoryId" => $CategoryId]);
	$apiResponse = json_encode($response);
	echo $apiResponse;
	apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
} catch (PDOException $e) {
	$apiResponse = json_encode(recordNotFoundMsg(0, $e->getMessage()));
	apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
	echo $apiResponse;
}
