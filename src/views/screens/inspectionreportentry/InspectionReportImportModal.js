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

import {
  Typography,
  Paper,
  Grid,
  Input,
  makeStyles,
  CircularProgress,
} from "@material-ui/core";

const useStyles = makeStyles((theme) => ({
  root: {
    display: "flex",
    justifyContent: "center",
    alignItems: "center",
    padding: "10px",
  },
  paper: {
    padding: theme.spacing(4),
    maxWidth: "50%",
    width: "100%",
  },
}));

const InspectionReportImportModal = (props) => {
  console.log("props modal: ", props);
  const serverpage = "inspectionreportentry"; // this is .php server page
  const [currentRow, setCurrentRow] = useState(props.currentRow);
  const [errorObject, setErrorObject] = useState({}); 
  const UserInfo = LoginUserInfo();
  const classes = useStyles();
  const [loading, setLoading] = useState(false);
   const [selectedFile, setSelectedFile] = useState(null);
  
    const handleFileChange = (e) => {
      let file = e.target.files[0];
      if (file) {
        let reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = (event) => {
          setSelectedFile(event.target.result);
        };
      }
    };
  
    function handleUpload() {
      if (selectedFile) {
        let params = {
          action: "importInspectionReport",
          lan: language(),
          UserId: UserInfo.UserId,
          rowData: selectedFile,
        };
  
        setLoading(true); //Show loader
        apiCall.post(serverpage, { params }, apiOption()).then((res) => {
          props.masterProps.openNoticeModal({
            isOpen: true,
            msg: res.data.message,
            msgtype: res.data.success,
          });
  
          if (res.data.success === 1) {
            setLoading(false); //Hide loader
            importModalCallback();
          }
        });
      } else {
        props.masterProps.openNoticeModal({
          isOpen: true,
          msg: "Please select file",
          msgtype: 0,
        });
      }
    }
   



  function importModalCallback() {
    props.importModalCallback("close");
  }

  return (
    <>
      {/* <!-- GROUP MODAL START --> */}
      <div id="groupModal" class="modal">
        {/* <!-- Modal content --> */}
        <div class="modal-content-reportblock">
          <div class="modalHeader">
            <h4>Import Inspection Report</h4>
          </div>
          
          <div class=" pt-10">
             
               <div className={classes.root}>
            <Paper className={classes.paper} elevation={3}>
              <Typography variant="h5" align="center" gutterBottom>
                Upload a File (.csv)
              </Typography>

              <Input
                type="file"
                onChange={(e) => handleFileChange(e)}
                fullWidth
                className={classes.input}
                inputProps={{
                  style: {
                    height: "100px",
                  },
                }}
              />

              <Grid container justify="center">
                {loading && (
                  <div style={{ textAlign: "center", marginTop: "5px" }}>
                    <CircularProgress size={24} />
                  </div>
                )}

                <Button
                  disabled={loading}
                  label={"Import Inspection Report"}
                  class={"btnAdd"}
                  onClick={handleUpload}
                />
              </Grid>
            </Paper>
          </div>
          </div>
   
          <div class="modalItem">
            <Button label={"Close"} class={"btnClose"} onClick={importModalCallback} />
          </div>
        </div>
      </div>
    </>
  );
};

export default InspectionReportImportModal;
