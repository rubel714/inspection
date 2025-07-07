<?php

try{
	apiLogWrite("\n\n========$PageName=======Called (".date('Y_m_d_H_i_s').")===================");
	apiLogWrite("Params (".date('Y_m_d_H_i_s')."): ".json_encode($data));
	
	$dbh = new Db();
	$UserId =  isset($data['UserInfoID']) ? $data['UserInfoID'] : 0;
	//$Search =  isset($data['Search']) ? $data['Search'] : 0;
	
	// if ($UserId == "" ) {
	// 	$apiResponse = json_encode(recordNotFoundMsg(0, "UserInfoID param is missing"));
	// 	apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
	// 	echo $apiResponse;
	// 	return;
	// }

	$sWhere = "";
	// if($Search == "Y"){
	// 	$sWhere = " AND a.IsVisitorFeedback='Y' ";
	// }else if($Search == "N"){
	// 	$sWhere = " AND a.IsVisitorFeedback='N' ";
	// }

    // {
    //     "SysValue": 1,
    //     "SysMessage": "Successful",
    //     "SalesForceVisitPlanID": 20979,===============PK
    //     "UserInfoID": 124,
    //     "VisitDateTime": "19-Oct-2023 12:00 AM",=========trans date
    //     "CustomerID": 5485,
    //     "CustomerName": "MONIR CHEMICAL",
    //     "VisitPurpose": "Good",=================SelfDiscussion field. own feedback
    //     "TerminalID": "sdk_gphone64_x86_64",========no need
    //     "IPAddress": "10.0.2.16"========no need
    // }
	
	$query = "SELECT 1 AS SysValue,'Successful' AS SysMessage, 
	a.TransactionId AS SalesForceVisitPlanID, 
	DATE_FORMAT(a.TransactionDate, '%d-%b-%Y %h:%i:%s %p') AS VisitDateTime,
	ifnull(a.CustomerId,'') AS CustomerID, ifnull(c.CustomerName,'') AS CustomerName,
	ifnull(a.SelfDiscussion,'') AS VisitPurpose, a.UserId as UserInfoID
	FROM t_transaction a
	left join t_customer c on a.CustomerId=c.CustomerId
	where (a.UserId = $UserId OR $UserId = 0)
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