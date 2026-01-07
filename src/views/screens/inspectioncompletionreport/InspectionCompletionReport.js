import React, { forwardRef, useRef, useEffect } from "react";
import swal from "sweetalert";
import {
  DeleteOutline,
  Edit,
  AddAPhoto,
  PictureAsPdf,
  Add,
  SwapVert,
  PhotoAlbum,
} from "@material-ui/icons";
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

const InspectionCompletionReport = (props) => {
  const serverpage = "inspectioncompletionreport"; // this is .php server page

  const { useState } = React;
  const [bFirst, setBFirst] = useState(true);
  const [currentRow, setCurrentRow] = useState([]);
  const [currentRowDelete, setCurrentRowDelete] = useState([]);
  const [showSortModal, setShowSortModal] = useState(false); //true=show sort modal, false=hide sort modal
  const [showBulkImagesModal, setShowBulkImagesModal] = useState(false); //true=show sort modal, false=hide Bulk Images Modal
  const [showModal, setShowModal] = useState(false); //true=show modal, false=hide modal
  const [showImportModal, setShowImportModal] = useState(false); //true=show import modal, false=hide import modal

  const [showCheckListModal, setShowCheckListModal] = useState(false); //true=show modal, false=hide modal
  const [currentCheckIdx, setCurrentCheckIdx] = useState("");

  const [ShowHidePanelFlag, setShowHidePanelFlag] = useState(1); //1=show master table, 2=show template panel, 3=show category panel, 4=show checklist and image block panel
  // const [CheckList, setCheckList] = useState(null);
  const [TemplateList, setTemplateList] = useState(null);
  const [currTemplateId, setCurrTemplateId] = useState(0);
  const [currCategoryId, setCurrCategoryId] = useState(0);
  const [currCategoryName, setCurrCategoryName] = useState("");

  // handleChangeWidthHeight
  const { isLoading, data: dataList, error, ExecuteQuery } = ExecuteQueryHook(); //Fetch data
  const {
    isLoading: isLoadingCategory,
    data: categoryDataList,
    error: errorCategory,
    ExecuteQuery: ExecuteQueryCategory,
  } = ExecuteQueryHook(); //Fetch data
  const UserInfo = LoginUserInfo();
  const [selectedDate, setSelectedDate] = useState(
    //new Date()
    moment().format("YYYY-MM-DD")
  );

  const [StartDate, setStartDate] = useState(moment().format("YYYY-MM-DD"));
  const [EndDate, setEndDate] = useState(moment().format("YYYY-MM-DD"));

  /* =====Start of Excel Export Code==== */
  const EXCEL_EXPORT_URL = process.env.REACT_APP_API_URL;
  const baseUrl = process.env.REACT_APP_STORAGE_URL;

  const PrintPDFExcelExportFunction = (reportType) => {
    let finalUrl = EXCEL_EXPORT_URL + "report/print_pdf_excel_server.php";

    window.open(
      finalUrl +
        "?action=InspectionCompletionReportExport" +
        "&reportType=excel" +
        "&StartDate=" + StartDate +
        "&EndDate=" + EndDate +
        "&TimeStamp=" +
        Date.now()
    );
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

  useEffect(() => {
    getDataList();
  }, [StartDate, EndDate]);

  const columnList = [
    { field: "rownumber", label: "SL", align: "center", width: "3%" },
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
      label: "Report Date",
      align: "left",
      visible: true,
      sort: true,
      filter: true,
      width: "6%",
    },

    {
      field: "BuyerName",
      label: "Buyer",
      align: "left",
      visible: true,
      sort: true,
      filter: true,
      // width: "12%",
    },
    {
      field: "SupplierName",
      label: "Supplier",
      align: "left",
      visible: true,
      sort: true,
      filter: true,
      // width: "12%",
    },
    {
      field: "FactoryName",
      label: "Factory",
      align: "left",
      visible: true,
      sort: true,
      filter: true,
      // width: "12%",
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
      width: "8%",
    },

    {
      field: "CoverFileUrlStatus",
      label: "Report File",
      align: "center",
      visible: true,
      sort: true,
      filter: true,
      width: "6%",
    },

    {
      field: "FooterFileUrlStatus",
      label: "Accessories File",
      align: "center",
      visible: true,
      sort: true,
      filter: true,
      width: "8%",
    },
    {
      field: "StatusName",
      label: "Status",
      align: "center",
      visible: true,
      sort: true,
      filter: true,
      width: "6%",
    },
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
      TransactionId: 0 /**0=ALL */,
      StartDate: StartDate,
      EndDate: EndDate,
    };

    ExecuteQuery(serverpage, params);
  }

  return (
    <>
      {ShowHidePanelFlag == 1 && (
        <div class="bodyContainer">
          <div class="topHeader">
            <h4>Home ❯ Reports ❯ Inspection Completion Report</h4>
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

            <Button
              label={"Export"}
              class={"btnPrint"}
              onClick={PrintPDFExcelExportFunction}
            />
          </div>

          <CustomTable columns={columnList} rows={dataList ? dataList : {}} />
        </div>
      )}
    </>
  );
};

export default InspectionCompletionReport;
