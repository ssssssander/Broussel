<template>
    <div class="find-buddies">
        <Message
            v-if="!success"
            message-type="error"
            :messages="errors"
            :extra-str="errorType"
        />
        <form @submit.prevent="findBuddies" method="post">
            <a-date-picker
                @change="onChangeDate"
                size="large"
                :disabledDate="disabledDate"
                format="DD/MM/YYYY"
                :showToday="false"
                :allowClear="false"
            />
            <a-time-picker
                @change="onChangeFromTime"
                :open.sync="isFromTimePickerOpen"
                size="large"
                format="HH:mm"
                :allowEmpty="false"
                inputReadOnly
                :defaultOpenValue="$moment().add(2, 'hours').startOf('hour')"
                :disabledHours="disabledHours"
                :disabledMinutes="disabledMinutes"
                :minuteStep="5"
                placeholder="Van"
                :disabled="isFromTimePickerDisabled"
            >
                <button slot="addon" slot-scope="panel" class="btn btn-time-picker" @click="handleClose">Ok</button>
            </a-time-picker>
            <a-time-picker
                @change="onChangeToTime"
                :open.sync="isToTimePickerOpen"
                size="large"
                format="HH:mm"
                :allowEmpty="false"
                inputReadOnly
                :defaultOpenValue="moment($store.state.selectedFromTime, 'HH:mm').add(2, 'hours').startOf('hour')"
                :disabledHours="disabledHours"
                :disabledMinutes="disabledMinutes"
                :minuteStep="5"
                placeholder="Tot"
                :disabled="isToTimePickerDisabled"
            >
                <button slot="addon" slot-scope="panel" class="btn btn-time-picker" @click="handleClose">Ok</button>
            </a-time-picker>
            <LoadingButton value="Zoek naar wandelbuddies" :loading="loading" />
        </form>
        <div v-if="success" class="buddies">
            <div class="side">
                <input type="search" v-model="search" placeholder="Zoeken op naam">
                <ul>
                    <li v-for="buddy in filteredBuddies" @click="selectBuddy(buddy)" :class="{ active: buddy == selectedBuddy }">
                        <a-skeleton active avatar :title="false" :paragraph="{ rows: 1, width: [250, 250] }" :loading="loading">
                            <div>
                                <img :src="buddy.avatar_path" :alt="buddy.name">
                                <span class="name">{{ buddy.name }}</span>
                                <span class="icon"><a-icon type="right" /></span>
                            </div>
                        </a-skeleton>
                    </li>
                </ul>
            </div>
            <div class="detail">
                <template v-if="Object.keys(selectedBuddy).length">
                    <div class="head">
                        <img :src="selectedBuddy.avatar_path" :alt="selectedBuddy.name">
                        <h2>{{ selectedBuddy.name }}</h2>
                    </div>
                    <a-divider />
                    <p>{{ selectedBuddy.info }}</p>
                    <div v-for="buddyInfo in JSON.parse(selectedBuddy.available_times)">
                        <p>{{ buddyInfo.day }}: {{ buddyInfo.from }} tot {{ buddyInfo.to }}</p>
                    </div>
                    <button class="btn" @click="">Wandelen maar! (€ {{ selectedBuddy.price }})</button>
                    <PayPal
                        :amount="selectedBuddy.price.toString()"
                        currency="EUR"
                        :client="payPalCredentials"
                        locale="nl_BE"
                        :button-style="payPalButtonStyle"
                        env="sandbox"
                        @payment-authorized="paymentAuthorized"
                        @payment-completed="paymentCompleted"
                        @payment-cancelled="paymentCancelled"
                    />
                    <p>Er worden nog geen kosten in rekening gebracht.</p>
                </template>
                <h2 v-else>Klik op namen om meer info te zien</h2>
            </div>
        </div>
        <h2 v-if="!success & !firstTime">Helaas is er niemand beschikbaar op deze dag en tijdstip.</h2>
        <div class="overlay" v-show="showPaymentModal"></div>
        <div class="payment-modal" v-show="showPaymentModal">
            <div class="box">
                <h3>Wandelen met {{ selectedBuddy.name }}</h3>
                <a class="btn" @click="bancontactPay(selectedBuddy.price)">Bancontact</a>
                <p>Op {{ finalDate }} van {{ finalFromTime }} tot {{ finalToTime }}.</p>
                <p>Je kan hierna met hem/haar chatten om de locatie af te spreken.</p>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    import PayPal from 'vue-paypal-checkout';
    import { PaymentCredentials } from '@/js/payment-credentials';

    @Component({
        components: {
            PayPal,
        }
    })
    export default class FindBuddies extends Vue {
        name: string = 'FindBuddies';
        moment: any = (this as any).$moment;
        isFromTimePickerDisabled: boolean = true;
        isToTimePickerDisabled: boolean = true;
        isFromTimePickerOpen: boolean = false;
        isToTimePickerOpen: boolean = false;
        errors: any = {};
        errorType: string = '';
        loading: boolean = false;
        success: boolean = false;
        availableBuddies: any[] = [];
        selectedBuddy: any = {};
        minutesAfterNowActive: number = 20;
        firstTime: boolean = true;
        search: string = '';
        finalDate: string = '';
        finalFromTime: string = '';
        finalToTime: string = '';
        payPalCredentials: any = PaymentCredentials.PAYPAL;
        payPalButtonStyle: any = {
            label: 'checkout',
            size:  'responsive',
            shape: 'rect',
            color: 'blue',
        };
        stripe: any = Stripe(PaymentCredentials.STRIPE);

        showPaymentModal: boolean = false;

        get filteredBuddies() {
            return this.availableBuddies.filter(availableBuddy => {
                return availableBuddy.name.toLowerCase().includes(this.search.toLowerCase());
            });
        }

        paymentAuthorized() {

        }

        paymentCompleted() {
            this.$http({
                url: `auth/make-appointment`,
                method: 'post',
                data: {
                    user_id: (this as any).$auth.user().id,
                    buddy_id: this.selectedBuddy.id,
                    day: this.moment(this.finalDate, 'DD/MM/YYYY').format('YYYY-MM-DD'),
                    time_from: this.finalFromTime,
                    time_to: this.finalToTime,
                }
            })
            .then((response: any) => {
                this.$message.success('Betaling geslaagd');
            }, (error: any) => {
                this.$message.error('Er is iets misgegaan');
            });
        }

        paymentCancelled() {
            this.$message.warning('Betaling stopgezet');
        }

        created() {
            const sourceId: any = this.$route.query.source;
            const clientSecret: any = this.$route.query.client_secret;
            const amount: any = this.$route.query.amount;

            if (sourceId && clientSecret) {
                this.bancontactPoll(sourceId, clientSecret, parseInt(amount));
            }
        }

        bancontactPoll(sourceId: string, clientSecret: string, amount: number) {
            const MAX_POLL_COUNT = 10;
            let pollCount = 0;

            const pollForSourceStatus = () => {
                this.stripe.retrieveSource({id: sourceId, client_secret: clientSecret}).then(({source}: any) => {
                    if (source.status === 'chargeable') {
                        this.$http({
                            url: `auth/charge-request`,
                            method: 'post',
                            data: {
                                amount: amount,
                                source: sourceId,
                            }
                        })
                        .then((response: any) => {
                            console.log(response);
                            this.$message.success('Betaling geslaagd');
                        }, (error: any) => {
                            console.log(error.response);
                            this.$message.error('Betaling mislukt');
                        });
                    } else if (source.status === 'pending' && pollCount < MAX_POLL_COUNT) {
                        console.log(source);
                        // Try again in a second, if the Source is still `pending`:
                        pollCount += 1;
                        setTimeout(pollForSourceStatus, 1000);
                    } else {
                        // Depending on the Source status, show your customer the relevant message.
                        console.log(source);
                    }
                });
            };
            pollForSourceStatus();
        }

        bancontactPay(amount: number) {
            this.stripe.createSource({
                type: 'bancontact',
                amount: amount,
                bancontact: {
                    preferred_language: 'nl',
                },
                currency: 'eur',
                owner: {
                    name: 'Jenny Rosen',
                },
                redirect: {
                    return_url: 'http://localhost:3000/app/find?amount=' + amount,
                },
            }).then((result: any) => {
                // Handle result.error or result.source
                console.log(result);
                window.location.replace(result.source.redirect.url);
            });
        }

        onChangeDate(date: any, dateString: string) {
            this.isFromTimePickerDisabled = false;
            this.$store.commit('setSelectedDate', dateString);
        }

        onChangeFromTime(time: any, timeString: string) {
            this.isToTimePickerDisabled = false;
            this.$store.commit('setSelectedFromTime', timeString);
        }

        onChangeToTime(time: any, timeString: string) {
            this.$store.commit('setSelectedToTime', timeString);
        }

        handleClose(){
            this.isFromTimePickerOpen = false;
            this.isToTimePickerOpen = false;
        }

        disabledDate(current: any) {
            // Enabled between today and 1 year from today
            return current < this.moment().subtract(1, 'days').endOf('day') || current > this.moment().add(1, 'years').endOf('day');
        }

        disabledHours() {
            if (!this.moment().isSame(this.moment(this.$store.state.selectedDate, 'DD/MM/YYYY'), 'day')) {
                return [];
            }

            let hoursToBeDisabled: number[] = [];
            let currentMinute: number = this.moment().minute();
            let currentHour: number = this.moment().hour();
            let minuteDiff = 60 - currentMinute;

            for (let i = 0; i < currentHour + ((minuteDiff < this.minutesAfterNowActive && currentHour != 23) ? 1 : 0); i++) {
                hoursToBeDisabled.push(i);
            }

            return hoursToBeDisabled;
        }

        disabledMinutes(selectedHour: any) {
            if (!this.moment().isSame(this.moment(this.$store.state.selectedDate, 'DD/MM/YYYY'), 'day')) {
                return [];
            }

            let minutesToBeDisabled: number[] = [];
            let currentMinute: number = this.moment().minute();
            let currentHour: number = this.moment().hour();
            let minuteDiff = 60 - currentMinute;

            if (selectedHour - 1 == currentHour && minuteDiff < this.minutesAfterNowActive) {
                for (let i = 0; i < (this.minutesAfterNowActive - minuteDiff); i++) {
                    minutesToBeDisabled.push(i);
                }
            }
            else if (selectedHour == currentHour) {
                for (let i = 0; i < currentMinute + this.minutesAfterNowActive; i++) {
                    minutesToBeDisabled.push(i);
                }
            }

            return minutesToBeDisabled;
        }

        findBuddies() {
            this.loading = true;
            this.selectedBuddy = {};

            // Debug
            this.$store.state.selectedDate = '17/06/2019';
            this.$store.state.selectedFromTime = '09:00';
            this.$store.state.selectedToTime = '15:00';

            this.$http({
                url: `auth/find-buddies`,
                method: 'post',
                data: {
                    date: this.$store.state.selectedDate,
                    from: this.$store.state.selectedFromTime,
                    to: this.$store.state.selectedToTime,
                }
            })
            .then((response: any) => {
                this.success = true;
                this.availableBuddies = response.data.available_buddies_data;
                this.finalDate = this.$store.state.selectedDate;
                this.finalFromTime = this.$store.state.selectedFromTime;
                this.finalToTime = this.$store.state.selectedToTime;

                if (this.availableBuddies.length == 0) {
                    this.$message.info('Niemand gevonden');
                    this.success = false;
                }
                else {
                    this.$message.success('Er zijn wandelbuddies gevonden!');
                }
            }, (error: any) => {
                this.success = false;
                this.$message.error('Niet alle velden zijn juist ingevuld!');

                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                }
                else {
                    this.errorType = error.response.status + ' ' + error.response.statusText;
                }

                document.getElementsByTagName('h1')[0].scrollIntoView();
            })
            .then(() => {
                this.loading = false;
                this.firstTime = false;
            });
        }

        selectBuddy(buddy: any) {
            this.selectedBuddy = buddy;
        }
    }
