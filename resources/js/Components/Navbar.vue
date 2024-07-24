<template>
    <Menubar>
        <template #start>
            <h1 class="text-3xl">Logo</h1>
        </template>
        <template #end>
            <span class="h-full text-c-black" @click="changeColorScheme"><fa-icon icon="fa-solid fa-bell" size="xl"></fa-icon></span>
            <span class="h-full text-c-black"><fa-icon icon="fa-solid fa-bell" size="xl"></fa-icon></span>
        </template>
    </Menubar>
</template>

<script>
import Menubar from "primevue/menubar";
export default {
    components: {
        Menubar,
    },
    methods: {
        changeColorScheme() {
            let scheme = document.querySelector("html");
            if (scheme.classList.contains("light")) {
                scheme.classList.remove("light");
                scheme.classList.add("dark");
            } else {
                scheme.classList.remove("dark");
                scheme.classList.add("light");
            }
        },
    },
};
</script>
