import React, { forwardRef, useRef, useEffect, useState } from "react";
import { Button } from "../../../components/CustomControl/Button";
import {
  apiCall,
  apiOption,
  LoginUserInfo,
  language,
} from "../../../actions/api";
import Autocomplete from "@material-ui/lab/Autocomplete";
import ExecuteQueryHook from "../../../components/hooks/ExecuteQueryHook";

import { Typography, TextField } from "@material-ui/core";
const InspectionReportEntryAddEditModal = (props) => {
  //console.log("props modal: ", props);
  const serverpage = "inspectionreportentry"; // this is .php server page
  const [currentRow, setCurrentRow] = useState(props.currentRow);
  const [errorObject, setErrorObject] = useState({});
  const [selectedFiles, setSelectedFiles] = useState(
    props.currentRow.FooterFileUrl
      ? props.currentRow.FooterFileUrl.split(",")
      : []
  );
  // const [currentFile, setCurrentFile] = useState(null);
  const UserInfo = LoginUserInfo();

  // const [CheckList, setCheckList] = useState(null);
  // const [currCheckId, setCurrCheckId] = useState(null);

  const baseUrl = process.env.REACT_APP_FRONT_URL;
  const baseUrlstorage = process.env.REACT_APP_STORAGE_URL;
  const [previewImage, setPreviewImage] = useState(
    `${baseUrl}image/transaction/placeholder.jpg`
  );

  // Build full URL for accessory files stored on server
  const getAccessoryFileUrl = (fileName) => {
    if (!fileName) return "";
    return `${baseUrlstorage}image/transaction/${currentRow.ManyImgPrefix}/${fileName}`;
  };

  const EXCEL_EXPORT_URL = process.env.REACT_APP_API_URL;
  const PDFGenerate = () => {
    let finalUrl = EXCEL_EXPORT_URL + "report/ReportGenerate_pdf.php";
    window.open(
      finalUrl + "?TransactionId=" + currentRow.id + "&TimeStamp=" + Date.now()
    );
  };

  const handleChange = (e) => {
    const { name, value } = e.target;
    let data = { ...currentRow };
    data[name] = value;
    setCurrentRow(data);
    setErrorObject({ ...errorObject, [name]: null });
  };

  const handleDeleteAccessory = (fileName) => {
    const isServerFile = /_(footer|cover)_/.test(fileName || "");
    if (!isServerFile) {
      // Remove from local selections only
      setSelectedFiles((prev) => prev.filter((f) => f !== fileName));
      let data = { ...currentRow };
      if (Array.isArray(data.FooterFileUrlUpload)) {
        data.FooterFileUrlUpload = data.FooterFileUrlUpload.filter(
          (f) => f.name !== fileName
        );
      }
      setCurrentRow(data);
      return;
    }

    const params = {
      action: "deleteAccessoryFile",
      lan: language(),
      UserId: UserInfo.UserId,
      TransactionId: currentRow.id,
      FileName: fileName,
    };

    apiCall.post(serverpage, { params }, apiOption()).then((res) => {
      if (
        props.masterProps &&
        typeof props.masterProps.openNoticeModal === "function"
      ) {
        props.masterProps.openNoticeModal({
          isOpen: true,
          msg: res.data.message,
          msgtype: res.data.success,
        });
      }
      if (res.data.success === 1) {
        setSelectedFiles((prev) => prev.filter((f) => f !== fileName));
      }
    });
  };

  const handleChangeMasterFile = (e) => {
    const { name } = e.target;
    const files = e.target.files;

    if (!files || files.length === 0) return;

    let data = { ...currentRow };

    // Handle multiple files for FooterFileUrlUpload (Accessories)
    if (name === "FooterFileUrlUpload") {
      const fileArray = Array.from(files);
      const fileNames = fileArray.map((f) => f.name);
      // console.log("selectedFiles: ", selectedFiles);

      // Append to existing files instead of replacing
      setSelectedFiles((prev) => [...prev, ...fileNames]);

      const filePromises = fileArray.map((file) => {
        return new Promise((resolve) => {
          const reader = new FileReader();
          reader.onload = (event) => {
            resolve({
              name: file.name,
              data: event.target.result,
            });
          };
          reader.readAsDataURL(file);
        });
      });

      Promise.all(filePromises).then((results) => {
        // Append to existing file data instead of replacing
        const existingFiles = data[name] || [];
        data[name] = [...existingFiles, ...results];
        setCurrentRow(data);
      });
    } else {
      // Handle single file for CoverFileUrlUpload (Report File)
      const file = files[0];
      const reader = new FileReader();
      reader.onload = (event) => {
        data[name] = event.target.result;
        setCurrentRow(data);
      };
      reader.readAsDataURL(file);
    }
  };

  
  // const handleChangeManyDropDown = (name, value, Idx) => {
  //   let data = { ...currentRow };
  //   if (name === "CheckId") {
  //     data.Items[Idx].CheckId = value;
  //   }

  //   // setErrorObject({ ...errorObject, [name]: null });
  //   setCurrentRow(data);
  //   // console.log("data: ", data);
  // };

  // const handleChangeWidthHeight = (type, classname, Idx) => {
  //   let data = { ...currentRow };
  //   if (type === "width") {
  //     data.Items[Idx].RowNo = classname;
  //   } else if (type === "height") {
  //     data.Items[Idx].ColumnNo = classname;
  //   }
  //   setCurrentRow(data);
  // };

  // function addCheckBlock() {
  //   let data = { ...currentRow };
  //   let currTime = Date.now();
  //   let newCheck = {
  //     CheckId: 0,
  //     ColumnNo: "reportcheckblock-height-onethird",
  //     PhotoUrl: "placeholder.jpg",
  //     PhotoUrlChanged: "",
  //     PhotoUrlPreview: "",
  //     PhotoUrlUpload: "",
  //     RowNo: "reportcheckblock-width-half",
  //     SortOrder: data.Items.length + 1,
  //     TransactionId: currTime,
  //     TransactionItemId: currTime,
  //     autoId: -1,
  //   };

  //   data.Items.push(newCheck);
  //   setCurrentRow(data);
  // }

  // function deleteCheckBlock(Idx) {
  //   let data = { ...currentRow };
  //   delete data.Items[Idx];
  //   setCurrentRow(data);
  // }

  const validateForm = () => {
    let validateFields = [];
    validateFields = ["InvoiceNo", "TransactionDate"];
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
      console.log("currentRow: ", currentRow);

      let params = {
        action: "dataAddEdit",
        lan: language(),
        UserId: UserInfo.UserId,
        rowData: currentRow,
      };

      apiCall.post(serverpage, { params }, apiOption()).then((res) => {
        props.masterProps.openNoticeModal({
          isOpen: true,
          msg: res.data.message,
          msgtype: res.data.success,
        });

        if (res.data.success === 1) {
          props.modalCallback("addedit");
        }
      });
    }
  }

  function modalClose() {
    // console.log("props modal: ", props);
    props.modalCallback("close");
  }

  // const handleFileChangeManyFile = (e, Idx) => {
  //   let data = { ...currentRow };
  //   let file = e.target.files[0];

  //   if (file) {
  //     data.Items[Idx].PhotoUrlUpload = file;
  //     data.Items[Idx].PhotoUrlChanged =
  //       data.Items[Idx].TransactionItemId + "_" + file.name;

  //     let reader = new FileReader();
  //     reader.readAsDataURL(file);
  //     reader.onload = (event) => {
  //       data.Items[Idx].PhotoUrlPreview = event.target.result;
  //       setCurrentRow(data);
  //     };
  //   } else {
  //     data.Items[Idx].PhotoUrlPreview = "";
  //     data.Items[Idx].PhotoUrlUpload = null;
  //     data.Items[Idx].PhotoUrlChanged = "";
  //     setCurrentRow(data);
  //   }
  // };

  return (
    <>
      {/* <!-- GROUP MODAL START --> */}
      <div id="groupModal" class="modal">
        {/* <!-- Modal content --> */}
        <div class="modal-content-reportblock">
          <div class="modalHeader">
            <h4>Add/Edit Inspection Report</h4>
          </div>

          <div class="contactmodalBody pt-10">
            <label>Report Number</label>
            <input
              type="text"
              id="InvoiceNo"
              name="InvoiceNo"
              class={errorObject.InvoiceNo}
              placeholder="Enter Report Number"
              value={currentRow.InvoiceNo}
              onChange={(e) => handleChange(e)}
            />

            <label>Report Date</label>
            <input
              type="date"
              id="TransactionDate"
              name="TransactionDate"
              // style={{width:"20%"}}
              class={errorObject.TransactionDate}
              placeholder="Enter Report Date"
              value={currentRow.TransactionDate}
              onChange={(e) => handleChange(e)}
            />
          </div>

          <div class="contactmodalBody pt-10">
            <label>Buyer Name</label>
            <input
              type="text"
              id="BuyerName"
              name="BuyerName"
              // class={errorObject.BuyerName}
              placeholder="Enter Buyer Name"
              value={currentRow.BuyerName}
              onChange={(e) => handleChange(e)}
            />

            <label>Supplier Name</label>
            <input
              type="text"
              id="SupplierName"
              name="SupplierName"
              // class={errorObject.SupplierName}
              placeholder="Enter Supplier Name"
              value={currentRow.SupplierName}
              onChange={(e) => handleChange(e)}
            />
          </div>
          <div class="contactmodalBody pt-10">
            <label>Factory Name</label>
            <input
              type="text"
              id="FactoryName"
              name="FactoryName"
              // class={errorObject.FactoryName}
              placeholder="Enter Factory Name"
              value={currentRow.FactoryName}
              onChange={(e) => handleChange(e)}
            />

            <label>Report File Page Count</label>
            <input
              type="text"
              id="CoverFilePages"
              name="CoverFilePages"
              // class={errorObject.CoverFilePages}
              placeholder="Enter Report File Page Count"
              value={currentRow.CoverFilePages}
              onChange={(e) => handleChange(e)}
            />
          </div>
          <div class="contactmodalBody pt-10">
            <label>Report File</label>
            <input
              type="file"
              id="CoverFileUrlUpload"
              name="CoverFileUrlUpload"
              accept="application/pdf"
              style={
                !currentRow.CoverFileUrlUpload ? { color: "transparent" } : {}
              }
              //onChange={handleFileChange}
              //onChange={(e) => handleFileChange(e, "CoverFileUrl")}
              onChange={(e) => handleChangeMasterFile(e)}
            />

            {/* </div>
          <div class="contactmodalBody pt-10"> */}
            <label>Accessories File</label>
            <input
              type="file"
              id="FooterFileUrlUpload"
              name="FooterFileUrlUpload"
              accept="application/pdf"
              multiple
              style={{ color: "transparent" }}
              //onChange={handleFileChange}
              //onChange={(e) => handleFileChange(e, "FooterFileUrl")}
              onChange={(e) => handleChangeMasterFile(e)}
            />
          </div>
          <div class="contactmodalBody pt-10">
            <div> </div>
            <div>
              {currentRow.CoverFileUrl && !currentRow.CoverFileUrlUpload && (
                <div style={{ color: "#666" }}>
                  <ul style={{ paddingLeft: "20px" }}>
                    <li key={0}>
                      {currentRow.CoverFileUrl.length > 15
                        ? `${currentRow.CoverFileUrl.slice(
                            0,
                            6
                          )}...${currentRow.CoverFileUrl.slice(-8)}`
                        : currentRow.CoverFileUrl}
                    </li>
                  </ul>
                </div>
              )}
            </div>
            <div> </div>
            <div>
              {selectedFiles.length > 0 && (
                <div style={{ color: "#666" }}>
                  <ul style={{ paddingLeft: "20px" }}>
                    {selectedFiles.map((fileName, index) => {
                      const displayName =
                        fileName && fileName.length > 15
                          ? `${fileName.slice(0, 6)}...${fileName.slice(-8)}`
                          : fileName;
                      // Server-stored files created via ConvertFileAPI include `_footer_` or `_cover_` in the name
                      const isServerFile = /_(footer|cover)_/.test(fileName || "");
                      const url = getAccessoryFileUrl(fileName);
                      return (
                        <li
                          key={index}
                          style={{ display: "flex", alignItems: "center", gap: "4px" }}
                        >
                          {isServerFile ? (
                            <a
                              href={url}
                              target="_blank"
                              rel="noopener noreferrer"
                              download
                              title={fileName}
                              style={{ textDecoration: "underline", color: "#3366cc" }}
                            >
                              {displayName}
                            </a>
                          ) : (
                            <span title={fileName}>{displayName}</span>
                          )}
                          <button
                            type="button"
                            className="btnDeleteSmall"
                            onClick={() => handleDeleteAccessory(fileName)}
                            title="Delete file"
                            style={{
                              border: "none",
                              background: "transparent",
                              color: "#d33",
                              cursor: "pointer",
                              padding: "0 2px",
                              lineHeight: 1,
                              minWidth: "2px",
                            }}
                          >
                            ✕
                          </button>
                        </li>
                      );
                    })}
                  </ul>
                </div>
              )}
            </div>
          </div>

          <div class="modalItem">
            {/* <Button
              label={"Report Generate"}
              class={"btnClose"}
              onClick={PDFGenerate}
            /> */}
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

export default InspectionReportEntryAddEditModal;
