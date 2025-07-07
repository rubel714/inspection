<?php

try {
	apiLogWrite("\n\n========$PageName=======Called (" . date('Y_m_d_H_i_s') . ")===================");
	apiLogWrite("Params (" . date('Y_m_d_H_i_s') . "): " . json_encode($data));

	$dbh = new Db();
	$FromDate = isset($data['FromDate']) ? convertAppToDBDate(checkNull($data['FromDate'])) : null; //'20-Aug-2024'
	$ToDate = isset($data['ToDate']) ? convertAppToDBDate(checkNull($data['ToDate'])) : null; //'20-Aug-2024'
	$DepartmentId =  isset($data['DepartmentId']) ? $data['DepartmentId'] : '';
	$UserInfoID =  isset($data['UserInfoID']) ? $data['UserInfoID'] : '';


	if ($FromDate == "" || $ToDate == "" || $DepartmentId == "" || $UserInfoID == "") {
		$apiResponse = json_encode(recordNotFoundMsg(0, "FromDate or ToDate or DepartmentId or UserInfoID param are missing"));
		apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
		echo $apiResponse;
		return;
	}

	// {
	//     "SysValue": 1,
	//     "SysMessage": "Successful",
	//     "SL": 1,
	//     "SalesForceCustomerVisitID": 47110,
	//     "VisitDate": "25-Sep-2024 09:17 AM",
	//     "EmployeeID": "9240031",-=====================visitor id
	//     "EmployeeName": "Md Moniruzzaman",===============visitor name
	//     "PunchLocation": "P9C6+9P4, Dhaka, Bangladesh",========visit location
	//     "VisitPurpose": "Installation",
	//     "CustomerCode": "CUS000763517",
	//     "CustomerName": "Modina febric",
	//     "ContactPersonName": "Kabir Hossain",==============customer cont person name
	//     "ContactPersonDesignation": "Owner",
	//     "ContactPersonMobileNumber": "8801766678310",
	//     "TransportationType": "Public",
	//     "ConveyanceAmount": 250.00,
	//     "RefreshmentAmount": 0.00,
	//     "LineManagerID": "2002930811641",
	//     "LineManagerName": "Ruhul Amin",
	//     "FromDate": "25-Sep-2024",===========================no need
	//     "ToDate": "25-Sep-2024",===========================no need
	//     "SelfDiscussion": "Unloading", ===================SelfDiscussion
	//     "LMAdvice": "",
	//     "LastFollowUpDate": null ===================LMFollowUpDate
	// },

	 $query = "SELECT 1 AS SysValue,'Successful' AS SysMessage, 
	a.TransactionId AS SalesForceCustomerVisitID, 
	DATE_FORMAT(a.TransactionDate, '%d-%b-%Y %h:%i:%s %p') AS VisitDate,
	a.UserId AS EmployeeID, b.UserName AS EmployeeName, 
	ifnull(b.PhoneNo,'') AS EmployeePhone,
	ifnull(a.PunchLocation,'') AS PunchLocation,
	ifnull(c.DisplayName,'') AS VisitPurpose,
	ifnull(d.CustomerCode,'') AS CustomerCode,
	ifnull(d.CustomerName,'') AS CustomerName,
	ifnull(a.ContactPersonName,'') AS ContactPersonName,
	ifnull(a.ContactPersonDesignation,'') AS ContactPersonDesignation,
	ifnull(a.ContactPersonMobileNumber,'') AS ContactPersonMobileNumber,
	ifnull(e.DisplayName,'') AS Transportation,
	ifnull(a.ConveyanceAmount,'') AS ConveyanceAmount, ifnull(a.RefreshmentAmount,'') AS RefreshmentAmount,
	ifnull(a.ApprovedRefreshmentAmount,'') AS ApprovedRefreshmentAmount,ifnull(a.ApprovedConveyanceAmount,'') AS ApprovedConveyanceAmount,
	ifnull(a.SelfDiscussion,'') AS SelfDiscussion,
	ifnull(a.LMAdvice,'') AS LMAdvice,
	case when a.LMFollowUpDate is null then '' else DATE_FORMAT(a.LMFollowUpDate, '%d-%b-%Y') end AS LMFollowUpDate,
	ifnull(b.LinemanUserId,'') AS LineManagerID,
	ifnull(f.UserName,'') AS LineManagerName

	FROM t_transaction a
	inner join t_users b on a.UserId=b.UserId
	left join t_dropdownlist c on a.DropDownListIDForPurpose=c.DropDownListID
	left join t_customer d on a.CustomerId=d.CustomerId
	left join t_dropdownlist e on a.DropDownListIDForTransportation=e.DropDownListID
	left join t_users f on b.LinemanUserId=f.UserId
	where a.TransactionTypeId=1
	and (a.TransactionDate between '$FromDate' and '$ToDate')
	and (b.DepartmentId = $DepartmentId or $DepartmentId=0)
	and (b.UserId = $UserInfoID or $UserInfoID=0)
	ORDER BY a.TransactionDate DESC;";

	$resultdata = $dbh->query($query);

	if (is_object($resultdata)) {
		$errormsg = $resultdata->errorInfo;
		$apiResponse = json_encode(recordNotFoundMsg(0, $errormsg[2]));
		apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
		echo $apiResponse;
	} else if (count($resultdata) === 0) {
		$apiResponse = json_encode(recordNotFoundMsg());
		apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
		echo $apiResponse;
	} else {
		echo json_encode($resultdata);
		apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): Success");
	}
} catch (PDOException $e) {
	$apiResponse = json_encode(recordNotFoundMsg(0, $e->getMessage()));
	apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
	echo $apiResponse;
}
