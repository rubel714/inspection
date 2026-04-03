import React, { useRef, useEffect, useState } from "react";
import { Button } from "../../../components/CustomControl/Button";
import { DragIndicator } from "@material-ui/icons";
import ExecuteQueryHook from "../../../components/hooks/ExecuteQueryHook";
import {
  apiCall,
  apiOption,
  LoginUserInfo,
  language,
} from "../../../actions/api";

const CheckListSortModal = (props) => {
  const serverpage = "inspectionreportentry"; // this is .php server page
  const UserInfo = LoginUserInfo();

  const { isLoading, data: dataList, error, ExecuteQuery } = ExecuteQueryHook();

  const [localRows, setLocalRows] = useState([]);
  const [dragOverIndex, setDragOverIndex] = useState(null);
  const dragItem = useRef(null);
  const dragOverItem = useRef(null);

  React.useEffect(() => {
    getDataList();
  }, []);

  useEffect(() => {
    if (dataList) {
      setLocalRows(dataList);
    }
  }, [dataList]);

  function getDataList() {
    let params = {
      action: "getSingleReportCheckDataList",
      lan: language(),
      UserId: UserInfo.UserId,
      TransactionId: props.currentRow.id,
    };
    ExecuteQuery(serverpage, params);
  }

  function modalClose() {
    props.modalCallback("close");
  }

  const handleDragStart = (index) => {
    dragItem.current = index;
  };

  const handleDragEnter = (index) => {
    dragOverItem.current = index;
    setDragOverIndex(index);
  };

  const handleDragEnd = () => {
    setDragOverIndex(null);
    if (
      dragItem.current === null ||
      dragOverItem.current === null ||
      dragItem.current === dragOverItem.current
    ) {
      dragItem.current = null;
      dragOverItem.current = null;
      return;
    }

    const newRows = [...localRows];
    const [dragged] = newRows.splice(dragItem.current, 1);
    newRows.splice(dragOverItem.current, 0, dragged);

    dragItem.current = null;
    dragOverItem.current = null;

    setLocalRows(newRows);
    saveNewOrder(newRows);
  };

  function saveNewOrder(rows) {
    const orderList = rows.map((row, index) => ({
      id: row.id,
      SortOrder: index + 1,
    }));

    let params = {
      action: "updateCheckListSortOrders",
      lan: language(),
      UserId: UserInfo.UserId,
      orderList: orderList,
    };

    apiCall.post(serverpage, { params }, apiOption());
  }

  return (
    <>
      {/* <!-- GROUP MODAL START --> */}
      <div id="groupModal" className="modal">
        {/* <!-- Modal content --> */}
        <div className="modal-content">
          <div className="modalHeader">
            <h4>Change Checklist Order</h4>
          </div>

          <div className="subContainer tableHeight">
            <div className="App">
              <table className="tableGlobal">
                <thead>
                  <tr>
                    <th style={{ width: "5%", textAlign: "center" }}>SL</th>
                    <th style={{ width: "5%", textAlign: "center" }}></th>
                    <th style={{ textAlign: "left" }}>Check Name</th>
                    <th style={{ textAlign: "left" }}>Category</th>
                  </tr>
                </thead>
                <tbody>
                  {localRows.map((row, index) => (
                    <React.Fragment key={row.id}>
                      {/* Insertion line shown ABOVE the drop target */}
                      {dragOverIndex === index &&
                        dragItem.current !== index && (
                          <tr style={{ height: 0, lineHeight: 0 }}>
                            <td
                              colSpan={4}
                              style={{
                                padding: 0,
                                height: 0,
                                borderTop: "3px solid #3f51b5",
                                boxShadow: "0 -1px 6px rgba(63,81,181,0.5)",
                                position: "relative",
                              }}
                            >
                              {/* Arrow dot on the left */}
                              <span
                                style={{
                                  position: "absolute",
                                  left: -6,
                                  top: -6,
                                  width: 10,
                                  height: 10,
                                  borderRadius: "50%",
                                  background: "#3f51b5",
                                  display: "inline-block",
                                }}
                              />
                            </td>
                          </tr>
                        )}
                      <tr
                        draggable
                        onDragStart={() => handleDragStart(index)}
                        onDragEnter={() => handleDragEnter(index)}
                        onDragEnd={handleDragEnd}
                        onDragOver={(e) => e.preventDefault()}
                        style={{
                          cursor: "grab",
                          opacity: dragItem.current === index ? 0.4 : 1,
                        }}
                      >
                        <td style={{ textAlign: "center" }}>{index + 1}</td>
                        <td style={{ textAlign: "center" }}>
                          <DragIndicator
                            className="table-edit-icon"
                            style={{ cursor: "grab", color: "#888" }}
                          />
                        </td>
                        <td>{row.CheckName}</td>
                        <td>{row.CategoryName}</td>
                      </tr>
                    </React.Fragment>
                  ))}
                </tbody>
              </table>
            </div>
          </div>

          <div className="modalItem">
            <Button label={"Close"} class={"btnClose"} onClick={modalClose} />
          </div>
        </div>
      </div>
      {/* <!-- GROUP MODAL END --> */}
    </>
  );
};

export default CheckListSortModal;
