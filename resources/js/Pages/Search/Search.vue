<template>
    <MainLayout>
        <div class="flex flex-col min-h- h-auto px-2">
            <h2 class="text-3xl text-center">Search</h2>
            <div id="search" class="flex flex-col gap-2">
                <form @submit.prevent="search()" class="flex flex-col">
                    <label for="search">Search</label>
                    <div class="flex flex-row gap-0">
                        <InputGroup>
                            <InputText
                                type="text"
                                class="basis-3/4 border-yellow-400 dark:border-zinc-800 text-black rounded-tl rounded-bl focus:ring-0 focus:border-yellow-400"
                                name="search"
                                id="search"
                                v-model="s.search"
                            />
                            <Button type="submit" class="basis-1/4 bg-yellow-400">Search</Button></InputGroup
                        >
                    </div>
                </form>
                <div>
                    <h3>Recent searchs</h3>
                    <div class="flex flex-col">
                        <div class="flex flex-row justify-start first:border-t items-center border-b" v-for="rs in recentSearches">
                            <button @click="visitRecentSearch(rs)" class="basis-11/12 p-2 text-start">{{ rs }}</button>
                            <button class="basis-1/12 text-red-500" @click="removeRs(rs)"><fa-icon icon="fa-soild fa-trash"></fa-icon></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script>
import InputText from "primevue/inputtext";
import MainLayout from "../../Layouts/MainLayout.vue";
import { useForm, Link, router } from "@inertiajs/vue3";
import Button from "primevue/button";
import InputGroup from "primevue/inputgroup";
export default {
    components: {
        MainLayout,
        Link,
        InputText,
        Button,
        InputGroup,
    },
    data() {
        return {
            s: useForm({
                search: null,
            }),
            recentSearches: [],
        };
    },
    mounted() {
        if (localStorage.getItem("recentSearches") != null) {
            this.recentSearches = JSON.parse(localStorage.getItem("recentSearches"));
        }
    },
    methods: {
        search() {
            if (!this.recentSearches.includes(this.s.search)) {
                this.recentSearches.push(this.s.search);
                localStorage.setItem("recentSearches", JSON.stringify(this.recentSearches));
            }
            this.s.get(route("search.result"));
        },
        visitRecentSearch(rs) {
            let index = this.recentSearches.indexOf(rs);
            this.recentSearches.unshift(this.recentSearches.splice(index, 1)[0]);
            localStorage.setItem("recentSearches", JSON.stringify(this.recentSearches));
            router.get(route("search.result"), { search: rs });
        },
        removeRs(rs) {
            this.recentSearches = this.recentSearches.filter((val) => {
                return val != rs;
            });
            localStorage.setItem("recentSearches", JSON.stringify(this.recentSearches));
        },
    },
};
</script>
