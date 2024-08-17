<template>
    <transition name="fade" appear>
        <div class="container">
            <nav id="navbar" class="fixed top-0 left-0 w-full bg-c-white text-c-black h-14 px-3 py-2 z-50 dark:bg-zinc-900 dark:text-white">
                <div class="flex flex-row justify-between md:justify-around items-center">
                    <div id="logo" class="basis-1/12">
                        <Link :href="route('home')" class="text-3xl">Logo</Link>
                    </div>
                    <div id="search-bar" class="basis-4/12 hidden md:block">
                        <InputGroup>
                            <InputText v-model="searchValue.search" @keypress.enter.prevent="search" class="!bg-zinc-900"></InputText>
                            <Button icon="pi pi-search" icon-pos="right" label="search" @click="search"></Button>
                        </InputGroup>
                    </div>
                    <div class="justify-end hidden md:flex gap-3 flex-row basis-1/12">
                        <Button icon="pi pi-bell" text size="large"></Button>
                        <Link class="text-yellow-400 flex flex-row justify-center items-center gap-1 hover:opacity-70 transition" :href="route('home')">
                            <OverlayBadge value="2">
                                <i class="pi pi-shopping-cart"></i>
                            </OverlayBadge>
                        </Link>
                        <Button icon="pi pi-bars" @click="toggleMenu" text aria-haspopup="true" aria-controls="overlay_menu"></Button>
                        <Menu ref="menu" :model="menuItems" id="overlay_menu" :popup="true">
                            <template #item="{ item, props }">
                                <Link
                                    :href="route(item.route)"
                                    :class="{ 'text-yellow-400': route().current() == item.route }"
                                    class="p-2 transition !w-full hover:text-yellow-400 flex gap-2 justify-start items-center"
                                >
                                    <i :class="item.icon"></i><span>{{ item.text }}</span>
                                </Link>
                            </template>
                            <template #start>
                                <Link
                                    v-if="$page.props.auth.user"
                                    class="flex flex-row justify-start items-center p-2 transition hover:bg-zinc-800 hover:text-yellow-400"
                                    :href="route('account.index')"
                                >
                                    <Avatar icon="pi pi-user" class="mr-2" shape="circle" />
                                    <span class="inline-flex flex-col items-start">
                                        <span class="font-bold">{{ $page.props.auth.user.name }}</span>
                                        <span class="text-sm" v-if="$page.props.auth.user.is_admin">Admin</span>
                                    </span>
                                </Link>
                                <Link v-else class="flex flex-row justify-start items-center p-2 transition hover:bg-zinc-800" :href="route('login')">
                                    <Avatar icon="pi pi-user" class="mr-2" shape="circle" />
                                    <span class="inline-flex flex-col items-start">
                                        <span class="font-bold">Login</span>
                                    </span>
                                </Link>
                            </template>
                            <template #end v-if="$page.props.auth.user">
                                <a class="text-red-600 flex justify-center gap-1 items-center p-2 hover:bg-zinc-800 transition" :href="route('logout')">
                                    <i class="pi pi-sign-out"></i><span>Logout</span>
                                </a>
                            </template>
                        </Menu>
                    </div>
                    <Button icon="pi pi-bell" class="md:!hidden" text size="large"></Button>
                </div>
            </nav>
            <!-- <Navbar></Navbar> -->

            <div class="h-auto mb-20 md:mb-0 mt-14 box-content w-dvw" :class="bg">
                <slot></slot>
            </div>
            <BottomBar></BottomBar>
            <!-- <Dock></Dock> -->
        </div>
    </transition>
</template>

<script>

import InputText from "primevue/inputtext";
import BottomBar from "../Components/BottomBar.vue";
import Button from "primevue/button";
import InputGroup from "primevue/inputgroup";
import Menu from "primevue/menu";
import { Link, useForm } from "@inertiajs/vue3";
import Avatar from "primevue/avatar";
import OverlayBadge from "primevue/overlaybadge";

export default {
    props: ["bg"],
    components: {
        BottomBar,
        InputText,
        Button,
        InputGroup,
        Menu,
        Link,
        Avatar,
        OverlayBadge,
    },
    data() {
        return {
            isSearhBarShowing: false,
            menuItems: [
                {
                    text: "Home Page",
                    icon: "pi pi-home",
                    route: "home",
                },
                {
                    text: "Browse",
                    icon: "pi pi-bars",
                    route: "browse.index",
                },
                {
                    text: "New product",
                    icon: "pi pi-plus",
                    route: "product.create",
                },
            ],
            searchValue: useForm({
                search: null,
            }),
        };
    },
    methods: {
        search() {
            this.searchValue.get(route("search.result"));
        },
        toggleMenu(event) {
            this.$refs.menu.toggle(event);
        },
        changeColorScheme() {
            let html = document.querySelector("html");
            if (html.classList.contains("light")) {
                html.classList.remove("light");
                html.classList.add("dark");
                localStorage.setItem("colorScheme", "dark");
                html.classList.remove("dark");
                html.classList.add("light");
                localStorage.setItem("colorScheme", "light");
            }
        },
    },
};
</script>
