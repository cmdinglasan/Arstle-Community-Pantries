<template>
    <app-layout>
        <div class="relative font-material">
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
                            <li class="block relative" v-if="!route().current('main')">
                                <inertia-link :href="route('main')" class="flex items-center gap-4 px-4 py-2 rounded-md text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                    </svg>
                                    <span class="text-sm font-semibold">Show Map</span>
                                </inertia-link>
                            </li>
                            <li class="block relative" v-else>
                                <a :href="route('main')" @click.prevent="sidebarOpen = false" class="flex items-center gap-4 px-4 py-2 rounded-md text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                    </svg>
                                    <span class="text-sm font-semibold">Show Map</span>
                                </a>
                            </li>
                            <li class="block relative">
                                <button @click="showPantries" class="flex items-center gap-4 px-4 py-2 w-full rounded-md text-gray-500 hover:text-gray-800 hover:bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    <span class="text-sm font-semibold">Community Pantries List</span>
                                </button>
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
                                <inertia-link as="button" method="post" :href="route('logout')" class="flex items-center gap-4 px-4 py-2 w-full rounded-md text-gray-500 hover:text-gray-800 hover:bg-gray-100">
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

            <div class="relative" v-show="screen === 'main'">
                <!-- Search -->
                <div class="fixed z-20 top-0 left-0 w-full mt-8 p-2 transition-height overflow-hidden" :class="searchVisible ? 'bg-gray-100 h-full z-30' : 'bg-white shadow h-16'">
                    <section class="relative">
                        <div class="container mx-auto">
                            <div class="relative h-12 w-full bg-white border rounded-md mb-4 overflow-hidden transition" :class="searchVisible ? 'border-transparent shadow' : ''">
                                <div class="h-12 flex items-center">
                                    <button type="button" class="h-12 w-12" v-if="!searchVisible" @click="sidebarOpen = true">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                        </svg>
                                    </button>
                                    <button type="button" class="h-12 w-12" v-else @click="searchVisible = false, searchQuery = null">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                        </svg>
                                    </button>
                                    <input type="text" id="search" class="border-0 focus:ring-0 px-0 flex-1" placeholder="Search here" ref="search" v-model="searchQuery" @focus="searchVisible = true" autocomplete="off"/>
                                    <button type="button" class="h-12 w-12" v-if="searchVisible">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="relative" v-if="screen === 'main'">
                                <div class="relative bg-white shadow p-4 rounded-md" v-if="!filteredList && searchQuery">
                                    <span class="block">No results found.</span>
                                    <span class="text-sm text-gray-500">Please try with another query.</span>
                                </div>
                                <a href="#" class="block relative bg-white shadow p-4 rounded-md mb-2" @click.prevent="setCurrentPantry(pantry)" v-for="pantry in filteredList" v-else>
                                    <div class="flex items-start gap-4">
                                        <div class="flex-none w-12 h-12">
                                            <img :src="pantry.featured_image_local ? pantry.featured_image_local : (pantry.featured_image_url ? pantry.featured_image_url : 'https://via.placeholder.com/120x120')" class="w-12 h-12 rounded-full object-cover"/>
                                        </div>
                                        <div class="flex-1">
                                            <h1 class="font-bold text-md">{{ pantry.name }}</h1>
                                            <span class="block text-gray-500 text-sm">{{ (pantry.address ? pantry.address + ', ' : '') + pantry.barangay + ', ' + pantry.city }}</span>
                                            <span class="font-bold text-gray-500 text-sm">{{ pantry.region }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </section>
                    <section class="p-4">
                        <div class="container mx-auto">

                        </div>
                    </section>
                </div>
                <div class="card-list" :class="screenSize == 'full' ? 'full' : screenSize == 'tablet' ? 'tablet' : 'mobile', cardDisplay ? 'shown' : 'not-shown' " v-if="currentPantry.name">
                    <div class="relative h-full overflow-auto">
                        <div class="sticky z-10 top-0 left-0 w-full h-16 bg-white shadow" v-if="cardDisplay">
                            <div class="relative p-2 flex items-center justify-between container mx-auto">
                                <button type="button" @click="cardDisplay = false" class="w-12 h-12 rounded-full active:bg-gray-100 text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                </button>
                                <button type="button" @click="toggleSearch" class="w-12 h-12 rounded-full active:bg-gray-100 text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="relative transition-height overflow-hidden" :class="cardDisplay ? 'h-32' : 'h-0'" v-if="currentPantry.featured_image_local || currentPantry.featured_image_url">
                            <div class="container mx-auto">
                                <div class="h-32 w-full bg-fixed bg-cover bg-center" :style="{ backgroundImage: `url(${(currentPantry.featured_image_local ?? currentPantry.featured_image_url)}` }"></div>
                            </div>
                        </div>
                        <div class="py-2 flex items-center transition justify-center" v-if="!cardDisplay">
                            <button class="h-2 w-8 rounded-full bg-gray-300" @click="toggleCardDisplay"></button>
                        </div>
                        <div class="relative">
                            <div class="container mx-auto">
                                <header class="relative px-4" :class="cardDisplay ? 'border-b py-4' : 'py-2'">
                                    <h1 class="text-lg">{{ currentPantry.name }}</h1>
                                    <span class="text-gray-500 text-sm">Community Pantry</span>
                                </header>
                                <div :class="cardDisplay ? 'py-4 border-b' : 'py-2'" v-if="currentPantry.contacts[0].contact_num != null">
                                    <div class="relative overflow-auto whitespace-nowrap pl-4">
                                        <a :href="currentPantry.contacts[0].contact_num ? ('tel:' + currentPantry.contacts[0].contact_num) : '#'" class="inline-block px-4 py-2 mr-2 border rounded-full">
                                            <div class="flex items-center gap-2 text-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500 flex-none" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                                </svg>
                                                <span class="flex-1">Call</span>
                                            </div>
                                        </a>
                                        <a :href="'https://www.google.com/maps/@' + currentPantry.latitude + ',' + currentPantry.longitude + ',13z'" target="_blank" class="inline-block px-4 py-2 mr-2 border rounded-full" v-if="currentPantry.latitude && currentPantry.longitude">
                                        <div class="flex items-center gap-2 text-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M12 1.586l-4 4v12.828l4-4V1.586zM3.707 3.293A1 1 0 002 4v10a1 1 0 00.293.707L6 18.414V5.586L3.707 3.293zM17.707 5.293L14 1.586v12.828l2.293 2.293A1 1 0 0018 16V6a1 1 0 00-.293-.707z" clip-rule="evenodd" />
                                            </svg>
                                            <span class="flex-1">Open in Google Maps</span>
                                        </div>
                                    </a>
                                    </div>
                                </div>
                                <div class="relative border-b" v-if="cardDisplay">
                                    <div class="relative border-b flex items-start">
                                        <div class="w-16 flex-none text-blue-500 py-4 text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 py-4 pr-4 pl-2">
                                                <span class="text-sm">
                                                    <span v-if="currentPantry.address" v-text="currentPantry.address + ', '"></span>
                                                    <span v-if="currentPantry.barangay" v-text="currentPantry.barangay + ', '"></span>
                                                    <span v-if="currentPantry.city" v-text="currentPantry.city + ', '"></span>
                                                    <span v-if="currentPantry.province" v-text="currentPantry.province"></span>
                                                </span>
                                        </div>
                                    </div>
                                    <div class="relative border-b flex items-start" v-if="currentPantry.latitude && currentPantry.longitude">
                                        <div class="w-16 flex-none text-blue-500 py-4 text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 py-4 pr-4 pl-2">
                                                <span class="text-sm">{{ currentPantry.latitude + ', ' + currentPantry.longitude}}</span>
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
                                                    <span v-if="currentPantry.region" v-text="currentPantry.region"></span>
                                                </span>
                                        </div>
                                    </div>
                                    <a :href="currentPantry.contacts[0].contact_num ? 'tel:'+currentPantry.contacts[0].contact_num : '#'">
                                        <div class="relative border-b flex items-start">
                                            <div class="w-16 flex-none text-blue-500 py-4 text-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                </svg>
                                            </div>
                                            <div class="flex-1 py-4 pr-4 pl-2">
                                                <span class="text-sm font-bold" v-if="currentPantry.contacts[0].name" v-text="currentPantry.contacts[0].name"></span>
                                                <span class="text-sm block" v-if="currentPantry.contacts[0].contact_num" v-text="currentPantry.contacts[0].contact_num"></span>
                                            </div>
                                        </div>
                                    </a>
                                    <a :href="currentPantry.source" target="_blank">
                                        <div class="relative border-b flex items-start">
                                            <div class="w-16 flex-none text-blue-500 py-4 text-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <div class="flex-1 py-4 pr-4 pl-2">
                                                <span class="text-sm">
                                                    <span v-if="currentPantry.source" v-text="currentPantry.source"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="map" id="mapid"></div>
            </div>

            <div class="relative" v-if="screen === 'listOfPantries'">
                <div class="fixed z-10 top-0 left-0 w-full h-16 bg-white shadow mt-8">
                    <div class="relative p-2 flex items-center justify-between">
                        <button type="button" @click="screen = 'main'" class="w-12 h-12 rounded-full active:bg-gray-100 text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </button>
                        <button type="button" @click="toggleSearch" class="w-12 h-12 rounded-full active:bg-gray-100 text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="relative py-2 mt-16">
                    <div class="container mx-auto">
                        <div class="relative">
                            <template v-if="pantries.length > 0">
                                <div class="relative px-4 py-2 flex items-center">
                                    <span class="text-sm text-gray-500 flex-1">{{ pantries.length }} pantries found</span>
                                    <button type="button" class="h-8 w-8 flex-none text-gray-500 rounded-full active:bg-gray-200" disabled>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                        </svg>
                                    </button>
                                </div>
                                <a href="#" class="block relative p-4 bg-white border-b" v-for="pantry in pantries" @click.prevent="setCurrentPantry(pantry)">
                                    <div class="flex items-start gap-4">
                                        <div class="flex-none w-12 h-12">
                                            <img :src="pantry.featured_image_local ? pantry.featured_image_local : (pantry.featured_image_url ? pantry.featured_image_url : 'https://via.placeholder.com/120x120')" class="w-12 h-12 rounded-full object-cover"/>
                                        </div>
                                        <div class="flex-1">
                                            <h1 class="font-bold text-md">{{ pantry.name }}</h1>
                                            <span class="block text-gray-500 text-sm">{{ (pantry.address ? pantry.address + ', ' : '') + pantry.barangay + ', ' + pantry.city }}</span>
                                            <span class="font-bold text-gray-500 text-sm">{{ pantry.region }}</span>
                                        </div>
                                    </div>
                                </a>
                            </template>
                            <template v-else>
                                <div class="relative p-4 h-12 bg-gray-300 rounded-md animate-pulse mx-4 my-2"></div>
                                <div class="relative p-4 h-12 bg-gray-300 rounded-md animate-pulse mx-4 my-2"></div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/App'

export default {
    name: "Home",
    props: ['auth'],
    components: {
        AppLayout,
    },
    data() {
        return {
            screenSize: 'full',
            cardDisplay: false,
            searchVisible: false,
            searchQuery: null,
            searchResults: [],
            pantries: [],
            isLoading: false,
            currentPantry: {
                featured_image_local: null,
                featured_image_url: null,
            },
            sidebarOpen: false,
            screen: 'main',
            map: null,
            mapMarker: null,
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

        this.isLoading = true;

        axios.get(route('pantries.api'))
            .then((response) => {
                this.pantries = response.data;
                this.isLoading = false;
            })
            .catch((error) => {

            });

        /* Leaflet */
        this.setupLeaflet();
    },
    computed: {
        filteredList() {
            if(this.searchQuery){
                return this.pantries.filter((item)=>{
                    return this.searchQuery.toLowerCase().split(' ').every(v => item.name.toLowerCase().includes(v))
                })
            }
        }
    },
    methods: {
        toggleCardDisplay() {
          this.cardDisplay = !this.cardDisplay;
        },
        toggleSearch() {
            this.cardDisplay = false;
            this.screen = 'main';
            this.searchVisible = true;
            this.$refs['search'].focus();
        },
        showPantries() {
            this.sidebarOpen = false;
            this.screen = 'listOfPantries';
        },
        setupLeaflet() {
            this.map = L.map('mapid', {
                center: [14.550001667731134, 121.05608763925126],
                zoom: 13,
                zoomControl: false,
            });

            L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                attribution: 'Map data &copy; <a href="https://arstlemedia.com">Arstle</a> contributors, Rappler',
            }).addTo(this.map);
        },
        setCurrentPantry(pantry) {
            this.screen = 'main';
            this.currentPantry = pantry;
            this.searchQuery = pantry.name;
            this.searchVisible = false;
            if(pantry.latitude && pantry.longitude) {
                this.mapMarker = L.marker([pantry.latitude, pantry.longitude], {
                    title: [pantry.latitude, pantry.longitude],
                    name: pantry.name,
                }).addTo(this.map);
                this.map.flyTo([pantry.latitude, pantry.longitude], 15);
            } else {
                this.map.removeLayer(this.mapMarker);
            }
        },
    }
}
</script>

<style scoped>

</style>
