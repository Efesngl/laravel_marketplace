<template>
    <MainLayout>
        <div class="flex flex-col min-h- h-auto px-2">
            <h2 class="text-3xl text-center">Search</h2>
            <div id="search" class="flex flex-col gap-2">
                <form @submit.prevent="search()" class="flex flex-col">
                    <label for="search">Search</label>
                    <div class="flex flex-row gap-0">
                        <input type="text" class="basis-3/4" name="search" id="search" v-model="s.search" />
                        <button type="submit" class="basis-1/4 bg-c-pr text-c-white">Search</button>
                    </div>
                </form>
                <div>
                    <h3>Recent searchs</h3>
                    <div class="flex flex-col ">
                        <div class="flex flex-row justify-start first:border-t items-center border-b" v-for="i in 10">
                            <a href="" class="basis-11/12 p-2">Search</a>
                            <button class="basis-1/12 text-red-500" ><fa-icon icon="fa-soild fa-trash"></fa-icon></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script>
import MainLayout from "../../Layouts/MainLayout.vue";
import { useForm } from "@inertiajs/vue3";
export default {
    components: {
        MainLayout,
    },
    data() {
        return {
            s:useForm({
                search:null
            })
        };
    },
    methods:{
        search(){
        }
    }
};
</script>
