<template>
    <div class="judge-buddies">
        <i v-if="success && !buddiesToBeJudged.length">{{ 'vue.nobody_to_judge' | trans }}</i>
        <a-skeleton active :title="false" :loading="!success">
            <ul v-if="buddiesToBeJudged.length">
                <input type="search" v-model="search" :placeholder="'vue.search_by_name_mail' | trans">
                <li v-for="buddy in filteredBuddies" :id="buddy.id">
                    <div class="info">
                        <div>
                            <span>{{ buddy.name }}</span>
                            <a-divider type="vertical" />
                            <span><a class="link" :href="'mailto:' + buddy.email">{{ buddy.email }}</a></span>
                            <a-divider type="vertical" />
                            <span>{{ buddy.ip_address }}</span>
                        </div>
                        <div class="description">
                            <p>{{ buddy.motivation }}</p>
                            <AvailableTimesTable :available-times="JSON.parse(buddy.available_times)" />
                        </div>
                    </div>
                    <div class="buttons">
                        <button class="btn" @click="setStatus(buddy, 'accepted')"><a-icon type="check-circle" />{{ 'vue.accept' | trans }}</button>
                        <button class="btn btn-danger" @click="setStatus(buddy, 'declined')"><a-icon type="close-circle" />{{ 'vue.decline' | trans }}</button>
                    </div>
                </li>
                <li v-if="!filteredBuddies.length && !firstTime"><i>{{ 'vue.nobody_found' | trans }}</i></li>
            </ul>
        </a-skeleton>
    </div>
</template>

<script lang="ts">
    import { Component, Vue } from 'vue-property-decorator';
    
    @Component
    export default class JudgeBuddies extends Vue {
        name: string = 'JudgeBuddies';
        lang = (this as any).$lang;
        buddiesToBeJudged: any[] = [];
        success: boolean = false;
        search: string = '';

        get filteredBuddies() {
            return this.buddiesToBeJudged.filter(buddyToBeJudged => {
                let normalized = buddyToBeJudged.name.normalize('NFD').replace(/[\u0300-\u036f]/g, "");
                return normalized.toLowerCase().indexOf(this.search.toLowerCase()) > -1 || buddyToBeJudged.email.toLowerCase().indexOf(this.search.toLowerCase()) > -1;
            });
        }

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

                if (this.$route.query.id) {
                    window.setTimeout(() => {
                        window.location.hash = '';
                        window.location.hash = this.$route.query.id.toString();
                    }, 500);
                }
            }, (error: any) => {
                this.$message.error(this.lang.get('vue.something_went_wrong'));
            });
        }

        setStatus(buddy: any, status: string) {
            this.$message.info(this.lang.get('vue.loading'));

            this.$http({
                url: `auth/set-status`,
                method: 'post',
                data: {
                    buddy_id: buddy.id,
                    status: status,
                },
            })
            .then((response: any) => {
                this.$message.success(this.lang.get('vue.' + status, { name: buddy.name }));
                this.getBuddiesToBeJudged();
            }, (error: any) => {
                this.$message.error(this.lang.get('vue.something_went_wrong'));
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
    input[type="search"] {
        margin: 30px 0 0 30px;
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
                flex: 1;

                p {
                    margin-bottom: 15px;
                }
                .description {
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
