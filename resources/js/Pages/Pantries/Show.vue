<template>
    <dashboard-layout :current="pantry.id">
        <template #header>
            {{ pantry.name }}
        </template>
        <template #content>
            <section class="relative py-4">
                <div class="mb-4">
                    <header class="relative mb-4">
                        <h1 class="font-bold">{{ pantry.region }}</h1>
                    </header>
                    <div class="relative">
                        <div class="relative bg-white shadow rounded-md mb-4">
                            <div class="relative">
                                <button class="relative p-4 w-full flex items-center">
                                    <div class="relative flex-1 text-left overflow-hidden overflow-ellipsis break-all">
                                        <h1 class="font-bold text-lg">{{ pantry.name }}</h1>
                                        <span class="text-sm text-gray-500">{{ pantry.address + ', ' + pantry.barangay + ', ' + pantry.city }}</span>
                                    </div>
                                    <div class="w-6 h-6">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </button>
                            </div>
                            <div class="relative">

                            </div>
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

</style>
