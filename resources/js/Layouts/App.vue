<template>
    <div class="min-h-screen bg-gray-50">
        <div class="fixed z-20 top-0 left-0 h-8 w-full bg-white border-b">
            <div class="px-4">
                <a href="//arstlemedia.com" class="h-8 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-xs uppercase font-bold">Return to Arstle Media</span>
                </a>
            </div>
        </div>
        <div class="relative pt-8 h-screen">
            <slot />
        </div>
    </div>
</template>

<script>
export default {
    name: "App"
}
</script>

<style scoped>

</style>
