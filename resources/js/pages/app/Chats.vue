<template>
    <div class="chats">
        <div id="talkjs-container"><i>Chat laden...</i></div>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    import Talk from 'talkjs';
    
    @Component
    export default class Chats extends Vue {
        name: string = 'Chats';
        buddy: any = {};

        created() {
            this.$http({
                url: `auth/get-user/2`,
                method: 'get',
            })
            .then((response: any) => {
                this.buddy = response.data.user_data;
                this.makeTalkSession();
            }, (error: any) => {
                this.$message.error('Er is iets misgegaan bij het ophalen van de gegevens');
            });
        }

        mounted() {

        }

        makeTalkSession() {
            Talk.ready.then(() => {
                let me = new Talk.User({
                    id: (this as any).$auth.user().id,
                    name: (this as any).$auth.user().name,
                    email: (this as any).$auth.user().email,
                    photoUrl: (this as any).$auth.user().avatar_path,
                    role: 'buyer',
                    locale: 'nl-NL',
                });
                (window as any).talkSession = new Talk.Session({
                    appId: 'tXjVxKb4',
                    me: me,
                });
                let other = new Talk.User({
                    id: this.buddy.id,
                    name: this.buddy.name,
                    email: this.buddy.email,
                    photoUrl: this.buddy.avatar_path,
                    welcomeMessage: 'Wandelen maar!',
                    role: 'seller',
                    locale: 'nl-NL',
                });

                let conversation = (window as any).talkSession.getOrCreateConversation(Talk.oneOnOneId(me, other));
                conversation.setParticipant(me);
                conversation.setParticipant(other);
                let inbox = (window as any).talkSession.createInbox({selected: conversation});
                inbox.mount(document.getElementById('talkjs-container'));
            });
        }
    }
</script>

<style lang="scss" scoped>
    #talkjs-container {
        height: 500px;
    }
</style>
