<template>
    <InputNumber
        @input="setQuantity"
        v-model="item.quantity"
        inputId="quantity-input"
        showButtons
        buttonLayout="horizontal"
        :step="1"
        class="basis-1/2"
        fluid
        :max="item.quantity_per_user == 0 ? item.stock : item.product.quantity_per_user"
    >
        <template #incrementbuttonicon>
            <span class="pi pi-plus"></span>
        </template>
        <template #decrementbuttonicon>
            <span class="pi pi-minus" v-if="item.quantity > 1" />
            <span class="pi pi-trash" v-else />
        </template>
    </InputNumber>
</template>

<script>
import axios from "axios";
import InputNumber from "primevue/inputnumber";
import { router } from "@inertiajs/vue3";
export default {
    props: {
        item: Object,
        type: String,
    },
    components: {
        InputNumber,
    },
    methods: {
        setQuantity() {
            router.patch(route("cart.setquantity", { cart: this.item.id }), {
                quantity: this.item.quantity,
                type: this.type,
            });
        },
    },
};
</script>
