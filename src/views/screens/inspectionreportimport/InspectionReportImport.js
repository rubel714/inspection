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
const InspectionReportImport = (props) => {
  const serverpage = "invoiceupload"; // this is .php server page

  const { useState } = React;
  const { isLoading, data: dataList, error, ExecuteQuery } = ExecuteQueryHook(); //Fetch data
  const UserInfo = LoginUserInfo();

  const classes = useStyles();
  const [selectedFile, setSelectedFile] = useState(null);
  const [toggleShowTable, setToggleShowTable] = useState(false);
  const [loading, setLoading] = useState(false);
  

  


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
        action: "dataAddEdit",
        lan: language(),
        UserId: UserInfo.UserId,
        rowData: selectedFile,
      };

      setLoading(true); //Show loader
      apiCall.post(serverpage, { params }, apiOption()).then((res) => {
        props.openNoticeModal({
          isOpen: true,
          msg: res.data.message,
          msgtype: res.data.success,
        });

        if (res.data.success === 1) {
          setToggleShowTable(true);
          setLoading(false); //Hide loader
        }
      });
    } else {
      props.openNoticeModal({
        isOpen: true,
        msg: "Please select file",
        msgtype: 0,
      });
    }
  }
 

  return (
    <>
      <div class="bodyContainer">

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
                    // padding: "12px 8px", // vertical padding increases height
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
                  label={"Invoice Upload"}
                  class={"btnAdd"}
                  onClick={handleUpload}
                />
              </Grid>
            </Paper>
          </div>
      

      </div>
    </>
  );
};

export default InspectionReportImport;
