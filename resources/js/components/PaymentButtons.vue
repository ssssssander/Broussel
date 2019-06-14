<template>
    <div class="payment-buttons">
        <PayPal
            :amount="selectedBuddy.price.toString()"
            currency="EUR"
            :client="payPalCredentials"
            locale="nl_BE"
            :button-style="payPalButtonStyle"
            env="sandbox"
            @payment-completed="paymentCompleted"
            @payment-cancelled="paymentCancelled"
            class="paypal"
        />
        <img src="~@/images/bancontact-logo.png" class="bancontact" @click="bancontactPay(selectedBuddy.price)">
    </div>
</template>

<script lang="ts">
    import { Component, Prop, Vue } from 'vue-property-decorator';
    import { PaymentCredentials } from '@/js/payment-credentials';
    import PayPal from 'vue-paypal-checkout';

    @Component({
        components: {
            PayPal,
        }
    })
    export default class PaymentButtons extends Vue {
        @Prop() selectedBuddy: any;
        @Prop(String) finalDate: string;
        @Prop(String) finalFromTime: string;
        @Prop(String) finalToTime: string;

        name: string = 'PaymentButtons';
        moment: any = (this as any).$moment;
        payPalCredentials: any = PaymentCredentials.PAYPAL;
        payPalButtonStyle: any = {
            label: 'checkout',
            size:  'responsive',
            shape: 'rect',
            color: 'blue',
        };
        stripe: any = Stripe(PaymentCredentials.STRIPE);

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
                    this.$router.push({ path: 'chats' })
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
    }
</script>

<style lang="scss" scoped>
    .payment-buttons {
        display: flex;
        flex-flow: row wrap;
        justify-content: space-between;
        margin-top: 24px;

        .bancontact, .paypal {
            width: 45%;
        }
        .bancontact {
            align-self: center;
            cursor: pointer;
        }
    }
</style>
