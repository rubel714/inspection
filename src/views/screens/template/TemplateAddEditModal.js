import React, { forwardRef, useRef, useEffect, useState } from "react";
import { Button } from "../../../components/CustomControl/Button";
import { DeleteOutline, Edit, ArrowUpward,ArrowDownward } from "@material-ui/icons";
import ExecuteQueryHook from "../../../components/hooks/ExecuteQueryHook";
import {
  apiCall,
  apiOption,
  LoginUserInfo,
  language,
} from "../../../actions/api";
import CustomTable from "components/CustomTable/CustomTable";

const TemplateAddEditModal = (props) => {
  console.log('props: ', props);
  const serverpage = "template"; // this is .php server page
  const [currentRow, setCurrentRow] = useState(props.currentRow);
  const [errorObject, setErrorObject] = useState({});
  const [filterType, setFilterType] = useState(0);
  // const [checkList, setCheckList] = useState(props.currentRow.CheckListMaped || []);
  // console.log('props.currentRow.CheckListMaped: ', props.currentRow.CheckListMaped);
  const UserInfo = LoginUserInfo();

  const { isLoading, data: dataList, error, ExecuteQuery } = ExecuteQueryHook(); //Fetch data



    React.useEffect(() => {
      getDataList();
    }, [filterType]);
    
    /**Get data for table list */
    function getDataList() {
      let params = {
        action: "getCheckDataList",
        lan: language(),
        UserId: UserInfo.UserId,
        TemplateId: props.currentRow.id,
        FilterType: filterType
      };
      // console.log('LoginUserInfo params: ', params);
  
      ExecuteQuery(serverpage, params);
    }
  


  const handleChange = (e) => {
    const { name, value } = e.target;
    let data = { ...currentRow };
    data[name] = value;

    setCurrentRow(data);
    setErrorObject({ ...errorObject, [name]: null });
  };

  const validateForm = () => {
    let validateFields = ["TemplateName"];
    let errorData = {};
    let isValid = true;
    validateFields.map((field) => {
      if (!currentRow[field]) {
        errorData[field] = "validation-style";
        isValid = false;
      }
    });
    setErrorObject(errorData);
    return isValid;
  };

  function addEditAPICall() {
    if (validateForm()) {
      let params = {
        action: "dataAddEdit",
        lan: language(),
        UserId: UserInfo.UserId,
        rowData: currentRow,
      };

      apiCall.post(serverpage, { params }, apiOption()).then((res) => {
        // console.log('res: ', res);

        props.masterProps.openNoticeModal({
          isOpen: true,
          msg: res.data.message,
          msgtype: res.data.success,
        });

        // console.log('props modal: ', props);
        if (res.data.success === 1) {
          props.modalCallback("addedit");
        }
      });
    }
  }

  function modalClose() {
    // console.log('props modal: ', props);
  //  console.log('props.currentRow.CheckListMaped-------------------: ', props.currentRow.CheckListMaped);
    props.modalCallback("close");
  }

  const columnList = [
    { field: "rownumber", label: "SL", align: "center", width: "5%" },
    // { field: 'SL', label: 'SL',width:'10%',align:'center',visible:true,sort:false,filter:false },
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


        {/* <Edit
          className={"table-edit-icon"}
          onClick={() => {
            editData(rowData);
          }}
        /> */}

        {rowData.IsAssigned === 0 && (
          <span
            className={"table-delete-icon clickable font-bold"}
            onClick={() => {
              assignData(rowData);
            }}
          >
            No
          </span>
        )}

        {rowData.IsAssigned === 1 && (
          <span
            className={"table-view-icon clickable font-bold"}
            onClick={() => {
              assignData(rowData);
            }}
          >
            Yes
          </span>
        )}


      {rowData.IsAssigned === 1 && (
        <>
        <ArrowUpward
          className={"table-edit-icon ml-10"}
          onClick={() => {
           changeOrder("up",rowData);
          }}
        />


         <ArrowDownward
          className={"table-edit-icon mr-10"}
          onClick={() => {
           changeOrder("down",rowData);
          }}
        />
        </>
      )}
       
      </>
    );
  }


  const assignData = (rowData) => {
    console.log('rowData: ', rowData);
    // console.log('currentRow: ', currentRow);
    rowData.TemplateId = currentRow.id;

    if(rowData.IsAssigned === 1){
      rowData.IsAssigned = 0;
    }else{
      rowData.IsAssigned = 1;
    }
 

    // const { name, value } = e.target;
    // let data = { ...currentRow };
    // data[name] = value;

    // setCurrentRow(data);

    // setCurrentRow(rowData);
    assignApi(rowData);
  };

  function assignApi(rowData) {
   
    let params = {
      action: "assignData",
      lan: language(),
      UserId: UserInfo.UserId,
      rowData: rowData,
    };

    apiCall.post(serverpage, { params }, apiOption()).then((res) => {
      // console.log('res: ', res);
      // props.openNoticeModal({
      //   isOpen: true,
      //   msg: res.data.message,
      //   msgtype: res.data.success,
      // });
      getDataList();
    });
  }


  
  const changeOrder = (type, rowData) => {
    // console.log('dataList: ', dataList);
    // console.log('dataList[2]: ', dataList[2]);
    console.log('rowData: ', rowData);

    let currIndx = -1;
    dataList.forEach((element, index) => {
      if(element.id === rowData.id){
        currIndx = index;
        console.log('Found at index: ', index);
      } 
    });

    console.log('currIndx: ', currIndx);

    let TorowData = null;
    if(type === "up" && currIndx > 0){
      TorowData = dataList[currIndx - 1];
    }else if(type === "down" && currIndx < dataList.length -1){
      TorowData = dataList[currIndx + 1];
    }

    console.log('TorowData: ', TorowData);

    if(TorowData){
      changeOrderApi(type,rowData,TorowData);
    }
  };

  function changeOrderApi(type,rowData,TorowData) {
   
    let params = {
      action: "changeOrder",
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
 
  function handleChangeCheck(e) {
     console.log('e.target.checked: ', e.target.checked);
      if(e.target.checked){
          setFilterType(1);
      }else{
          setFilterType(0);
      }
     
  }


  return (
    <>
      {/* <!-- GROUP MODAL START --> */}
      <div id="groupModal" class="modal">
        {/* <!-- Modal content --> */}
        <div class="modal-content">
          <div class="modalHeader">
            <h4>Add/Edit Template</h4>
          </div>

          <div class="modalItem">
            <label>Template Name *</label>
            <input
              type="text"
              id="TemplateName"
              name="TemplateName"
              class={errorObject.TemplateName}
              placeholder="Enter Template Name"
              value={currentRow.TemplateName}
              onChange={(e) => handleChange(e)}
            />
          </div>

          <div class="modalItem">
            <label>Comments</label>
            <input
              type="text"
              id="Comments"
              name="Comments"
              // class={errorObject.Comments}
              placeholder="Enter Comments"
              value={currentRow.Comments}
              onChange={(e) => handleChange(e)}
            />
          </div>

          {currentRow.id && (<div class="">

            {/* <div style={{"margin":"5px", "font-weight":"bold"}}  >
              <label>Show Only Assigned</label>
              <input 
                id="FilterType" 
                name="FilterType" 
                type = "checkbox" 
                checked={filterType === 0 ? false : true} 
                onChange = {handleChangeCheck} 
              />
            </div> */}


            <CustomTable
              columns={columnList}
              rows={dataList ? dataList : {}}
              actioncontrol={actioncontrol}
              ispagination={false}
            />
          </div>)}

          <div class="modalItem">
            <Button label={"Close"} class={"btnClose"} onClick={modalClose} />
            {props.currentRow.id && (
              <Button
                label={"Update"}
                class={"btnUpdate"}
                onClick={addEditAPICall}
              />
            )}
            {!props.currentRow.id && (
              <Button
                label={"Save"}
                class={"btnSave"}
                onClick={addEditAPICall}
              />
            )}
          </div>
        </div>
      </div>
      {/* <!-- GROUP MODAL END --> */}
    </>
  );
};

export default TemplateAddEditModal;
