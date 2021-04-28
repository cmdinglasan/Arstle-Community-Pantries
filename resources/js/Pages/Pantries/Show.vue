<template>
    <dashboard-layout :current="pantry.id">
        <template #header>
            {{ pantry.name }}
        </template>
        <template #content>
            <section class="relative -mx-4">
                <div class="mb-4 relative">
                    <!-- Featured Image -->
                    <div class="featured-image absolute z-0 top-0 left-0 h-44 -m-4" v-if="pantry.featured_image_local || pantry.featured_image_url">
                        <img :src="pantry.featured_image_local" class="w-full h-44 object-cover" v-if="pantry.featured_image_local"/>
                        <img :src="pantry.featured_image_url" class="w-full h-44 object-cover" v-else/>
                    </div>

                    <!-- Main Content -->
                    <div :class="pantry.featured_image_local || pantry.featured_image_url ? 'pt-36' : 'pt-0'">
                        <div class="relative z-10 bg-gray-50 rounded-t-md min-h-16">
                            <section class="relative overflow-x-hidden" :class="pantry.featured_image_local ? 'py-2' : 'pb-2'">
                                <header class="p-4">
                                    <h1 class="text-lg">{{ pantry.name }}</h1>
                                    <span class="text-gray-500 text-sm">Community Pantry</span>
                                </header>
                                <div class="sticky top-16 border-t border-b flex items-start overflow-auto shadow">
                                    <a href="#about" @click.prevent="currentMenu = 'about'" class="block flex-none px-4 pt-1 h-12">
                                        <span class="font-bold uppercase text-xs text-gray-600 block h-11" :class="currentMenu == 'about' ? 'border-b-2 border-blue-500 pt-3' : 'py-3'">About</span>
                                    </a>
                                    <a href="#social" @click.prevent="currentMenu = 'social'" class="block flex-none px-4 pt-1 h-12">
                                        <span class="font-bold uppercase text-xs text-gray-600 block h-11" :class="currentMenu == 'social' ? 'border-b-2 border-blue-500 pt-3' : 'py-3'">Social</span>
                                    </a>
                                </div>
                                <div class="relative">
                                    <div class="relative bg-gray-50" v-show="currentMenu == 'about'">
                                        <div class="relative border-b flex items-start">
                                            <div class="w-16 flex-none text-blue-500 py-4 text-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </div>
                                            <div class="flex-1 py-4 pr-4 pl-2">
                                                <span class="text-sm">
                                                    <span v-if="pantry.address" v-text="pantry.address + ', '"></span>
                                                    <span v-if="pantry.barangay" v-text="pantry.barangay + ', '"></span>
                                                    <span v-if="pantry.city" v-text="pantry.city + ', '"></span>
                                                    <span v-if="pantry.province" v-text="pantry.province"></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="relative border-b flex items-start">
                                            <div class="w-16 flex-none text-blue-500 py-4 text-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                                </svg>
                                            </div>
                                            <div class="flex-1 py-4 pr-4 pl-2">
                                                <span class="text-sm">
                                                    <span v-if="pantry.region" v-text="pantry.region"></span>
                                                </span>
                                            </div>
                                        </div>
                                        <a :href="pantry.contacts[0].contact_num ? 'tel:'+pantry.contacts[0].contact_num : '#'">
                                            <div class="relative border-b flex items-start">
                                                <div class="w-16 flex-none text-blue-500 py-4 text-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                    </svg>
                                                </div>
                                                <div class="flex-1 py-4 pr-4 pl-2">
                                                    <span class="text-sm font-bold" v-if="pantry.contacts[0].name" v-text="pantry.contacts[0].name"></span>
                                                    <span class="text-sm block" v-if="pantry.contacts[0].contact_num" v-text="pantry.contacts[0].contact_num"></span>
                                                </div>
                                            </div>
                                        </a>
                                        <a :href="pantry.source">
                                            <div class="relative border-b flex items-start">
                                                <div class="w-16 flex-none text-blue-500 py-4 text-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </div>
                                                <div class="flex-1 py-4 pr-4 pl-2">
                                                    <span class="text-sm">
                                                        <span v-if="pantry.source" v-text="pantry.source"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="relative bg-gray-50" v-show="currentMenu == 'social'">
                                        <div class="relative border-b flex items-start" v-for="(account, index) in pantry.accounts[0]" v-if="pantry.accounts">
                                            <div class="w-16 flex-none text-blue-500 py-4 text-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <div class="flex-1 py-4 pr-4 pl-2">
                                                <span class="text-sm">
                                                    <a :href="account">
                                                        <span v-if="account" v-text="account"></span>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </section>
        </template>
    </dashboard-layout>
</template>

<script>
import DashboardLayout from '@/Layouts/Dashboard'
export default {
    props: ['pantry'],
    name: "Show",
    data() {
        return {
            activeCard: null,
            currentMenu: 'about',
        }
    },
    components: {
        DashboardLayout,
    },
    methods: {
        setActiveCard(index) {
            if(index === this.activeCard) {
                this.activeCard = null;
            } else {
                this.activeCard = index;
            }
        }
    }
}
</script>

<style scoped>
.featured-image {
    width: calc(100% + 1rem)
}
</style>
