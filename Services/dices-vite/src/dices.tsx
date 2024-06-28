//import React from 'react'
//import ReactDOM from 'react-dom/client'
//import ReactDOM from 'react-dom'
//import {createRoot} from 'react-dom/client'
//import Login from './components/Login.tsx'
//import Play from './components/Play.tsx';
//const dices_URL = 'http://127.0.0.1:8000';



function setCookie(cname: any, cvalue: any, exdays: any) {
  const d = new Date();
  d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
  let expires = "expires="+d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";SameSite=Strict;" + expires + ";path=/";
}

function getCookie(cname: any) {
  let name = cname + "=";
  let ca = document.cookie.split(';');
  for(let i = 0; i < ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

/*
function checkCookieUser() {
  let user = getCookie("userid");
  if (user != "") {
    alert("Welcome again " + user);
  } else {
    user = prompt("Please enter your name:", "");
    if (user != "" && user != null) {
      setCookie("username", user, 365);
    }
  }
}*/


export {
	getCookie, 
	setCookie,
}
