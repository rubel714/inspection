<?php

try{
	
	apiLogWrite("\n\n========$PageName=======Called (".date('Y_m_d_H_i_s').")===================");
	apiLogWrite("Params (".date('Y_m_d_H_i_s')."): ".json_encode($data));
	
	$UserId =  isset($data['UserInfoID']) ? $data['UserInfoID'] : 0;
	$VisitDate = isset($data['VisitDate']) ? convertAppToDBDate(checkNull($data['VisitDate'])) : null;
		
	$dbh = new Db();
	$query = "SELECT 1 AS SysValue,'Successful' AS SysMessage, count(a.TransactionId) AS VisitCount
	FROM t_transaction a
	where a.TransactionTypeId=1
	and a.UserId = $UserId
	and a.DropDownListIDForPurpose in (1,2,3,4,5)
	and (date(a.TransactionDate) = '$VisitDate');";

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