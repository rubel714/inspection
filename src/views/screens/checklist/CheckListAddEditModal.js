import React, { forwardRef, useRef, useEffect, useState } from "react";
import { Button } from "../../../components/CustomControl/Button";
import {
  apiCall,
  apiOption,
  LoginUserInfo,
  language,
} from "../../../actions/api";
import Autocomplete from "@material-ui/lab/Autocomplete";
import { Typography, TextField } from "@material-ui/core";

const CheckListAddEditModal = (props) => {
  // console.log('props modal: ', props);
  const serverpage = "checklist"; // this is .php server page
  const [currentRow, setCurrentRow] = useState(props.currentRow);
  const [errorObject, setErrorObject] = useState({});
  const UserInfo = LoginUserInfo();

 
  const [CategoryList, setCategoryList] = useState(null);
  const [currCategoryId, setCurrCategoryId] = useState(null);

    React.useEffect(() => {
      getCategoryList(props.currentRow.CategoryId);
    }, []);
  
    function getCategoryList(selectCategoryId) {
      let params = {
        action: "CategoryList",
        lan: language(),
        UserId: UserInfo.UserId,
      };
  
      apiCall.post("combo_generic", { params }, apiOption()).then((res) => {
        setCategoryList(
          [{ id: "", name: "Select Category" }].concat(res.data.datalist)
        );
  
        setCurrCategoryId(selectCategoryId);
      });
    }
  




  const handleChange = (e) => {
    const { name, value } = e.target;
    let data = { ...currentRow };
    data[name] = value;

    setCurrentRow(data);
    setErrorObject({ ...errorObject, [name]: null });
  };

  const validateForm = () => {
    let validateFields = ["CheckName","CategoryId"];
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
        if (res.data.success === 1) {
          props.modalCallback("addedit");
        }
      });
    }
  }

  function modalClose() {
    // console.log('props modal: ', props);
    props.modalCallback("close");
  }

  
  const handleChangeFilterDropDown = (name, value) => {
    let data = { ...currentRow };

    if (name === "CategoryId") {
      data["CategoryId"] = value;
      setCurrCategoryId(value);
    }

    setErrorObject({ ...errorObject, [name]: null });
    setCurrentRow(data);
  };

  return (
    <>
      {/* <!-- GROUP MODAL START --> */}
      <div id="groupModal" class="modal">
        {/* <!-- Modal content --> */}
        <div class="modal-content">
          <div class="modalHeader">
            <h4>Add/Edit Check List</h4>
          </div>

          <div class="modalItem">
            <label>Check Name *</label>
            <input
              type="text"
              id="CheckName"
              name="CheckName"
              class={errorObject.CheckName}
              placeholder="Enter Check Name"
              value={currentRow.CheckName}
              onChange={(e) => handleChange(e)}
            />
          </div>

          <div class="modalItem">
            <label>Category *</label>
            <Autocomplete
              autoHighlight
              disableClearable
              className="chosen_dropdown"
              id="CategoryId"
              name="CategoryId"
              autoComplete
              class={errorObject.CategoryId}
              options={CategoryList ? CategoryList : []}
              getOptionLabel={(option) => option.name}
              defaultValue={{ id: 0, name: "Select Category" }}
              value={
                CategoryList
                  ? CategoryList[
                      CategoryList.findIndex(
                        (list) => list.id === currCategoryId
                      )
                    ]
                  : null
              }
              onChange={(event, valueobj) =>
                handleChangeFilterDropDown(
                  "CategoryId",
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

export default CheckListAddEditModal;
