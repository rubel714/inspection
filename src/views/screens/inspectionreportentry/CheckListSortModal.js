import React, { forwardRef, useRef, useEffect, useState } from "react";
import { Button } from "../../../components/CustomControl/Button";
import {
  ArrowUpward,
  ArrowDownward,
} from "@material-ui/icons";
import ExecuteQueryHook from "../../../components/hooks/ExecuteQueryHook";
import {
  apiCall,
  apiOption,
  LoginUserInfo,
  language,
} from "../../../actions/api";
import CustomTable from "components/CustomTable/CustomTable";

const CheckListSortModal = (props) => {
  // console.log('props: ', props);
  const serverpage = "inspectionreportentry"; // this is .php server page
  const UserInfo = LoginUserInfo();

  const { isLoading, data: dataList, error, ExecuteQuery } = ExecuteQueryHook(); //Fetch data

  React.useEffect(() => {
    getDataList();
  }, []);

  /**Get data for table list */
  function getDataList() {
    let params = {
      action: "getSingleReportCheckDataList",
      lan: language(),
      UserId: UserInfo.UserId,
      TransactionId: props.currentRow.id,
    };
    // console.log('LoginUserInfo params: ', params);

    ExecuteQuery(serverpage, params);
  }

  function modalClose() {
    // console.log('props modal: ', props);
    //  console.log('props.currentRow.CheckListMaped-------------------: ', props.currentRow.CheckListMaped);
    props.modalCallback("close");
  }

  const columnList = [
    { field: "rownumber", label: "SL", align: "center", width: "5%" },
    {
      field: "custom",
      label: "Action",
      width: "15%",
      align: "left",
      visible: true,
      sort: false,
      filter: false,
    },
    {
      field: "CheckName",
      label: "Check Name",
      align: "left",
      visible: true,
      sort: false,
      filter: true,
    },
    {
      field: "CategoryName",
      label: "Category",
      align: "left",
      visible: true,
      sort: false,
      filter: true,
    },
  ];

  /** Action from table row buttons*/
  function actioncontrol(rowData) {
    return (
      <>
        <ArrowUpward
          className={"table-edit-icon ml-10"}
          onClick={() => {
            changeOrder("up", rowData);
          }}
        />

        <ArrowDownward
          className={"table-edit-icon mr-10"}
          onClick={() => {
            changeOrder("down", rowData);
          }}
        />
      </>
    );
  }

  const changeOrder = (type, rowData) => {
    // console.log('dataList: ', dataList);
    // console.log('dataList[2]: ', dataList[2]);
    console.log("rowData: ", rowData);

    let currIndx = -1;
    dataList.forEach((element, index) => {
      if (element.id === rowData.id) {
        currIndx = index;
        console.log("Found at index: ", index);
      }
    });

    console.log("currIndx: ", currIndx);

    let TorowData = null;
    if (type === "up" && currIndx > 0) {
      TorowData = dataList[currIndx - 1];
    } else if (type === "down" && currIndx < dataList.length - 1) {
      TorowData = dataList[currIndx + 1];
    }

    console.log("TorowData: ", TorowData);

    if (TorowData) {
      changeOrderApi(type, rowData, TorowData);
    }
  };

  function changeOrderApi(type, rowData, TorowData) {
    let params = {
      action: "changeCheckListOrder",
      lan: language(),
      UserId: UserInfo.UserId,
      type: type,
      rowData: rowData,
      toRowData: TorowData,
    };

    apiCall.post(serverpage, { params }, apiOption()).then((res) => {
      getDataList();
    });
  }

  return (
    <>
      {/* <!-- GROUP MODAL START --> */}
      <div id="groupModal" class="modal">
        {/* <!-- Modal content --> */}
        <div class="modal-content">
          <div class="modalHeader">
            <h4>Change Checklist Order</h4>
          </div>

          <CustomTable
            columns={columnList}
            rows={dataList ? dataList : {}}
            actioncontrol={actioncontrol}
            ispagination={false}
          />

          <div class="modalItem">
            <Button label={"Close"} class={"btnClose"} onClick={modalClose} />
          </div>
        </div>
      </div>
      {/* <!-- GROUP MODAL END --> */}
    </>
  );
};

export default CheckListSortModal;