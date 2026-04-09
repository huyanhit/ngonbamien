const APP_FRONTEND_URL  = 'http://ngonbamien.local';
const APP_API_URL       = 'http://ngonbamien.local';

const APP_PUSH_SOCKET   = 'push-socket';
const APP_JOIN_CHANNEL  = 'join_channel';
const APP_LEAVE_ROOM    = 'leave_channel'
const APP_DISCONNECT    = 'disconnect';
const SOCKET_KEY        = 'abc';
const API_GET_AUTH      = APP_API_URL+'/get-auth';
const API_GET_CBOX      = APP_API_URL+'/cbox/cbox';
const API_GET_MY_ROOM   = APP_API_URL+'/chat/get-my-rooms';
const API_JOIN_ROOM     = APP_API_URL+'/chat/join-room';

import { createServer } from "http";
import { Server } from "socket.io";
import express from "express";
import axios  from 'axios';

const credentials = {};

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
    if (token.includes('Bearer')) {
        infos = await axios.get(API_GET_AUTH, {
            headers: {
                Accept: 'application/json',
                Authorization: token
            }
        }).then(res => {
            return res.data;
        }).catch(()=>{
            console.log('Token is valid '+ token);
        })
           
        if (infos) {
            auth[socket.id] = token;
            return next();
        }
    }else if (token.includes('Cbox')) {
        return next();
    }else if (token === SOCKET_KEY) {
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
    } 
    if (token.includes('Cbox')) {
        axios.get(API_GET_CBOX, {
            headers: {
                Accept: 'application/json',
                Authorization: 'Bearer '+token.substring(5)
            }
        }).then(res => {
            if (res.data.success) {
                socket.join('CBOX_' + token.substring(5));
                console.log('Join channel Cbox: ' + 'CBOX_' + token.substring(5));
                for (let index in res.data.data) {
                    socket.join('ROOM_' + res.data.data[index]);
                    console.log('Join channel Cbox: ' + 'ROOM_' + res.data.data[index]);
                }
            }
        }).catch(()=>{
            console.log('Token is valid '+ token);
        })

        socket.on(APP_JOIN_CHANNEL, join => {
            axios.get(API_GET_CBOX, {
                headers: {
                    Accept: 'application/json',
                    Authorization: 'Bearer '+ join.token
                }
            }).then(res => {
                if(join.cbox){
                    socket.join('CBOX_' + join.token);
                }
                if (res.data.success) {
                    if(res.data.data.includes(join.room_id)){
                        socket.join('ROOM_' + join.room_id);
                        console.log('Join channel: ' + 'ROOM_' + join.room_id);
                    }
                }
            }).catch((error) => {
                console.log(error.message);
            });
        })
    } 
    if (auth[socket.id] === token) {
        if(infos && infos.data){
            const id = infos.data.id;
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
                console.log(error.message);
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