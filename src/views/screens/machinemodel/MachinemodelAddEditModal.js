import React, { forwardRef, useRef,useEffect,useState } from "react";
import {Button}  from "../../../components/CustomControl/Button";
import {apiCall, apiOption, LoginUserInfo, language}  from "../../../actions/api";
// import Select2 from 'react-select2-wrapper/lib/components/Select2';
// import jquery from 'jquery';
// import Select2 from 'react-select2-wrapper';
const MachinemodelAddEditModal = (props) => { 
  // console.log('props modal: ', props);
  const serverpage = "machinemodel"; // this is .php server page

  const [machineList, setMachineList] = useState(null);
  const [currentRow, setCurrentRow] = useState([]);
  const [errorObject, setErrorObject] = useState({});
 
  
   React.useEffect(() => {
    getProductGroup();
  }, []);

  function getProductGroup() {
    let UserInfo = LoginUserInfo();
 
    let params = {
      action: "MachineList",
      lan: language(),
      UserId: UserInfo.UserId,
      ClientId: UserInfo.ClientId,
      BranchId: UserInfo.BranchId,
      // rowData: rowData,
    };

    apiCall.post("combo_generic", { params }, apiOption()).then((res) => {
      setMachineList([{id:"", name: "Select machine"}].concat(res.data.datalist));
      setCurrentRow(props.currentRow);
    });

  }

  
  const handleChange = (e) => {
    const { name, value } = e.target;
    let data = { ...currentRow };
    data[name] = value;
    setCurrentRow(data);
    // console.log('aaa data: ', data);

    setErrorObject({ ...errorObject, [name]: null });

  };
 
  function handleChangeCheck(e) {
    // console.log('e.target.checked: ', e.target.checked);
    const { name, value } = e.target;

     let data = { ...currentRow };
     data[name] = e.target.checked;
     setCurrentRow(data);
    //  console.log('aaa data: ', data);

  }

  
  const validateForm = () => {

    let validateFields = ["MachineId","MachineModelName"]
    let errorData = {}
    let isValid = true
    validateFields.map((field) => {
      if (!currentRow[field]) {
        errorData[field] = "validation-style";
        isValid = false
      }
    })
    setErrorObject(errorData);
    return isValid
  }


  function addEditAPICall(){

    if (validateForm()) {

      let UserInfo = LoginUserInfo();
      let params = {
        action: "dataAddEdit",
        lan: language(),
        UserId: UserInfo.UserId,
        ClientId: UserInfo.ClientId,
        BranchId: UserInfo.BranchId,
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
    console.log('props modal: ', props);
    props.modalCallback("close");
  }


  return (
    <>

      {/* <!-- GROUP MODAL START --> */}
      <div id="groupModal" class="modal">
        {/* <!-- Modal content --> */}
        <div class="modal-content">
          <div class="modalHeader">
            <h4>Add/Edit Machine Model</h4>
          </div>

          <div class="modalItem">
                <label for="">Machine Name *</label>
              <select 
                id="MachineId" 
                name="MachineId" 
                class={errorObject.MachineId} 
                value={currentRow.MachineId}
                onChange={(e) => handleChange(e)}>

                    {/* <option value="">Select Product Group</option>
                    <option value="1">Pharma</option>
                    <option value="2">Non Pharma</option> */
                    }
                    
                    {machineList &&
                        machineList.map(
                        (item, index) => {
                          return ( 
                            <option value={item.id}>{item.name}</option>
                            // <option value="1">AAAAAA</option>
                            // <MenuItem value={item.id}>
                            //   {item.name}
                            // </MenuItem>
                          );
                        })
                        
                        }

                </select>
                {/* <button class="btnPlus">+</button> */}
            </div>

          <div class="modalItem">
            <label>Machine Model Name *</label>
            <input
              type="text"
              id="MachineModelName"
              name="MachineModelName"
              class={errorObject.MachineModelName}
              placeholder="Enter machine model name"
              value={currentRow.MachineModelName}
              onChange={(e) => handleChange(e)}
            />
          </div>
 
           <div class="modalItem">

            <Button label={"Close"} class={"btnClose"} onClick={modalClose} />
            {props.currentRow.id && (<Button label={"Update"} class={"btnUpdate"} onClick={addEditAPICall} />)}
            {!props.currentRow.id && (<Button label={"Save"} class={"btnSave"} onClick={addEditAPICall} />)}
            
          </div>
        </div>
      </div>
      {/* <!-- GROUP MODAL END --> */}



    </>
  );
};

export default MachinemodelAddEditModal;