</script>

<style lang="scss">
    .find-buddies .ant-calendar-picker, .find-buddies .ant-time-picker {
        display: block;
        width: 50%;
        margin-top: 15px;
    }
</style>

<style lang="scss" scoped>
    form {
        margin-bottom: 30px;

        .btn {
            width: 50%;
            margin-top: 15px;
        }
    }
    img {
        border-radius: 50%;
        background-color: $dark-color;
    }
    .buddies {
        padding: 15px;
        border: $light-border;

        .side {
            display: inline-block;
            width: 33%;

            input[type="search"] {
                width: 100%;
            }
            ul {
                margin-top: 20px;

                li {
                    display: block;
                    cursor: pointer;
                    padding: 0 10px;
                    border-bottom: $light-border;
                    margin: 10px 0;

                    &:hover, &.active {
                        color: $dark-primary-accent-color;
                    }
                    img, .name, .icon {
                        vertical-align: middle;
                    }
                    img {
                        width: 20px;
                        height: 20px;
                    }
                    .name {
                        margin-left: 5px;
                    }
                    .icon {
                        float: right;
                    }
                }
            }

        }
        .detail {
            display: inline-flex;
            vertical-align: top;
            flex-flow: column wrap;
            width: 66%;
            padding: 30px;

            .head {
                display: flex;
                flex-flow: row wrap;
                align-items: center;

                h2 {
                    margin-left: 30px;
                }
            }
            img {
                width: 200px;
                height: 200px;
            }
        }
    }
    @media screen and (max-width: 900px) {
        .find-buddies .ant-calendar-picker, .find-buddies .ant-time-picker, form .btn {
            width: 100%;
        }
    }
</style>
