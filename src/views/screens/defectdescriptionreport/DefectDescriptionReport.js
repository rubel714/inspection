import React, { forwardRef, useRef,useEffect } from "react";

import { Button } from "../../../components/CustomControl/Button";
import Autocomplete from "@material-ui/lab/Autocomplete";
import { Typography, TextField } from "@material-ui/core";

import CustomTable from "components/CustomTable/CustomTable";
import {
  apiCall,
  apiCallReport,
  apiOption,
  LoginUserInfo,
  language,
} from "../../../actions/api";
import ExecuteQueryHook from "../../../components/hooks/ExecuteQueryHook";
import moment from "moment";


const DefectDescriptionReport = (props) => {
  const serverpage = "defectdescriptionreport"; // this is .php server page

  const { useState } = React;
  const [bFirst, setBFirst] = useState(true); 
  
  const { isLoading, data: dataList, error, ExecuteQuery } = ExecuteQueryHook(); //Fetch data
  const UserInfo = LoginUserInfo();

  const [StartDate, setStartDate] = useState(moment().format("YYYY-MM-DD"));
  const [EndDate, setEndDate] = useState(moment().format("YYYY-MM-DD"));

  /* =====Start of Excel Export Code==== */
  const EXCEL_EXPORT_URL = process.env.REACT_APP_API_URL;
 
    const handleChangeFilterDate = (e) => {
    const { name, value } = e.target;
    if (name === "StartDate") {
      setStartDate(value);
    }

    if (name === "EndDate") {
      setEndDate(value);
    }
  };

  useEffect(() => {
    getDataList();
  }, [StartDate, EndDate]);
 
  /* =====End of Excel Export Code==== */

  const columnList = [
    { field: "rownumber", label: "SL", align: "center", width: "3%" },
    // { field: 'SL', label: 'SL',width:'10%',align:'center',visible:true,sort:false,filter:false },
    {
      field: "BuyerName",
      label: "Buyer Name",
      align: "left",
      visible: true,
      sort: true,
      filter: true,
      width: "17%",
    },
    {
      field: "FactoryName",
      label: "Factory Name",
      align: "left",
      visible: true,
      sort: true,
      filter: true,
      width: "17%",
    },

    {
      field: "InvoiceNo",
      label: "Report Number",
      align: "left",
      visible: true,
      sort: true,
      filter: true,
      width: "12%",
    },
    {
      field: "CheckName",
      label: "Defect Description",
      align: "left",
      visible: true,
      sort: true,
      filter: true,
      // width: "12%",
    },
    {
      field: "CheckType",
      label: "Type",
      align: "left",
      visible: true,
      sort: true,
      filter: true,
      width: "6%",
    },
    {
      field: "TransactionDate",
      label: "Inspection Date",
      align: "left",
      visible: true,
      sort: true,
      filter: true,
      width: "10%",
    }
  ];

  if (bFirst) {
    /**First time call for datalist */
    getDataList();
    setBFirst(false);
  }

  /**Get data for table list */
  function getDataList() {
    let params = {
      action: "getDataList",
      lan: language(),
      UserId: UserInfo.UserId,
      StartDate: StartDate,
      EndDate: EndDate,
    };
    // console.log('LoginUserInfo params: ', params);

    ExecuteQuery(serverpage, params);
  }
   
  
  function getTemplateList() {
    // let params = {
    //   action: "TemplateList",
    //   lan: language(),
    //   UserId: UserInfo.UserId,
    // };

    // apiCall.post("combo_generic", { params }, apiOption()).then((res) => {
    //   setTemplateList(
    //     [{ id: 0, name: "Select Template" }].concat(res.data.datalist)
    //   );
 
    // });
  }

  // const handleChangeMasterDropDown = (name, value) => {
  //   let data = { ...currentRow };
  //   if (name === "TemplateId") {
  //     data["TemplateId"] = value;
  //     setCurrTemplateId(value);
  //     // console.log('value: ', value);
  //   }
  //   setCurrentRow(data);
  // };


  return (
    <>
        <div class="bodyContainer">
          {/* <!-- ######-----TOP HEADER-----####### --> */}
          <div class="topHeader">
            <h4>Home ❯ Reports ❯ Defect Description</h4>
          </div>

          {/* <!-- TABLE SEARCH AND GROUP ADD --> */}
          <div class="searchAdd">
         
          <div>
              <label>Report Start Date</label>
              <div class="">
                <input
                  type="date"
                  id="StartDate"
                  name="StartDate"
                  value={StartDate}
                  onChange={(e) => handleChangeFilterDate(e)}
                />
              </div>
            </div>

            <div>
              <label>Report End Date</label>

              <div class="">
                <input
                  type="date"
                  id="EndDate"
                  name="EndDate"
                  value={EndDate}
                  onChange={(e) => handleChangeFilterDate(e)}
                />
              </div>
            </div>

            {/* <Button
            label={"Export"}
            class={"btnPrint"}
            onClick={PrintPDFExcelExportFunction}
          /> */}
          </div>

 
          <CustomTable
            columns={columnList}
            rows={dataList ? dataList : {}}
            // actioncontrol={actioncontrol}
          />
 
        </div>

    </>
  );
};

export default DefectDescriptionReport;
