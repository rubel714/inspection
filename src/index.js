import React, { Suspense } from "react";
import ReactDOM from "react-dom";
import { BrowserRouter, Route, Switch, Redirect } from "react-router-dom";

import "assets/css/main.css";
import "assets/css/modal.css";
import "assets/css/header.css";
import "assets/js/include.js";
import "assets/js/modal.js";

// pages for this kit
import Index from "views/Index.js";
import LoginPage from "views/screens/LoginPage.js";
// import SignUpPage from "views/screens/SignUp.js";
// import ResetPassword from "views/screens/ResetPasswordPage";
// import DashboardPage from "views/screens/DashboardPage";
import MyProfile from "views/screens/myprofile/index.js";
import CheckPermission from "views/screens/CheckPermission.js";
import Dashboard from "views/screens/dashboard/index.js";
import BusinessLine from "views/screens/businessline/index.js";
import Customer from "views/screens/customer/index.js";
import UserEntry from "views/screens/userentry/index.js";
import Team from "views/screens/team/index.js";
import Designation from "views/screens/designation/index.js";
import Department from "views/screens/department/index.js";
import Categories from "views/screens/categories/index.js";
import CheckList from "views/screens/checklist/index.js";
import UserRole from "views/screens/userrole/index.js";
import RoleToMenuPermission from "views/screens/roletomenupermission/index.js";
import AuditLog from "views/screens/auditlog/index.js";
import ErrorLog from "views/screens/errorlog/index.js";
import InspectionReportEntry from "views/screens/inspectionreportentry/index.js";
import UserContextProvider from './context/user-info-context';

// import { QueryClient, QueryClientProvider, useQuery } from 'react-query';

// const queryClient = new QueryClient()

const loading = (
  <div className="pt-3 text-center">
    <div className="sk-spinner sk-spinner-pulse"></div>
  </div>
);

let userInfo = null;

userInfo = {
  FacilityId: 0,
  FacilityName: 'NA',
  LangId: 'en_GB'
};

ReactDOM.render(
  <UserContextProvider userInfo={userInfo}>
    {/* <QueryClientProvider client={queryClient}> */}
      <BrowserRouter basename={process.env.REACT_APP_BASE_NAME}>
        <Suspense>
          <Switch>

            <Route path="/home" render={(props) => <Index {...props} />} />
            <Route path="/login" render={(props) => <LoginPage {...props} />} />
            {/* <Route path="/signup" render={(props) => <SignUpPage {...props} />} /> */}
            {/* <Route path="/reset-password" render={(props) => <ResetPassword {...props} />} /> */}
            {/* <Route path="/dashboard" render={(props) => <DashboardPage {...props} />} /> */}
      			<Route path="/myprofileweb" render={(props) => <MyProfile {...props} />} />
            <Route path="/check-permission" render={(props) => <CheckPermission {...props} />} />

            <Route path="/dashboard" render={(props) => <Dashboard {...props} />} />

            <Route path="/businessline" render={(props) => <BusinessLine {...props} />} />
            <Route path="/customer" render={(props) => <Customer {...props} />} />
            <Route path="/userentry" render={(props) => <UserEntry {...props} />} />
            <Route path="/team" render={(props) => <Team {...props} />} />
            <Route path="/designation" render={(props) => <Designation {...props} />} />
            <Route path="/department" render={(props) => <Department {...props} />} />
            <Route path="/categories" render={(props) => <Categories {...props} />} />
            <Route path="/checklist" render={(props) => <CheckList {...props} />} />
            <Route path="/userrole" render={(props) => <UserRole {...props} />} />
            <Route path="/roletomenupermission" render={(props) => <RoleToMenuPermission {...props} />} />
            <Route path="/auditlog" render={(props) => <AuditLog {...props} />} />
            <Route path="/errorlog" render={(props) => <ErrorLog {...props} />} />
            <Route path="/inspectionreportentry" render={(props) => <InspectionReportEntry {...props} />} />
            <Route path="/" render={(props) => <Index {...props} />} />

          </Switch>
        </Suspense>
      </BrowserRouter>
    {/* </QueryClientProvider> */}
  </UserContextProvider>,
  document.getElementById("root")
);
