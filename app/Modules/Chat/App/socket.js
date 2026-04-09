import { io } from "socket.io-client";
const VITE_APP_API_SOCKET = 'localhost:8081'
const URL          = VITE_APP_API_SOCKET;
const pathname     = window.location.pathname;

let ioSocket = null
function connect(){
    let tokenBearer  = document.querySelector("meta[name='api-token']")?.getAttribute('content');
    let tokenCbox    = localStorage.getItem("cbox_token");
    let token        = tokenBearer? "Bearer " + tokenBearer: tokenCbox? "Cbox " + tokenCbox: 'Cbox ';

    if(VITE_APP_API_SOCKET){
        ioSocket = io(URL, {
            extraHeaders: {
                Authorization: token,
                Pathname: pathname
            }
        });
    }
}

connect();
export const socket = ioSocket
