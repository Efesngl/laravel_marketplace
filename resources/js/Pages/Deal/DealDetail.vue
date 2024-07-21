<template>
    <MainLayout>
        <div class="min-h-svh h-auto flex flex-col gap-1">
            <h2 class="text-center text-2xl">{{ deal.title }}</h2>
            <Carousel :Images="images"></Carousel>
            <div id="owner-detail" class="flex flex-col border-b">
                <div id="owner" class="text-center">
                    <a href="/" class="text-blue-500">{{ deal.user.name }}</a>
                </div>
                <div id="address" class="text-center">
                    <a class="text-blue-500">İzmir</a><small>/</small><a class="text-blue-500">Karabağlar</a><small>/</small><a class="text-blue-500">Esenlik Mahallesi</a>
                </div>
            </div>
            <div>
                <TabGroup>
                    <TabList class="flex flex-row justify-center gap-4 border-b-2 border-c-pr">
                        <Tab v-slot="{ selected }" class="focus-visible:outline-none"
                            ><button class="p-2 border-b-0 border focus-visible:outline-none" :class="{ 'bg-c-white text-c-black': !selected, 'bg-c-pr text-c-white': selected }">
                                Deal details
                            </button></Tab
                        >
                        <Tab v-slot="{ selected }" class="focus-visible:outline-none"
                            ><button class="p-2 border-b-0 border focus-visible:outline-none" :class="{ 'bg-c-white text-c-black': !selected, 'bg-c-pr text-c-white': selected }">
                                Description
                            </button></Tab
                        >
                        <Tab v-slot="{ selected }" class="focus-visible:outline-none"
                            ><button class="p-2 border-b-0 border focus-visible:outline-none" :class="{ 'bg-c-white text-c-black': !selected, 'bg-c-pr text-c-white': selected }">
                                Location
                            </button></Tab
                        >
                    </TabList>
                    <TabPanels>
                        <TabPanel class="mt-2 p-2">
                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400">
                                    <tbody>
                                        <tr v-for="spec in deal.specifications" class="flex flex-col bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                            <th>{{ spec.specification.specification }}</th>
                                            <td>{{ spec.value.value }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </TabPanel>
                        <TabPanel class="mt-2 p-2 h-auto">
                            <span v-html="deal.description"></span>
                        </TabPanel>
                        <TabPanel class="mt-2 p-2">Content 3</TabPanel>
                    </TabPanels>
                </TabGroup>
            </div>
        </div>
    </MainLayout>
</template>

<script>
import MainLayout from "../../Layouts/MainLayout.vue";
import Carousel from "../../Components/Carousel.vue";
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from "@headlessui/vue";
export default {
    components: {
        MainLayout,
        Carousel,
        TabGroup,
        TabList,
        TabPanel,
        Tab,
        TabPanels,
    },
    data() {
        return {
            images: [
                {
                    itemImageSrc: "/storage/images/1/araba.jpg",
                    thumbnailImageSrc: "/storage/images/1/araba.jpg",
                    alt: "Description for Image 1",
                    title: "Title 1",
                },
                {
                    itemImageSrc: "/storage/images/1/araba2.jpg",
                    thumbnailImageSrc: "/storage/images/1/araba2.jpg",
                    alt: "Description for Image 1",
                    title: "Title 1",
                },
                {
                    itemImageSrc: "/storage/images/1/araba3.jpg",
                    thumbnailImageSrc: "/storage/images/1/araba3.jpg",
                    alt: "Description for Image 1",
                    title: "Title 1",
                },
                {
                    itemImageSrc: "/storage/images/1/araba4.jpg",
                    thumbnailImageSrc: "/storage/images/1/araba4.jpg",
                    alt: "Description for Image 1",
                    title: "Title 1",
                },
            ],
        };
    },
    props: {
        deal: Object,
    },
};
</script>
