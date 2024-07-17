<template>
    <div class="container">
        <nav id="navbar" class="fixed top-0 left-0 w-full bg-c-white text-c-black h-14 px-3 py-2">
            <div class="flex flex-row justify-between items-center">
                <div id="logo">
                    <h1 class="text-3xl">Logo</h1>
                </div>
                <span class="h-full text-c-black"><fa-icon icon="fa-solid fa-bell" size="xl"></fa-icon></span>
            </div>
        </nav>
        <div class="h-auto mb-20 mt-16 box-content w-svw" :class="bg">
            <slot />
        </div>
        <BottomBar></BottomBar>
    </div>
</template>

<script>
import BottomBar from "../Components/BottomBar.vue";
export default {
    props: ["bg"],
    components: {
        BottomBar,
    },
    data() {
        return {
            isSearhBarShowing: false,
        };
    },
    methods: {
        toggleSearch(status) {
            this.isSearhBarShowing = status;
        },
    },
};
</script>
