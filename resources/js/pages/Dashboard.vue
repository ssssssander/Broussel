<template>
    <div class="dashboard">
        <div class="box">
            <p>{{ user.name }}</p>
            <p>{{ user.email }}</p>
            <div class="dashboard-inner">
                <div class="card" @click="c">
                    <span>+</span>
                    <p>Nieuwe afspraak</p>
                </div>
                <div class="chats">
                    <h3>Chats</h3>
                </div>
            </div>
<!--            <div class="chats">-->
<!--                <div class="chat-block">-->
<!--                    <span class="avatar"></span>-->
<!--                    <p class="name">Bart</p>-->
<!--                    <p class="last-message">Hoi</p>-->
<!--                    <time datetime="2008-02-14 11:54">11:54</time>-->
<!--                </div>-->
<!--            </div>-->
        </div>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';

    @Component
    export default class Dashboard extends Vue {
        name: string = 'Dashboard';
        user: object = {};

        c() {
            this.$message.success('Nieuwe afspraak');
            this.$notification.open({
                message: 'Nieuwe afspraak',
                description: 'Nieuwe afspraak',
            });
        }

        created() {
            this.getUser();
        }

        getUser() {
            this.$http({
                url: `auth/user`,
                method: 'GET'
            })
            .then((response: any) => {
                this.user = response.data.user_data;
            }, (error: any) => {
                this.$message.error('Er is iets misgegaan bij het ophalen van je gegevens');
            });
        }
    }
</script>

<style lang="scss" scoped>
    .dashboard-inner {
        display: flex;
        flex-flow: row wrap;
        justify-content: space-between;
    }
    .card {
        width: 55%;
        min-width: 240px;
        height: 250px;
        background-color: $primary-accent-color;
        padding: 10px;
        border-radius: $default-border-radius;
        cursor: pointer;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        flex-flow: column nowrap;
        box-shadow: $box-shadow;
        margin-top: 20px;

        span {
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 8em;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background-color: $light-primary-accent-color;
            color: $light-color;
        }
        p {
            color: $light-color;
            font-size: 1.3em;
        }
    }
    .chats {
        width: 43%;
        min-width: 240px;
        padding: 10px;
        height: 300px;
        border: $light-border;
        border-radius: $default-border-radius;
        margin-top: 20px;

        h3 {
            border-bottom: $light-border;
        }
    }
</style>
