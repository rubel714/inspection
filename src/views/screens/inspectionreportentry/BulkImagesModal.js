import React, { forwardRef, useRef, useEffect, useState } from "react";
import { Button } from "../../../components/CustomControl/Button";
import { ArrowUpward, ArrowDownward } from "@material-ui/icons";
import ExecuteQueryHook from "../../../components/hooks/ExecuteQueryHook";
import {
  apiCall,
  apiOption,
  LoginUserInfo,
  language,
} from "../../../actions/api";
import CustomTable from "components/CustomTable/CustomTable";

const BulkImagesModal = (props) => {
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
      action: "getBulkImages",
      lan: language(),
      UserId: UserInfo.UserId,
      TransactionId: props.currentRow.id,
      ManyImgPrefix: props.currentRow.ManyImgPrefix,
    };
    // console.log('LoginUserInfo params: ', params);

    ExecuteQuery(serverpage, params);
  }

  function modalClose() {
    // console.log('props modal: ', props);
    //  console.log('props.currentRow.CheckListMaped-------------------: ', props.currentRow.CheckListMaped);
    props.modalCallback("close");
  }

  // const handleDownloadImage = (imageUrl) => {
  //     // const imageUrl = "/images/sample.jpg";   // place image in public/images/

  //     const link = document.createElement("a");
  //     link.href = imageUrl;
  //     link.download = "sample.jpg";   // download file name
  //     document.body.appendChild(link);
  //     link.click();
  //     document.body.removeChild(link);
  //   };

  //   const handleDownloadImage = async (imageUrl) => {
  //     console.log('imageUrl: ', imageUrl);
  //   // const imageUrl = "https://example.com/myimage.png";

  //   const response = await fetch(imageUrl);
  //   const blob = await response.blob();
  //   const url = window.URL.createObjectURL(blob);

  //   const link = document.createElement("a");
  //   link.href = url;
  //   link.download = "myimage.png";   // file name for download
  //   link.click();

  //   window.URL.revokeObjectURL(url);
  // };

  return (
    <>
      {/* <!-- GROUP MODAL START --> */}
      <div id="groupModal" class="modal">
        {/* <!-- Modal content --> */}
        <div class="modal-content">
          <div class="modalHeader">
            <h4>Bulk Images</h4>
          </div>

          {dataList &&
            dataList.map((Item, Idx) => {
              return (
                <>
                  <div className={"bulk-image-block"}>
                    <img
                      // src={
                      //   "http://localhost/inspection/image/transaction/1761323204832/bulkimg/1761323204832_2025_10_28_00_30_06_9200.jpeg"
                      // }
                      src={Item}
                      alt="Photo"
                      className="preview-image"
                    />
                    {/* <Button label={"Download"} class={"btnUpdate"} onClick={()=>handleDownloadImage("http://localhost/inspection/image/transaction/1761323204832/bulkimg/1761323204832_2025_10_28_00_30_06_9200.jpeg")} /> */}
                  </div>
                </>
              );
            })}

          <div class="modalItem">
            <Button label={"Close"} class={"btnClose"} onClick={modalClose} />
          </div>
        </div>
      </div>
      {/* <!-- GROUP MODAL END --> */}
    </>
  );
};

export default BulkImagesModal;
