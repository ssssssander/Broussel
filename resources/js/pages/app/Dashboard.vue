<template>
    <div class="dashboard">
        <router-link :to="{ name: 'buddy-detail', params: { id: 1 } }" class="link">Buddy detail</router-link>
            <div class="card" @click="toBuddy">
                <span>+</span>
                <p>Nieuwe wandeling</p>
            </div>
<!--        <div class="dashboard-inner">-->
<!--            <div class="card" @click="toBuddy">-->
<!--                <span>+</span>-->
<!--                <p>Nieuwe afspraak</p>-->
<!--            </div>-->
<!--            <div class="chats">-->
<!--                <h3>Chats</h3>-->
<!--            </div>-->
<!--        </div>-->
        <!--            <div class="chats">-->
        <!--                <div class="chat-block">-->
        <!--                    <span class="avatar"></span>-->
        <!--                    <p class="name">Bart</p>-->
        <!--                    <p class="last-message">Hoi</p>-->
        <!--                    <time datetime="2008-02-14 11:54">11:54</time>-->
        <!--                </div>-->
        <!--            </div>-->
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';

    @Component
    export default class Dashboard extends Vue {
        name: string = 'Dashboard';

        toBuddy() {
            this.$router.push({ name: 'find-buddies' });
        }
    }
</script>

<style lang="scss" scoped>
    .card {
        width: 100%;
        min-width: 240px;
        background-color: $primary-accent-color;
        padding: 10px;
        border-radius: $default-border-radius;
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-flow: column nowrap;
        box-shadow: $box-shadow;

        span, p {
            color: $light-color;
        }

        span {
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 8em;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background-color: $light-primary-accent-color;
        }

        p {
            font-size: 1.3em;
        }
    }

    // ?
    /*
    .dashboard-inner {
        display: flex;
        flex-flow: row wrap;
        justify-content: space-between;
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
    */
</style>
