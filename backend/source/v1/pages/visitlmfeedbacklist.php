<?php

try{
	apiLogWrite("\n\n========$PageName=======Called (".date('Y_m_d_H_i_s').")===================");
	apiLogWrite("Params (".date('Y_m_d_H_i_s')."): ".json_encode($data));
	
	$dbh = new Db();
	$UserId =  isset($data['UserInfoID']) ? $data['UserInfoID'] : 0; /**This is Line Man user id. We will return under this members visitor list */
	$Search =  isset($data['Search']) ? $data['Search'] : 0; //0=All, Y=LM approved, N=LM not approved
	
	if ($UserId == "" ) {
		$apiResponse = json_encode(recordNotFoundMsg(0, "UserInfoID param is missing"));
		apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
		echo $apiResponse;
		return;
	}

	$sWhere = "";
	if($Search == "Y"){
		$sWhere = " AND a.IsLinemanFeedback='Y' ";
	}else if($Search == "N"){
		$sWhere = " AND a.IsLinemanFeedback='N' ";
	}

	$query = "SELECT 1 AS SysValue,'Successful' AS SysMessage, 
	a.TransactionId AS SalesForceCustomerVisitID, ifnull(PunchLocation,'') AS PunchLocation, 
	ifnull(Longitude,'') AS Longitude, ifnull(Latitude,'') AS Latitude,
	ifnull(a.DropDownListIDForPurpose,'') AS DropDownListIDForPurpose,ifnull(b.DisplayName,'') AS Purpose,
	ifnull(a.CustomerId,'') AS CustomerID,ifnull(c.CustomerName,'') AS CustomerName,
	ifnull(a.ContactPersonName,'') AS ContactPersonName,ifnull(a.ContactPersonDesignation,'') AS ContactPersonDesignation,
	ifnull(a.ContactPersonMobileNumber,'') AS ContactPersonMobileNumber,
	ifnull(a.DropDownListIDForTransportation,'') AS DropDownListIDForTransportation,
	ifnull(d.DisplayName,'') AS Transportation,
	ifnull(a.ConveyanceAmount,'') AS ConveyanceAmount, ifnull(a.RefreshmentAmount,'') AS RefreshmentAmount,
	ifnull(a.ApprovedRefreshmentAmount,'') AS ApprovedRefreshmentAmount,ifnull(a.ApprovedConveyanceAmount,'') AS ApprovedConveyanceAmount,
	DATE_FORMAT(a.TransactionDate, '%d-%b-%Y %h:%i:%s %p') AS VisitDate,
	a.IsVisitorFeedback,a.IsLinemanFeedback,
	ifnull(a.PublicTransportDesc,'') AS PublicTransportDesc, ifnull(a.DummyCustomerDesc,'') AS DummyCustomerDesc,
	ifnull(e.MachineName,'') AS MachineName,ifnull(f.MachineModelName,'') AS MachineModelName,
	ifnull(a.SelfDiscussion,'') AS SelfDiscussion,
	case when a.SelfFollowUpDate is null then '' else DATE_FORMAT(a.SelfFollowUpDate, '%d-%b-%Y') end AS SelfFollowUpDate,
	ifnull(a.LMAdvice,'') AS LMAdvice, 
	case when a.LMFollowUpDate is null then '' else DATE_FORMAT(a.LMFollowUpDate, '%d-%b-%Y') end AS LMFollowUpDate,
	ifnull(a.MachineSerial,'') AS MachineSerial,ifnull(a.MachineComplain,'') AS MachineComplain,
	g.UserName AS VisitorName

	FROM t_transaction a
	inner join t_users g on a.UserId=g.UserId
	left join t_dropdownlist b on a.DropDownListIDForPurpose=b.DropDownListID
	left join t_customer c on a.CustomerId=c.CustomerId
	left join t_dropdownlist d on a.DropDownListIDForTransportation=d.DropDownListID
	left join t_machine e on a.MachineId=e.MachineId
	left join t_machinemodel f on a.MachineModelId=f.MachineModelId
	where (g.LinemanUserId=$UserId OR $UserId=0)
	and a.TransactionTypeId=1
	and a.IsVisitorFeedback='Y'
	$sWhere
	and (a.ConveyanceAmount>0 OR a.RefreshmentAmount>0 OR a.ApprovedRefreshmentAmount>0 OR a.ApprovedConveyanceAmount>0)
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