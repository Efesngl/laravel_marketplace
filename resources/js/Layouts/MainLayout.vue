<template>
    <div class="container">
        <nav id="navbar" class="fixed top-0 left-0 w-full bg-c-white text-c-black h-14 px-3 py-2 z-50 dark:bg-zinc-900 dark:text-white">
            <div class="flex flex-row justify-between items-center">
                <div id="logo">
                    <h1 class="text-3xl">Logo</h1>
                </div>
                <span class="h-full text-c-black" @click="changeColorScheme"><fa-icon icon="fa-solid fa-bell" size="xl"></fa-icon></span>
                <span class="h-full text-c-black"><fa-icon icon="fa-solid fa-bell" size="xl"></fa-icon></span>
            </div>
        </nav>
        <!-- <Navbar></Navbar> -->
        <div class="h-auto mb-20 mt-16 box-content w-svw" :class="bg">
            <slot />
        </div>
        <BottomBar></BottomBar>
        <!-- <Dock></Dock> -->
    </div>
</template>

<script>
// import Dock from "../Components/Dock.vue";
// import Navbar from "../Components/Navbar.vue";

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
        changeColorScheme() {
            let html = document.querySelector("html");
            if (html.classList.contains("light")) {
                html.classList.remove("light");
                html.classList.add("dark");
                localStorage.setItem("colorScheme","dark")
            } else {
                html.classList.remove("dark");
                html.classList.add("light");
                localStorage.setItem("colorScheme","light")
            }
        },
    },
};
</script>
