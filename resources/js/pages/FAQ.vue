<template>
    <div class="faq">
        <h1>{{ 'vue.faq' | trans }}</h1>
        <a-divider></a-divider>
        <a-collapse :bordered="false">
            <a-collapse-panel :header="'vue.faq_title1' | trans" key="1">
                <p>{{ 'vue.faq_text1' | trans }}</p>
            </a-collapse-panel>
            <a-collapse-panel :header="'vue.faq_title2' | trans" key="2">
                <p>{{ 'vue.faq_text2' | trans }}</p>
            </a-collapse-panel>
            <a-collapse-panel :header="'vue.faq_title3' | trans" key="3">
                <p>{{ 'vue.faq_text3' | trans }}</p>
            </a-collapse-panel>
        </a-collapse>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    
    @Component
    export default class FAQ extends Vue {
        name: string = 'FAQ';
    }
</script>

<style lang="scss">
    .ant-collapse {
        font-size: 1em;
    }
    .ant-collapse > .ant-collapse-item > .ant-collapse-header {
        padding: 20px 0 20px 40px;
    }
</style>

<style lang="scss" scoped>
    
</style>
