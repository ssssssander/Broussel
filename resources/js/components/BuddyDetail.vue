<template>
    <div class="buddy-detail">
        <div class="head">
            <img class="avatar avatar-large" :src="selectedBuddy.avatar_path" :alt="selectedBuddy.name">
            <div class="name">
                <h2>{{ selectedBuddy.name }}</h2>
                <p>Talen:
                    <span v-for="(lang, index) in langsWhereKnows">
                        {{ lang.trans }}<a-divider v-if="index != langsWhereKnows.length - 1" type="vertical" />
                    </span>
                </p>
            </div>
        </div>
        <a-divider />
        <p>{{ selectedBuddy.info }}</p>
        <template v-if="payment">
            <a-divider />
            <h3>Wandelen met {{ selectedBuddy.name }}</h3>
            <p>Op {{ finalDate }} van {{ finalFromTime }} tot {{ finalToTime }} voor <strong>€ {{ selectedBuddy.price }}</strong>.</p>
            <p>Je kan hierna met hem/haar chatten om de locatie af te spreken.</p>
            <PaymentButtons
                :selected-buddy="selectedBuddy"
                :final-date="finalDate"
                :final-from-time="finalFromTime"
                :final-to-time="finalToTime"
            />
        </template>
        <a-divider />
        <h3>Alle beschikbare tijden van {{ selectedBuddy.name }}</h3>
        <div v-for="buddyInfo in JSON.parse(selectedBuddy.available_times)">
            <p>{{ buddyInfo.day }}: van {{ buddyInfo.from }} tot {{ buddyInfo.to }}</p>
        </div>
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
                knows: this.selectedBuddy.nl,
                trans: 'Nederlands',
            },
            {
                knows: this.selectedBuddy.fr,
                trans: 'Frans',
            },
            {
                knows: this.selectedBuddy.en,
                trans: 'Engels',
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
