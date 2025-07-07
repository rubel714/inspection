import React, { forwardRef, useRef, useEffect } from "react";
import swal from "sweetalert";
import { DeleteOutline, Edit } from "@material-ui/icons";
import { Button } from "../../../components/CustomControl/Button";
import moment from "moment";
import { Typography, TextField } from "@material-ui/core";

import Autocomplete from "@material-ui/lab/Autocomplete";
import CustomTable from "components/CustomTable/CustomTable";
import {
  apiCall,
  apiOption,
  LoginUserInfo,
  language,
} from "../../../actions/api";
import ExecuteQueryHook from "../../../components/hooks/ExecuteQueryHook";

const LocalConveyance = (props) => {
  const serverpage = "transactionreport"; // this is .php server page

  const permissionType = props.permissionType;
  const { useState } = React;
  const [bFirst, setBFirst] = useState(true);

  const { isLoading, data: dataList, error, ExecuteQuery } = ExecuteQueryHook(); //Fetch data

  const UserInfo = LoginUserInfo();
  const [currReportTypeId, setCurrReportTypeId] = useState(
    "LocalConveyance"
  );

  const [DepartmentList, setDepartmentList] = useState(null);
  const [currDepartmentId, setCurrDepartmentId] = useState(0);

  const [UserList, setUserList] = useState(null);
  const [currUserId, setCurrUserId] = useState(UserInfo.UserId);
  // console.log('UserInfo: ', UserInfo.UserName);
  const [isdisablevisitorlist, setIsdisablevisitorlist] = useState(true);

  const [TransactionList, setTransactionList] = useState(null);
  const [currTransactionId, setCurrTransactionId] = useState(0);

  // const [StartDate, setStartDate] = useState(
  //   moment().subtract(30, "days").format("YYYY-MM-DD")
  // );
  // const [EndDate, setEndDate] = useState(moment().format("YYYY-MM-DD"));

  let currDay = moment().format("DD");
  let currMonth = moment().format("MM");
  let currYear = moment().format("YYYY");

  let defaultStartDate = "";
  let defaultEndDate = "";
  if (currDay > 15) {
    //from curr month
    defaultStartDate = currYear + "-" + currMonth + "-01";
    defaultEndDate = currYear + "-" + currMonth + "-15";
  } else {
    let premontMonth = moment().subtract(1, "months").format("YYYY-MM-DD"); // Go pre month
    let myd = premontMonth.split("-");

    let preMonthLastDay = new Date(
      currYear + "-" + currMonth + "-00"
    ).getDate(); //return premonth last day
    // console.log('preMonthLastDay: ', preMonthLastDay);

    defaultStartDate = myd[0] + "-" + myd[1] + "-16";
    defaultEndDate = myd[0] + "-" + myd[1] + "-" + preMonthLastDay;
  }

  const [StartDate, setStartDate] = useState(defaultStartDate);
  const [EndDate, setEndDate] = useState(defaultEndDate);

  // const [StartDate, setStartDate] = useState(
  //   moment().subtract(30, "days").format("YYYY-MM-DD")
  // );
  // const [EndDate, setEndDate] = useState(moment().format("YYYY-MM-DD"));

  /* =====Start of Excel Export Code==== */
  const EXCEL_EXPORT_URL = process.env.REACT_APP_API_URL;

  const ExcelGenerate = () => {
    // if (!chkValidation()) {
    //   return;
    // }

    let finalUrl =
      EXCEL_EXPORT_URL + "report/LocalConveyance_excel.php";
    window.open(
      finalUrl +
        "?DepartmentId=" +
        currDepartmentId +
        "&VisitorId=" +
        currUserId +
        "&StartDate=" +
        StartDate +
        "&EndDate=" +
        EndDate +
        "&TimeStamp=" +
        Date.now()
    );
  };

  const PDFGenerate = () => {

    let finalUrl = EXCEL_EXPORT_URL + "report/LocalConveyance_pdf.php";
    window.open(
      finalUrl +
        "?DepartmentId=" +
        currDepartmentId +
        "&VisitorId=" +
        currUserId +
        "&StartDate=" +
        StartDate +
        "&EndDate=" +
        EndDate +
        "&TimeStamp=" +
        Date.now()
    );
  };

  /* =====End of Excel Export Code==== */

  const handleChangeFilterDropDown = (name, value) => {

    // if (name === "DepartmentId") {
    //   setCurrDepartmentId(value);
    //   // getUser(value);
    // }

    // if (name === "UserId") {
    //   setCurrUserId(value);
    // }

  };

  const handleChangeFilterDate = (e) => {
    const { name, value } = e.target;
    if (name === "StartDate") {
      setStartDate(value);
    }

    if (name === "EndDate") {
      setEndDate(value);
    }
  };

  // function getDepartment() {
  //   let params = {
  //     action: "DepartmentList",
  //     lan: language(),
  //     UserId: UserInfo.UserId,
  //     ClientId: UserInfo.ClientId,
  //     BranchId: UserInfo.BranchId,
  //   };

  //   apiCall.post("combo_generic", { params }, apiOption()).then((res) => {
  //     setDepartmentList([{ id: 0, name: "All" }].concat(res.data.datalist));

  //     setCurrDepartmentId(0);
  //   });
  // }

  // function getUser(deptId) {
  //   let params = {
  //     action: "UserList",
  //     lan: language(),
  //     UserId: UserInfo.UserId,
  //     ClientId: UserInfo.ClientId,
  //     BranchId: UserInfo.BranchId,
  //     DepartmentId: deptId,
  //   };

  //   apiCall.post("combo_generic", { params }, apiOption()).then((res) => {

  //     setUserList([{ id: 0, name: "Select" }].concat(res.data.datalist));

  //     // setCurrUserId(0);
  //     setCurrUserId(UserInfo.ClientId);
  //   });
  // }
 
  
  useEffect(() => {
    getDataList();
  }, [
    currDepartmentId,
    currUserId,
    StartDate,
    EndDate,
  ]);



  const columnList =  [
    { field: "rownumber", label: "SL", align: "center", width: "5%" },
    {
      field: "TransactionDate",
      label: "Date",
      align: "left",
      visible: true,
      sort: true,
      filter: true,
      width: "10%",
    },

    {
      field: "DisplayName",
      label: "Reason For Entertainment",
      align: "left",
      visible: true,
      sort: true,
      filter: true,
      // width: "20%"
    },
    {
      field: "CustomerName",
      label: "Travel Origin to Destination",
      align: "left",
      visible: true,
      sort: true,
      filter: true,
    },
    {
      field: "PublicTransportDesc",
      label: "Transport Details",
      align: "left",
      visible: true,
      sort: true,
      filter: true,
      width: "12%",
    },

    {
      field: "ApprovedConveyanceAmount",
      label: "Conveyance (TK)",
      align: "right",
      visible: true,
      sort: true,
      filter: true,
      width: "9%",
    },
    {
      field: "ApprovedRefreshmentAmount",
      label: "Entertainment (TK)",
      align: "right",
      visible: true,
      sort: true,
      filter: true,
      width: "10%",
    },
    {
      field: "ApprovedDinnerBillAmount",
      label: "Dinner Bill (TK)",
      align: "right",
      visible: true,
      sort: true,
      filter: true,
      width: "9%",
    },
  ];

  if (bFirst) {
    /**First time call for datalist */
    // getDepartment();
    // getUser(0);
    setBFirst(false);
  }

  /**Get data for table list */
  function getDataList() {
    let params = {
      action: "getDataList",
      lan: language(),
      UserId: UserInfo.UserId,
      ClientId: UserInfo.ClientId,
      BranchId: UserInfo.BranchId,
      ReportTypeId: currReportTypeId,
      DepartmentId: currDepartmentId,
      VisitorId: currUserId,
      StartDate: StartDate,
      EndDate: EndDate,
      TransactionId: currTransactionId,
    };

    ExecuteQuery(serverpage, params);
  }

  return (
    <>
      <div class="bodyContainer">
        {/* <!-- ######-----TOP HEADER-----####### --> */}
        <div class="topHeader">
          <h4>
            <a href="#">Home</a> ❯ Reports ❯ Self Conveyance Report
          </h4>
        </div>

        <div class="searchAdd">
          {/* <div>
            <label>Department</label>
          </div>
          <div class="">
            <Autocomplete
              autoHighlight
              disableClearable
              className="chosen_dropdown"
              id="DepartmentId"
              name="DepartmentId"
              autoComplete
              options={DepartmentList ? DepartmentList : []}
              getOptionLabel={(option) => option.name}
              defaultValue={{ id: 0, name: "All" }}
              onChange={(event, valueobj) =>
                handleChangeFilterDropDown(
                  "DepartmentId",
                  valueobj ? valueobj.id : ""
                )
              }
              renderOption={(option) => (
                <Typography className="chosen_dropdown_font">
                  {option.name}
                </Typography>
              )}
              renderInput={(params) => (
                <TextField {...params} variant="standard" fullWidth />
              )}
            />
          </div> */}

          <div>
            <label>Sales Force: {UserInfo.UserName}</label>
          </div>

          {/* <div class="">
            <Autocomplete
              autoHighlight
              disableClearable
              className="chosen_dropdown"
              id="UserId"
              name="UserId"
              autoComplete
              options={UserList ? UserList : []}
              getOptionLabel={(option) => option.name}
              defaultValue={{ id: 0, name: "Select" }}
              onChange={(event, valueobj) =>
                handleChangeFilterDropDown(
                  "UserId",
                  valueobj ? valueobj.id : ""
                )
              }
              renderOption={(option) => (
                <Typography className="chosen_dropdown_font">
                  {option.name}
                </Typography>
              )}
              renderInput={(params) => (
                <TextField {...params} variant="standard" fullWidth />
              )}
            />
          </div> */}

          <div>
            <label>Start Date</label>
            <div class="">
            <input
              type="date"
              id="StartDate"
              name="StartDate"
              value={StartDate}
              disabled={true}
              onChange={(e) => handleChangeFilterDate(e)}
            />
          </div>
          </div>
          

          <div>
            <label>End Date</label>
            <div class="">
            <input
              type="date"
              id="EndDate"
              name="EndDate"
              value={EndDate}
              disabled={true}
              onChange={(e) => handleChangeFilterDate(e)}
            />
          </div>
          </div>
       
 

          <Button label={"Excel"} class={"btnPrint"} onClick={ExcelGenerate} />
          <Button label={"PDF"} class={"btnClose"} onClick={PDFGenerate} />
        </div>
 

        <div class="subContainer ">
          <div className="App">
            <CustomTable
              columns={columnList}
              rows={dataList ? dataList : {}}
              // actioncontrol={actioncontrol}
            />
          </div>
        </div>
      </div>
      {/* <!-- BODY CONTAINER END --> */}
    </>
  );
};

export default LocalConveyance;
