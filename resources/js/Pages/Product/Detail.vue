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
    <AccountLayout :backUrl="route('home')">
        <template v-slot:navButton v-if="$page.props.auth.user">
            <Button @click="addToFav" icon="pi pi-star" text v-if="product.favorites_count == 0"></Button>
            <Button @click="removeFromFav" icon="pi pi-star-fill" class="text-yellow-400" text v-else></Button>
        </template>
        <template v-slot:content>
            <div class="min-h-svh h-auto flex flex-col gap-1 md:px-16 p-3">
                <!-- main content -->
                <div class="flex flex-col md:flex-row gap-5 justify-center">
                    <div class="md:basis-6/12 basis-12/12">
                        <Galleria :value="product.images" :numVisible="3" containerClass="w-full" :showItemNavigators="true">
                            <template #item="slotProps">
                                <img :src="slotProps.item.image" alt="image" class="w-full md:h-[34rem]" />
                            </template>
                            <template #thumbnail="slotProps">
                                <img :src="slotProps.item.image" alt="image" class="md:h-24" />
                            </template>
                        </Galleria>
                        <div class="flex flex-col items-start p-2 md:hidden">
                            <h2 class="text-center md:hidden text-2xl">{{ product.title }}</h2>
                            <div class="flex flex-row gap-2 items-center">
                                <div class="flex gap-1 bg-yellow-400 bg-opacity-10 rounded p-1 flex-row">
                                    <Rating :modelValue="4" :readonly="true" :disabled="true"></Rating>
                                    <span>4</span>
                                </div>
                                <Button label="50 Review" text />
                            </div>
                            <div>
                                <h4 class="text-3xl">{{ product.formatted_price }} TL</h4>
                            </div>
                        </div>
                    </div>
                    <div id="product-detail" class="md:flex hidden flex-col border-none basis-3/12">
                        <div class="flex flex-col items-start">
                            <h2 class="text-center text-3xl">{{ product.title }}</h2>
                            <a href="/" class="text-blue-500 capitalize">Brand</a>
                            <div class="flex flex-row w-full justify-between">
                                <h4 class="text-3xl">{{ product.formatted_price }} TL</h4>
                                <div class="flex flex-row justify-center items-center gap-1">
                                    <span>4</span>
                                    <Rating :modelValue="4" :readonly="true" :disabled="true"></Rating>
                                </div>
                            </div>
                            <div class="flex justify-end w-full">
                                <span>50 Review</span>
                            </div>
                            <div class="flex flex-row gap-1">
                                <span>Seller: </span><Link :href="route('home')" class="text-blue-500 capitalize">{{ product.user.name }}</Link>
                            </div>
                        </div>

                        <div class="w-full hidden md:flex flex-row justify-between gap-1 sticky bottom-0 left-0 bg-zinc-900 p-3" v-if="$page.props.auth.user">
                            <Button v-if="product.cart.length == 0" @click="addToCart" class="p-3 basis-1/2 flex flex-col justify-center items-center hover:opacity-50 !transition">
                                <span>Add to cart</span>
                            </Button>
                            <InputNumber
                                v-else
                                @update:modelValue="setQuantity"
                                v-model="product.cart[0].quantity"
                                inputId="quantity-input"
                                showButtons
                                buttonLayout="horizontal"
                                :step="1"
                                class="basis-1/2"
                                fluid
                            >
                                <template #incrementbuttonicon>
                                    <span class="pi pi-plus" />
                                </template>
                                <template #decrementbuttonicon>
                                    <span class="pi pi-minus" v-if="product.cart[0].quantity > 1" />
                                    <span class="pi pi-trash" v-else />
                                </template>
                            </InputNumber>
                            <button
                                v-if="chat == null"
                                @click="
                                    () => {
                                        this.sendMessageDialogVisible = true;
                                    }
                                "
                                class="p-3 basis-1/2 flex flex-col justify-center items-center hover:opacity-50 !transition"
                            >
                                <span>Send message</span>
                            </button>
                            <Link
                                v-else
                                :href="route('account.chats.show', { chatID: chat.id })"
                                class="text-center bg-yellow-400 p-3 basis-1/2 text-zinc-950 rounded-md flex items-center justify-center hover:opacity-50 transition"
                                >Go to chat</Link
                            >
                        </div>
                        <div class="w-full hidden md:flex flex-row justify-center gap-1 sticky bottom-0 left-0 bg-zinc-900 p-3" v-else>
                            <Link
                                :href="route('login')"
                                class="bg-yellow-400 p-3 basis-1/2 text-zinc-950 rounded flex flex-col justify-center items-center hover:opacity-50 transition"
                            >
                                <span>Please login</span>
                            </Link>
                        </div>
                        <div>
                            <DataTable stripedRows :value="product.specifications">
                                <Column field="specification.specification"></Column>
                                <Column field="value.value"></Column>
                            </DataTable>
                        </div>
                    </div>
                    <div id="owner-detail" class="md:hidden flex flex-col border-none basis-3/12">
                        <div id="owner" class="text-start px-2">
                            <a href="/" class="text-blue-500 capitalize">{{ product.user.name }}</a>
                        </div>
                    </div>
                </div>
                <!-- tab list -->
                <div class="w-full">
                    <Tabs value="0">
                        <TabList class="!justify-center w-full">
                            <Tab value="0">Description</Tab>
                            <Tab value="1" class="md:hidden">Details</Tab>
                            <Tab value="2">Comments</Tab>
                        </TabList>
                        <TabPanels>
                            <TabPanel value="0">
                                <p class="m-0">
                                    <span v-html="product.description"></span>
                                </p>
                            </TabPanel>
                            <TabPanel value="1" class="md:hidden">
                                <DataTable stripedRows :value="product.specifications">
                                    <Column field="specification.specification" header="Spec"></Column>
                                    <Column field="value.value" header=""></Column>
                                </DataTable>
                            </TabPanel>
                            <TabPanel value="2">
                                <h4>Comments</h4>
                            </TabPanel>
                        </TabPanels>
                    </Tabs>
                </div>
            </div>
            <!-- bottom bar -->
            <div class="w-full md:hidden flex flex-row justify-between gap-1 sticky !bottom-0 left-0 bg-zinc-900 p-3" v-if="$page.props.auth.user">
                <Button v-if="product.cart.length == 0" @click="addToCart" class="p-3 basis-1/2 flex flex-col justify-center items-center hover:opacity-50 !transition">
                    <span>Add to cart</span>
                </Button>
                <InputNumber
                    v-else
                    @update:modelValue="setQuantity"
                    v-model="product.cart[0].quantity"
                    inputId="quantity-input"
                    showButtons
                    buttonLayout="horizontal"
                    :step="1"
                    class="basis-1/2"
                    fluid
                    :max="product.quantity_per_user == 0 ? product.stock : product.quantity_per_user"
                >
                    <template #incrementbuttonicon>
                        <span class="pi pi-plus"></span>
                    </template>
                    <template #decrementbuttonicon>
                        <span class="pi pi-minus" v-if="product.cart[0].quantity > 1" />
                        <span class="pi pi-trash" v-else />
                    </template>
                </InputNumber>

                <Button
                    v-if="chat == null"
                    @click="
                        () => {
                            this.sendMessageDialogVisible = true;
                        }
                    "
                    class="p-3 basis-1/2 flex flex-col justify-center items-center hover:opacity-50 !transition"
                >
                    <span>Send message</span>
                </Button>
                <Link
                    v-else
                    :href="route('account.chats.show', { chatID: chat.id })"
                    class="text-center bg-yellow-400 p-3 basis-1/2 text-zinc-950 rounded flex items-center justify-center hover:opacity-50 transition"
                    >Go to chat</Link
                >
            </div>
            <div class="w-full flex flex-row justify-center gap-1 sticky bottom-0 left-0 bg-zinc-900 p-3" v-else>
                <Link :href="route('login')" class="bg-yellow-400 p-3 basis-1/2 text-zinc-950 rounded flex flex-col justify-center items-center hover:opacity-50 transition">
                    <span>Please login</span>
                </Link>
            </div>
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
    </AccountLayout>
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
import { Link, router, useForm } from "@inertiajs/vue3";
import Toast from "primevue/toast";
import Button from "primevue/button";
import axios from "axios";
import Rating from "primevue/rating";
import InputNumber from "primevue/inputnumber";
export default {
    props: {
        product: Object,
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
        Rating,
        InputNumber,
    },
    mounted() {
        this.product.images.push({
            image: this.product.banner,
        });
    },
    data() {
        return {
            sendMessageDialogVisible: false,
            message: useForm({
                message: null,
                receiverID: this.product.user.id,
                productID: this.product.id,
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
            axios.post(route("favorites.store"), { productID: this.product.id }).then((e) => {
                this.product.favorites_count = 1;
            });
        },
        removeFromFav() {
            axios.delete(route("favorites.destroy", { productID: this.product.id })).then((e) => {
                this.product.favorites_count = 0;
            });
        },
        addToCart() {
            router.post(route("cart.store"), { productID: this.product.id });
        },
        setQuantity(quantity) {
            axios
                .post(route("cart.update", { cart: this.product.cart[0].id }), {
                    _method: "patch",
                    quantity: quantity,
                })
                .then((e) => {
                    if (quantity == 0) {
                        this.product.cart = [];
                    }
                });
        },
    },
};
</script>
