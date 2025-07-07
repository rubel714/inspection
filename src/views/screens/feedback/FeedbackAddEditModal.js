import React, { forwardRef, useRef,useEffect,useState } from "react";
import {Button}  from "../../../components/CustomControl/Button";
import {apiCall, apiOption, LoginUserInfo, language}  from "../../../actions/api";

const FeedbackAddEditModal = (props) => { 
  console.log('props modal: ', props.currentRow);
  const serverpage = "feedback";// this is .php server page
  const [currentRow, setCurrentRow] = useState(props.currentRow);
  const [errorObject, setErrorObject] = useState({});
  const UserInfo = LoginUserInfo();
  
  const handleChange = (e) => {
    const { name, value } = e.target;
    let data = { ...currentRow };
    data[name] = value;

    setCurrentRow(data);
    setErrorObject({ ...errorObject, [name]: null });

  };
 
  
  const validateForm = () => {

    // let validateFields = ["ApprovedConveyanceAmount","ApprovedRefreshmentAmount"];
    let validateFields = ["ApprovedConveyanceAmount"];
    let errorData = {};
    let isValid = true;
    validateFields.map((field) => {
      if (!currentRow[field]) {
        errorData[field] = "validation-style";
        isValid = false;
      }
    })
    setErrorObject(errorData);
    return isValid;
  }


  function addEditAPICall(){

    if (validateForm()) {

      let params = {
        action: "dataAddEdit",
        lan: language(),
        UserId: UserInfo.UserId,
        // ClientId: UserInfo.ClientId,
        // BranchId: UserInfo.BranchId,
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
        if(res.data.success === 1){
          props.modalCallback("addedit");
        }


      });

    }

    
  }

  function modalClose(){
    // console.log('props modal: ', props);
    props.modalCallback("close");
  }


  return (
    <>

      {/* <!-- GROUP MODAL START --> */}
      <div id="groupModal" class="modal">
        {/* <!-- Modal content --> */}
        <div class="modal-content">
          <div class="modalHeader">
            <h4>Add/Edit Feedback</h4>
          </div>

          <div class="modalItem">
            <label>Conveyance *</label>
            <input
              type="text"
              id="ApprovedConveyanceAmount"
              name="ApprovedConveyanceAmount"
              class={errorObject.ApprovedConveyanceAmount}
              placeholder="Enter Approved Conveyance"
              value={currentRow.ApprovedConveyanceAmount}
              onChange={(e) => handleChange(e)}
            />
          </div>
          <div class="modalItem">
            <label>Refreshment</label>
            <input
              type="text"
              id="ApprovedRefreshmentAmount"
              name="ApprovedRefreshmentAmount"
              // class={errorObject.ApprovedRefreshmentAmount}
              placeholder="Enter Approved Refreshment"
              value={currentRow.ApprovedRefreshmentAmount}
              onChange={(e) => handleChange(e)}
            />
          </div>
          <div class="modalItem">
            <label>Dinner Bill</label>
            <input
              type="text"
              id="ApprovedDinnerBillAmount"
              name="ApprovedDinnerBillAmount"
              // class={errorObject.ApprovedDinnerBillAmount}
              placeholder="Enter Approved Dinner Bill"
              value={currentRow.ApprovedDinnerBillAmount}
              onChange={(e) => handleChange(e)}
            />
          </div>
          <div class="modalItem">
            <label>Pass with Advice</label>
            <input
              type="text"
              id="LMAdvice"
              name="LMAdvice"
              // class={errorObject.LMAdvice}
              placeholder="Enter Pass with Advice"
              value={currentRow.LMAdvice}
              onChange={(e) => handleChange(e)}
            />
          </div>
          <div class="modalItem">
            <label>Next FollowUp Date</label>
            <input
              type="date"
              id="LMFollowUpDate"
              name="LMFollowUpDate"
              style={{width:"20%"}}
              // class={errorObject.LMFollowUpDate}
              placeholder="Enter Next FollowUp Date"
              value={currentRow.LMFollowUpDate}
              onChange={(e) => handleChange(e)}
            />
          </div>

          <div class="modalItem">

            <Button label={"Close"} class={"btnClose"} onClick={modalClose} />
            {props.currentRow.id && (<Button label={"Save"} class={"btnUpdate"} onClick={addEditAPICall} />)}
            {/* {!props.currentRow.id && (<Button label={"Save"} class={"btnSave"} onClick={addEditAPICall} />)} */}
            
          </div>
        </div>
      </div>
      {/* <!-- GROUP MODAL END --> */}



    </>
  );
};

export default FeedbackAddEditModal;
