<template>
    <div class="buddy-detail">
        <div class="head">
            <img class="avatar avatar-large" :src="selectedBuddy.avatar_path" :alt="selectedBuddy.name">
            <div class="name">
                <h2>{{ selectedBuddy.name }}</h2>
                <p>{{ 'vue.languages' | trans }}:
                    <span v-for="lang in langsWhereKnows">
                        <a-divider type="vertical" />{{ 'vue.' + lang.name | trans }}
                    </span>
                </p>
            </div>
        </div>
        <a-divider />
        <p>{{ selectedBuddy.info }}</p>
        <template v-if="payment">
            <a-divider />
            <h3>{{ 'vue.walk_with' | trans({ name: selectedBuddy.name }) }}</h3>
            <p v-html="$options.filters.trans('vue.on_from_until_for', { day: finalDate, from: finalFromTime, to: finalToTime, price: selectedBuddy.price })"></p>
            <p>{{ 'vue.chat_afterwards' | trans }}</p>
            <PaymentButtons
                :selected-buddy="selectedBuddy"
                :final-date="finalDate"
                :final-from-time="finalFromTime"
                :final-to-time="finalToTime"
            />
        </template>
        <a-divider />
        <h3>{{ 'vue.all_available_times' | trans({ name: selectedBuddy.name }) }}</h3>
        <AvailableTimesTable :available-times="JSON.parse(selectedBuddy.available_times)" />
    </div>
</template>

<script lang="ts">
    import { Component, Prop, Vue } from 'vue-property-decorator';
    
    @Component
    export default class BuddyDetail extends Vue {
        @Prop() selectedBuddy: any;
        @Prop(Boolean) payment: boolean;
        @Prop(String) finalDate: string;
        @Prop(String) finalFromTime: string;
        @Prop(String) finalToTime: string;

        name: string = 'BuddyDetail';
        langs: any = [
            {
                name: 'nl',
                knows: this.selectedBuddy.nl,
            },
            {
                name: 'fr',
                knows: this.selectedBuddy.fr,
            },
            {
                name: 'en',
                knows: this.selectedBuddy.en,
            },
        ];
        langsWhereKnows: any = this.langs.filter((lang: any) => lang.knows);
    }
</script>

<style lang="scss" scoped>
    .buddy-detail {
        display: inline-flex;
        vertical-align: top;
        flex-flow: column wrap;
        width: 66%;
        padding: 30px;

        h3 {
            margin-bottom: 24px;
        }
        .head {
            display: flex;
            flex-flow: row wrap;
            align-items: center;

            .name {
                margin-left: 30px;
            }
        }
    }
</style>
