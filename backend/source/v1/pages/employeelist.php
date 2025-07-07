<?php



try{
	apiLogWrite("\n\n========$PageName=======Called (".date('Y_m_d_H_i_s').")===================");
	apiLogWrite("Params (".date('Y_m_d_H_i_s')."): ".json_encode($data));
	
	$dbh = new Db();
	$Search =  isset($data['Search'])?$data['Search']:'';
	
	$sWhere="";
	if($Search){
		$sWhere=" where a.UserName like '%$Search%' ";
	}
	
	$query = "SELECT 1 AS SysValue,'Successful' AS SysMessage, 
	a.UserId AS EmployeeID, a.UserName AS EmployeeName, ifnull(b.DesignationName,'') AS DesignationName,c.DepartmentName,
	ifnull(a.Address,'') AS LocationName,'' AS ContactNumber,a.Email AS EmailAddress
	FROM t_users a
	INNER JOIN t_designation b on a.DesignationId=b.DesignationId
	INNER JOIN t_department c on a.DepartmentId=c.DepartmentId
	$sWhere
	ORDER BY a.UserId ASC;";		

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