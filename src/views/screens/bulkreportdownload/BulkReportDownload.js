import React, { forwardRef, useRef, useEffect } from "react";

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
import { id } from "date-fns/locale";

const BulkReportDownload = (props) => {
  const serverpage = "bulkreportdownload"; // this is .php server page

  const { useState } = React;
  const [bFirst, setBFirst] = useState(true);

  const { isLoading, data: dataList, error, ExecuteQuery } = ExecuteQueryHook(); //Fetch data
  const UserInfo = LoginUserInfo();

  const [StartDate, setStartDate] = useState(moment().format("YYYY-MM-DD"));
  const [EndDate, setEndDate] = useState(moment().format("YYYY-MM-DD"));

  // Dropdown states
  const [buyerList, setBuyerList] = useState([]);
  const [factoryList, setFactoryList] = useState([]);
  const [selectedBuyer, setSelectedBuyer] = useState(null);
  const [selectedFactory, setSelectedFactory] = useState(null);

  /* =====Start of Excel Export Code==== */
    const EXCEL_EXPORT_URL = process.env.REACT_APP_API_URL;

    const PrintPDFExcelExportFunction = () => {
      let finalUrl = EXCEL_EXPORT_URL + "report/BulkReportGenerateAndDownload.php";
     
      window.open(
        finalUrl +
          "?StartDate=" + StartDate +
          "&EndDate=" + EndDate +
          "&BuyerId=" + selectedBuyer.id +
          "&FactoryId=" + selectedFactory.id +
          "&TimeStamp=" + Date.now()
      );
    };

// StartDate: StartDate,
// EndDate: EndDate,
// BuyerId: selectedBuyer,
// FactoryId: selectedFactory,

    /* =====End of Excel Export Code==== */



  const handleChangeFilterDate = (e) => {
    const { name, value } = e.target;
    if (name === "StartDate") {
      setStartDate(value);
    }

    if (name === "EndDate") {
      setEndDate(value);
    }
  };

  // When StartDate or EndDate change, refresh dropdown lists
  useEffect(() => {
    getBuyerList();
    getFactoryList();
  }, [StartDate, EndDate]);

  // When date range or dropdown selections change, refresh table data
  useEffect(() => {
    getDataList();
  }, [StartDate, EndDate, selectedBuyer, selectedFactory]);

  /* =====End of Excel Export Code==== */

  function getBuyerList() {
    let params = {
      action: "getBuyerList",
      lan: language(),
      UserId: UserInfo.UserId,
      StartDate: StartDate,
      EndDate: EndDate,
    };

    apiCall.post(serverpage, { params }, apiOption()).then((res) => {
      const list = [{ id: 0, name: "All Buyers" }].concat(res.data.datalist);
      setBuyerList(list);
      // Only set default if none selected or current not in list
      if (!selectedBuyer || !list.find((x) => x.id === selectedBuyer.id)) {
        setSelectedBuyer(list[0]);
      }
    });
  }

  function getFactoryList() {
    let params = {
      action: "getFactoryList",
      lan: language(),
      UserId: UserInfo.UserId,
      StartDate: StartDate,
      EndDate: EndDate,
    };

    apiCall.post(serverpage, { params }, apiOption()).then((res) => {
      const list = [{ id: 0, name: "All Factories" }].concat(res.data.datalist);
      setFactoryList(list);
      if (!selectedFactory || !list.find((x) => x.id === selectedFactory.id)) {
        setSelectedFactory(list[0]);
      }
    });
  }

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
      width: "10%",
    },
    {
      field: "TransactionDate",
      label: "Inspection Date",
      align: "left",
      visible: true,
      sort: true,
      filter: true,
      width: "8%",
    },
    {
      field: "TemplateName",
      label: "Template",
      align: "left",
      visible: true,
      sort: true,
      filter: true,
      // width: "12%",
    },
    {
      field: "InspectorUserName",
      label: "Inspector Name",
      align: "left",
      visible: true,
      sort: true,
      filter: true,
      width: "12%",
    }
  ];

  if (bFirst) {
    /**First time call for datalist */
    getDataList();
    getBuyerList();
    getFactoryList();
    setBFirst(false);
  }

  /**Get data for table list */
  function getDataList() {
    if (StartDate && EndDate && selectedBuyer && selectedFactory) {
      let params = {
        action: "getDataList",
        lan: language(),
        UserId: UserInfo.UserId,
        StartDate: StartDate,
        EndDate: EndDate,
        BuyerId: selectedBuyer,
        FactoryId: selectedFactory,
      };
      // console.log('LoginUserInfo params: ', params);

      ExecuteQuery(serverpage, params);
    }
  }

  return (
    <>
      <div class="bodyContainer">
        {/* <!-- ######-----TOP HEADER-----####### --> */}
        <div class="topHeader">
          <h4>Home ❯ Reports ❯ Bulk Report Download</h4>
        </div>

        {/* <!-- TABLE SEARCH AND GROUP ADD --> */}
        <div class="searchAdd">
          <div>
            <label>Report Start Date</label>
            <div class="" >
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

          <div>
            <label>Buyer</label>
            <div class="">
              <Autocomplete
                options={buyerList}
                getOptionLabel={(option) => option.name}
                value={selectedBuyer}
                defaultValue={{ id: 0, name: "All Buyers" }}
                onChange={(e, newValue) => setSelectedBuyer(newValue)}
                renderInput={(params) => (
                  <TextField {...params}  size="small" />
                )}
                style={{ width: 220 }}
              />
            </div>
          </div>

          <div>
            <label>Factory</label>
            <div class="">
              <Autocomplete
                options={factoryList}
                getOptionLabel={(option) =>
                  option.name || option.FactoryName || option
                }
                value={selectedFactory}
                onChange={(e, newValue) => setSelectedFactory(newValue)}
                renderInput={(params) => (
                  <TextField {...params} size="small" />
                )}
                style={{ width: 220 }}
              />
            </div>
          </div>

          <Button
            label={"Bulk Download"}
            class={"btnPrint"}
            onClick={PrintPDFExcelExportFunction}
          />
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

export default BulkReportDownload;
