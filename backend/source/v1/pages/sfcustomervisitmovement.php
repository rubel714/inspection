<?php

try{
	apiLogWrite("\n\n========$PageName=======Called (".date('Y_m_d_H_i_s').")===================");
	apiLogWrite("Params (".date('Y_m_d_H_i_s')."): ".json_encode($data));
	
	$dbh = new Db();
	// $UserId =  isset($data['UserInfoID']) ? $data['UserInfoID'] : '';
	$SalesForceID =  isset($data['SalesForceID']) ? $data['SalesForceID'] : '';//entry by userid
	$VisitDate = isset($data['VisitDate']) ? convertAppToDBDate(checkNull($data['VisitDate'])) : null; //'20-Aug-2024'

	if ($SalesForceID == "" || $VisitDate == "" ) {
		$apiResponse = json_encode(recordNotFoundMsg(0, "SalesForceID or VisitDate param are missing"));
		apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
		echo $apiResponse;
		return;
	}

	
	// {
    //     "SysValue": 1,
    //     "SysMessage": "Successful",
    //     "SalesForceCustomerVisitID": 49993,
    //     "VisitDate": "04-Oct-2024 07:32 PM",=============
    //     "Longitude": "89.9015504",=========
    //     "Latitude": "24.2416246",==============
    //     "PunchLocation": "6WR2+QP7, Jamtoli - Kagmari Rd, Tangail, Bangladesh",
       
    // }

	 $query = "SELECT 1 AS SysValue,'Successful' AS SysMessage, 
	TransactionId AS SalesForceCustomerVisitID,
	DATE_FORMAT(a.TransactionDate, '%d-%b-%Y %h:%i:%s %p') AS VisitDate,
	ifnull(a.Longitude,'') AS Longitude,
	ifnull(a.Latitude ,'') AS Latitude 
	FROM t_transaction a
	where a.TransactionTypeId=1
	and a.UserId=$SalesForceID
	and date(a.TransactionDate) = '$VisitDate'
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