<template>
    <MainLayout>
        <div class="min-h-svh h-auto flex flex-col gap-1">
            <h2 class="text-center text-2xl">{{ deal.title }}</h2>
            <div>
                <Galleria :value="images" :numVisible="3" containerStyle="w-full" :showItemNavigators="true">
                    <template #item="slotProps">
                        <img :src="slotProps.item.itemImageSrc" :alt="slotProps.item.alt" style="width: 100%" />
                    </template>
                    <template #thumbnail="slotProps">
                        <img :src="slotProps.item.thumbnailImageSrc" :alt="slotProps.item.alt" />
                    </template>
                </Galleria>
            </div>

            <div id="owner-detail" class="flex flex-col border-b">
                <div id="owner" class="text-center">
                    <a href="/" class="text-blue-500">{{ deal.user.name }}</a>
                </div>
                <div id="address" class="text-center">
                    <a class="text-blue-500">{{deal.city.name}}</a><small>/</small><a class="text-blue-500">{{ deal.district.name }}</a><small>/</small><a class="text-blue-500">{{ deal.neighbourhood.name }}</a>
                </div>
            </div>
            <div>
                <Tabs value="0">
                    <TabList class="justify-between">
                        <Tab value="0">Description</Tab>
                        <Tab value="1">Details</Tab>
                        <Tab value="2">Location</Tab>
                    </TabList>
                    <TabPanels>
                        <TabPanel value="0">
                            <p class="m-0">
                                <span v-html="deal.description"></span>
                            </p>
                        </TabPanel>
                        <TabPanel value="1">
                            <p class="m-0">
                                <DataTable stripedRows :value="deal.specifications">
                                    <Column field="specification.specification" header="Spec"></Column>
                                    <Column field="value.value" header=""></Column>
                                </DataTable>
                            </p>
                        </TabPanel>
                        <TabPanel value="2">
                            <p class="m-0">
                                Location
                            </p>
                        </TabPanel>
                    </TabPanels>
                </Tabs>
            </div>
        </div>
    </MainLayout>
</template>

<script>
import MainLayout from "../../Layouts/MainLayout.vue";
import Galleria from "primevue/galleria";
import Tabs from 'primevue/tabs';
import TabList from 'primevue/tablist';
import Tab from 'primevue/tab';
import TabPanels from 'primevue/tabpanels';
import TabPanel from 'primevue/tabpanel';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
export default {
    components: {
        MainLayout,
        Galleria,
        Tabs,
        TabList,
        Tab,
        TabPanel,
        TabPanels,
        DataTable,
        Column
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
