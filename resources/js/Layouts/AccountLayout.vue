<template>
    <transition name="fade" appear>
        <div class="container">
            <nav id="navbar" class="fixed top-0 left-0 w-full bg-white dark:bg-zinc-900 text-black dark:text-white h-14 px-3 py-2 border-b border-yellow-400">
                <div class="flex flex-row justify-start items-center h-full">
                    <div id="back" class="basis-1/6" v-if="backUrl">
                        <Link :href="backUrl"><fa-icon icon="fa-solid fa-arrow-left"></fa-icon></Link>
                    </div>
                    <div id="title" class="flex basis-4/6 justify-center w-full items-center">
                        <h1 class="text-xl h-fit capitalize">{{ title }}</h1>
                    </div>
                    <div id="icon" class="flex basis-1/6 justify-end w-full items-center">
                        <slot name="navButton"></slot>
                    </div>
                </div>
            </nav>
            <div class="h-auto box-border pt-16 w-svw bg-stone-200 dark:bg-zinc-900">
                <slot></slot>
            </div>
        </div>
    </transition>
</template>

<script>
import { Link } from "@inertiajs/vue3";
import BottomBar from "../Components/BottomBar.vue";
export default {
    props: {
        bg: {
            type: String,
        },
        title: String,
        backUrl: String,
    },
    components: {
        Link,
        BottomBar,
    },
    data() {
        return {
            navItems: [
                {
                    text: "Home Page",
                    icon: "fa-house",
                    routeName: "home",
                },
                {
                    text: "Categories",
                    icon: "fa-list",
                    routeName: "deal.index",
                },
                {
                    text: "New Deal",
                    icon: "fa-circle-plus",
                    routeName: "deal.create",
                },
                {
                    text: this.$page.props.auth.user != null ? "Account" : "Log In",
                    icon: "fa-user",
                    routeName: this.$page.props.auth.user != null ? "account" : "login",
                },
            ],
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
