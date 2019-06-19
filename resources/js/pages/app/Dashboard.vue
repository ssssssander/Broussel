<template>
    <div class="dashboard">
            <div class="card" @click="toFindBuddies">
                <span>+</span>
                <p>{{ 'vue.new_walk' | trans }}</p>
            </div>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';

    @Component
    export default class Dashboard extends Vue {
        name: string = 'Dashboard';

        toFindBuddies() {
            this.$router.push({ name: 'find-buddies' } );
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
</style>
