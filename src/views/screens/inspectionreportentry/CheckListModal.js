import React, { forwardRef, useRef, useEffect, useState } from "react";
import { Button } from "../../../components/CustomControl/Button";
import {
  apiCall,
  apiOption,
  LoginUserInfo,
  language,
} from "../../../actions/api";
import ExecuteQueryHook from "../../../components/hooks/ExecuteQueryHook";
import CustomTable from "components/CustomTable/CustomTable";
import {
  DeleteOutline,
  Edit,
  Add,
  AddAlarm,
  AddBox,
  AddBoxOutlined,
  AddAPhoto,
  PictureAsPdf,
} from "@material-ui/icons";
const CheckListModal = (props) => {
  //console.log("props modal: ", props);
  const serverpage = "checklist"; // this is .php server page
  const [currentRow, setCurrentRow] = useState(props.currentRow);
  const [errorObject, setErrorObject] = useState({});
  const UserInfo = LoginUserInfo();

  const baseUrl = process.env.REACT_APP_FRONT_URL;
  const { isLoading, data: dataList, error, ExecuteQuery } = ExecuteQueryHook(); //Fetch data

  // const handleChange = (e) => {
  //   const { name, value } = e.target;
  //   let data = { ...currentRow };
  //   data[name] = value;
  //   setCurrentRow(data);
  //   setErrorObject({ ...errorObject, [name]: null });
  // };

  const columnList = [
    { field: "rownumber", label: "SL", align: "center", width: "3%" },
    {
      field: "CheckName",
      label: "Check Name",
      align: "left",
      visible: true,
      sort: true,
      filter: true,
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

  /**Get data for table list */
  function getDataList() {
    let params = {
      action: "getDataList",
      lan: language(),
      UserId: UserInfo.UserId,
    };
    // console.log('LoginUserInfo params: ', params);

    ExecuteQuery(serverpage, params);
  }

  /** Action from table row buttons*/
  function actioncontrol(rowData) {
    return (
      <>
        <AddBoxOutlined
          className={"table-edit-icon"}
          onClick={() => {
            selectRowData(rowData);
          }}
        />
      </>
    );
  }

  function selectRowData(rowData) {
    // console.log("rowData: ", rowData);
    props.modalCallback(rowData);
  }

  function modalClose() {
    // console.log("props modal: ", props);
    props.modalCallback("close");
  }

  React.useEffect(() => {
    getDataList();
  }, []);

  return (
    <>
      {/* <!-- GROUP MODAL START --> */}
      <div id="groupModal" class="modal">
        {/* <!-- Modal content --> */}
        <div class="modal-content-checklist">
          <div class="modalHeader">
            <h4>Select Check Name</h4>
          </div>

          <div>
            <CustomTable
              columns={columnList}
              rows={dataList ? dataList : {}}
              actioncontrol={actioncontrol}
            />
          </div>

          <div class="modalItem">
            <Button label={"Close"} class={"btnClose"} onClick={modalClose} />
            {/*             
             <Button
                label={"Select"}
                class={"btnUpdate"}
                onClick={addEditAPICall}
              /> */}
          </div>
        </div>
      </div>
      {/* <!-- GROUP MODAL END --> */}
    </>
  );
};

export default CheckListModal;
