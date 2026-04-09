<template>
    <div class="container">
        <div v-if="!error">
            <div id="remote-container"></div>
            <div id="local-container"></div>
        </div>
        <div v-else class="p-3 text-center">
            {{ error.message }}
        </div>
    </div>
</template>

<script setup>
    import { onMounted, ref } from 'vue'

    //import { UserAgent } from "@apizee/apirtc";
    const con  = ref(null)
    const name = ref('Huyla')
    const error = ref(null)
    const getOrCreateConversation = function(){
        /* var localStream = null;
        //==============================
        // 1/ CREATE USER AGENT
        //==============================
        var ua = new UserAgent({
            uri: "apzkey:3d4c3b3bd60cb0df31a4d72e2868daeb",
        });
        //==============================
        // 2/ REGISTER
        //==============================
        ua.register().then((session) => {
            //==============================
            // 3/ CREATE CONVERSATION
            //==============================
            const conversation = session.getConversation(name.value);
            con.value = conversation;
            //==========================================================
            // 4/ ADD EVENT LISTENER : WHEN NEW STREAM IS AVAILABLE IN CONVERSATION
            //==========================================================
            conversation.on("streamListChanged", (streamInfo) => {
                console.log("streamListChanged :", streamInfo);
                if (streamInfo.listEventType === "added") {
                    if (streamInfo.isRemote === true) {
                        conversation
                            .subscribeToMedia(streamInfo.streamId)
                            .then((stream) => {
                                console.log("subscribeToMedia success", stream);
                            })
                            .catch((err) => {
                                console.error("subscribeToMedia error", err);
                            });
                    }
                }
            });
            //=====================================================
            // 4 BIS/ ADD EVENT LISTENER : WHEN STREAM IS ADDED/REMOVED TO/FROM THE CONVERSATION
            //=====================================================
            conversation.on("streamAdded", (stream) => {
                    stream.addInDiv(
                        "remote-container",
                        "remote-media-" + stream.streamId,
                        {},
                        false
                    );
                })
                .on("streamRemoved", (stream) => {
                    stream.removeFromDiv(
                        "remote-container",
                        "remote-media-" + stream.streamId
                    );
                });
            //==============================
            // 5/ CREATE LOCAL STREAM
            //==============================
            ua.createStream({
                constraints: {
                    audio: true,
                    video: false,
                },
            }).then((stream) => {
                console.log("createStream :", stream);
                // Save local stream
                localStream = stream;
                stream.removeFromDiv("local-container", "local-media");
                stream.addInDiv("local-container", "local-media", {}, true);
                //==============================
                // 6/ JOIN CONVERSATION
                //==============================
                conversation.join().then((response) => {
                    console.log("Conversation joined", response);
                    //==============================
                    // 7/ PUBLISH LOCAL STREAM
                    //==============================
                    conversation
                        .publish(localStream)
                        .then((stream) => {
                            console.log("published", stream);
                        })
                        .catch((err) => {
                            console.error("publish error", err);
                        });
                })
                .catch((err) => {
                    console.error("Conversation join error", err);
                });
            })
            .catch((err) => {
                error.value = err;
            });
        }); */
    }
    onMounted(()=>{
        getOrCreateConversation()
    })
</script>
