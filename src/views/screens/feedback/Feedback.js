import React, { forwardRef, useRef } from "react";
import swal from "sweetalert";
import { DeleteOutline, Edit } from "@material-ui/icons";
import { Button } from "../../../components/CustomControl/Button";

import CustomTable from "components/CustomTable/CustomTable";
import {
  apiCall,
  apiOption,
  LoginUserInfo,
  language,
} from "../../../actions/api";
import ExecuteQueryHook from "../../../components/hooks/ExecuteQueryHook";
import { Typography, TextField } from "@material-ui/core";

import Autocomplete from "@material-ui/lab/Autocomplete";
import FeedbackAddEditModal from "./FeedbackAddEditModal";

const Feedback = (props) => {
  const serverpage = "feedback"; // this is .php server page

  const permissionType = props.permissionType;
  const { useState } = React;
  const [bFirst, setBFirst] = useState(true);
  const [currSearch, setCurrSearch] = useState("N"); //0=All, Y=LM approved, N=LM not approved
  const [currentRow, setCurrentRow] = useState([]);
  const [showModal, setShowModal] = useState(false); //true=show modal, false=hide modal
  const [approvedStatusList, setApprovedStatusList] = useState([
    { id: 0, name: "All" },
    { id: "Y", name: "Approved" },
    { id: "N", name: "Not Approved" },
  ]);

  const { isLoading, data: dataList, error, ExecuteQuery } = ExecuteQueryHook(); //Fetch data
  const UserInfo = LoginUserInfo();
  const CurrRoleId = UserInfo.RoleId[0] ? UserInfo.RoleId[0] : 0;

  /* =====Start of Excel Export Code==== */
  const EXCEL_EXPORT_URL = process.env.REACT_APP_API_URL;

  const PrintPDFExcelExportFunction = () => {
    let finalUrl = EXCEL_EXPORT_URL + "report/print_pdf_excel_server.php";

    window.open(
      finalUrl +
        "?action=FeedbackExport" +
        "&reportType=excel" +
        "&UserId=" +
        (CurrRoleId == 1 ? 0 : UserInfo.UserId) +
        "&Search=" +
        currSearch +
        "&TimeStamp=" +
        Date.now()
    );
  };
  /* =====End of Excel Export Code==== */

  const columnList = [
    { field: "rownumber", label: "SL", align: "center", width: "4%" },
    // { field: 'SL', label: 'SL',width:'10%',align:'center',visible:true,sort:false,filter:false },
    {
      field: "CustomerName",
      label: "Customer Name",
      align: "left",
      visible: true,
      sort: true,
      filter: true,
      // width: "10%"
    },
    {
      field: "VisitDate",
      label: "Visit Date",
      align: "left",
      visible: true,
      sort: true,
      filter: true,
      width: "6%",
    },
    {
      field: "VisitorName",
      label: "Employee",
      align: "left",
      visible: true,
      sort: true,
      filter: true,
      width: "7%",
    },

    {
      field: "Purpose",
      label: "Purpose",
      align: "left",
      visible: true,
      sort: true,
      filter: true,
      width: "7%",
    },
    {
      field: "Transportation",
      label: "Transportation",
      align: "left",
      visible: true,
      sort: true,
      filter: true,
      width: "7%",
    },
    {
      field: "PublicTransportDesc",
      label: "Transportation Description",
      align: "left",
      visible: true,
      sort: true,
      filter: true,
      width: "10%",
    },
    {
      field: "SelfDiscussion",
      label: "Discussion",
      align: "left",
      visible: true,
      sort: true,
      filter: true,
      width: "12%",
    },
    {
      field: "ConveyanceAmount",
      label: "Conveyance",
      align: "right",
      visible: true,
      sort: true,
      filter: true,
      width: "7%",
    },
    {
      field: "RefreshmentAmount",
      label: "Refreshment",
      align: "right",
      visible: true,
      sort: true,
      filter: true,
      width: "7%",
    },
    {
      field: "DinnerBillAmount",
      label: "Dinner Bill",
      align: "right",
      visible: true,
      sort: true,
      filter: true,
      width: "7%",
    },
    {
      field: "ApprovedConveyanceAmount",
      label: "Approved Conveyance",
      align: "right",
      visible: true,
      sort: true,
      filter: true,
      width: "7%",
    },
    {
      field: "ApprovedRefreshmentAmount",
      label: "Approved Refreshment",
      align: "right",
      visible: true,
      sort: true,
      filter: true,
      width: "7%",
    },
    {
      field: "ApprovedDinnerBillAmount",
      label: "Approved Dinner Bill",
      align: "right",
      visible: true,
      sort: true,
      filter: true,
      width: "7%",
    },
    {
      field: "IsLinemanFeedback",
      label: "Approved",
      width: "5%",
      align: "center",
      visible: true,
      sort: true,
      filter: true,
    },
    {
      field: "custom",
      label: "Action",
      width: "4%",
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
      UserId: CurrRoleId == 1 ? 0 : UserInfo.UserId,
      Search: currSearch,

      // ClientId: UserInfo.ClientId,
      // BranchId: UserInfo.BranchId,
    };
    // console.log('LoginUserInfo params: ', params);

    ExecuteQuery(serverpage, params);
  }

  /** Action from table row buttons*/
  function actioncontrol(rowData) {
    return (
      <>
        {permissionType === 0 &&
          (rowData.IsLinemanFeedback == "N" || CurrRoleId == 1) && (
            <Edit
              className={"table-edit-icon"}
              onClick={() => {
                editData(rowData);
              }}
            />
          )}

        {/* {permissionType === 0 && (<DeleteOutline
          className={"table-delete-icon"}
          onClick={() => {
            deleteData(rowData);
          }}
        />)} */}
      </>
    );
  }

  // const addData = () => {
  //   // console.log("rowData: ", rowData);
  //   // console.log("dataList: ", dataList);

  //   setCurrentRow({
  //     id: "",
  //     ConveyanceAmount: "",
  //     RefreshmentAmount: "",
  //     ApprovedConveyanceAmount: "",
  //     ApprovedRefreshmentAmount: "",
  //   });
  //   openModal();
  // };

  const editData = (rowData) => {
    // console.log("rowData: ", rowData);
    // console.log("dataList: ", dataList);

    setCurrentRow(rowData);
    openModal();
  };

  function openModal() {
    setShowModal(true); //true=modal show, false=modal hide
  }

  function modalCallback(response) {
    //response = close, addedit
    // console.log('response: ', response);
    getDataList();
    setShowModal(false); //true=modal show, false=modal hide
  }

  // const deleteData = (rowData) => {
  //   swal({
  //     title: "Are you sure?",
  //     text: "Once deleted, you will not be able to recover this data!",
  //     icon: "warning",
  //     buttons: {
  //       confirm: {
  //         text: "Yes",
  //         value: true,
  //         visible: true,
  //         className: "",
  //         closeModal: true,
  //       },
  //       cancel: {
  //         text: "No",
  //         value: null,
  //         visible: true,
  //         className: "",
  //         closeModal: true,
  //       },
  //     },
  //     dangerMode: true,
  //   }).then((allowAction) => {
  //     if (allowAction) {
  //       deleteApi(rowData);
  //     }
  //   });
  // };

  // function deleteApi(rowData) {

  //   let params = {
  //     action: "deleteData",
  //     lan: language(),
  //     UserId: UserInfo.UserId,
  //     ClientId: UserInfo.ClientId,
  //     BranchId: UserInfo.BranchId,
  //     rowData: rowData,
  //   };

  //   // apiCall.post("productgroup", { params }, apiOption()).then((res) => {
  //   apiCall.post(serverpage, { params }, apiOption()).then((res) => {
  //    // console.log('res: ', res);
  //     props.openNoticeModal({
  //       isOpen: true,
  //       msg: res.data.message,
  //       msgtype: res.data.success,
  //     });
  //     getDataList();
  //   });

  // }

  const handleChangeFilterDropDown = (name, value) => {

    if (name === "IsLinemanFeedback") {
      setCurrSearch(value);
      //getUser(value);
    }
  };
  React.useEffect(() => {
    getDataList();
  }, [currSearch]);




  
  const ApproveALl = () => {
    swal({
      title: "Are you sure?",
      text: "You want to approve all following visit!",
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
        approveAllApi();
      }
    });
  };

  function approveAllApi() {

    let params = {
      action: "approveAll",
      lan: language(),
      UserId: (CurrRoleId == 1 ? 0 : UserInfo.UserId),
      ClientId: UserInfo.ClientId,
      BranchId: UserInfo.BranchId,
      // rowData: rowData,
    };

    // apiCall.post("productgroup", { params }, apiOption()).then((res) => {
    apiCall.post(serverpage, { params }, apiOption()).then((res) => {
     // console.log('res: ', res);
      props.openNoticeModal({
        isOpen: true,
        msg: res.data.message,
        msgtype: res.data.success,
      });
      getDataList();
    });

  }


  return (
    <>
      <div class="bodyContainer">
        {/* <!-- ######-----TOP HEADER-----####### --> */}
        <div class="topHeader">
          <h4>
            <a href="#">Home</a> ❯ My Task ❯ Feedback
          </h4>
        </div>

        {/* <!-- TABLE SEARCH AND GROUP ADD --> */}
        <div class="searchAdd">
          <div>
            <label>Approved Status</label>
            <div class="">
              <Autocomplete
                autoHighlight
                disableClearable
                className="chosen_dropdown"
                id="IsLinemanFeedback"
                name="IsLinemanFeedback"
                autoComplete
                options={approvedStatusList ? approvedStatusList : []}
                getOptionLabel={(option) => option.name}
                defaultValue={{ id: "N", name: "Not Approved" }}
                onChange={(event, valueobj) =>
                  handleChangeFilterDropDown(
                    "IsLinemanFeedback",
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
          </div>
          <Button
            label={"Approve"}
            class={"btnSave"}
            onClick={ApproveALl}
          />

          <Button
            label={"Export"}
            class={"btnPrint"}
            onClick={PrintPDFExcelExportFunction}
          />
          {/* <Button disabled={permissionType} label={"ADD"} class={"btnAdd"} onClick={addData} /> */}
        </div>



 
        {/* <!-- ####---THIS CLASS IS USE FOR TABLE GRID PRODUCT INFORMATION---####s --> */}
        <div class="subContainer tableHeight">
          <div className="App">
            <CustomTable
              columns={columnList}
              rows={dataList ? dataList : {}}
              actioncontrol={actioncontrol}
            />
          </div>
        </div>
      </div>
      {/* <!-- BODY CONTAINER END --> */}

      {showModal && (
        <FeedbackAddEditModal
          masterProps={props}
          currentRow={currentRow}
          modalCallback={modalCallback}
        />
      )}
    </>
  );
};

export default Feedback;
