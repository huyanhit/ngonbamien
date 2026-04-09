const APP_FRONTEND_URL  = 'http://ngonbamien.local';
const APP_API_URL       = 'http://ngonbamien.local';

const APP_PUSH_SOCKET   = 'push-socket';
const APP_JOIN_CHANNEL  = 'join_channel';
const APP_LEAVE_ROOM    = 'leave_channel'
const APP_DISCONNECT    = 'disconnect';
const SOCKET_KEY        = 'abc';
const API_GET_AUTH      = APP_API_URL+'/get-auth';
const API_GET_MY_ROOM   = APP_API_URL+'/chat/get-my-rooms';
const API_JOIN_ROOM     = APP_API_URL+'/chat/join-room';

import { createServer } from "http";
import { Server } from "socket.io";
import express from "express";
import axios  from 'axios';

import fs  from 'fs';
const privateKey  = fs.readFileSync('./cert/server.key');
const certificate = fs.readFileSync('./cert/server.crt');
const credentials = {key: privateKey, cert: certificate};

const app = express();
const httpServer = createServer(credentials, app);
const io = new Server(httpServer, {
    cors: {
        origin: APP_FRONTEND_URL,
        credentials: true
    }
});

let auth = [], infos = [], token
io.use(async function(socket, next) {
    token = socket.request.headers.authorization;
    if (token.includes('Bearer ')) {
        infos = await axios.get(API_GET_AUTH, {
            headers: {
                Accept: 'application/json',
                Authorization: token
            }
        }).then(res => {
            return res.data;
        }).catch((res)=>{
            console.log('Token is valid'+ token);
            return res.data;
        })
           
        if (infos) {
            auth[socket.id] = token;
            return next();
        }

    } else if (token === SOCKET_KEY) {
        return next();
    }

    return next(new Error("No authorization header"));
});

io.on("connection", async (socket) => {
    if (token === SOCKET_KEY) {
        socket.on(APP_PUSH_SOCKET, pack => {
            console.log('Push data to channel: ' + pack.channel + ' with event: ' + pack.event);
            io.to(pack.channel).emit(pack.event, pack.data);
        })
    } else if (auth[socket.id] === token) {
        if(infos){
            const id = infos.id;
            socket.join('USER_' + id);
            console.log('Join channel: ' + 'USER_' + id);
            if(socket.request.headers.pathname && socket.request.headers.pathname.includes("/chat")){
                axios.get(API_GET_MY_ROOM, {
                    headers: {
                        Accept: 'application/json',
                        Authorization: token
                    }
                }).then(res => {
                    if(res.data.success){
                        const myRooms = res.data.data['MY_ROOM'][id];
                        for (let index in myRooms) {
                            socket.join('ROOM_' + myRooms[index]);
                            console.log('Join channel: ' + 'ROOM_' + myRooms[index]);
                        }
                    }
                })
            }
        }

        socket.on(APP_JOIN_CHANNEL,join => {
            axios.post(API_JOIN_ROOM, { 'room_id': join.room_id }, {
                headers: {
                    Accept: 'application/json',
                    Authorization: auth[socket.id],
                },
            }).then(res => {
                if (res.data.success) {
                    socket.join('ROOM_' + join.room_id);
                    console.log('Join channel room: ' + 'ROOM_' + join.room_id);
                }
            }).catch((error) => {
                console.log(API_JOIN_ROOM +' '+ join.room_id)
                console.log(error.message);
                return false;
            });
        })

        socket.on(APP_LEAVE_ROOM,join => {
            socket.leave('ROOM_' + join.room_id);
            console.log(APP_LEAVE_ROOM +' '+join.room_id)
        })

        socket.on(APP_DISCONNECT, function() {
            delete (auth[socket.id]);
            socket.disconnect();
        });
    }
});

const port = (process.env.PORT || 8081);
httpServer.listen(port,() => console.log('Server running in port ' + port));

app.get('/', (req, res) => {
    res.send("Server running okay.");
})