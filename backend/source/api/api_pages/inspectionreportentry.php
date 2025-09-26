<?php

$task = '';
if (isset($data->action)) {
	$task = trim($data->action);
}

switch ($task) {

	case "getDataList":
		$returnData = getDataList($data);
		break;
	case "dataAddEdit":
		$returnData = dataAddEdit($data);
		break;
	case "updateMasterPartial":
		$returnData = updateMasterPartial($data);
		break;
	case "bulkInsertCheckData":
		$returnData = bulkInsertCheckData($data);
		break;
	case "dataAddEditMany":
		$returnData = dataAddEditMany($data);
		break;
	case "getCategoryList":
		$returnData = getCategoryList($data);
		break;
	case "deleteData":
		$returnData = deleteData($data);
		break;
	default:
		echo "{failure:true}";
		break;
}

function getDataList($data)
{

	$pTransactionId = $data->TransactionId ? $data->TransactionId : 0;
	$pCategoryId = $data->CategoryId ? $data->CategoryId : 0;


	try {
		$dbh = new Db();

		$query = "SELECT a.TransactionId AS id,a.TransactionTypeId,DATE(a.`TransactionDate`) TransactionDate, 
		a.InvoiceNo,a.BuyerName,a.SupplierName,a.FactoryName,a.CoverFilePages,
		a.`UserId`, a.StatusId, b.`UserName`,c.`StatusName`, a.CoverFileUrl,'' CoverFileUrlUpload,
		case when a.CoverFileUrl is null then '' else 'Yes' end as CoverFileUrlStatus,a.ManyImgPrefix,'' Items,
		ifnull(a.TemplateId,0) as TemplateId
	   FROM `t_transaction` a
	   INNER JOIN `t_users` b ON a.`UserId` = b.`UserId`
	   INNER JOIN `t_status` c ON a.`StatusId` = c.`StatusId`
	   where (a.TransactionId = $pTransactionId OR $pTransactionId=0)
	   ORDER BY a.`TransactionDate` DESC, a.InvoiceNo ASC;";

		$resultdatalist = $dbh->query($query);
		$resultdata = array();
		foreach ($resultdatalist as $row) {
			$TransactionId = $row['id'];

			$query = "SELECT a.TransactionItemId as autoId,a.`TransactionItemId`, a.`TransactionId`,a.CategoryId, a.`CheckId`,a.CheckName,
			a.RowNo,a.ColumnNo,a.PhotoUrl,'' PhotoUrlChanged, '' PhotoUrlPreview, '' PhotoUrlUpload, a.SortOrder,a.CheckType
			FROM t_transaction_items a
			where a.TransactionId=$TransactionId
			and (a.CategoryId = $pCategoryId OR $pCategoryId=0)
			order by a.SortOrder ASC;";
			$resultdataItems = $dbh->query($query);
			$row['Items'] = $resultdataItems;
			$resultdata[] = $row;
		}



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


function dataAddEdit($data)
{

	if ($_SERVER["REQUEST_METHOD"] != "POST") {
		return $returnData = msg(0, 404, 'Page Not Found!');
	} else {

		$lan = trim($data->lan);
		$UserId = trim($data->UserId);
		$ClientId = 1;

		$id = $data->rowData->id;
		$TransactionTypeId = $data->rowData->TransactionTypeId;
		$StatusId = $data->rowData->StatusId;
		// $CoverFileUrl = $data->rowData->CoverFileUrl ? $data->rowData->CoverFileUrl : null;
		$InvoiceNo = $data->rowData->InvoiceNo;
		$BuyerName = $data->rowData->BuyerName ? $data->rowData->BuyerName : null;
		$SupplierName = $data->rowData->SupplierName ? $data->rowData->SupplierName : null;
		$FactoryName = $data->rowData->FactoryName ? $data->rowData->FactoryName : null;

		$TransactionDate = $data->rowData->TransactionDate;
		$CoverFilePages = $data->rowData->CoverFilePages ? $data->rowData->CoverFilePages : null;
		$ManyImgPrefix = $data->rowData->ManyImgPrefix;
		$CoverFileUrl = $data->rowData->CoverFileUrlUpload ? ConvertFile($data->rowData->CoverFileUrlUpload, $ManyImgPrefix) : null;
		try {
			$aQuerys = array();
			if ($id == "") {
				$q = new insertq();
				$q->table = 't_transaction';
				$q->columns = ['ClientId', 'TransactionTypeId', 'TransactionDate', 'InvoiceNo', 'BuyerName', 'SupplierName', 'FactoryName', 'CoverFilePages', 'CoverFileUrl', 'UserId', 'StatusId', 'ManyImgPrefix'];
				$q->values = [$ClientId, $TransactionTypeId, $TransactionDate, $InvoiceNo, $BuyerName, $SupplierName, $FactoryName, $CoverFilePages, $CoverFileUrl, $UserId, $StatusId, $ManyImgPrefix];
				$q->pks = ['TransactionId'];
				$q->bUseInsetId = true;
				$q->build_query();
				$aQuerys[] = $q;
			} else {
				$u = new updateq();
				$u->table = 't_transaction';
				if ($CoverFileUrl) {
					$u->columns = ['TransactionDate', 'InvoiceNo', 'BuyerName', 'SupplierName', 'FactoryName', 'CoverFilePages', 'CoverFileUrl', 'StatusId'];
					$u->values = [$TransactionDate, $InvoiceNo, $BuyerName, $SupplierName, $FactoryName, $CoverFilePages, $CoverFileUrl, $StatusId];
				} else {
					$u->columns = ['TransactionDate', 'InvoiceNo', 'BuyerName', 'SupplierName', 'FactoryName', 'CoverFilePages', 'StatusId'];
					$u->values = [$TransactionDate, $InvoiceNo, $BuyerName, $SupplierName, $FactoryName, $CoverFilePages, $StatusId];
				}

				$u->pks = ['TransactionId'];
				$u->pk_values = [$id];
				$u->build_query();
				$aQuerys[] = $u;
			}

			$res = exec_query($aQuerys, $UserId, $lan);
			$success = ($res['msgType'] == 'success') ? 1 : 0;
			$status = ($res['msgType'] == 'success') ? 200 : 500;

			$returnData = [
				"success" => $success,
				"status" => $status,
				"UserId" => $UserId,
				"message" => $res['msg']
			];
		} catch (PDOException $e) {
			$returnData = msg(0, 500, $e->getMessage());
		}

		return $returnData;
	}
}

function updateMasterPartial($data)
{

	if ($_SERVER["REQUEST_METHOD"] != "POST") {
		return $returnData = msg(0, 404, 'Page Not Found!');
	} else {

		$lan = trim($data->lan);
		$UserId = trim($data->UserId);

		$id = $data->rowData->id;
		$TemplateId = $data->rowData->TemplateId;

		try {
			$aQuerys = array();
			// if ($id > 0) {
			$u = new updateq();
			$u->table = 't_transaction';
			$u->columns = ['TemplateId'];
			$u->values = [$TemplateId];
			$u->pks = ['TransactionId'];
			$u->pk_values = [$id];
			$u->build_query();
			$aQuerys[] = $u;
			// }

			$res = exec_query($aQuerys, $UserId, $lan);
			$success = ($res['msgType'] == 'success') ? 1 : 0;
			$status = ($res['msgType'] == 'success') ? 200 : 500;

			$returnData = [
				"success" => $success,
				"status" => $status,
				"UserId" => $UserId,
				"message" => $res['msg']
			];
		} catch (PDOException $e) {
			$returnData = msg(0, 500, $e->getMessage());
		}

		return $returnData;
	}
}


function bulkInsertCheckData($data)
{
	if ($_SERVER["REQUEST_METHOD"] != "POST") {
		return $returnData = msg(0, 404, 'Page Not Found!');
	} else {

		$lan = trim($data->lan);
		$UserId = trim($data->UserId);

		$TransactionId = $data->TransactionId;
		$CategoryId = $data->CategoryId;
		$CheckType = "R";
		try {

			$dbh = new Db();
			$aQuerys = array();

			/**Check Check list exist under this reports */
			$query = "SELECT count(TransactionItemId) as ChkCount
					FROM `t_transaction_items` a
					where a.TransactionId = $TransactionId
					and a.CategoryId = $CategoryId;";

			$resultdatalist = $dbh->query($query);
			$ChkCount = $resultdatalist[0]["ChkCount"];

			if($ChkCount == 0){

				/**Get transaction master information */
				$query = "SELECT TemplateId, ManyImgPrefix
						FROM `t_transaction` a
						where a.TransactionId = $TransactionId;";
				$resultdatalist = $dbh->query($query);
				$TemplateId = $resultdatalist[0]["TemplateId"];
				$ManyImgPrefix = $resultdatalist[0]["ManyImgPrefix"];


				$query = "SELECT a.CheckId,b.CheckName,b.Sequence
					FROM t_template_checklist_map a
					inner join t_checklist b on a.CheckId=b.CheckId and b.CategoryId=$CategoryId
					WHERE a.TemplateId = $TemplateId
					order by b.Sequence;";
				$resultdatalist = $dbh->query($query);
				

				foreach ($resultdatalist as $Item) {

					$CheckId = $Item["CheckId"];
					$CheckName = $Item["CheckName"];
					$Sequence = $Item["Sequence"];
				
					$RowNo = "reportcheckblock-width-half";
					$ColumnNo = "reportcheckblock-height-onethird";
					$PhotoUrl = "placeholder.jpg";

					$q = new insertq();
					$q->table = 't_transaction_items';
					$q->columns = ['TransactionId','CategoryId','CheckId', 'CheckName', 'RowNo', 'ColumnNo', 'PhotoUrl','CheckType', 'SortOrder'];
					$q->values = [$TransactionId,$CategoryId,$CheckId, $CheckName, $RowNo, $ColumnNo, $PhotoUrl,$CheckType, $Sequence];
					$q->pks = ['TransactionItemId'];
					$q->bUseInsetId = false;
					$q->build_query();
					$aQuerys[] = $q;
			
				}

				$res = exec_query($aQuerys, $UserId, $lan);
				$success = ($res['msgType'] == 'success') ? 1 : 0;
				$status = ($res['msgType'] == 'success') ? 200 : 500;

				$returnData = [
					"success" => $success,
					"status" => $status,
					"UserId" => $UserId,
					"message" => $res['msg']
				];
			}else{
				$returnData = [
					"success" => 1,
					"status" => 200,
					"UserId" => $UserId,
					"message" => "Check list already exist under this category"
				];
			}


		} catch (PDOException $e) {
			$returnData = msg(0, 500, $e->getMessage());
		}

		return $returnData;
	}
}

function dataAddEditMany($data)
{

	if ($_SERVER["REQUEST_METHOD"] != "POST") {
		return $returnData = msg(0, 404, 'Page Not Found!');
	} else {

		// echo "<pre>";
		// print_r($data);
		$lan = trim($data->lan);
		$UserId = trim($data->UserId);

		$CategoryId = trim($data->CategoryId);
		$id = $data->rowData->id;
		$ManyImgPrefix = $data->rowData->ManyImgPrefix;
		$Items = $data->rowData->Items;
		$currentRowDelete = $data->currentRowDelete;
		// $PhotoUrl =  $data->rowData->PhotoUrl? $data->rowData->PhotoUrl : "placeholder.png";
		// echo "<pre>";
		// print_r($Items);
		try {

			// $dbh = new Db();
			$aQuerys = array();

			foreach ($currentRowDelete as $DelItem) {
				if ($DelItem->autoId != -1) {
					$d = new deleteq();
					$d->table = 't_transaction_items';
					$d->pks = ['TransactionItemId'];
					$d->pk_values = [$DelItem->TransactionItemId];
					$d->build_query();
					$aQuerys[] = $d;
				}
			}

			foreach ($Items as $Item) {
				$TransactionItemId = $Item->TransactionItemId;
				$autoId = $Item->autoId;
				$CheckName = $Item->CheckName ? $Item->CheckName : null; //$Item->CheckName;
				$RowNo = $Item->RowNo;
				$ColumnNo = $Item->ColumnNo;
				//$PhotoUrl = $Item->PhotoUrlChanged ? $Item->PhotoUrlChanged : $Item->PhotoUrl;
				$PhotoUrl = $Item->PhotoUrlPreview ? ConvertImage($Item->PhotoUrlPreview, $ManyImgPrefix) : $Item->PhotoUrl;
				$SortOrder = $Item->SortOrder;
				$CheckType = $Item->CheckType ? $Item->CheckType : "R";

				if ($autoId == -1) {
					$q = new insertq();
					$q->table = 't_transaction_items';
					$q->columns = ['TransactionId','CategoryId', 'CheckName', 'RowNo', 'ColumnNo', 'PhotoUrl', 'SortOrder','CheckType'];
					$q->values = [$id,$CategoryId, $CheckName, $RowNo, $ColumnNo, $PhotoUrl, $SortOrder,$CheckType];
					$q->pks = ['TransactionItemId'];
					$q->bUseInsetId = false;
					$q->build_query();
					$aQuerys[] = $q;
				} else {
					$u = new updateq();
					$u->table = 't_transaction_items';
					$u->columns = ['CheckName', 'RowNo', 'ColumnNo', 'PhotoUrl', 'SortOrder','CheckType'];
					$u->values = [$CheckName, $RowNo, $ColumnNo, $PhotoUrl, $SortOrder,$CheckType];
					$u->pks = ['TransactionItemId'];
					$u->pk_values = [$TransactionItemId];
					$u->build_query();
					$aQuerys[] = $u;
				}
			}

			$res = exec_query($aQuerys, $UserId, $lan);
			$success = ($res['msgType'] == 'success') ? 1 : 0;
			$status = ($res['msgType'] == 'success') ? 200 : 500;

			$returnData = [
				"success" => $success,
				"status" => $status,
				"UserId" => $UserId,
				"message" => $res['msg']
			];
		} catch (PDOException $e) {
			$returnData = msg(0, 500, $e->getMessage());
		}

		return $returnData;
	}
}


function getCategoryList($data)
{

	$TransactionId = trim($data->TransactionId);

	try {
		$dbh = new Db();
		$query = "SELECT a.CategoryId, a.CategoryName, 
		(select count(p.TransactionItemId) from t_transaction_items p where a.CategoryId=p.CategoryId and p.TransactionId=$TransactionId) as CheckCount
		FROM `t_category` a
		ORDER BY a.CategoryId ASC;";

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



function deleteData($data)
{

	if ($_SERVER["REQUEST_METHOD"] != "POST") {
		return $returnData = msg(0, 404, 'Page Not Found!');
	}
	// CHECKING EMPTY FIELDS
	elseif (!isset($data->rowData->id)) {
		$fields = ['fields' => ['id']];
		return $returnData = msg(0, 422, 'Please Fill in all Required Fields!', $fields);
	} else {

		$id = $data->rowData->id;
		$lan = trim($data->lan);
		$UserId = trim($data->UserId);

		try {

			$dbh = new Db();

			$d = new deleteq();
			$d->table = 't_transaction_items';
			$d->pks = ['TransactionId'];
			$d->pk_values = [$id];
			$d->build_query();
			$aQuerys[] = $d;

			$d = new deleteq();
			$d->table = 't_transaction';
			$d->pks = ['TransactionId'];
			$d->pk_values = [$id];
			$d->build_query();
			$aQuerys[] = $d;

			$res = exec_query($aQuerys, $UserId, $lan);
			$success = ($res['msgType'] == 'success') ? 1 : 0;
			$status = ($res['msgType'] == 'success') ? 200 : 500;

			$returnData = [
				"success" => $success,
				"status" => $status,
				"UserId" => $UserId,
				"message" => $res['msg']
			];
		} catch (PDOException $e) {
			$returnData = msg(0, 500, $e->getMessage());
		}

		return $returnData;
	}
}




function ConvertFile($base64_string, $prefix, $extention = null)
{

	$path = "../../../image/transaction/" . $prefix;

	if (!file_exists($path)) {
		mkdir($path, 0777, true);
	}

	$targetDir = '../../../image/transaction/' . $prefix;
	$exploded = explode(',', $base64_string, 2);
	if (!$extention) {
		$extention = explode(';', explode('/', $exploded[0])[1])[0];
	}
	$decoded = base64_decode($exploded[1]);
	$output_file = $prefix . "_cover_" . date("Y_m_d_H_i_s") . "_" . rand(1, 9999) . "." . $extention;
	file_put_contents($targetDir . "/" . $output_file, $decoded);
	return $output_file;
}


function ConvertImage($base64_string, $prefix)
{

	$path = "../../../image/transaction/" . $prefix;

	if (!file_exists($path)) {
		mkdir($path, 0777, true);
	}

	$targetDir = '../../../image/transaction/' . $prefix;
	$exploded = explode(',', $base64_string, 2);
	$extention = explode(';', explode('/', $exploded[0])[1])[0];
	$decoded = base64_decode($exploded[1]);
	$output_file = $prefix . "_" . date("Y_m_d_H_i_s") . "_" . rand(1, 9999) . "." . $extention;
	// $output_file = date("Y_m_d_H_i_s") . rand(1, 9999) . "." . $extention;
	/**Image file name */
	file_put_contents($targetDir . "/" . $output_file, $decoded);
	return $output_file;
}
