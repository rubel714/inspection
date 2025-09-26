import React, { forwardRef, useRef } from "react";
import swal from "sweetalert";
import {
  DeleteOutline,
  Edit,
  AddAPhoto,
  PictureAsPdf,
  Add
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
import InspectionReportImportModal from "./InspectionReportImportModal";
import InspectionReportEntryAddEditModal from "./InspectionReportEntryAddEditModal";
import CheckListModal from "./CheckListModal";

const InspectionReportEntry = (props) => {
  const serverpage = "inspectionreportentry"; // this is .php server page

  const { useState } = React;
  const [bFirst, setBFirst] = useState(true);
  const [currentRow, setCurrentRow] = useState([]);
  const [currentRowDelete, setCurrentRowDelete] = useState([]);
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
  const { isLoading:isLoadingCategory, data: categoryDataList, error:errorCategory, ExecuteQuery:ExecuteQueryCategory } = ExecuteQueryHook(); //Fetch data
  const UserInfo = LoginUserInfo();
  const [selectedDate, setSelectedDate] = useState(
    //new Date()
    moment().format("YYYY-MM-DD")
  );

  /* =====Start of Excel Export Code==== */
  const EXCEL_EXPORT_URL = process.env.REACT_APP_API_URL;
  const baseUrl = process.env.REACT_APP_FRONT_URL;
  const PDFGenerate = (TransactionId) => {
    // if (!chkValidation()) {
    //   return;
    // }
    // console.log("currentRow:",currentRow);
    let finalUrl = EXCEL_EXPORT_URL + "report/ReportGenerate_pdf.php";
    window.open(
      finalUrl + "?TransactionId=" + TransactionId + "&TimeStamp=" + Date.now()
    );
  };

  // backend\report\ReportGenerate_pdf.php
  function PDFGenerate1(TransactionId) {
    let params = {
      action: "export",
      lan: language(),
      UserId: UserInfo.UserId,
      TransactionId: TransactionId,
    };

    // apiCall.post("productgroup", { params }, apiOption()).then((res) => {
    apiCallReport
      .post("ReportGenerate_pdf.php", { params }, apiOption())
      .then((res) => {
        console.log("res: ", res);

        // window.open(finalUrl + "?TransactionId=" + TransactionId + "&TimeStamp=" + Date.now());
        // props.openNoticeModal({
        //   isOpen: true,
        //   msg: res.data.message,
        //   msgtype: res.data.success,
        // });
        // getDataList();
      });
  }

  // 	$.ajax({
  // 	type: "POST",
  // 	url: baseUrl + "monthlylogisticsreportwizardserver.php",
  // 	data: {
  // 		operation: 'combineLogisticsReport',
  // 		baseUrl: baseUrl,
  // 		lan: lan,
  // 		MonthId :MonthId,
  // 		MonthName : monthList[parseInt(MonthId)-1],
  // 		YearId : YearId,
  // 		CountryId : CountryId
  // 	},
  // 	success: function(response) {
  // 		//console.log(response);
  // 		$("#tab9loader").hide();
  // 		window.open( baseUrl + 'report/pdfslice/Health_Commodity_Dashboard_Monthly_Logistics_Report_'+CountryId+'_'+monthList[parseInt(MonthId)-1]+'_'+YearId+'.pdf');
  // 	}

  // });

  // const PrintPDFExcelExportFunction = (reportType) => {
  //   let finalUrl = EXCEL_EXPORT_URL + "report/print_pdf_excel_server.php";

  //   window.open(
  //     finalUrl +
  //       "?action=UserExport" +
  //       "&reportType=excel" +
  //       "&ClientId=" +
  //       UserInfo.ClientId +
  //       "&BranchId=" +
  //       UserInfo.BranchId +
  //       "&TimeStamp=" +
  //       Date.now()
  //   );
  // };
  /* =====End of Excel Export Code==== */

  const columnList = [
    { field: "rownumber", label: "SL", align: "center", width: "3%" },
    // { field: 'SL', label: 'SL',width:'10%',align:'center',visible:true,sort:false,filter:false },
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
      width: "7%",
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
    // {
    //   field: "UserName",
    //   label: "Reported By",
    //   align: "left",
    //   visible: true,
    //   sort: true,
    //   filter: true,
    //   width: "10%",
    // },

    {
      field: "CoverFileUrlStatus",
      label: "Cover File Uploaded",
      align: "center",
      visible: true,
      sort: true,
      filter: true,
      width: "10%",
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
    {
      field: "custom",
      label: "Action",
      width: "12%",
      align: "center",
      visible: true,
      sort: false,
      filter: false,
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
      TransactionId: 0 /**0=ALL */
    };
    // console.log('LoginUserInfo params: ', params);

    ExecuteQuery(serverpage, params);
  }

  /** Action from table row buttons*/
  function actioncontrol(rowData) {
    return (
      <>
        <PictureAsPdf
          titleAccess="Export"
          className={"table-generate-icon"}
          onClick={() => {
            PDFGenerate(rowData.id);
          }}
        ></PictureAsPdf>

       {rowData.StatusId==1 && (<AddAPhoto
          className={"table-addimg-icon"}
          onClick={() => {
            editDataForCheck(rowData);
          }}
        />)}

        {rowData.StatusId==1 && (<Edit
          className={"table-edit-icon"}
          onClick={() => {
            editData(rowData);
          }}
        />)}

        {rowData.StatusId==1 && (<DeleteOutline
          className={"table-delete-icon"}
          onClick={() => {
            deleteData(rowData);
          }}
        />)}
      </>
    );
  }

  const importData = () => {
setShowImportModal(true);
  }

  const addData = () => {
    setCurrentRow({
      id: "",
      TransactionTypeId: 1,
      TransactionDate: selectedDate,
      InvoiceNo: "",
      CoverFileUrl: "",
      CoverFileUrlUpload: "",
      CoverFilePages: "",
      StatusId: 1,
      ManyImgPrefix: Date.now(),
      BuyerName: "",
      SupplierName: "",
      FactoryName: "",
      FormData: null,
      TemplateId:"",
      Items: [],
    });
    openModal();
  };

  /**Master Edit */
  const editData = (rowData) => {
    console.log('rowData editData: ', rowData);
    setCurrentRow(rowData);
  
    openModal();
  };

  function handleCheckListModal(Idx) {
    setCurrentCheckIdx(Idx);
    setShowCheckListModal(true); //true=modal show, false=modal hide
  }

  function modalCallbackCheckList(response) {
    // console.log('response: ', response);
    // console.log('response.CheckName: ', response.CheckName);

    let data = { ...currentRow };
    data.Items[currentCheckIdx].CheckName = response.CheckName;

    setCurrentRow(data);
    setShowCheckListModal(false); //true=modal show, false=modal hide
  }

  function openModal() {
    setShowModal(true); //true=modal show, false=modal hide
  }

  function modalCallback(response) {
    getDataList();
    setShowModal(false); //true=modal show, false=modal hide
  }

  function importModalCallback(response) {
    getDataList();
    setShowImportModal(false); //true=import modal show, false=import modal hide
  }

  const editDataForCheck = (rowData) => {
    console.log('rowData: ', rowData);
    setCurrentRow(rowData);
    setCurrTemplateId(rowData.TemplateId);
    panelShowHide(2);//1=show master table, 2=show template panel, 3=show category panel, 4=show checklist and image block panel
  };

  function panelShowHide(Idx) {
    setShowHidePanelFlag(Idx); //1=show master table, 2=show template panel, 3=show category panel, 4=show checklist and image block panel

    if(Idx == 1){
      getDataList(); //refresh master table
    }

  }


  const deleteData = (rowData) => {
    swal({
      title: "Are you sure?",
      text: "Once deleted, you will not be able to recover this data!",
      icon: "warning",
      buttons: {
        confirm: {
          text: "Yes",
          value: true,
          visible: true,
          className: "",
          closeModal: true,
        },
        cancel: {
          text: "No",
          value: null,
          visible: true,
          className: "",
          closeModal: true,
        },
      },
      dangerMode: true,
    }).then((allowAction) => {
      if (allowAction) {
        deleteApi(rowData);
      }
    });
  };

  function deleteApi(rowData) {
    let params = {
      action: "deleteData",
      lan: language(),
      UserId: UserInfo.UserId,
      ClientId: UserInfo.ClientId,
      BranchId: UserInfo.BranchId,
      rowData: rowData,
    };

    // apiCall.post("productgroup", { params }, apiOption()).then((res) => {
    apiCall.post(serverpage, { params }, apiOption()).then((res) => {
      // console.log("res: ", res);
      props.openNoticeModal({
        isOpen: true,
        msg: res.data.message,
        msgtype: res.data.success,
      });
      getDataList();
    });
  }

  React.useEffect(() => {
    getTemplateList();
  }, []);

  
  function getTemplateList() {
    let params = {
      action: "TemplateList",
      lan: language(),
      UserId: UserInfo.UserId,
    };

    apiCall.post("combo_generic", { params }, apiOption()).then((res) => {
      setTemplateList(
        [{ id: 0, name: "Select Template" }].concat(res.data.datalist)
      );
 
    });
  }

  const handleChangeMasterDropDown = (name, value) => {
    let data = { ...currentRow };
    if (name === "TemplateId") {
      data["TemplateId"] = value;
      setCurrTemplateId(value);
      // console.log('value: ', value);
    }
    setCurrentRow(data);
  };


  
  function assignTemplateUnderInspection() {
    if(!currTemplateId){
      props.openNoticeModal({
        isOpen: true,
        msg: "Select Template",
        msgtype: 0
      });

      return;
    }

     addEditMasterAPICall(currentRow); 
  }
  
  function postInspection() {
 swal({
      title: "Are you sure?",
      text: "You want to finish this inspection, you will not be able to change this inspection!",
      icon: "warning",
      buttons: {
        confirm: {
          text: "Yes",
          value: true,
          visible: true,
          className: "",
          closeModal: true,
        },
        cancel: {
          text: "No",
          value: null,
          visible: true,
          className: "",
          closeModal: true,
        },
      },
      dangerMode: true,
    }).then((allowAction) => {
      if (allowAction) {
          let data = { ...currentRow };
          data["StatusId"] = 5;
          setCurrentRow(data);
          addEditMasterAPICall(data); 
      }
    });


  }

  function addEditMasterAPICall(rowData) {

      let params = {
        action: "updateMasterPartial",
        lan: language(),
        UserId: UserInfo.UserId,
        rowData: rowData,
      };

      apiCall.post(serverpage, { params }, apiOption()).then((res) => {
        props.openNoticeModal({
          isOpen: true,
          msg: res.data.message,
          msgtype: res.data.success,
        });

        if (res.data.success === 1) {
          if(rowData.StatusId == 5){
            panelShowHide(1); // go to master list and refresh
          }else{
            getCategoryDataList();
          }
        }
      });

  }










  const columnListCategory = [
    { field: "rownumber", label: "SL", align: "center", width: "3%" },
    {
      field: "CategoryName",
      label: "Category",
      align: "left",
      visible: true,
      sort: true,
      filter: true,
      // width: "10%",
    },
    {
      field: "CheckCount",
      label: "Number of Added Check List",
      align: "center",
      visible: true,
      sort: true,
      filter: true,
      // width: "10%",
    },
    {
      field: "custom",
      label: "Action",
      width: "8%",
      align: "center",
      visible: true,
      sort: false,
      filter: false,
    },
  ];


  /**Get data for table list */
  function getCategoryDataList() {
    let params = {
      action: "getCategoryList",
      lan: language(),
      UserId: UserInfo.UserId,
      TransactionId:currentRow.id,
    };
    // console.log('LoginUserInfo params: ', params);

    ExecuteQueryCategory(serverpage, params);
    panelShowHide(3); //1=show master table, 2=show template panel, 3=show category panel, 4=show checklist and image block panel
  }

  /** Action from table row buttons*/
  function actioncontrolcategory(rowData) {
    // console.log('rowData actioncontrolcategory: ', rowData);
    // console.log('currentRow actioncontrolcategory: ', currentRow.Items);
    return (
      <>

        {/* {currentRow.Items.length} */}

        {(rowData.CheckCount == 0) && (<Add
          className={"table-edit-icon"}
          onClick={() => {
           bulkInsertCheckDataAPICall(rowData);
          }}
        />)}

         {(rowData.CheckCount > 0) && (<Edit
          className={"table-edit-icon"}
          onClick={() => {
           bulkInsertCheckDataAPICall(rowData);
          }}
        />)}


      </>
    );
  }


  function bulkInsertCheckDataAPICall(rowData) {
   
      setCurrCategoryId(rowData.CategoryId);
      setCurrCategoryName(rowData.CategoryName);

      let params = {
        action: "bulkInsertCheckData",
        lan: language(),
        UserId: UserInfo.UserId,
        TransactionId: currentRow.id,
        CategoryId: rowData.CategoryId,
      };

      apiCall.post(serverpage, { params }, apiOption()).then((res) => {
        // console.log('res: ', res);
        
        if(res.data.success == 1){
          getDataListSingle(currentRow.id,rowData.CategoryId);
        }else{
          props.openNoticeModal({
            isOpen: true,
            msg: res.data.message,
            msgtype: res.data.success,
          });
        }
 
      });
    // }
  }



    /**Get data for single report */
  function getDataListSingle(pTransactionId,pCategoryId) {
    let params = {
      action: "getDataList",
      lan: language(),
      UserId: UserInfo.UserId,
      TransactionId: pTransactionId, /**0=ALL */
      CategoryId: pCategoryId
    };

    apiCall.post(serverpage, { params }, apiOption()).then((res) => {
      // console.log('res: ', res.data.datalist[0]);
      setCurrentRow(res.data.datalist[0]); 

      panelShowHide(4);
    });
  }





























  const handleFileChangeManyFile = (e, Idx) => {

    let data = { ...currentRow };
    // let dataManyFiles = { ...manyFiles };
    let file = e.target.files[0];
    // dataManyFiles[name] = file;
    // data["CoverFileUrl"]=file;
    // console.log('file: ', file);
    if (file) {
      // console.log('file: ', file.name);

      data.Items[Idx].PhotoUrlUpload = file;
      data.Items[Idx].PhotoUrlChanged =
        data.Items[Idx].TransactionItemId + "_" + file.name;

      let reader = new FileReader();
      // reader.onload = () => setPreview(reader.result);
      reader.readAsDataURL(file);
      reader.onload = (event) => {
        // setPreview(event.target.result);
        data.Items[Idx].PhotoUrlPreview = event.target.result;
        setCurrentRow(data);
      };
    } else {
      data.Items[Idx].PhotoUrlPreview = "";
      data.Items[Idx].PhotoUrlUpload = null;
      data.Items[Idx].PhotoUrlChanged = "";
      setCurrentRow(data);
    }

  };

  const handleChangeManyText = (e, Idx) => {
    const { name, value } = e.target;

    // console.log("Idx: ", Idx);
    // console.log("value: ", value);
    // console.log("name: ", name);
    let data = { ...currentRow };
    if (name === "CheckName") {
      data.Items[Idx].CheckName = value;
    }

    // setErrorObject({ ...errorObject, [name]: null });
    setCurrentRow(data);
    // console.log("data: ", data);
  };

    const handleChangeWidthHeight = (classnamewidth, classnameheight, Idx) => {
    let data = { ...currentRow };

    data.Items[Idx].RowNo = classnamewidth;
    data.Items[Idx].ColumnNo = classnameheight;
 
    setCurrentRow(data);
  };


  // const handleChangeWidthHeight = (type, classname, Idx) => {
  //   let data = { ...currentRow };
  //   console.log('data: ', data);
  //   if (type === "width") {
  //     data.Items[Idx].RowNo = classname;
  //   } else if (type === "height") {
  //     data.Items[Idx].ColumnNo = classname;
  //   }
  //   setCurrentRow(data);
  // };

  const handleChangeCheckType = (CheckType, Idx) => {
    let data = { ...currentRow };
    console.log('data: ', data);
    data.Items[Idx].CheckType = CheckType;
 
    setCurrentRow(data);
  };

  function addCheckBlock() {
    let data = { ...currentRow };
    let currTime = Date.now();
    let newCheck = {
      CheckId: "",
      CheckName: "",
      CheckType: "R",
      ColumnNo: "reportcheckblock-height-onethird",
      PhotoUrl: "placeholder.jpg",
      PhotoUrlChanged: "",
      PhotoUrlPreview: "",
      PhotoUrlUpload: "",
      RowNo: "reportcheckblock-width-half",
      SortOrder: currTime,// data.Items.length + 1,
      TransactionId: currTime,
      TransactionItemId: currTime,
      autoId: -1,
    };

    // console.log('newCheck: ', newCheck);
    data.Items.push(newCheck);
    setCurrentRow(data);
    // console.log("data: ", data.Items);
  }

  function deleteCheckBlock(Idx) {
    // console.log("Idx: ", Idx);
    let data = { ...currentRow };

    let dataDelete = { ...currentRowDelete };
    dataDelete[data.Items[Idx].TransactionItemId] = data.Items[Idx];
    setCurrentRowDelete(dataDelete);

    delete data.Items[Idx];
    setCurrentRow(data);
    // console.log("dataDelete: ", dataDelete);
  }

  function addEditAPICall() {
    let params = {
      action: "dataAddEditMany",
      lan: language(),
      UserId: UserInfo.UserId,
      CategoryId: currCategoryId,
      rowData: currentRow,
      currentRowDelete: currentRowDelete,
    };

    apiCall.post(serverpage, { params }, apiOption()).then((res) => {
      props.openNoticeModal({
        isOpen: true,
        msg: res.data.message,
        msgtype: res.data.success,
      });

      if (res.data.success === 1) {
        getCategoryDataList();
      }
    });
  }

  return (
    <>
      {(ShowHidePanelFlag == 1) && (
        <div class="bodyContainer">
          {/* <!-- ######-----TOP HEADER-----####### --> */}
          <div class="topHeader">
            <h4>Home ❯ Report Entry ❯ Inspection Report Entry</h4>
          </div>

          {/* <!-- TABLE SEARCH AND GROUP ADD --> */}
          <div class="searchAdd">
            {/* <input type="text" placeholder="Search Product Group"/> */}
            {/* <label></label> */}
            {/* <button
            onClick={() => {
              addData();
            }}
            className="btnAdd"
          >
            ADD
          </button> */}

            {/* <Button
            label={"Export"}
            class={"btnPrint"}
            onClick={PrintPDFExcelExportFunction}
          /> */}
            {/* <Button label={"IMPORT"} class={"btnClose"} onClick={importData} /> */}
            <Button label={"ADD"} class={"btnAdd"} onClick={addData} />
          </div>

          {/* <!-- ####---THIS CLASS IS USE FOR TABLE GRID PRODUCT INFORMATION---####s --> */}
          {/* <div class="subContainer tableHeight">
            <div className="App"> */}
          <CustomTable
            columns={columnList}
            rows={dataList ? dataList : {}}
            actioncontrol={actioncontrol}
          />
          {/* </div>
          </div> */}
        </div>
      )}
      {/* <!-- BODY CONTAINER END --> */}
      {/* {ShowHidePanelFlag && ( */}

 {(ShowHidePanelFlag == 2) && (
      <div class="bodyContainer">
        {/* <!-- GROUP MODAL START --> */}
        <div id="groupModal" class="modalz">
          {/* <!-- Modal content --> */}
          <div class="modal-content-reportblock">
            <div class="modalHeader">
              <h4>Add/Edit Inspection Template - {currentRow.InvoiceNo}</h4>
            </div>

            <div class="contactmodalBody pt-10">
              <label>Template *</label>
              <Autocomplete
                autoHighlight
                disableClearable
                className="chosen_dropdown"
                id="TemplateId"
                name="TemplateId"
                autoComplete
                //class={errorObject.TemplateId}
                disabled={currentRow.Items.length>0}
                options={TemplateList ? TemplateList : []}
                getOptionLabel={(option) => option.name}
                defaultValue={{ id: 0, name: "Select Template" }}
                value={
                  TemplateList
                    ? TemplateList[
                        TemplateList.findIndex(
                          (list) => list.id === currTemplateId
                        )
                      ]
                    : null
                }
                onChange={(event, valueobj) =>
                  handleChangeMasterDropDown(
                    "TemplateId",
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
            </div>

            <div class="modalItem">

              <Button
                label={"Back to List"}
                class={"btnClose"}
                onClick={()=>panelShowHide(1)}
              />

              {(currentRow.Items.length == 0) && (<Button
                label={"Save"}
                class={"btnUpdate"}
                onClick={assignTemplateUnderInspection}
              />)}

               {(currentRow.Items.length > 0) && (<Button
                label={"Next"}
                class={"btnUpdate"}
                onClick={getCategoryDataList}
              />)}
            </div>
          </div>
        </div>
      </div>)}


       {(ShowHidePanelFlag == 3) && (
      <div class="bodyContainer">
        {/* <!-- GROUP MODAL START --> */}
        <div id="groupModal" class="modalz">
          {/* <!-- Modal content --> */}
          <div class="modal-content-reportblock">
            <div class="modalHeader">
              <h4>Add/Edit Inspection Category List - {currentRow.InvoiceNo}</h4>
            </div>

            <div class="contactmodalBodyx pt-10">

                <CustomTable
                  columns={columnListCategory}
                  rows={categoryDataList ? categoryDataList : {}}
                  actioncontrol={actioncontrolcategory}
                  ispagination={false}
                />

            </div>

            <div class="modalItem">
              <Button
                label={"Back to List"}
                class={"btnClose"}
                onClick={()=>panelShowHide(2)}
              />

              <Button
                  label={"Finish Inspection"}
                  class={"btnUpdate"}
                  onClick={postInspection}
                />

            </div>
          </div>
        </div>
      </div>
      )}


      {(ShowHidePanelFlag == 4) && (
        <div class="bodyContainer">
          {/* <!-- GROUP MODAL START --> */}
          <div id="groupModal" class="modalz">
            {/* <!-- Modal content --> */}
            <div class="modal-content-reportblock">
              <div class="modalHeader">
                  <h4>Add/Edit Inspection Check List - {currentRow.InvoiceNo} - {currCategoryName}</h4>
              </div>

              {currentRow.Items &&
                currentRow.Items.map((Item, Idx) => {
                  return (
                    <>
                      <div className={"reportcheckblock " + Item.RowNo}>
                        {/* <label>{Item.PhotoUrl}</label> */}
                        {/* <label>{Item.PhotoUrlPreview}</label> */}
                        <input
                          type="file"
                          id="PhotoUrl"
                          name="PhotoUrl"
                          accept="image/*"
                          // style={{opacity: 0 }}
                          // onchange="this.value=null"
                          //onChange={handleFileChange}
                          // onChange={(e) => handleFileChangeManyFile(e, "PhotoUrl")}
                          onChange={(e) => handleFileChangeManyFile(e, Idx)}
                        />

                        {Item.autoId != -1 &&
                          Item.PhotoUrlPreview == "" &&
                          Item.PhotoUrl && (
                            <div
                              className={
                                "reportcheckblock-image " + Item.ColumnNo
                              }
                            >
                              <img
                                src={
                                  Item.PhotoUrl == "placeholder.jpg"
                                    ? `${baseUrl}image/transaction/${Item.PhotoUrl}`
                                    : `${baseUrl}image/transaction/${currentRow.ManyImgPrefix}/${Item.PhotoUrl}`
                                }
                                // src={
                                //     Item.PhotoUrl
                                //       ? `${baseUrl}image/transaction/${Item.PhotoUrl}`
                                //       : previewImage
                                //   }
                                alt="Photo"
                                className="preview-image"
                              />
                            </div>
                          )}

                        {(Item.autoId == -1 || Item.PhotoUrlPreview != "") && (
                          <div
                            className={
                              "reportcheckblock-image " + Item.ColumnNo
                            }
                          >
                            <img
                              src={
                                Item.PhotoUrlPreview
                                  ? Item.PhotoUrlPreview
                                  : Item.PhotoUrl == "placeholder.jpg"
                                  ? `${baseUrl}image/transaction/${Item.PhotoUrl}`
                                  : `${baseUrl}image/transaction/${currentRow.ManyImgPrefix}/${Item.PhotoUrl}`
                              }
                              alt="Photo"
                              className="preview-image"
                            />
                          </div>
                        )}


                        
                        <div className=" checkblockselector">
                          <div className="checkblocksize">
                            <Button
                              label={"R"}
                              class={
                                "btnreportcheckblockheight " +
                                (Item.CheckType ==
                                "R"
                                  ? "bgselect"
                                  : "")
                              }
                              onClick={(i) =>
                                handleChangeCheckType(
                                  "R",
                                  Idx
                                )
                              }
                            />
                            <Button
                              label={"C"}
                              class={
                                "btnreportcheckblockheight " +
                                (Item.CheckType == "C"
                                  ? "bgselect"
                                  : "")
                              }
                              onClick={(i) =>
                                handleChangeCheckType(
                                  "C",
                                  Idx
                                )
                              }
                            />
                            <Button
                              label={"M"}
                              class={
                                "btnreportcheckblockheight " +
                                (Item.CheckType == "M"
                                  ? "bgselect"
                                  : "")
                              }
                              onClick={(i) =>
                                handleChangeCheckType(
                                  "M",
                                  Idx
                                )
                              }
                            />

                             <Button
                              label={"m"}
                              class={
                                "btnreportcheckblockheight " +
                                (Item.CheckType == "m"
                                  ? "bgselect"
                                  : "")
                              }
                              onClick={(i) =>
                                handleChangeCheckType(
                                  "m",
                                  Idx
                                )
                              }
                            />
                            
                          </div>
                      
                        </div>



                        <div class="inspectionChecklistBody pt-10">
                          {/* <label>Report Number *</label> */}
                          <input
                            type="text"
                            id="CheckName"
                            name="CheckName"
                            style={{ height: "30px" }}
                            // class={errorObject.InvoiceNo}
                            placeholder="Enter Check Name"
                            value={Item.CheckName}
                            onChange={(e) => handleChangeManyText(e, Idx)}
                          />

                          <Button
                            label={"..."}
                            class={"btnChkList"}
                            onClick={(i) => handleCheckListModal(Idx)}
                          />
                        </div>

                        {/* <label>CNC label</label> */}
                        {/* <Autocomplete
                          autoHighlight
                          disableClearable
                          className="chosen_dropdown"
                          id="CheckId"
                          name="CheckId"
                          autoComplete
                          //class={errorObject.CheckId}
                          options={CheckList ? CheckList : []}
                          getOptionLabel={(option) => option.name}
                          defaultValue={{ id: 0, name: "Select Check Name" }}
                          value={
                            CheckList
                              ? CheckList[
                                  CheckList.findIndex(
                                    (list) => list.id === Item.CheckId
                                  )
                                ]
                              : null
                          }
                          onChange={(event, valueobj) =>
                            handleChangeManyDropDown(
                              "CheckId",
                              valueobj ? valueobj.id : "",
                              Idx
                            )
                          }
                          renderOption={(option) => (
                            <Typography className="chosen_dropdown_font">
                              {option.name}
                            </Typography>
                          )}
                          renderInput={(params) => (
                            <TextField
                              {...params}
                              variant="standard"
                              fullWidth
                            />
                          )}
                        /> */}

                        <div className=" checkblockselector">






                         <div className="checkblocksize">
                            <label>Size</label>
                            <Button
                              label={"1P"}
                              class={
                                "btnreportcheckblockheight " +
                                ((Item.RowNo == "reportcheckblock-width-full" && Item.ColumnNo == "reportcheckblock-height-full")
                                  ? "bgselect"
                                  : "")
                              }
                              onClick={(i) =>
                                handleChangeWidthHeight(
                                  "reportcheckblock-width-full",
                                  "reportcheckblock-height-full",
                                  Idx
                                )
                              }
                            />
                            <Button
                              label={"2P"}
                              class={
                                "btnreportcheckblockheight " +
                                ((Item.RowNo == "reportcheckblock-width-full" && Item.ColumnNo == "reportcheckblock-height-half")
                                  ? "bgselect"
                                  : "")
                              }
                              onClick={(i) =>
                                handleChangeWidthHeight(
                                  "reportcheckblock-width-full",
                                  "reportcheckblock-height-half",
                                  Idx
                                )
                              }
                            />
                            <Button
                              label={"4P"}
                              class={
                                "btnreportcheckblockheight " +
                                ((Item.RowNo == "reportcheckblock-width-half" && Item.ColumnNo == "reportcheckblock-height-half")
                                  ? "bgselect"
                                  : "")
                              }
                              onClick={(i) =>
                                handleChangeWidthHeight(
                                  "reportcheckblock-width-half",
                                  "reportcheckblock-height-half",
                                  Idx
                                )
                              }
                            />
                            <Button
                              label={"6P"}
                              class={
                                "btnreportcheckblockheight " +
                                ((Item.RowNo == "reportcheckblock-width-half" && Item.ColumnNo == "reportcheckblock-height-onethird")
                                  ? "bgselect"
                                  : "")
                              }
                              onClick={(i) =>
                                handleChangeWidthHeight(
                                  "reportcheckblock-width-half",
                                  "reportcheckblock-height-onethird",
                                  Idx
                                )
                              }
                            />
                          </div>

 {/*
                          <div className="checkblocksize">
                            <label>Width</label>
                            <Button
                              label={"1/2"}
                              class={
                                "btnreportcheckblockheight " +
                                (Item.RowNo == "reportcheckblock-width-half"
                                  ? "bgselect"
                                  : "")
                              }
                              onClick={(i) =>
                                handleChangeWidthHeight(
                                  "width",
                                  "reportcheckblock-width-half",
                                  Idx
                                )
                              }
                            />
                            <Button
                              label={"1/1"}
                              class={
                                "btnreportcheckblockheight " +
                                (Item.RowNo == "reportcheckblock-width-full"
                                  ? "bgselect"
                                  : "")
                              }
                              onClick={(i) =>
                                handleChangeWidthHeight(
                                  "width",
                                  "reportcheckblock-width-full",
                                  Idx
                                )
                              }
                            />
                          </div>

                          <div className="checkblocksize">
                            <label>Height</label>
                            <Button
                              label={"1/3"}
                              class={
                                "btnreportcheckblockheight " +
                                (Item.ColumnNo ==
                                "reportcheckblock-height-onethird"
                                  ? "bgselect"
                                  : "")
                              }
                              onClick={(i) =>
                                handleChangeWidthHeight(
                                  "height",
                                  "reportcheckblock-height-onethird",
                                  Idx
                                )
                              }
                            />
                            <Button
                              label={"1/2"}
                              class={
                                "btnreportcheckblockheight " +
                                (Item.ColumnNo == "reportcheckblock-height-half"
                                  ? "bgselect"
                                  : "")
                              }
                              onClick={(i) =>
                                handleChangeWidthHeight(
                                  "height",
                                  "reportcheckblock-height-half",
                                  Idx
                                )
                              }
                            />
                            <Button
                              label={"1/1"}
                              class={
                                "btnreportcheckblockheight " +
                                (Item.ColumnNo == "reportcheckblock-height-full"
                                  ? "bgselect"
                                  : "")
                              }
                              onClick={(i) =>
                                handleChangeWidthHeight(
                                  "height",
                                  "reportcheckblock-height-full",
                                  Idx
                                )
                              }
                            />
                          </div>
*/}





                          <Button
                            label={"X"}
                            title={"Delete"}
                            class={"btnreportcheckblockdelete"}
                            onClick={(i) => deleteCheckBlock(Idx)}
                          />
                        </div>




                      </div>
                    </>
                  );
                })}

              <div className="reportcheckblock">
                <Button
                  label={"+"}
                  class={"btnAddBlock"}
                  onClick={addCheckBlock}
                />
              </div>

              <div class="modalItem">
                {/* <Button
                  label={"Report Generate"}
                  class={"btnClose"}
                  onClick={PDFGenerate}
                /> */}
                <Button
                  label={"Back to List"}
                  class={"btnClose"}
                  onClick={getCategoryDataList}
                />
                <Button
                  label={"Save"}
                  class={"btnUpdate"}
                  onClick={addEditAPICall}
                />
              </div>
            </div>
          </div>
          {/* <!-- GROUP MODAL END --> */}
        </div>
      )}

      {showImportModal && (
        <InspectionReportImportModal
          masterProps={props}
          currentRow={currentRow}
          importModalCallback={importModalCallback}
        />
      )}

      {showModal && (
        <InspectionReportEntryAddEditModal
          masterProps={props}
          currentRow={currentRow}
          modalCallback={modalCallback}
        />
      )}
      {showCheckListModal && (
        <CheckListModal
          masterProps={props}
          currentRow={currentRow}
          modalCallback={modalCallbackCheckList}
        />
      )}


      

    </>
  );
};

export default InspectionReportEntry;
