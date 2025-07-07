<?php

try{
	apiLogWrite("\n\n========$PageName=======Called (".date('Y_m_d_H_i_s').")===================");
	apiLogWrite("Params (".date('Y_m_d_H_i_s')."): ".json_encode($data));
	
	$dbh = new Db();
	// $UserId =  isset($data['UserInfoID']) ? $data['UserInfoID'] : '';
	$FromDate = isset($data['FromDate']) ? convertAppToDBDate(checkNull($data['FromDate'])) : null; //'20-Aug-2024'
	$ToDate = isset($data['ToDate']) ? convertAppToDBDate(checkNull($data['ToDate'])) : null; //'20-Aug-2024'

	if ($FromDate == "" || $ToDate == "" ) {
		$apiResponse = json_encode(recordNotFoundMsg(0, "FromDate or ToDate param are missing"));
		apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
		echo $apiResponse;
		return;
	}

	
    // {
    //     "SysValue": 1,
    //     "SysMessage": "Successful",
    //     "SalesForceCustomerVisitID": 45791,
    //     "Name": "18-Sep-2024 - FARIHA KNITTEX LTD. (PRINTING) - 
	// 	Laboratory Dyeing Machine - Model: SD-16 - "
		
	// 	Name: visit date - custormer name - machine name - model,
    // }

	$query = "SELECT 1 AS SysValue,'Successful' AS SysMessage, 
	TransactionId AS SalesForceCustomerVisitID,
	concat(DATE_FORMAT(a.TransactionDate, '%d-%b-%Y %h:%i:%s %p'),' - ',b.CustomerName,' - ',c.MachineName,' - ',d.MachineModelName) AS `Name`
	FROM t_transaction a
	inner join t_customer b on a.CustomerId=b.CustomerId
	inner join t_machine c on a.MachineId=c.MachineId
	inner join t_machinemodel d on a.MachineModelId=d.MachineModelId

	where a.TransactionTypeId=1
	and a.DropDownListIDForPurpose is not null
	and (a.TransactionDate between '$FromDate' and '$ToDate')
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