<style>
.p-tablist-tab-list {
    justify-content: center !important;
}
.p-galleria-prev-icon,
.p-galleria-next-icon {
    mix-blend-mode: difference;
}
</style>
<template>
    <AccountLayout title="deal" :backUrl="route('home')">
        <template v-slot:navButton>
            <Button @click="addToFav" icon="pi pi-star" text v-if="deal.favorites.length == 0"></Button>
            <Button @click="removeFromFav" icon="pi pi-star-fill" class="text-yellow-400" text v-else></Button>
        </template>
        <div class="min-h-svh h-auto flex flex-col gap-1">
            <h2 class="text-center text-2xl">{{ deal.title }}</h2>
            <div>
                <Galleria :value="deal.images" :numVisible="3" containerStyle="w-full" :showItemNavigators="true">
                    <template #item="slotProps">
                        <img :src="slotProps.item.image" alt="image" style="width: 100%" />
                    </template>
                    <template #thumbnail="slotProps">
                        <img :src="slotProps.item.image" alt="image" />
                    </template>
                </Galleria>
            </div>

            <div id="owner-detail" class="flex flex-col border-b">
                <div id="owner" class="text-center">
                    <a href="/" class="text-blue-500">{{ deal.user.name }}</a>
                </div>
                <div id="address" class="text-center">
                    <a class="text-blue-500">{{ deal.city.name }}</a
                    ><small>/</small><a class="text-blue-500">{{ deal.district.name }}</a
                    ><small>/</small><a class="text-blue-500">{{ deal.neighbourhood.name }}</a>
                </div>
            </div>
            <div>
                <Tabs value="0">
                    <TabList class="!justify-center w-full">
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
                            <p class="m-0">Location</p>
                        </TabPanel>
                    </TabPanels>
                </Tabs>
            </div>
        </div>
        <div class="w-full flex flex-row justify-between gap-1 sticky bottom-0 left-0 bg-zinc-900 p-3">
            <a :href="route('home')" class="bg-yellow-400 p-3 basis-1/2 text-zinc-950 rounded flex flex-col justify-center items-center hover:opacity-50 transition">
                <span>Buy</span>
                <small class="text-sm">{{ deal.price }} TL</small>
            </a>
            <button
                v-if="chat == null"
                @click="
                    () => {
                        this.sendMessageDialogVisible = true;
                    }
                "
                class="bg-yellow-400 p-3 basis-1/2 text-zinc-950 rounded flex items-center justify-center hover:opacity-50 transition"
            >
                <span>Send message</span>
            </button>
            <Link v-else :href="route('account.chats.show', { chatID: chat.id })" class="text-center bg-yellow-400 p-3 basis-1/2 text-zinc-950 rounded flex items-center justify-center hover:opacity-50 transition">Go to chat</Link>
        </div>
    </AccountLayout>
    <Dialog contentClass="w-80 flex flex-col items-center gap-2" v-model:visible="sendMessageDialogVisible" modal :draggable="false">
        <h5 class="text-lg">Send an message</h5>
        <InputText @keypress.enter="sendMessage" v-model="message.message" fluid></InputText>
        <div class="flex flex-col gap-1 w-full">
            <button @click="sendMessage" class="bg-emerald-400 rounded-lg p-2 w-full">Send</button>
            <button
                @click="
                    () => {
                        sendMessageDialogVisible = false;
                    }
                "
                class="w-full bg-red-400 rounded-lg p-2"
            >
                Cancel
            </button>
        </div>
    </Dialog>
    <Toast class="!w-80"></Toast>
</template>

<script>
import Galleria from "primevue/galleria";
import Tabs from "primevue/tabs";
import TabList from "primevue/tablist";
import Tab from "primevue/tab";
import TabPanels from "primevue/tabpanels";
import TabPanel from "primevue/tabpanel";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import AccountLayout from "@/Layouts/AccountLayout.vue";
import Dialog from "primevue/dialog";
import InputText from "primevue/inputtext";
import { Link, useForm } from "@inertiajs/vue3";
import Toast from "primevue/toast";
import Button from "primevue/button";
import axios from "axios";
export default {
    props: {
        deal: Object,
        chat: Object,
    },
    components: {
        Galleria,
        Tabs,
        TabList,
        Tab,
        TabPanel,
        TabPanels,
        DataTable,
        Column,
        AccountLayout,
        InputText,
        Dialog,
        Link,
        Toast,
        Button,
    },
    mounted() {
        this.deal.images.push({
            image: this.deal.banner,
        });
    },
    data() {
        return {
            sendMessageDialogVisible: false,
            message: useForm({
                message: null,
                receiverID: this.deal.user.id,
                dealId: this.deal.id,
            }),
        };
    },
    methods: {
        sendMessage() {
            this.message.post(route("chat.store"), {
                onSuccess: (page) => {
                    this.$toast.add({ severity: "success", summary: "Message sent", life: 3000 });
                    this.sendMessageDialogVisible = false;
                    this.message.reset("message");
                },
            });
        },
        addToFav() {
            axios.post(route("favorites.store"), { dealID: this.deal.id }).then((e) => {
                this.deal.favorites[0] = e.data;
            });
        },
        removeFromFav() {
            console.log(this.deal.favorites.id);
            axios.delete(route("favorites.destroy", { favID: this.deal.favorites[0].id })).then((e) => {
                this.deal.favorites = [];
            });
        },
    },
};
</script>
