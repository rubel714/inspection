<?php

try{
	apiLogWrite("\n\n========$PageName=======Called (".date('Y_m_d_H_i_s').")===================");
	apiLogWrite("Params (".date('Y_m_d_H_i_s')."): ".json_encode($data));
	
	$dbh = new Db();
	$Search =  isset($data['Search'])?$data['Search']:'';
	
	$sWhere="";
	if($Search){
		$sWhere=" where (a.CustomerCode like '%$Search%' 
		OR a.CustomerName like '%$Search%' 
		OR a.ContactPhone like '%$Search%' 
		OR a.CompanyName like '%$Search%' 
		OR a.NatureOfBusiness like '%$Search%' 
		OR a.CompanyEmail like '%$Search%' 
		OR a.CompanyAddress like '%$Search%' 
		)";
	}
	
	$query = "SELECT 1 AS SysValue,'Successful' AS SysMessage, 
	a.CustomerId AS CustomerID, a.CustomerCode, a.CustomerName,
	'' AS Designation,ifnull(a.ContactPhone,'') AS ContactNumber,
	
	ifnull(a.CompanyName,'') AS CompanyName, ifnull(a.NatureOfBusiness,'') AS NatureOfBusiness, 
	ifnull(a.CompanyEmail,'') AS CompanyEmail,
	ifnull(a.CompanyAddress,'') AS CompanyAddress
	,0 AS UserInfoID,'' AS TerminalID,'' AS IPAddress
	,'Y' AS IsEligibleForConveyance
	,'Y' AS IsEligibleForRefreshment
	FROM t_customer a
	$sWhere
	ORDER BY a.CustomerId ASC;";		

// "CustomerID": 4074,
// "CustomerCode": "54165",
// "CustomerName": "ADHUNIK CHEMICAL",
// "Designation": "",
// "ContactNumber": "",

// "CompanyName": "",
// "NatureOfBusiness": "",
// "CompanyEmail": "",
// "CompanyAddress": "",
// "UserInfoID": 0,
// "TerminalID": "",
// "IPAddress": "",
// "IsEligibleForConveyance": "Y",
// "IsEligibleForRefreshment": "Y"


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