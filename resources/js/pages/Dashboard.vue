<template>
    <div class="dashboard fullscreen">
        <div class="white-bg">
            <div class="card">
                <span>+</span>
                <p>Nieuwe afspraak</p>
            </div>
            <div class="chats">
                <h2>Chats</h2>
            </div>
            <div class="card">
                <span>+</span>
                <p>Nieuwe afspraak</p>
            </div>
            <div class="chats">
                <h2>Chats</h2>
            </div>
            <div class="card">
                <span>+</span>
                <p>Nieuwe afspraak</p>
            </div>
            <div class="chats">
                <h2>Chats</h2>
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

        mounted() {

        }
    }
</script>

<style lang="scss" scoped>
    .white-bg {
        display: flex;
        flex-flow: row wrap;
        justify-content: space-around;
    }
    .card {
        width: 45%;
        min-width: 370px;
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
            font-size: 1.5em;
        }
    }
    .chats {
        width: 45%;
        min-width: 370px;
        padding: 10px;
        height: 300px;
        border: $light-border;
        border-radius: $default-border-radius;
        margin-top: 20px;

        h2 {
            border-bottom: $light-border;
            display: block;
        }
    }
</style>
