<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Manage Sessions
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white overflow-hidden">
                <div class="py-4 border-b" v-for="session in sessions" :key="session.id">
                    <div class="text-center text-2xl py-2">{{session.name}}</div>
                    <div class="flex flex-col md:flex-row justify-between text-center">
                        <div>
                            {{session.time}}
                        </div>
                        <div>
                            By: {{session.speaker}}
                        </div>
                        <div :class="loading ? 'opacity-25' : ''" class="flex items-center justify-center">
                            <SwitchGroup>
                                <div class="flex items-center">
                                    <SwitchLabel class="mr-4" passive>Audience can join</SwitchLabel>
                            <Switch :disabled="loading"
                                :modelValue="session.audience_can_join"
                                @update:modelValue="changeSessionStatus(session, $event)"
                                :class="session.audience_can_join ? 'bg-green-700' : 'bg-gray-400'"
                                class="relative inline-flex items-center h-6 rounded-full w-11"
                            >
                                <span class="sr-only">Enable notifications</span>
                                <span
                                    :class="session.audience_can_join ? 'translate-x-6' : 'translate-x-1'"
                                    class="inline-block w-4 h-4 transform bg-white rounded-full"
                                />
                            </Switch>
                                </div>
                            </SwitchGroup>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import { Switch, SwitchGroup, SwitchLabel } from '@headlessui/vue'

    import AppLayout from '@/Layouts/AppLayout.vue'
    import Welcome from '@/Jetstream/Welcome.vue'

    export default defineComponent({
        components: {
            Switch,
            SwitchGroup,
            SwitchLabel,
            AppLayout,
            Welcome,
        },
        data() {
            return {
                sessions: [],
                loading: false
            }
        },
        methods: {
            getEventSessions() {
                axios.get('/event-sessions').then(res => {
                    this.sessions = res.data
                }).catch(err => {
                    console.log(err)
                })
            },
            changeSessionStatus(session, status) {
                console.log(status)
                this.loading = true
                axios.post('/event-sessions/'+session.id + '/status', {audience_can_join: status}).then(res => {
                    this.sessions = this.sessions.map(item => {
                        if (item.id == session.id) {
                            return {...item, ...res.data}
                        }
                        return item
                    })
                }).catch(error => {
                    console.log(error)
                }).finally(() => {
                    this.loading = false
                })
            }
        },
        created() {
            this.getEventSessions();
        }
    })
</script>
