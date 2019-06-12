<template>
    <div class="buddy-detail">
        <div v-show="Object.keys(buddy).length">
            <img class="avatar avatar-large" :src="buddy.avatar_path" :alt="buddy.name">
            <h1>{{ buddy.name }}</h1>
            <p>{{ buddy.info }}</p>
        </div>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    
    @Component
    export default class BuddyDetail extends Vue {
        name: string = 'BuddyDetail';
        buddy: any = {};

        created() {
            this.getBuddy();
        }

        getBuddy() {
            this.$http({
                url: `auth/get-user/${this.$route.params.id}`,
                method: 'get',
            })
            .then((response: any) => {
                this.buddy = response.data.user_data;
                document.title = this.buddy.name;
            }, (error: any) => {
                this.$message.error('Er is iets misgegaan bij het ophalen van de gegevens');
            });
        }
    }
</script>

<style lang="scss" scoped>
    
</style>
