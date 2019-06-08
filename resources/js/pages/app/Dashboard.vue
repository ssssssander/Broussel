<template>
    <div class="dashboard">
        <a-skeleton active :title="false" :paragraph="{ rows: 2, width: [250, 250] }" :loading="!Object.keys(user).length">
            <div>
                <p>{{ user.name }}</p>
                <p>{{ user.email }}</p>
            </div>
        </a-skeleton>
        <router-link :to="{ name: 'calendar' }" class="link">Kalender</router-link>
        <router-link :to="{ name: 'buddy-detail', params: { id: 1 } }" class="link">Buddy detail</router-link>
        <div class="dashboard-inner">
            <div class="card" @click="toBuddy">
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
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    import { State } from 'vuex-class';

    @Component
    export default class Dashboard extends Vue {
        @State('userData') user: any;

        name: string = 'Dashboard';

        toBuddy() {
            this.$router.push({ name: 'find-buddies' });
        }

        mounted() {
            let skeletonBlock: any = document.querySelector('.ant-skeleton-paragraph li');
            if (skeletonBlock) skeletonBlock.style.display = 'block';
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
