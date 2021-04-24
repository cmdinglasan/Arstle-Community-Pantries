<template>
    <app-layout>
        <div class="relative">
            <div class="card-list" :class="screenSize == 'full' ? 'full' : screenSize == 'tablet' ? 'tablet' : 'mobile', cardDisplay ? 'shown' : 'not-shown' ">
                <div class="relative h-screen overflow-auto">
                    <div class="py-2 flex items-center transition" :class="cardDisplay ? 'justify-end h-14 px-4' : 'justify-center h-10'">
                        <button class="h-2 w-8 rounded-full bg-gray-300" @click="toggleCardDisplay" v-if="!cardDisplay"></button>
                        <button class="h-10 w-10 rounded-full" @click="toggleCardDisplay" v-else>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="map">
                <iframe id="openstreet" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://umap.openstreetmap.fr/en/map/community-pantries-ph_598704"></iframe>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/App'

export default {
    name: "Home",
    components: {
        AppLayout,
    },
    data() {
        return {
            screenSize: 'full',
            cardDisplay: false,
        }
    },
    mounted() {
      if(window.outerWidth <= 360) {
          this.screenSize = 'mobile';
      } else if(window.outerWidth > 360 && window.outerWidth <= 768) {
          this.screenSize = 'tablet'
      } else {
          this.screenSize = 'full';
      }
    },
    methods: {
        toggleCardDisplay() {
          this.cardDisplay = !this.cardDisplay;
        },
    }
}
</script>

<style scoped>

</style>
