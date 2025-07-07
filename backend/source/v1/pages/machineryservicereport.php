<?php

try{
	apiLogWrite("\n\n========$PageName=======Called (".date('Y_m_d_H_i_s').")===================");
	apiLogWrite("Params (".date('Y_m_d_H_i_s')."): ".json_encode($data));
	
	$dbh = new Db();
	$TransactionId =  isset($data['SalesForceCustomerVisitID']) ? $data['SalesForceCustomerVisitID'] : '';

	if ($TransactionId == "" ) {
		$apiResponse = json_encode(recordNotFoundMsg(0, "SalesForceCustomerVisitID param are missing"));
		apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
		echo $apiResponse;
		return;
	}

	// {
    //     "SysValue": 1,
    //     "SysMessage": "Successful",
    //     "SL": 1,
    //     "TRANDATE": "18-Sep-2024 02:48 PM", ===========visit date
    //     "TRANDATEOUT": "",===========always empty
    //     "SERVICEENGINEER": "Md. Rupon Mondal",=============visitor name
    //     "CUSTOMERNAME": "FARIHA KNITTEX LTD. (PRINTING)",
    //     "ADDRESS": "",	============= customer address

    //     "MACHINENAME": "Laboratory Dyeing Machine",
    //     "MODELNO": "Model: SD-16",
    //     "SERIALNO": "373",
    //     "CUSTOMERCOMPLAINT": "shade variation",	============= MachineComplain
    //     "SERVICECONTENTS": "need to change the faulty pt 100 sensor",	============= SelfDiscussion
    //     "SUGGESTIONTOCUSTOMER": "", =============no need
    //     "SUGGESTIONBYCUSTOMER": "",=============no need
    //     "CUSTREPRENAME1": "",=============no need
    //     "CUSTREPREDESIG1": "",=============no need
    //     "CUSTREPRENAME2": "",=============no need
    //     "CUSTREPREDESIG2": "",=============no need
    //     "CUSTREPRENAME3": "",=============no need
    //     "CUSTREPREDESIG3": "",=============no need
    //     "MACHINEPARTS": "" =============parts name by coma seperator zzzzz,xxxx,cccv
    // }
	
	
	$query = "SELECT 1 AS SysValue,'Successful' AS SysMessage, 
	DATE_FORMAT(a.TransactionDate, '%d-%b-%Y %h:%i:%s %p') AS VisitDate,
	b.UserName AS VisitorName,
	ifnull(c.CustomerName,'') AS CustomerName,c.CompanyAddress AS Address,
	ifnull(e.MachineName,'') AS MachineName, ifnull(f.MachineModelName,'') AS MachineModelName, 
	ifnull(a.MachineSerial,'') AS MachineSerial,
	ifnull(a.MachineComplain,'') AS MachineComplain,
	ifnull(a.SelfDiscussion,'') AS SelfDiscussion,
	(SELECT ifnull(group_concat(concat(q.MachinePartsName,' (',round(p.Qty),')')),'')
	FROM `t_transaction_machineparts` p
	inner join t_machineparts q on p.MachinePartsId=q.MachinePartsId
	WHERE p.TransactionId=$TransactionId) AS MachinePartsName

	FROM t_transaction a
	inner join t_users b on a.UserId=b.UserId
	inner join t_customer c on a.CustomerId=c.CustomerId
	left join t_machine e on a.MachineId=e.MachineId
	left join t_machinemodel f on a.MachineModelId=f.MachineModelId

	where a.TransactionId=$TransactionId
	and a.TransactionTypeId in (1,2)
	ORDER BY a.TransactionDate DESC;";		

	$resultdata = $dbh->query($query);
	
	if (is_object($resultdata)) {
		$errormsg = $resultdata->errorInfo;
		$apiResponse = json_encode(recordNotFoundMsg(0,$errormsg[2]));
		apiLogWrite("Output (".date('Y_m_d_H_i_s')."): ".$apiResponse);
		echo $apiResponse;					
	}else if(count($resultdata)===0){
		$apiResponse = json_encode(recordNotFoundMsg());
		apiLogWrite("Output (".date('Y_m_d_H_i_s')."): ".$apiResponse);
		echo $apiResponse;
	}else{
		echo json_encode($resultdata);
		apiLogWrite("Output (".date('Y_m_d_H_i_s')."): Success");
	}
	
}catch(PDOException $e){
	$apiResponse = json_encode(recordNotFoundMsg(0,$e->getMessage()));
	apiLogWrite("Output (".date('Y_m_d_H_i_s')."): ".$apiResponse);
	echo $apiResponse;	
}

?>