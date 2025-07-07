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
    //     "SL": 764,     ================= no need
    //     "EmployeeID": "9210058", ==============visitor user id/entry by user id
    //     "EmployeeName": "Md. Tariqul Islam", ==============visitor user name/entry by user name
    //     "EmpDesignation": "Site Engineer", ==============visitor user name/entry by user name
    //     "EmpDepartment": "Constraction", ==============visitor user name/entry by user name
    //     "ConveyanceDate": "16-Sep-2024",=============not need
    //     "ConveyanceTime": "09:53:21 AM",,=============not need
    //     "ConveyanceDate": "16-Sep-2024 09:53:21 AM",,=============trans date time
    //     "ReasonForEntertainment": "Others",========================== purpose (busines,order etc)
    //     "TravelDestination": "Fatullah market; JFQF+V94, Narayanganj, Bangladesh", ====== lat-log locatetion/ visit location
    //     "ModeOfTransport": "40", ===============PublicTransportDesc
    //     "ConveyanceAmount": 40.00, =======ConveyanceAmount
    //     "EntertainmentAmount": 0.00, =========RefreshmentAmount
		
		
    //     "VisitAllowance": 0,        ===============,=============not need this filed
    //     "FromDate": "16-Sep-2024",,=============not need this filed
    //     "ToDate": "30-Sep-2024",,=============not need this filed
    //     "TotalAmount": 310105.00,,=============not need this filed
    //     "TotalAmountInWord": "Three Lac Ten Thousand One Hundred Five",=============not need this filed
    // }

	$query = "SELECT 1 AS SysValue,'Successful' AS SysMessage, 

a.UserId AS EmployeeID, g.UserName AS EmployeeName
,h.DesignationName AS EmpDesignation, i.DepartmentName AS EmpDepartment,
DATE_FORMAT(a.TransactionDate, '%d-%b-%Y %h:%i:%s %p') AS ConveyanceDate,
ifnull(b.DisplayName,'') AS ReasonForEntertainment,
ifnull(a.PunchLocation,'') AS TravelDestination,
ifnull(a.PublicTransportDesc,'') AS ModeOfTransport,
ifnull(a.ConveyanceAmount,'') AS ConveyanceAmount, ifnull(a.RefreshmentAmount,'') AS RefreshmentAmount,
ifnull(a.ApprovedRefreshmentAmount,'') AS ApprovedRefreshmentAmount,ifnull(a.ApprovedConveyanceAmount,'') AS ApprovedConveyanceAmount

	FROM t_transaction a
	inner join t_users g on a.UserId=g.UserId
	inner join t_designation h on g.DesignationId=h.DesignationId
	inner join t_department i on g.DepartmentId=i.DepartmentId
	left join t_dropdownlist b on a.DropDownListIDForPurpose=b.DropDownListID

	where a.TransactionTypeId=1
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