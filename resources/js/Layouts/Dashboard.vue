<template>
    <div class="relative font-material">
        <div class="fixed top-0 left-0 z-20 h-16 w-full bg-blue-500 shadow">
            <header class="relative h-16 flex items-center">
                <button type="button" class="flex-none h-16 w-16 text-white" @click="sidebarOpen = !sidebarOpen">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div class="flex-1 min-w-[0px]">
                    <div class="flex w-full overflow-hidden h-7 overflow-ellipsis">
                        <h1 class="font-bold text-lg text-white"><slot name="header"/></h1>
                    </div>
                </div>
                <inertia-link as="button" :href="route('pantries.create')" class="flex-none h-16 w-16 text-white" v-if="(!route().current('pantries.show'))|| route().current('pantries.edit')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </inertia-link>
                <inertia-link as="button" :href="route('pantries.edit', current)" class="flex-none h-16 w-16 text-white" v-if="route().current('pantries.show')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                </inertia-link>
                <button type="button" class="flex-none h-16 w-16 text-white" @click="toggleSearch()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </header>
        </div>

        <!-- Search-->
        <div class="fixed top-0 left-0 z-30 h-16 w-full bg-white shadow" v-if="searchOpen">
            <div class="h-16 flex items-center">
                <button type="button" class="h-16 w-16 text-gray-800" @click="searchOpen = false">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </button>
                <div class="flex-1">
                    <input type="text" ref="searchBox" class="h-16 w-full border-0 focus:ring-0 pr-4" v-model="searchQuery"/>
                </div>
            </div>
        </div>

        <!-- Sidebar Navigation -->
        <div class="fixed top-0 left-0 w-full h-full z-40 bg-black bg-opacity-50" v-show="sidebarOpen" @click="sidebarOpen = false"></div>
        <div class="fixed top-0 left-0 max-w-[320px] z-50 w-11/12 h-full top-0 left-0 bg-white shadow transform transition" :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            <div class="relative h-screen overflow-hidden">
                <section class="relative px-4 py-3 h-16">
                    <a href="#">
                        <img src="https://arstlemedia.com/wp-content/uploads/2021/04/arstle_logo_blue_2019.png" class="h-10 w-auto"/>
                    </a>
                </section>
                <section class="relative p-4 border-t">
                    <nav class="relative">
                        <li class="block relative">
                            <inertia-link :href="route('pantries.index')" class="flex items-center gap-4 px-4 py-2 rounded-md text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                <span class="text-sm font-semibold">Community Pantries List</span>
                            </inertia-link>
                        </li>
                        <li class="block relative">
                            <inertia-link :href="route('pantries.create')" class="flex items-center gap-4 px-4 py-2 rounded-md text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-sm font-semibold">Add Item</span>
                            </inertia-link>
                        </li>
                    </nav>
                </section>
                <section class="relative p-4 border-t">
                    <nav class="relative">
                        <li class="block relative" v-if="auth.user">
                            <inertia-link as="button" method="post" :href="route('logout')" class="flex items-center gap-4 px-4 py-2 rounded-md text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                <span class="text-sm font-semibold">Log out</span>
                            </inertia-link>
                        </li>
                        <li class="block relative" v-else>
                            <inertia-link :href="route('login')" class="flex items-center gap-4 px-4 py-2 rounded-md text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                </svg>
                                <span class="text-sm font-semibold">Log in</span>
                            </inertia-link>
                        </li>
                    </nav>
                </section>
            </div>
        </div>

        <div class="relative mt-16">
            <div class="container mx-auto p-4">
                <slot name="content" :searchQuery="searchQuery"/>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['auth','current'],
    name: "Dashboard",
    data() {
        return {
            sidebarOpen: false,
            searchOpen: false,
            searchQuery: null,
        }
    },
    methods: {
      toggleSearch() {
          this.searchOpen = true;
          this.$nextTick(() => {
              this.$refs['searchBox'].focus();
          });
      }
    },
}
</script>

<style scoped>

</style>
