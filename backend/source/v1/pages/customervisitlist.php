<?php

try{
	apiLogWrite("\n\n========$PageName=======Called (".date('Y_m_d_H_i_s').")===================");
	apiLogWrite("Params (".date('Y_m_d_H_i_s')."): ".json_encode($data));
	
	$dbh = new Db();
	$UserId =  isset($data['UserInfoID']) ? $data['UserInfoID'] : 0;
	$Search =  isset($data['Search']) ? $data['Search'] : 0;
	
	if ($UserId == "" ) {
		$apiResponse = json_encode(recordNotFoundMsg(0, "UserInfoID param is missing"));
		apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
		echo $apiResponse;
		return;
	}

	$sWhere = "";
	if($Search == "Y"){
		$sWhere = " AND a.IsVisitorFeedback='Y' ";
	}else if($Search == "N"){
		$sWhere = " AND a.IsVisitorFeedback='N' ";
	}


	
	$query = "SELECT 1 AS SysValue,'Successful' AS SysMessage, 
	a.TransactionId AS SalesForceCustomerVisitID, ifnull(PunchLocation,'') AS PunchLocation, 
	ifnull(Longitude,'') AS Longitude, ifnull(Latitude,'') AS Latitude,
	ifnull(a.DropDownListIDForPurpose,'') AS DropDownListIDForPurpose, ifnull(b.DisplayName,'') AS Purpose,
	ifnull(a.CustomerId,'') AS CustomerID, ifnull(c.CustomerName,'') AS CustomerName,
	ifnull(a.ContactPersonName,'') AS ContactPersonName, ifnull(a.ContactPersonDesignation,'') AS ContactPersonDesignation, 
	ifnull(a.ContactPersonMobileNumber,'') AS ContactPersonMobileNumber,
	ifnull(a.DropDownListIDForTransportation,'') AS DropDownListIDForTransportation, 
	ifnull(d.DisplayName,'') AS Transportation,
	ifnull(a.ConveyanceAmount,'') AS ConveyanceAmount, ifnull(a.RefreshmentAmount,'') AS RefreshmentAmount,
	DATE_FORMAT(a.TransactionDate, '%d-%b-%Y %h:%i:%s %p') AS VisitDate,
	a.IsVisitorFeedback,a.IsLinemanFeedback,
	ifnull(a.PublicTransportDesc,'') AS PublicTransportDesc, ifnull(a.DummyCustomerDesc,'') AS DummyCustomerDesc, 
	ifnull(e.MachineName,'') AS MachineName, ifnull(f.MachineModelName,'') AS MachineModelName, 
	ifnull(a.MachineSerial,'') AS MachineSerial, ifnull(a.MachineComplain,'') AS MachineComplain

	FROM t_transaction a
	left join t_dropdownlist b on a.DropDownListIDForPurpose=b.DropDownListID
	left join t_customer c on a.CustomerId=c.CustomerId
	left join t_dropdownlist d on a.DropDownListIDForTransportation=d.DropDownListID
	left join t_machine e on a.MachineId=e.MachineId
	left join t_machinemodel f on a.MachineModelId=f.MachineModelId

	where a.UserId=$UserId and a.TransactionTypeId=1
	$sWhere
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