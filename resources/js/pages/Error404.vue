<template>
    <div class="error-404">
        <div class="box">
            <h1>{{ 'vue.page_doesnt_exist' | trans }}</h1>
            <a-divider></a-divider>
            <img src="@/images/404.png" alt="Error 404">
            <a href="https://icons8.com/ouch/illustration/page-not-found-2" target="_blank" class="link">{{ 'vue.illustration_by' | trans }}</a>
        </div>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';

    @Component
    export default class Error404 extends Vue {
        name: string = 'Error404';
    }
</script>

<style lang="scss" scoped>
    .box {
        padding: 30px 30px 60px 30px;
    }
    h1, a {
        text-align: center;
        display: block;
    }
    img {
        display: block;
        margin: 0 auto;
        width: 100%;
        max-width: 800px;
    }
</style>
