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
		$sWhere = " AND a.TransactionId = $Search ";
		//$sWhere = " AND (c.CustomerName like '%".$Search."%') ";
	}

// {
// 	"SysValue": 1,
// 	"SysMessage": "Successful",
// 	"SalesFunnelID": 27,										PK
// 	"UserInfoID": 124,
// 	"CustomerID": 31945,
// 	"CustomerName": "AL-ZAFOR",
// 	"ContactPersonName": "kk",
// 	"ContactPersonMobileNumber": "0",
// 	"ProductID": 0,								=========No need
// 	"ProductName": "Ancd",
// 	"RequiredQuantity": 12.00,
// 	"ExpectedPrice": 120.00,
// 	"OfferQuantity": 122.00,
// 	"NegotiablePrice": 122.00,
// 	"FinalPrice": 120.00,
// 	"FunnelStatusID": 28,
// 	"FunnelStatus": "Negotiation",
// 	"TranDate": "30-Sep-2024"
// }

	
 	$query = "SELECT 1 AS SysValue,'Successful' AS SysMessage, 
	a.TransactionId AS SalesForceCustomerVisitID,
		ifnull(a.DropDownListIDForFunnelStatus,'') AS DropDownListIDForFunnelStatus, 
		ifnull(b.DisplayName,'') AS FunnelStatus,
		ifnull(a.CustomerId,'') AS CustomerID, ifnull(c.CustomerName,'') AS CustomerName,
	ifnull(a.ContactPersonName,'') AS ContactPersonName, ifnull(a.ContactPersonDesignation,'') AS ContactPersonDesignation, 
	ifnull(a.ContactPersonMobileNumber,'') AS ContactPersonMobileNumber,
	ifnull(a.ProductName,'') AS ProductName,
	ifnull(a.RequiredQuantity,'') AS RequiredQuantity, ifnull(a.ExpectedPrice,'') AS ExpectedPrice,
	ifnull(a.OfferQuantity,'') AS OfferQuantity, ifnull(a.NegotiablePrice,'') AS NegotiablePrice,
	ifnull(a.FinalPrice,'') AS FinalPrice,
	DATE_FORMAT(a.TransactionDate, '%d-%b-%Y %h:%i:%s %p') AS TranDate

	FROM t_transaction a
	left join t_dropdownlist b on a.DropDownListIDForFunnelStatus=b.DropDownListID
	left join t_customer c on a.CustomerId=c.CustomerId

	where a.UserId=$UserId 
	and a.TransactionTypeId=5
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