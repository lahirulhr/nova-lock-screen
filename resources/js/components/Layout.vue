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


<style scoped>
.lc-parent {
    position: relative;

}

.bg-lock::before{
    content: "";
        position: absolute;
        width: 100%;
        height: 100vh;
        backdrop-filter: blur(8px);
}

div.bg-lock {
    height: 100vh;
    width: 100%;
    background-color: linear-gradient(rgba(0, 0, 0, 0.63), rgba(0, 0, 0, 0.623));
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: -1;

}
</style>
