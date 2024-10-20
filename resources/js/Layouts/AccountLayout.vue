<template>
    <transition name="fade" appear>
        <div class="container">
            <nav id="navbar" class="fixed z-50 top-0 left-0 w-full bg-white dark:bg-zinc-900 text-black dark:text-white h-14 px-3 py-2 border-b border-yellow-400">
                <div class="flex flex-row justify-start items-center h-full">
                    <div id="back" class="basis-1/6" v-if="backUrl">
                        <Link :href="backUrl"><i class="pi pi-arrow-left"></i></Link>
                    </div>
                    <div id="title" class="flex basis-4/6 justify-center w-full items-center">
                        <h1 class="text-xl h-fit capitalize">{{ title }}</h1>
                    </div>
                    <div id="icon" class="flex basis-1/6 justify-end w-full items-center">
                        <slot name="navButton"></slot>
                    </div>
                </div>
            </nav>
            <div class="h-auto box-border pt-14 w-dvw bg-stone-200 dark:bg-zinc-900">
                <slot name="content"></slot>
            </div>
        </div>
    </transition>
</template>

<script>
import { Link } from "@inertiajs/vue3";
import BottomBar from "../Components/BottomBar.vue";
export default {
    props: {
        title: String,
        backUrl: String,
    },
    components: {
        Link,
        BottomBar,
    },
};
</script>
