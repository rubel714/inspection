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

  // Processing/loader states
  const { useState: useStateAlias } = React; // keep consistency if needed
  const [isProcessing, setIsProcessing] = useState(false);
  const [elapsedSeconds, setElapsedSeconds] = useState(0);
  const [completedCount, setCompletedCount] = useState(0);
  const [totalCount, setTotalCount] = useState(0);
  const timerRef = useRef(null);
  const [showProgressModal, setShowProgressModal] = useState(false);

  const formatTime = (totalSeconds) => {
    const m = Math.floor(totalSeconds / 60);
    const s = totalSeconds % 60;
    return `${m.toString().padStart(2, "0")}:${s.toString().padStart(2, "0")}`;
  };

  // Cleanup timer on unmount
  useEffect(() => {
    return () => {
      if (timerRef.current) {
        clearInterval(timerRef.current);
        timerRef.current = null;
      }
    };
  }, []);

  /* =====Start of Excel Export Code==== */
  const EXCEL_EXPORT_URL = process.env.REACT_APP_API_URL;

  // const PrintPDFExcelExportFunction = () => {
  //   let finalUrl = EXCEL_EXPORT_URL + "report/BulkReportGenerateAndDownload.php";

  //   window.open(
  //     finalUrl +
  //       "?StartDate=" + StartDate +
  //       "&EndDate=" + EndDate +
  //       "&BuyerId=" + selectedBuyer.id +
  //       "&FactoryId=" + selectedFactory.id +
  //       "&TimeStamp=" + Date.now()
  //   );
  // };

  const PrintPDFExcelExportFunction = () => {
    if (!dataList || dataList.length === 0) {
      alert("No reports to download");
      return;
    }

    let BulkFolderName =
      "Inspection_reports_" +
      StartDate +
      "_to_" +
      EndDate +
      "_generated_" +
      new Date().toISOString().replace(/[:.-]/g, "_");

    // Init processing state and timer
    setIsProcessing(true);
    setShowProgressModal(true);
    setElapsedSeconds(0);
    setCompletedCount(0);
    setTotalCount(dataList.length);
    const startTs = Date.now();
    if (timerRef.current) clearInterval(timerRef.current);
    timerRef.current = setInterval(() => {
      setElapsedSeconds(Math.floor((Date.now() - startTs) / 1000));
    }, 1000);

    const requests = dataList.map((record) =>
      fetch(
        EXCEL_EXPORT_URL +
          "report/ReportGenerate_pdf.php?TransactionId=" +
          record.TransactionId +
          "&BulkFolderName=" +
          BulkFolderName +
          "&TimeStamp=" +
          Date.now().toString(),
        { method: "POST" }
      )
        .then((res) => {
          setCompletedCount((c) => c + 1);
          return res.ok;
        })
        .catch(() => {
          setCompletedCount((c) => c + 1);
          return false;
        })
    );

    Promise.allSettled(requests).then(() => {
      if (timerRef.current) {
        clearInterval(timerRef.current);
        timerRef.current = null;
      }
      setIsProcessing(false);
      setShowProgressModal(false);
      let finalUrl =
        EXCEL_EXPORT_URL + "report/BulkReportGenerateAndDownload.php";

      window.open(
        finalUrl +
          "?BulkFolderName=" +
          BulkFolderName +
          "&TimeStamp=" +
          Date.now()
      );

      // alert(
      //   "Report generation in progress. Please check the Downloads section after a few minutes to download the ZIP file."
      // );
    });
  };

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
    },
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

          <div>
            <label>Buyer</label>
            <div class="">
              <Autocomplete
                options={buyerList}
                getOptionLabel={(option) => option.name}
                value={selectedBuyer}
                defaultValue={{ id: 0, name: "All Buyers" }}
                onChange={(e, newValue) => setSelectedBuyer(newValue)}
                renderInput={(params) => <TextField {...params} size="small" />}
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
                renderInput={(params) => <TextField {...params} size="small" />}
                style={{ width: 220 }}
              />
            </div>
          </div>

          <Button
            label={"Bulk Download"}
            class={"btnPrint"}
            onClick={PrintPDFExcelExportFunction}
            disabled={isProcessing}
          />
          {isProcessing && (
            <div class="processingStatus" style={{ marginTop: 8 }}>
              Generating {completedCount}/{totalCount} reports • Elapsed {formatTime(elapsedSeconds)}
            </div>
          )}
        </div>

        {showProgressModal && (
          <div
            class="modalOverlay"
            style={{
              position: "fixed",
              inset: 0,
              backgroundColor: "rgba(0,0,0,0.35)",
              display: "flex",
              alignItems: "center",
              justifyContent: "center",
              zIndex: 1000,
            }}
          >
            <div
              class="modalContent"
              style={{
                background: "#fff",
                padding: 20,
                borderRadius: 8,
                minWidth: 360,
                boxShadow: "0 10px 30px rgba(0,0,0,0.2)",
              }}
            >
              <h4 style={{ marginTop: 0, marginBottom: 10 }}>Generating Reports</h4>
              <div style={{ marginBottom: 6 }}>
                Progress: {completedCount}/{totalCount}
              </div>
              <div style={{ marginBottom: 12 }}>
                Elapsed: {formatTime(elapsedSeconds)}
              </div>
              <div style={{ fontSize: 13, color: "#666" }}>
                Please keep this tab open. The ZIP download will start
                automatically when ready.
              </div>
            </div>
          </div>
        )}

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
