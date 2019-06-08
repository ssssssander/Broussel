<template>
    <a-locale-provider :locale="nl_BE">
        <div class="site">
            <template v-if="$auth.ready()">
                <Header></Header>
                <main>
                    <div class="wrapper">
                        <router-view></router-view>
                    </div>
                </main>
            </template>
        </div>
    </a-locale-provider>
</template>

<script lang="ts">
    import { Component, Vue} from 'vue-property-decorator';
    import nl_BE from 'ant-design-vue/lib/locale-provider/nl_BE';

    @Component
    export default class Site extends Vue {
        name: string = 'Site';
        nl_BE: any = nl_BE;
    }
</script>

<style lang="scss" scoped>

</style>
