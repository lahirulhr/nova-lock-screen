<template>
    <div class="py-6 px-1 md:px-2 lg:px-6 lc-parent">
        <div class="bg-lock" :style="bgImage"></div>
        <div class="mx-auto py-8 max-w-sm flex justify-center text-black">
            <AppLogo class="h-8" />
        </div>
        <slot />
    </div>
</template>

<script>
export default {
    name: 'Auth',
    computed:{
        bgImage(){
            return `background-image: url('${Nova.config('nls')['background_image']}')`
        }
    }
}
</script>

