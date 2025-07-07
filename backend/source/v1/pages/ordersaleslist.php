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
	if($Search == '0'){
		$sWhere = " ";
	}else{
		$sWhere = " AND (d.DisplayName like '%".$Search."%' 
		OR c.CustomerName like '%".$Search."%') ";
	}

	// {
    //     "SysValue": 1,
    //     "SysMessage": "Successful",
    //     "SalesForceOrderSalesID": 66,
    //     "UserInfoID": 124,
    //     "Purpose": "Lab",
    //     "CustomerID": 4074,
    //     "CustomerName": "ADHUNIK CHEMICAL",
    //     "ContactPersonName": "test",
    //     "ContactPersonDesignation": "dev",
    //     "ContactPersonMobileNumber": "019",
    //     "ProductDetails": "yes",          ===============new field
    //     "TargetPrice": 255.00,          ===============new field
    //     "SalesOrderVolume": 369.00,          ===============new field
    //     "Action": "Done",             =========this is has in dropdownlist catid= 5
    //     "TerminalID": "Symphony Z60",
    //     "IPAddress": "192.168.0.102"
    // }

	
 	$query = "SELECT 1 AS SysValue,'Successful' AS SysMessage, 
	a.TransactionId AS SalesForceCustomerVisitID,
		ifnull(a.DropDownListIDForPurpose,'') AS DropDownListIDForPurpose, ifnull(b.DisplayName,'') AS Purpose,
		ifnull(a.CustomerId,'') AS CustomerID, ifnull(c.CustomerName,'') AS CustomerName,
	ifnull(a.ContactPersonName,'') AS ContactPersonName, ifnull(a.ContactPersonDesignation,'') AS ContactPersonDesignation, 
	ifnull(a.ContactPersonMobileNumber,'') AS ContactPersonMobileNumber,
	ifnull(a.ProductDetails,'') AS ProductDetails,
	ifnull(a.TargetPrice,'') AS TargetPrice, ifnull(a.SalesOrderVolume,'') AS SalesOrderVolume,
	ifnull(a.DropDownListIDForVisitAction,'') AS DropDownListIDForVisitAction, ifnull(d.DisplayName,'') AS Action

	FROM t_transaction a
	left join t_dropdownlist b on a.DropDownListIDForPurpose=b.DropDownListID
	left join t_customer c on a.CustomerId=c.CustomerId
	left join t_dropdownlist d on a.DropDownListIDForVisitAction=d.DropDownListID

	where a.UserId=$UserId 
	and a.TransactionTypeId=3
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