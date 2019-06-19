<template>
    <div class="chats">
        <div id="talkjs-container">
            <i v-if="!success">{{ 'vue.loading' | trans }}</i>
            <i v-if="success && !Object.keys(buddy).length">{{ 'vue.no_chats' | trans }}</i></div>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    import Talk from 'talkjs';
    
    @Component
    export default class Chats extends Vue {
        name: string = 'Chats';
        lang = (this as any).$lang;
        buddy: any = {};
        success: boolean = false;

        created() {
            this.getChattableBuddy();
        }

        getChattableBuddy() {
            this.$http({
                url: `auth/get-chattable-buddy`,
                method: 'get',
            })
            .then((response: any) => {
                this.success = true;
                this.buddy = response.data.chattable_buddies_data;
                console.log(response);
                this.makeTalkSession();
            }, (error: any) => {
                console.log(error.response);
                this.$message.error(this.lang.get('vue.something_went_wrong'));
            });
        }

        makeTalkSession() {
            Talk.ready.then(() => {
                let me = new Talk.User({
                    id: (this as any).$auth.user().id,
                    name: (this as any).$auth.user().name,
                    email: (this as any).$auth.user().email,
                    photoUrl: (this as any).$auth.user().avatar_path,
                    role: 'buyer',
                    locale: this.lang.getLocale() == 'nl' ? 'nl-NL' : 'fr-FR',
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
                    role: 'seller',
                    locale: this.lang.getLocale() == 'nl' ? 'nl-NL' : 'fr-FR',
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
