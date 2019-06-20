<template>
    <div class="app box">
        <div class="user-links">
            <ul v-if="$auth.check('user') || $auth.check('buddy')">
                <li v-if="$auth.check('user')">
                    <router-link :to="{ name: 'dashboard' }">{{ 'vue.dashboard' | trans }}</router-link>
                </li><li v-if="$auth.check('user')">
                    <router-link :to="{ name: 'find-buddies' }">{{ 'vue.new_walk' | trans }}</router-link>
                </li><li>
                    <router-link :to="{ name: 'chats' }">{{ 'vue.chats' | trans }}</router-link>
                </li><li>
                    <router-link :to="{ name: 'calendar' }">{{ 'vue.calendar' | trans }}</router-link>
                </li><li>
                    <router-link :to="{ name: 'settings' }">{{ 'vue.settings' | trans }}</router-link>
                </li>
            </ul>
            <ul v-if="$auth.check('admin')">
                <li>
                    <router-link :to="{ name: 'judge-buddies' }">{{ 'vue.judge' | trans }}</router-link>
                </li><li>
                    <router-link :to="{ name: 'settings' }">{{ 'vue.settings' | trans }}</router-link>
                </li>
            </ul>
        </div>
        <div class="app-content">
            <div class="title">
                <h1>{{ $route.meta['title_' + $lang.getLocale()] }}</h1>
                <div class="user-data">
                    <div>
                        <p>{{ 'vue.logged_in_as' | trans({ name: $auth.user().name }) }}<span v-if="$auth.check('buddy')" class="badge">{{ 'vue.walking_buddy' | trans }}</span></p>
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
    
    @Component
    export default class App extends Vue {
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
            min-width: 140px;
            flex: 1;

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
