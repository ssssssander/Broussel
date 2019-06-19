<template>
    <div class="buddy-profile">
        <a-skeleton active avatar :loading="!Object.keys(buddy).length">
            <BuddyDetail
                :selected-buddy="buddy"
            />
        </a-skeleton>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    
    @Component
    export default class BuddyProfile extends Vue {
        name: string = 'BuddyProfile';
        lang = (this as any).$lang;
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
                if (response.data.user_data.role == 'buddy' && response.data.user_data.status == 'accepted') {
                    this.buddy = response.data.user_data;
                    document.title = this.buddy.name + ' - Broussel';
                }
                else {
                    this.$router.replace({ name: 'error404'} );
                }
            }, (error: any) => {
                this.$message.error(this.lang.get('vue.something_went_wrong'));
            });
        }
    }
</script>

<style lang="scss" scoped>
    
</style>
