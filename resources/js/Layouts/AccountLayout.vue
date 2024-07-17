<template>
    <div class="container">
        <nav id="navbar" class="fixed top-0 left-0 w-full bg-c-white text-c-black h-14 px-3 py-2">
            <div class="flex flex-row justify-start items-center h-full">
                <div id="back" v-if="backUrl">
                    <Link :href="backUrl"><fa-icon icon="fa-solid fa-arrow-left"></fa-icon></Link>
                </div>
                <div id="title" class="flex justify-center w-full items-center">
                    <h1 class="text-xl h-fit capitalize">{{title}}</h1>
                </div>
            </div>
        </nav>
        <div class="h-auto box-border pt-14 w-svw" :class="bg">
            <slot />
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";
import BottomBar from "../Components/BottomBar.vue"
export default {
    props: {
        bg:{
            type:String,
        },
        title:String,
        backUrl:String
    },
    components: {
        Link,
        BottomBar
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
