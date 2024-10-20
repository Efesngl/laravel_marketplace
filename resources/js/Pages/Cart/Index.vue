<template>
    <AccountLayout :backUrl="route('home')" :title="'My Cart (' + cart.length + ' Item)'">
        <template v-slot:navButton>
            <Link :href="route('cart.clear')">
                <Button icon="pi pi-trash" text></Button>
            </Link>
        </template>
        <template v-slot:content>
            <div>
                <!-- mobile view -->
                <div class="flex md:hidden flex-row justify-center h-auto min-h-[calc(100dvh-3.5rem)] items-start gap-3 pt-3 px-1">
                    <DataView :value="cart">
                        <template #list="slotProps">
                            <div class="flex flex-col gap-1 mb-24 md:mb-2">
                                <div v-for="(item, index) in slotProps.items" :key="index">
                                    <div class="flex flex-row bg-zinc-950 p-2 rounded">
                                        <div class="flex basis-1/12 items-center">
                                            <Checkbox
                                                @update:modelValue="setSelected($event, item)"
                                                v-model="item.selected"
                                                :false-value="false"
                                                :true-value="true"
                                                :binary="true"
                                            ></Checkbox>
                                        </div>
                                        <div class="flex flex-col basis-11/12">
                                            <div class="flex gap-2 justify-between flex-row">
                                                <div class="basis-4/12">
                                                    <img :src="item.product.banner" class="rounded w-full" />
                                                </div>
                                                <div class="basis-8/12">
                                                    <h4 class="text-xl">{{ item.product.title }}</h4>
                                                </div>
                                            </div>
                                            <div class="flex flex-row basis-8/12 items-center justify-between">
                                                <div class="basis-3/6">
                                                    <p class="text-lg">{{ item.product.formatted_price }} TL</p>
                                                </div>
                                                <div class="basis-3/6">
                                                    <ProductQuantity type="cart" :item="item"></ProductQuantity>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </DataView>
                    <div class="fixed md:hidden h-20 bottom-0 bg-zinc-950 p-3 left-0 justify-between flex w-dvw">
                        <div class="flex flex-col">
                            <span>Total:</span>
                            <span class="text-2xl"> {{ total }} TL</span>
                        </div>
                        <Link :href="route('cart.checkout')">
                            <Button label="Proceed to checkout" class="h-full"></Button>
                        </Link>
                    </div>
                </div>
                <!-- desktop view -->
                <div class="hidden md:flex flex-row justify-center h-auto min-h-[calc(100dvh-3.5rem)] items-start gap-3 pt-3 px-1">
                    <div class="basis-7/12">
                        <DataView :value="cart">
                            <template #list="slotProps">
                                <div class="flex flex-col gap-1 mb-24 md:mb-2">
                                    <div v-for="(item, index) in slotProps.items" :key="index">
                                        <div class="flex flex-row bg-zinc-950 p-3 rounded">
                                            <div class="flex basis-1/12 items-center">
                                                <Checkbox v-model="item.selected" :false-value="false" :true-value="true" :binary="true"></Checkbox>
                                            </div>
                                            <div class="flex flex-col basis-11/12">
                                                <div class="flex gap-2 justify-between flex-row">
                                                    <div class="basis-2/12">
                                                        <Avatar size="xlarge" :image="item.product.banner" rounded />
                                                    </div>
                                                    <div class="basis-10/12">
                                                        <h4 class="text-xl">{{ item.product.title }}</h4>
                                                        <div class="flex flex-row items-center justify-between">
                                                            <div class="basis-2/6">
                                                                <p class="text-lg">{{ item.product.formatted_price }} TL</p>
                                                            </div>
                                                            <div class="basis-2/6 flex justify-end">
                                                                <div class="w-2/3">
                                                                    <ProductQuantity type="cart" :item="item"></ProductQuantity>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </DataView>
                    </div>
                    <div class="basis-2/12 flex flex-col gap-1">
                        <div class="basis-1/3">
                            <h4>Selected items({{ selectedItems }})</h4>
                        </div>
                        <div class="basis-1/3">
                            <span class="text-xl">{{ total }} TL</span>
                        </div>
                        <div class="basis-1/3">
                            <Link :href="route('cart.checkout')">
                                <Button label="Proceed to checkout"></Button>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </AccountLayout>
</template>

<script>
import ProductQuantity from "@/Components/ProductQuantity.vue";
import AccountLayout from "@/Layouts/AccountLayout.vue";
import Avatar from "primevue/avatar";
import Button from "primevue/button";
import Checkbox from "primevue/checkbox";
import DataView from "primevue/dataview";
import InputNumber from "primevue/inputnumber";
import { Link, router } from "@inertiajs/vue3";
export default {
    props: {
        cart: Object,
        total: String,
    },
    computed: {
        selectedItems() {
            let selected = 0;
            this.cart.forEach((item) => {
                if (item.selected) selected++;
            });
            return selected;
        },
    },
    components: {
        AccountLayout,
        Button,
        DataView,
        InputNumber,
        Checkbox,
        Avatar,
        ProductQuantity,
        Link,
    },
    methods: {
        setSelected(value, item) {
            router.patch(route("cart.setselected", { cart: item.id }), {
                selected: value,
            });
        },
        clearCart(){

        }
    },
};
</script>
