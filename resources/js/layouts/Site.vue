<template>
    <a-locale-provider :locale="antDesignLocale">
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
    import fr_BE from 'ant-design-vue/lib/locale-provider/fr_BE';

    @Component
    export default class Site extends Vue {
        name: string = 'Site';
        antDesignLocale: any = (this as any).$lang.getLocale() == 'nl' ? nl_BE : fr_BE;
    }
</script>

<style lang="scss" scoped>

</style>
