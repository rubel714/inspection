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
	case "importInspectionReport":
		$returnData = importInspectionReport($data);
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
		$StatusId = $data->rowData->StatusId;

		try {
			$aQuerys = array();
			// if ($id > 0) {
			$u = new updateq();
			$u->table = 't_transaction';
			$u->columns = ['TemplateId','StatusId'];
			$u->values = [$TemplateId,$StatusId];
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






function importInspectionReport($data)
{

	if ($_SERVER["REQUEST_METHOD"] != "POST") {
		return $returnData = msg(0, 404, 'Page Not Found!');
	} else {

		$lan = trim($data->lan);
		$UserId = trim($data->UserId);
		$FileNameString = $data->rowData;

		try {

			$dbh = new Db();
			$aQuerys = array();

			$prefix = 123;
			$FileName = $FileNameString ? ConvertCSVFile($FileNameString, $prefix) : null;
			// $TransactionDate = date("Y-m-d H:i:s");


			// $query = "SELECT a.CustomerId, b.CustomerCode, c.BusinessLineCode, a.UserId 
			// FROM t_customer_map a 
			// inner join t_customer b on a.CustomerId=b.CustomerId
			// inner join t_businessline c on a.BusinessLineId=c.BusinessLineId;";

			// $resultdata = $dbh->query($query);
			// $CustomerUserList = array();
			// foreach ($resultdata as $row) {
			// 		$CustomerUserList[$row['CustomerCode']][$row['BusinessLineCode']] = $row["UserId"];
			// }
// echo "<pre>";
// 		print_r($CustomerUserList);
		
// 		exit;


			//Insert Master
			// $q = new insertq();
			// $q->table = 't_invoice';
			// $q->columns = ['TransactionDate', 'FileName', 'UserId'];
			// $q->values = [$TransactionDate, $FileName, $UserId];
			// $q->pks = ['InvoiceId'];
			// $q->bUseInsetId = true;
			// $q->build_query();
			// $aQuerys[] = $q;





			$fileDir = '../../../image/invoicefiles/' . $FileName;
			$rowcounter = 0;
			$csvFileContext = fopen($fileDir, "r");

			//CSV file column index
			$NameIdx = 0;
			$BusinessUnitIdx = 1;
			$BudgetCodeIdx = 2;
			$AccountCodeIdx = 3;
			$AccountingPeriodIdx = 4;
			$DebitCreditIdx = 5;
			$DescriptionIdx = 6;
			$JournalTypeIdx = 7;
			$BaseAmountIdx = 8;
			$TransactionDateIdx = 9;
			$TransactionReferenceIdx = 10;
			$AnalysisCode1Idx = 11;
			$AnalysisCode2Idx = 12;
			$AnalysisCode3Idx = 13;
			$AnalysisCode4Idx = 14;
			$AnalysisCode5Idx = 15;
			$AnalysisCode6Idx = 16;
			$AnalysisCode7Idx = 17;
			$AnalysisCode8Idx = 18;
			$AnalysisCode9Idx = 19;
			$TransactionAmountIdx = 20;
			$CurrencyCodeIdx = 21;
			$GeneralDate1Idx = 22;
			$GeneralDate2Idx = 23;
			$GeneralDate3Idx = 24;
			$GeneralDescription9Idx = 25;
			$GeneralDescription4Idx = 26;
			$GeneralDescription11Idx = 27;
			$GeneralDescription2Idx = 28;
			$GeneralDescription12Idx = 29;
			$GeneralDescription13Idx = 30;
			$GeneralDescription14Idx = 31;
			$GeneralDescription15Idx = 32;
			$GeneralDescription16Idx = 33;
			$GeneralDescription17Idx = 34;
			$GeneralDescription18Idx = 35;
			$GeneralDescription19Idx = 36;
			$GeneralDescription20Idx = 37;

			$TotalInvoice = 0;
			while (! feof($csvFileContext)) {
				$rowcounter++;
				$csvLine = trim(fgets($csvFileContext));

				//when this row is blank
				if (strlen($csvLine) == 0) {
					//when first row is blank then no data
					if ($rowcounter == 1) {
						$returnData = [
							"success" => 0,
							"status" => 500,
							"UserId" => $UserId,
							"InvoiceId" => 0,
							"TotalInvoice" => $TotalInvoice,
							"message" => "There are no invoice in this file"
						];
						break;
					}
					break; //when has blank row then stop loop
				}

				//first row use for header and when header then no need operation.
				if ($rowcounter == 1) {
					continue; //first row script
				}

				// $datalist = array();
				// $datalist = parse_csv($csvLine);
				//https://www.php.net/manual/en/function.str-getcsv.php
				$data = str_getcsv($csvLine);

				// echo "<pre>";
				// print_r($data);

				$Name = $data[$NameIdx];
				$BusinessUnit = $data[$BusinessUnitIdx];
				$BudgetCode = $data[$BudgetCodeIdx];
				$AccountCode = $data[$AccountCodeIdx];
				$AccountingPeriod = $data[$AccountingPeriodIdx];
				$DebitCredit = $data[$DebitCreditIdx];
				$Description = $data[$DescriptionIdx];
				$JournalType = $data[$JournalTypeIdx];
				$BaseAmount = $data[$BaseAmountIdx];
				$TransactionDate = $data[$TransactionDateIdx];
				$TransactionReference = $data[$TransactionReferenceIdx];
				$AnalysisCode1 = $data[$AnalysisCode1Idx];
				$AnalysisCode2 = $data[$AnalysisCode2Idx];
				$AnalysisCode3 = $data[$AnalysisCode3Idx];
				$AnalysisCode4 = $data[$AnalysisCode4Idx];
				$AnalysisCode5 = $data[$AnalysisCode5Idx];
				$AnalysisCode6 = $data[$AnalysisCode6Idx];
				$AnalysisCode7 = $data[$AnalysisCode7Idx];
				$AnalysisCode8 = $data[$AnalysisCode8Idx];
				$AnalysisCode9 = $data[$AnalysisCode9Idx];
				$TransactionAmount = $data[$TransactionAmountIdx];
				$CurrencyCode = $data[$CurrencyCodeIdx];
				$GeneralDate1 = $data[$GeneralDate1Idx];
				$GeneralDate2 = $data[$GeneralDate2Idx];
				$GeneralDate3 = $data[$GeneralDate3Idx];
				$GeneralDescription9 = $data[$GeneralDescription9Idx];
				$GeneralDescription4 = $data[$GeneralDescription4Idx];
				$GeneralDescription11 = $data[$GeneralDescription11Idx];
				$GeneralDescription2 = $data[$GeneralDescription2Idx];
				$GeneralDescription12 = $data[$GeneralDescription12Idx];
				$GeneralDescription13 = $data[$GeneralDescription13Idx];
				$GeneralDescription14 = $data[$GeneralDescription14Idx];
				$GeneralDescription15 = $data[$GeneralDescription15Idx];
				$GeneralDescription16 = $data[$GeneralDescription16Idx];
				$GeneralDescription17 = $data[$GeneralDescription17Idx];
				$GeneralDescription18 = $data[$GeneralDescription18Idx];
				$GeneralDescription19 = $data[$GeneralDescription19Idx];
				$GeneralDescription20 = $data[$GeneralDescription20Idx];

				$CustomerUserId = null;
				if(array_key_exists($AccountCode, $CustomerUserList)){
					if(array_key_exists($AnalysisCode3, $CustomerUserList[$AccountCode])){
						$CustomerUserId = $CustomerUserList[$AccountCode][$AnalysisCode3];
					}
				}

				//Mrinal bhai confirmed only DebitCredit = D will be save
				if($DebitCredit != "D"){
					continue;
				}

				$q = new insertq();
				$q->table = 't_invoiceitems';
				$q->columns = ['InvoiceId', 'Name', 'BusinessUnit', 'BudgetCode', 'AccountCode', 'AccountingPeriod', 'DebitCredit', 'Description', 'JournalType', 'BaseAmount', 'TransactionDate', 'TransactionReference', 'AnalysisCode1', 'AnalysisCode2', 'AnalysisCode3', 'AnalysisCode4', 'AnalysisCode5', 'AnalysisCode6', 'AnalysisCode7', 'AnalysisCode8', 'AnalysisCode9', 'TransactionAmount', 'CurrencyCode', 'GeneralDate1', 'GeneralDate2', 'GeneralDate3', 'GeneralDescription9', 'GeneralDescription4', 'GeneralDescription11', 'GeneralDescription2', 'GeneralDescription12', 'GeneralDescription13', 'GeneralDescription14', 'GeneralDescription15', 'GeneralDescription16', 'GeneralDescription17', 'GeneralDescription18', 'GeneralDescription19', 'GeneralDescription20','CustomerUserId'];
				$q->values = ['[LastInsertedId]', $Name, $BusinessUnit, $BudgetCode, $AccountCode, $AccountingPeriod, $DebitCredit, $Description, $JournalType, $BaseAmount, $TransactionDate, $TransactionReference, $AnalysisCode1, $AnalysisCode2, $AnalysisCode3, $AnalysisCode4, $AnalysisCode5, $AnalysisCode6, $AnalysisCode7, $AnalysisCode8, $AnalysisCode9, $TransactionAmount, $CurrencyCode, $GeneralDate1, $GeneralDate2, $GeneralDate3, $GeneralDescription9, $GeneralDescription4, $GeneralDescription11, $GeneralDescription2, $GeneralDescription12, $GeneralDescription13, $GeneralDescription14, $GeneralDescription15, $GeneralDescription16, $GeneralDescription17, $GeneralDescription18, $GeneralDescription19, $GeneralDescription20, $CustomerUserId];
				$q->pks = ['InvoiceItemId'];
				$q->bUseInsetId = false;
				$q->build_query();
				$aQuerys[] = $q;
				$TotalInvoice++;
			}

			$res = exec_query($aQuerys, $UserId, $lan);
			$success = ($res['msgType'] == 'success') ? 1 : 0;
			$status = ($res['msgType'] == 'success') ? 200 : 500;
			$message = ($res['msgType'] == 'success') ? "Invoice imported successfully" : $res['msg'];
			$InvoiceId = ($res['msgType'] == 'success') ? $res['InvoiceId'] : 0;

			$returnData = [
				"success" => $success,
				"status" => $status,
				"UserId" => $UserId,
				"InvoiceId" => $InvoiceId,
				"TotalInvoice" => $TotalInvoice,
				"message" => $message
			];
		} catch (PDOException $e) {
			$returnData = msg(0, 500, $e->getMessage());
		}

		return $returnData;
	}
}

function ConvertCSVFile($base64_string, $prefix)
{
	$targetDir = '../../../image/invoicefiles';

	if (!file_exists($targetDir)) {
		mkdir($targetDir, 0777, true);
	}

	$exploded = explode(',', $base64_string, 2);
	// echo "<pre>";
	// print_r($exploded);
	$extention = "csv"; // explode(';', explode('/', $exploded[0])[1])[0];
	$decoded = base64_decode($exploded[1]);
	// $output_file = $prefix . "_cover_" . date("Y_m_d_H_i_s") . "_" . rand(1, 9999) . "." . $extention;
	$output_file = date("Y_m_d_H_i_s") . "_" . rand(1, 9999) . "." . $extention;
	file_put_contents($targetDir . "/" . $output_file, $decoded);
	return $output_file;
}


