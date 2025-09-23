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
	
	try{
		$dbh = new Db();
		$query = "SELECT t_checklist.CheckId AS id, CheckName,t_checklist.CategoryId, Sequence, CategoryName, 
		case when t_template_checklist_map.CheckId is null then 0 else 1 end IsAssigned
		FROM t_checklist 
		inner join t_category on t_category.CategoryId=t_checklist.CategoryId
		left join t_template_checklist_map on t_template_checklist_map.CheckId=t_checklist.CheckId and t_template_checklist_map.TemplateId=$TemplateId
		ORDER BY `Sequence` ASC;";		
		
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
		$TemplateId = $data->rowData->TemplateId;
		$IsAssigned = $data->rowData->IsAssigned;
		$lan = trim($data->lan);
		$UserId = trim($data->UserId);


		try {

			$aQuerys = array();
			if($IsAssigned === 1){
				$q = new insertq();
				$q->table = 't_template_checklist_map';
				$q->columns = ['TemplateId','CheckId'];
				$q->values = [$TemplateId,$CheckId];
				$q->pks = ['TemplateCheckListMapId'];
				$q->bUseInsetId = false;
				$q->build_query();
				$aQuerys[] = $q;

			}else{
				$d = new deleteq();
				$d->table = 't_template_checklist_map';
				$d->pks = ['TemplateId','CheckId'];
				$d->pk_values = [$TemplateId,$CheckId];
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
