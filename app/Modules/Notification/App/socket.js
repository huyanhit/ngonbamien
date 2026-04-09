import { io } from "socket.io-client";
const VITE_APP_API_SOCKET = 'localhost:8081'
const URL      = process.env.NODE_ENV === "production" ? VITE_APP_API_SOCKET : VITE_APP_API_SOCKET;
const pathname = window.location.pathname;
const token    = document.querySelector("meta[name='api-token']").getAttribute('content');

let ioSocket = null
if(VITE_APP_API_SOCKET){
    ioSocket = io(URL, {
        extraHeaders: {
            Authorization: "Bearer " + token,
            Pathname: pathname
        }
    });
}

export const socket = ioSocket