<template>
    <AccountLayout bg="" title="Orders" :backUrl="route('home')">
        <template v-slot:content>
            <div class="h-[calc(100dvh-3.5rem)] flex p-2">
                <div class="flex flex-col justify-start md:items-center gap-4 w-full">
                    <DataTable stripedRows :value="orders">
                        <Column field="id" header="Order ID"></Column>
                        <Column field="total" header="Total"></Column>
                        <Column header="Status"></Column>
                    </DataTable>
                </div>
            </div>
        </template>
    </AccountLayout>
</template>

<script>
import AccountLayout from "../../Layouts/AccountLayout.vue";
import { Link } from "@inertiajs/vue3";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
export default {
    props:{
        orders:Object
    },
    components: {
        AccountLayout,
        Link,
        DataTable,
        Column
    },
};
</script>
