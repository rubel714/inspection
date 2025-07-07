<?php

try{
	apiLogWrite("\n\n========$PageName=======Called (".date('Y_m_d_H_i_s').")===================");
	apiLogWrite("Params (".date('Y_m_d_H_i_s')."): ".json_encode($data));
	
	$dbh = new Db();
	$TransactionId =  isset($data['SalesForceCustomerVisitID'])?$data['SalesForceCustomerVisitID']:'';
	$CategoryID = 8; //Visit Action

	$query = "SELECT 1 AS SysValue,'Successful' AS SysMessage, 
	a.TransactionId AS SalesForceCustomerVisitID, 

	DATE_FORMAT(a.TransactionDate, '%d-%b-%Y %h:%i:%s %p') AS VisitDate,
	ifnull(a.ContactPersonName,'') AS ContactPersonName,
	ifnull(a.ContactPersonDesignation,'') AS ContactPersonDesignation,
	ifnull(a.ContactPersonMobileNumber,'') AS ContactPersonMobileNumber,

	ifnull(c.Designation,'') AS CustomerContactPersonDesignation, 
	ifnull(c.ContactPhone,'') AS CustomerContactPersonMobileNumber,
	ifnull(a.visitStartLocation,'') AS visitStartLocation,
	ifnull(a.visitStartTime,'') AS visitStartTime,
	


	ifnull(a.SelfDiscussion,'') AS SelfDiscussion,'' AS SelfFBVisitActions,'' AS SelfFBVisitMachineParts,
	case when a.SelfFollowUpDate is null then '' else DATE_FORMAT(a.SelfFollowUpDate, '%d-%b-%Y') end AS SelfFollowUpDate,
	ifnull(a.CustomerId,'') AS CustomerID,ifnull(c.CustomerName,'') AS CustomerName,
	ifnull(a.ConveyanceAmount,'') AS ConveyanceAmount,
	ifnull(a.RefreshmentAmount,'') AS RefreshmentAmount,
	ifnull(a.DinnerBillAmount,'') AS DinnerBillAmount,
	ifnull(a.ApprovedConveyanceAmount,'') AS ApprovedConveyanceAmount,
	ifnull(a.ApprovedRefreshmentAmount,'') AS ApprovedRefreshmentAmount,
	ifnull(a.ApprovedDinnerBillAmount,'') AS ApprovedDinnerBillAmount,
	ifnull(a.DropDownListIDForPurpose,'') AS DropDownListIDForPurpose,ifnull(b.DisplayName,'') AS Purpose,
	ifnull(a.PunchLocation,'') AS PunchLocation, ifnull(a.Longitude,'') AS Longitude,ifnull(a.Latitude,'') AS Latitude,
	ifnull(a.DropDownListIDForTransportation,'') AS DropDownListIDForTransportation,
	ifnull(d.DisplayName,'') AS Transportation,
	a.IsVisitorFeedback,a.IsLinemanFeedback,
	ifnull(a.LMAdvice,'') AS LMAdvice, 
	case when a.LMFollowUpDate is null then '' else DATE_FORMAT(a.LMFollowUpDate, '%d-%b-%Y') end AS LMFollowUpDate,
	ifnull(a.PublicTransportDesc,'') AS PublicTransportDesc, ifnull(a.DummyCustomerDesc,'') AS DummyCustomerDesc,
	ifnull(a.MachineId,'') AS MachineId,
	ifnull(e.MachineName,'') AS MachineName,ifnull(f.MachineModelName,'') AS MachineModelName,
	ifnull(a.MachineSerial,'') AS MachineSerial,ifnull(a.MachineComplain,'') AS MachineComplain
	,ifnull(a.customerBySuggestion,'') AS customerBySuggestion
	,(case when a.customerSignature is null then '' else concat('https://dysin.ng-ssl.com/image/transaction/',a.customerSignature) end) AS customerSignature
	,ifnull(a.customerToSuggestion,'') AS customerToSuggestion
	,ifnull(c.CompanyName,'') AS CustomerContactPersonName
	,case when a.VisitOutDate is null then '' else DATE_FORMAT(a.VisitOutDate, '%d-%b-%Y %h:%i:%s %p') end AS VisitOutDate



	FROM t_transaction a
	left join t_dropdownlist b on a.DropDownListIDForPurpose=b.DropDownListID
	left join t_customer c on a.CustomerId=c.CustomerId
	left join t_dropdownlist d on a.DropDownListIDForTransportation=d.DropDownListID
	left join t_machine e on a.MachineId=e.MachineId
	left join t_machinemodel f on a.MachineModelId=f.MachineModelId

	where a.TransactionId=$TransactionId
	and a.TransactionTypeId=1
	ORDER BY a.TransactionDate DESC;";
	$resultdata = $dbh->query($query);


	$SelfFBVisitActions=array();
	// $SelfFBVisitActions[]=array("VisitActionID"=>1);
	// $SelfFBVisitActions[]=array("VisitActionID"=>2);
	// $SelfFBVisitActions[]=array("VisitActionID"=>3);
	$query6 = "SELECT b.DropDownListID, b.DisplayName
	FROM t_transaction_dropdown a
	inner join t_dropdownlist b on a.DropDownListID=b.DropDownListID
	where a.TransactionId=$TransactionId
	and b.CategoryID=$CategoryID
	ORDER BY b.DropDownListID ASC;";
	$resultdata6 = $dbh->query($query6);
	foreach($resultdata6 as $key=>$row){
		$SelfFBVisitActions[]=array("VisitActionName"=>$row["DisplayName"]);
	}
	$resultdata[0]["SelfFBVisitActions"]=$SelfFBVisitActions;



	$SelfFBVisitMachineParts=array();
	// $SelfFBVisitMachineParts[]=array("MachinePartsId"=>11);
	// $SelfFBVisitMachineParts[]=array("MachinePartsId"=>29);
	// $SelfFBVisitMachineParts[]=array("MachinePartsId"=>53);
	$query7 = "SELECT a.MachinePartsId, b.MachinePartsName,a.Qty
	FROM t_transaction_machineparts a
	inner join t_machineparts b on a.MachinePartsId=b.MachinePartsId
	where a.TransactionId=$TransactionId
	ORDER BY b.MachinePartsId ASC;";
	$resultdata7 = $dbh->query($query7);
	foreach($resultdata7 as $key=>$row){
		$SelfFBVisitMachineParts[]=array("MachinePartsName"=>$row["MachinePartsName"],"PartsQuantity"=>$row["Qty"]);
	}
	$resultdata[0]["SelfFBVisitMachineParts"]=$SelfFBVisitMachineParts;

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