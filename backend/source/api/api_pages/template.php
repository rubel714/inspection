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

	case "deleteData":
		$returnData = deleteData($data);
		break;
	case "getCheckDataList":
		$returnData = getCheckDataList($data);
		break;
	case "assignData":
		$returnData = assignData($data);
		break;
	case "changeOrder":
		$returnData = changeOrder($data);
		break;
	case "copyCheck":
		$returnData = copyCheck($data);
		break;
	default:
		echo "{failure:true}";
		break;
}

function getDataList($data)
{

	try {
		$dbh = new Db();

		$query0 = "SELECT TemplateId, CheckId FROM t_template_checklist_map ;";

		$checkListResult = $dbh->query($query0);
		$checkList = array();
		foreach ($checkListResult as $key => $row0) {
			$checkList[$row0["TemplateId"]][] = $row0["CheckId"];
		}
// echo "<pre>"; print_r($checkList); echo "</pre>";

		$query = "SELECT TemplateId AS id, TemplateName, Comments, '' MapCheckList
		FROM t_template 
		ORDER BY `TemplateName` ASC;";
		$resultdataresult = $dbh->query($query);
		$resultdata = array();
		foreach ($resultdataresult as $key => $row) {
			if(array_key_exists($row["id"], $checkList)){
				$row["MapCheckList"] = $checkList[$row["id"]];
			}else{
				$row["MapCheckList"] = [];
			}
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

		$TemplateId = $data->rowData->id;
		$TemplateName = $data->rowData->TemplateName;
		$Comments = $data->rowData->Comments ? $data->rowData->Comments : null;

		try {

			$aQuerys = array();

			if ($TemplateId == "") {
				$q = new insertq();
				$q->table = 't_template';
				$q->columns = ['TemplateName', 'Comments'];
				$q->values = [$TemplateName, $Comments];
				$q->pks = ['TemplateId'];
				$q->bUseInsetId = false;
				$q->build_query();
				$aQuerys = array($q);
			} else {
				$u = new updateq();
				$u->table = 't_template';
				$u->columns = ['TemplateName', 'Comments'];
				$u->values = [$TemplateName, $Comments];
				$u->pks = ['TemplateId'];
				$u->pk_values = [$TemplateId];
				$u->build_query();
				$aQuerys = array($u);
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

		$TemplateId = $data->rowData->id;
		$lan = trim($data->lan);
		$UserId = trim($data->UserId);

		try {


			$d = new deleteq();
			$d->table = 't_template';
			$d->pks = ['TemplateId'];
			$d->pk_values = [$TemplateId];
			$d->build_query();
			$aQuerys = array($d);

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


function getCheckDataList($data){

		$TemplateId = $data->TemplateId;
		$FilterType = $data->FilterType;

		if($FilterType == 1){
			$join = " inner ";	
		}else{
			$join = " left ";
		}
	
	try{
		$dbh = new Db();
		$query = "SELECT t_checklist.CheckId AS id, CheckName,t_checklist.CategoryId, SortOrder, CategoryName, 
		case when t_template_checklist_map.CheckId is null then 0 else 1 end IsAssigned, 
		t_template_checklist_map.TemplateCheckListMapId,t_template_checklist_map.TemplateId
		FROM t_checklist 
		$join join t_category on t_category.CategoryId=t_checklist.CategoryId
		$join join t_template_checklist_map on t_template_checklist_map.CheckId=t_checklist.CheckId and t_template_checklist_map.TemplateId=$TemplateId
		ORDER BY IsAssigned desc, SortOrder ASC, `Sequence` ASC;";		
		
		$resultdata = $dbh->query($query);
		
		$returnData = [
			"success" => 1,
			"status" => 200,
			"message" => "",
			"datalist" => $resultdata
		];

	}catch(PDOException $e){
		$returnData = msg(0,500,$e->getMessage());
	}
	
	return $returnData;
}


function assignData($data)
{

	if ($_SERVER["REQUEST_METHOD"] != "POST") {
		return $returnData = msg(0, 404, 'Page Not Found!');
	}{

		$CheckId = $data->rowData->id;
		$TemplateCheckListMapId = $data->rowData->TemplateCheckListMapId;
		$TemplateId = $data->rowData->TemplateId;
		$IsAssigned = $data->rowData->IsAssigned;
		$lan = trim($data->lan);
		$UserId = trim($data->UserId);


		try {

			$aQuerys = array();
			if($IsAssigned === 1){

				$dbh = new Db();
				$query = "SELECT ifnull(MAX(SortOrder),0)+1 AS NextSortOrder
				FROM t_template_checklist_map where TemplateId=$TemplateId;";
				
				$resultdata = $dbh->query($query);
				$NextSortOrder = $resultdata[0]['NextSortOrder'];
				
				$q = new insertq();
				$q->table = 't_template_checklist_map';
				$q->columns = ['TemplateId','CheckId','SortOrder'];
				$q->values = [$TemplateId,$CheckId,$NextSortOrder];
				$q->pks = ['TemplateCheckListMapId'];
				$q->bUseInsetId = false;
				$q->build_query();
				$aQuerys[] = $q;

			}else{
				$d = new deleteq();
				$d->table = 't_template_checklist_map';
				$d->pks = ['TemplateCheckListMapId'];
				$d->pk_values = [$TemplateCheckListMapId];
				$d->build_query();
				$aQuerys[] = $d;
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



function changeOrder($data)
{

	if ($_SERVER["REQUEST_METHOD"] != "POST") {
		return $returnData = msg(0, 404, 'Page Not Found!');
	}{

		$FromId = $data->rowData->TemplateCheckListMapId;
		$FromSortOrder = $data->rowData->SortOrder;

		$ToId = $data->toRowData->TemplateCheckListMapId;
		$ToSortOrder = $data->toRowData->SortOrder;

		$lan = trim($data->lan);
		$UserId = trim($data->UserId);


		try {

			$aQuerys = array();
		
			$u = new updateq();
			$u->table = 't_template_checklist_map';
			$u->columns = ['SortOrder'];
			$u->values = [$ToSortOrder];
			$u->pks = ['TemplateCheckListMapId'];
			$u->pk_values = [$FromId];
			$u->build_query();
			$aQuerys[] = $u;

			$u = new updateq();
			$u->table = 't_template_checklist_map';
			$u->columns = ['SortOrder'];
			$u->values = [$FromSortOrder];
			$u->pks = ['TemplateCheckListMapId'];
			$u->pk_values = [$ToId];
			$u->build_query();
			$aQuerys[] = $u;

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


function copyCheck($data)
{

	if ($_SERVER["REQUEST_METHOD"] != "POST") {
		return $returnData = msg(0, 404, 'Page Not Found!');
	}{
		$dbh = new Db();

		$CopyFromId = $data->rowData->TemplateCheckListMapId;
		$CopyFromSortOrder = $data->rowData->SortOrder;
		$NextSortOrder = $CopyFromSortOrder + 1;
		$TemplateId = $data->rowData->TemplateId;
		$CheckId = $data->rowData->id;

		$lan = trim($data->lan);
		$UserId = trim($data->UserId);


		try {

			/**Next all check list order+1 */
			$query = "update t_template_checklist_map set SortOrder=SortOrder+1
			 where TemplateId=$TemplateId and SortOrder>$CopyFromSortOrder;";
			$dbh->query($query);


			$aQuerys = array();
		
			$q = new insertq();
			$q->table = 't_template_checklist_map';
			$q->columns = ['TemplateId','CheckId','SortOrder'];
			$q->values = [$TemplateId,$CheckId,$NextSortOrder];
			$q->pks = ['TemplateCheckListMapId'];
			$q->bUseInsetId = false;
			$q->build_query();
			$aQuerys[] = $q;

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