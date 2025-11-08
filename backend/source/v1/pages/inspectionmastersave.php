<?php
try {

	apiLogWrite("\n\n========$PageName=======Called (" . date('Y_m_d_H_i_s') . ")===================");
	apiLogWrite("Params (" . date('Y_m_d_H_i_s') . "): " . json_encode($data));

	$db = new Db();
	$TransactionId = isset($data['TransactionId']) ? checkNull($data['TransactionId']) : "";
	$TransactionDate = isset($data['TransactionDate']) ? convertAppToDBDate(checkNull($data['TransactionDate'])) : ""; //21-Aug-2024 5:15 AM
	$InvoiceNo = isset($data['InvoiceNo']) ? checkNull($data['InvoiceNo']) : "";
	$BuyerName = isset($data['BuyerName']) ? checkNull($data['BuyerName']) : null;
	$SupplierName = isset($data['SupplierName']) ? checkNull($data['SupplierName']) : null;
	$FactoryName = isset($data['FactoryName']) ? checkNull($data['FactoryName']) : null;

	$CoverFilePages = isset($data['CoverFilePages']) ? checkNull($data['CoverFilePages']) : "";
	$CoverFileUrl = isset($data['CoverFileUrl']) ? checkNull($data['CoverFileUrl']) : null; 
	$FooterFileUrl = isset($data['FooterFileUrl']) ? checkNull($data['FooterFileUrl']) : null; 
	$UserId = isset($data['UserInfoID']) ? checkNull($data['UserInfoID']) : "";
	$ManyImgPrefix = isset($data['ManyImgPrefix']) ? checkNull($data['ManyImgPrefix']) : "";
	$CurrentDate = date('Y-m-d H:i:s');
	$ClientId = 1;
	$TransactionTypeId = 1;
	$StatusId = 1;

	if ($CoverFileUrl) {
		$CoverFileUrl = ConvertFileAPI($CoverFileUrl, $ManyImgPrefix, "pdf","cover");
	}
	if ($FooterFileUrl) {
		$FooterFileUrl = ConvertFileAPI($FooterFileUrl, $ManyImgPrefix, "pdf","footer");
	}



	if ($TransactionDate == "") {
		$apiResponse = json_encode(recordNotFoundMsg(0, "Report Date param is missing"));
		apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
		echo $apiResponse;
		return;
	}

	if ($InvoiceNo == "") {
		$apiResponse = json_encode(recordNotFoundMsg(0, "Report Number param is missing"));
		apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
		echo $apiResponse;
		return;
	}

	// if ($CoverFilePages == "" ) {
	// 	$apiResponse = json_encode(recordNotFoundMsg(0, "Cover File Page Count param is missing"));
	// 	apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
	// 	echo $apiResponse;
	// 	return;
	// }

	// if ($CoverFileUrl == "" ) {
	// 	$apiResponse = json_encode(recordNotFoundMsg(0, "Cover File param is missing"));
	// 	apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
	// 	echo $apiResponse;
	// 	return;
	// }

	if ($UserId == "") {
		$apiResponse = json_encode(recordNotFoundMsg(0, "UserId param is missing"));
		apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
		echo $apiResponse;
		return;
	}

	if ($ManyImgPrefix == "") {
		$apiResponse = json_encode(recordNotFoundMsg(0, "ManyImg Prefix param is missing"));
		apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
		echo $apiResponse;
		return;
	}

	
	if ($TransactionId == "") {
		$query = "INSERT INTO t_transaction(ClientId, TransactionTypeId, TransactionDate, InvoiceNo,BuyerName,SupplierName,FactoryName, CoverFilePages, CoverFileUrl,FooterFileUrl, UserId, StatusId,ManyImgPrefix) 
			VALUES (:ClientId, :TransactionTypeId, :TransactionDate, :InvoiceNo,:BuyerName,:SupplierName,:FactoryName, :CoverFilePages, :CoverFileUrl, :FooterFileUrl, :UserId, :StatusId, :ManyImgPrefix);";

		$pList = array(
			'ClientId' => $ClientId,
			'TransactionTypeId' => $TransactionTypeId,
			'TransactionDate' => $TransactionDate,
			'InvoiceNo' => $InvoiceNo,
			'BuyerName' => $BuyerName,
			'SupplierName' => $SupplierName,
			'FactoryName' => $FactoryName,
			'CoverFilePages' => $CoverFilePages,
			'CoverFileUrl' => $CoverFileUrl,
			'FooterFileUrl' => $FooterFileUrl,
			'UserId' => $UserId,
			'StatusId' => $StatusId,
			'ManyImgPrefix' => $ManyImgPrefix
		);
	} else {

		if ($CoverFileUrl && $FooterFileUrl) {
			$query = "UPDATE t_transaction set TransactionDate=:TransactionDate, InvoiceNo=:InvoiceNo,
			BuyerName=:BuyerName,SupplierName=:SupplierName,FactoryName=:FactoryName, 
			CoverFilePages=:CoverFilePages, CoverFileUrl=:CoverFileUrl, FooterFileUrl=:FooterFileUrl
			where TransactionId=:TransactionId;";

			$pList = array(
				'TransactionDate' => $TransactionDate,
				'InvoiceNo' => $InvoiceNo,
				'BuyerName' => $BuyerName,
				'SupplierName' => $SupplierName,
				'FactoryName' => $FactoryName,
				'CoverFilePages' => $CoverFilePages,
				'CoverFileUrl' => $CoverFileUrl,
				'FooterFileUrl' => $FooterFileUrl,
				'TransactionId' => $TransactionId
			);

		}
		else if ($CoverFileUrl) {
			$query = "UPDATE t_transaction set TransactionDate=:TransactionDate, InvoiceNo=:InvoiceNo,
			BuyerName=:BuyerName,SupplierName=:SupplierName,FactoryName=:FactoryName, 
			CoverFilePages=:CoverFilePages, CoverFileUrl=:CoverFileUrl
			where TransactionId=:TransactionId;";

			$pList = array(
				'TransactionDate' => $TransactionDate,
				'InvoiceNo' => $InvoiceNo,
				'BuyerName' => $BuyerName,
				'SupplierName' => $SupplierName,
				'FactoryName' => $FactoryName,
				'CoverFilePages' => $CoverFilePages,
				'CoverFileUrl' => $CoverFileUrl,
				'TransactionId' => $TransactionId
			);


		}
		else if ($FooterFileUrl) {
			$query = "UPDATE t_transaction set TransactionDate=:TransactionDate, InvoiceNo=:InvoiceNo,
			BuyerName=:BuyerName,SupplierName=:SupplierName,FactoryName=:FactoryName, 
			CoverFilePages=:CoverFilePages, FooterFileUrl=:FooterFileUrl
			where TransactionId=:TransactionId;";

			$pList = array(
				'TransactionDate' => $TransactionDate,
				'InvoiceNo' => $InvoiceNo,
				'BuyerName' => $BuyerName,
				'SupplierName' => $SupplierName,
				'FactoryName' => $FactoryName,
				'CoverFilePages' => $CoverFilePages,
				'FooterFileUrl' => $FooterFileUrl,
				'TransactionId' => $TransactionId
			);

		}else{
			$query = "UPDATE t_transaction set TransactionDate=:TransactionDate, 
			InvoiceNo=:InvoiceNo,BuyerName=:BuyerName,SupplierName=:SupplierName,FactoryName=:FactoryName, 
			CoverFilePages=:CoverFilePages
			where TransactionId=:TransactionId;";

			$pList = array(
				'TransactionDate' => $TransactionDate,
				'InvoiceNo' => $InvoiceNo,
				'BuyerName' => $BuyerName,
				'SupplierName' => $SupplierName,
				'FactoryName' => $FactoryName,
				'CoverFilePages' => $CoverFilePages,
				'TransactionId' => $TransactionId
			);
		}

		
		
	}

	$db->bindMore($pList);
	$resultdata = $db->query($query);

	if (is_object($resultdata)) {
		$errormsg = $resultdata->errorInfo;
		$apiResponse = json_encode(recordNotFoundMsg(0, $errormsg[2]));
		apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
		echo $apiResponse;
	} else {

		if ($TransactionId == "") {
			$TransactionId = $db->lastInsertId();
		}

		$response = array(["SysValue" => 1, "SysMessage" => "Data has been saved successfully", "TransactionId" => $TransactionId]);
		$apiResponse = json_encode($response);
		echo $apiResponse;
		apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
	}
} catch (PDOException $e) {
	$apiResponse = json_encode(recordNotFoundMsg(0, $e->getMessage()));
	apiLogWrite("Output (" . date('Y_m_d_H_i_s') . "): " . $apiResponse);
	echo $apiResponse;
}
