import Mymenu from "./components/menu";
import MyList from "./components/list"
import "./styles/app.css";

import React from "react";
import ReactDOM from "react-dom/client";



const el = document.getElementById('root');
const root = ReactDOM.createRoot(el);


function App() {
    return (
      <div>
        <Mymenu />
        <div>Hello</div>
        <MyList /> 
      </div>
    
    );
  }

  root.render(<App />);
 
