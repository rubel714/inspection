<?php

$task = '';
if (isset($data->action)) {
	$task = trim($data->action);
}

switch ($task) {

	case "getDataList":
		$returnData = getDataList($data);
		break;
	default:
		echo "{failure:true}";
		break;
}

function getDataList($data)
{

	$pTransactionId = $data->TransactionId ? $data->TransactionId : 0;
	$pCategoryId = $data->CategoryId ? $data->CategoryId : 0;
	$StartDate = trim($data->StartDate);
	$EndDate = trim($data->EndDate) . " 23-59-59";
	try {
		$dbh = new Db();

		$query = "SELECT a.TransactionId AS id,a.TransactionTypeId,DATE(a.`TransactionDate`) TransactionDate, 
		a.InvoiceNo,a.BuyerName,a.SupplierName,a.FactoryName,a.CoverFilePages,
		a.`UserId`, a.StatusId, b.`UserName`,c.`StatusName`, e.`UserName` as InspectorUserName,
		a.CoverFileUrl,'' CoverFileUrlUpload, case when a.CoverFileUrl is null then '' else 'Yes' end as CoverFileUrlStatus,
		a.FooterFileUrl,'' FooterFileUrlUpload, case when a.FooterFileUrl is null then '' else 'Yes' end as FooterFileUrlStatus,
		a.ManyImgPrefix,'' Items,
		ifnull(a.TemplateId,0) as TemplateId,d.TemplateName
	   FROM `t_transaction` a
	   INNER JOIN `t_users` b ON a.`UserId` = b.`UserId`
	   INNER JOIN `t_status` c ON a.`StatusId` = c.`StatusId`
	   INNER JOIN `t_template` d ON a.`TemplateId` = d.`TemplateId`
	   LEFT JOIN `t_users` e ON a.`InspectorUserId` = e.`UserId`
	   where (a.TransactionDate between '$StartDate' and '$EndDate')
	   ORDER BY a.`TransactionDate` DESC, a.InvoiceNo ASC;";

		$resultdata = $dbh->query($query);

		$returnData = [
			"success" => 1,
			"status" => 200,
			"message" => "",
			"datalist" => $resultdata
		];
	} catch (PDOException $e) {
		$returnData = msg(0, 500, $e->getMessage());
	}

	return $returnData;
}