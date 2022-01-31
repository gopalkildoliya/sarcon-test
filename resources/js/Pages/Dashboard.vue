<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Event Sessions
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 bg-white overflow-hidden">
                <div class="py-4 border-b" v-for="session in sessions">

                    <div class="flex flex-col md:flex-row md:space-x-8 justify-between md:items-center">
                        <div class="text-center basis-1/4">
                            <a href="/event-session/join" target="_blank" v-if="session.audience_can_join" class="cursor-pointer inline-flex items-center px-4 py-2 border border-blue-300 rounded-md font-semibold text-xs text-blue-700 tracking-widest active:bg-gray-50 hover:bg-gray-50 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-300 disabled:opacity-25 transition">
                                Join as audience
                            </a>
                        </div>
                        <div class="order-first md:order-none text-center basis-2/4">
                            <div class="text-center text-2xl py-2 font-bold">
                                {{session.name}}
                            </div>
                            <div class="font-semibold">{{session.detail}}</div>
                            <div class="italic py-4 items-start flex space-x-2 justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>
                                      {{session.speaker}}, {{session.speaker_designation}}, {{session.speaker_company}}
                                </span>
                            </div>
                        </div>
                        <div class="text-center basis-1/4">
                            <div>
                                {{session.time}}
                                <br>
                                UAE (GMT+4)
                            </div>
                            <div class="flex justify-center">
                                <img :src="session.speaker_image" alt="Speaker" class="w-24 h-24 rounded-full">
                            </div>

                            <div class="flex justify-center py-2">

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" viewBox="0 0 20 20" fill="currentColor" v-for="count in session.rating">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300" viewBox="0 0 20 20" fill="currentColor" v-for="count in 5 - session.rating">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>
                            <div class="py-4">
                                <button class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700  tracking-widest hover:bg-gray-300 active:bg-gray-300 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                                    Add to Calender
                                </button>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import Welcome from '@/Jetstream/Welcome.vue'

    export default defineComponent({
        components: {
            AppLayout,
            Welcome,
        },
        data() {
            return {
                sessions: []
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
            setupEcho() {
                console.log('Subscribing to events')
                window.Echo.channel('events')
                    .listen('.event.status.changed', (e) => {
                        console.log(e);
                        this.sessions = this.sessions.map(item => {
                            if (item.id == e.id) {
                                return {...item, ...e}
                            }
                            return item
                        })
                    });
            },
            leaveEcho() {
                Echo.leave('events');
            }
        },
        created() {
            this.getEventSessions();
            this.setupEcho();
        },
        beforeUnmount() {
            this.leaveEcho()
        }
    })
</script>
