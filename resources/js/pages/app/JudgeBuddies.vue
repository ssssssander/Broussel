<template>
    <div class="judge-buddies">
        <i v-if="success && !buddiesToBeJudged.length">Niemand om te beoordelen.</i>
        <a-skeleton active :title="false" :loading="!success">
            <ul v-if="buddiesToBeJudged.length">
                <li v-for="buddy in buddiesToBeJudged">
                    <div class="info">
                        <div>
                            <span>{{ buddy.name }}</span>
                            <a-divider type="vertical" />
                            <span><a class="link" :href="'mailto:' + buddy.email">{{ buddy.email }}</a></span>
                        </div>
                        <p>{{ buddy.info }}</p>
                    </div>
                    <div class="buttons">
                        <button class="btn" @click="setStatus(buddy, 'accepted')"><a-icon type="check-circle" />Accepteren</button>
                        <button class="btn btn-danger" @click="setStatus(buddy, 'declined')"><a-icon type="close-circle" />Afwijzen</button>
                    </div>
                </li>
            </ul>
        </a-skeleton>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    
    @Component
    export default class JudgeBuddies extends Vue {
        name: string = 'JudgeBuddies';
        buddiesToBeJudged: any[] = [];
        success: boolean = false;

        created() {
            this.getBuddiesToBeJudged();
        }

        getBuddiesToBeJudged() {
            this.$http({
                url: `auth/get-buddies-to-be-judged`,
                method: 'get',
            })
            .then((response: any) => {
                this.buddiesToBeJudged = response.data.buddies_to_be_judged_data;
                this.success = true;
            }, (error: any) => {
                this.$message.error('Er is iets misgegaan bij het ophalen van de gegevens');
            });
        }

        setStatus(buddy: any, status: string) {
            this.$http({
                url: `auth/set-status`,
                method: 'post',
                data: {
                    buddy_id: buddy.id,
                    status: status,
                },
            })
            .then((response: any) => {
                this.$message.success(`${buddy.name} is ${status}.`);
                this.getBuddiesToBeJudged();
            }, (error: any) => {
                console.log(error.response);
                this.$message.error('Er is iets misgegaan.');
            });
        }
    }
</script>

<style lang="scss" scoped>
    .judge-buddies .anticon {
        margin-right: 10px;

        svg {
            vertical-align: middle;
        }
    }
    ul {
        border: $light-border;
        border-radius: $default-border-radius;

        li {
            padding: 30px;
            border-bottom: $light-border;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;

            .info {
                display: flex;
                flex-flow: column wrap;

                p {
                    flex: 1;
                    padding: 30px;
                }
            }
            .buttons {
                display: flex;

                button {
                    margin-right: 10px;
                }
            }
        }
    }
</style>
