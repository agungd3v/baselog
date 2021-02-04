<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div>
            <slot name="logo" />
        </div>

        <div class="w-full md:w-3/4 lg:w-1/2 px-3 mt-6 overflow-hidden">
            <slot />
        </div>
    </div>
</template>
<style>
    html {
        overflow-y: auto;
    }
</style>