<template>
    <MainLayout>
        <div class="min-h-svh h-auto flex flex-col gap-1">
            <h2 class="text-center text-2xl">Deal</h2>
            <Carousel :Images="images"></Carousel>
            <div id="owner-detail" class="flex flex-col border-b">
                <div id="owner" class="text-center">
                    <a href="/" class="text-blue-500">Efe Şengül</a>
                </div>
                <div id="address" class="text-center">
                    <a class="text-blue-500">İzmir</a><small>/</small><a class="text-blue-500">Karabağlar</a><small>/</small><a class="text-blue-500">Esenlik Mahallesi</a>
                </div>
            </div>
            <div>
                <TabGroup>
                    <TabList class="flex flex-row justify-center gap-4 border-b-2 border-c-pr">
                        <Tab v-slot="{selected}" class="focus-visible:outline-none"><button class="p-2 border-b-0 border focus-visible:outline-none" :class="{'bg-c-white text-c-black':!selected,'bg-c-pr text-c-white':selected}">Deal details</button></Tab>
                        <Tab v-slot="{selected}" class="focus-visible:outline-none"><button class="p-2 border-b-0 border focus-visible:outline-none" :class="{'bg-c-white text-c-black':!selected,'bg-c-pr text-c-white':selected}">Description</button></Tab>
                        <Tab v-slot="{selected}" class="focus-visible:outline-none"><button class="p-2 border-b-0 border focus-visible:outline-none" :class="{'bg-c-white text-c-black':!selected,'bg-c-pr text-c-white':selected}">Location</button></Tab>
                    </TabList>
                    <TabPanels>
                        <TabPanel class="mt-2">Deal Details</TabPanel>
                        <TabPanel class="mt-2 h-auto">
                            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ipsum minima earum molestias officiis expedita, sunt quibusdam recusandae repudiandae, unde eum esse fugit autem nostrum asperiores in modi. Minus architecto perspiciatis officia, nam et necessitatibus a labore officiis placeat! Facere, cupiditate nesciunt dolorum minima velit earum molestias aliquam ratione nemo tenetur inventore illo recusandae ullam itaque dolore odio perspiciatis commodi magnam quidem. Veniam doloribus voluptates iusto cum molestiae vitae tempora ab nihil, nobis et. Odio obcaecati quas aperiam temporibus fuga suscipit ratione placeat quo beatae enim modi iste atque eveniet eligendi voluptate deserunt, consequuntur repellat! Quam error illo architecto, at maxime harum ratione nobis mollitia quia labore quasi dicta vero rem dolorem fugit sint et consectetur ut optio. Maxime tempora inventore sequi suscipit, ipsa rem, dolorem alias quasi voluptas enim in vitae temporibus nihil dicta beatae voluptatibus repellat! Totam corporis optio ducimus voluptates? Voluptas eligendi quibusdam distinctio beatae, in quia fugiat aspernatur assumenda accusantium libero deserunt magni ea architecto magnam maxime rem sapiente voluptatem harum explicabo aperiam exercitationem iste eos inventore atque? Odit id nihil tempore! Quo architecto quidem aliquam fugiat accusantium praesentium, necessitatibus tempora deserunt recusandae voluptates a numquam, quos, hic labore consectetur at amet?
                        </TabPanel>
                        <TabPanel class="mt-2">Content 3</TabPanel>
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
};
</script>
