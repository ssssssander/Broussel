<template>
    <div class="chats">
        <div id="talkjs-container" style="width: 90%; margin: 30px; height: 500px"><i>Loading chat...</i></div>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    
    @Component
    export default class Chats extends Vue {
        name: string = 'Chats';

        mounted() {
            Talk.ready.then(function() {
                var me = new Talk.User({
                    id: "123456",
                    name: "Alice",
                    email: "alice@example.com",
                    photoUrl: "https://demo.talkjs.com/img/alice.jpg",
                    welcomeMessage: "Hey there! How are you? :-)"
                });
                window.talkSession = new Talk.Session({
                    appId: "tXjVxKb4",
                    me: me
                });
                var other = new Talk.User({
                    id: "654321",
                    name: "Sebastian",
                    email: "Sebastian@example.com",
                    photoUrl: "https://demo.talkjs.com/img/sebastian.jpg",
                    welcomeMessage: "Hey, how can I help?"
                });

                var conversation = talkSession.getOrCreateConversation(Talk.oneOnOneId(me, other))
                conversation.setParticipant(me);
                conversation.setParticipant(other);
                var inbox = talkSession.createInbox({selected: conversation});
                inbox.mount(document.getElementById("talkjs-container"));
            });
        }
    }
</script>

<style lang="scss" scoped>
    
</style>
