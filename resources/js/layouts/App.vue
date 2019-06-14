<template>
    <div class="app box">
        <div class="user-links">
            <ul>
                <li>
                    <router-link :to="{ name: 'dashboard' }">Dashboard</router-link>
                </li><li>
                    <router-link :to="{ name: 'find-buddies' }">Nieuwe wandeling</router-link>
                </li><li>
                    <router-link :to="{ name: 'walks' }">Mijn wandelingen</router-link>
                </li><li>
                    <router-link :to="{ name: 'chats' }">Chats</router-link>
                </li><li>
                    <router-link :to="{ name: 'calendar' }">Kalender</router-link>
                </li><li>
                    <router-link :to="{ name: 'settings' }">Instellingen</router-link>
                </li>
            </ul>
        </div>
        <div class="app-content">
            <div class="title">
                <h1>{{ $route.meta.title }}</h1>
                <div class="user-data">
                    <div>
                        <p>Ingelogd als {{ $auth.user().name }} <span v-if="$auth.check(1)" class="badge">Wandelbuddy</span></p>
                        <p>{{ $auth.user().email }}</p>
                    </div>
                    <img class="avatar avatar-medium" :src="$auth.user().avatar_path" :alt="$auth.user().name">
                </div>
            </div>
            <router-view></router-view>
        </div>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    // import { State } from 'vuex-class';
    
    @Component
    export default class App extends Vue {
        // @State('userData') user: any;

        name: string = 'App';
    }
</script>

<style lang="scss" scoped>
    .app-content {
        padding: 30px 30px 60px 30px;

        .title {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;

            .user-data {
                text-align: right;
                display: flex;
                align-items: center;
            }
        }
    }
    .avatar {
        margin-left: 15px;
    }
    .user-links {
        border-top-left-radius: $default-border-radius;
        border-top-right-radius: $default-border-radius;
        border-bottom: $light-border;

        ul {
            display: flex;
            flex-flow: row wrap;
            justify-content: center;
            align-items: flex-end;
        }
        li {
            text-align: center;
            width: 16.6%;
            min-width: 140px;

            a {
                width: 100%;
                height: 100%;
                display: block;
                padding: 10px 25px;
                color: $dark-color;
                border-bottom: 2px solid transparent;

                &:hover, &.router-link-exact-active {
                    border-bottom: 2px solid $primary-accent-color;
                }
            }
        }
    }
    @media screen and (max-width: 900px) {
        .app-content .title .user-data {
            display: none;
        }
    }
    @media screen and (max-width: 500px) {
        .user-links li {
            width: 100%;
        }
        .app-content {
            padding: 15px;
        }
    }
</style>
