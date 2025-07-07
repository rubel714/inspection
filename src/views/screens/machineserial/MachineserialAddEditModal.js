import React, { forwardRef, useRef,useEffect,useState } from "react";
import {Button}  from "../../../components/CustomControl/Button";
import {apiCall, apiOption, LoginUserInfo, language}  from "../../../actions/api";

const MachineserialAddEditModal = (props) => {
  const serverpage = "machineserial"; // this is .php server page

  const [machineList, setMachineList] = useState(null);
  const[currMachineId,setCurrMachineId] = useState(0);
  const [modelList, setModelList] = useState(null);

  const [currentRow, setCurrentRow] = useState([]);
  const [errorObject, setErrorObject] = useState({});
 
  
   React.useEffect(() => {
    getMachineList();
    getMachineModelList(props.currentRow.MachineId);
    // console.log('props.currentRow:ssssssssssssssssssssss ', props.currentRow);
    // console.log('props.currentRow:ssssssssssssssssssssss ', props.currentRow.MachineId);
  }, []);

  function getMachineList() {
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

  
  function getMachineModelList(pMachineId) {
    let UserInfo = LoginUserInfo();
 
    let params = {
      action: "MachineModelList",
      lan: language(),
      UserId: UserInfo.UserId,
      ClientId: UserInfo.ClientId,
      BranchId: UserInfo.BranchId,
      MachineId: pMachineId,
      // rowData: rowData,
    };

    apiCall.post("combo_generic", { params }, apiOption()).then((res) => {
      setModelList([{id:"", name: "Select machine model"}].concat(res.data.datalist));
      //setCurrentRow(props.currentRow);
    });

  }
  
  const handleChange = (e) => {
    const { name, value } = e.target;
    let data = { ...currentRow };
    data[name] = value;
    
    if(name == "MachineId"){
      data["MachineModelId"] = "";
      getMachineModelList(value);
    }
    
    
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

    let validateFields = ["MachineId","MachineModelId","MachineSerial"]
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
            <h4>Add/Edit Machine Serial</h4>
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
                <label for="">Machine Model Name *</label>
              <select 
                id="MachineModelId" 
                name="MachineModelId" 
                class={errorObject.MachineModelId} 
                value={currentRow.MachineModelId}
                onChange={(e) => handleChange(e)}>

                    {/* <option value="">Select Product Group</option>
                    <option value="1">Pharma</option>
                    <option value="2">Non Pharma</option> */
                    }
                    
                    {modelList &&
                        modelList.map(
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
            <label>Machine Serial *</label>
            <input
              type="text"
              id="MachineSerial"
              name="MachineSerial"
              class={errorObject.MachineSerial}
              placeholder="Enter machine serial"
              value={currentRow.MachineSerial}
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

export default MachineserialAddEditModal;
