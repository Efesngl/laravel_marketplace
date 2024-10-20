<template>
    <AccountLayout :backUrl="route('cart.index')" title="Checkout" ></AccountLayout>
</template>
<script>
import AccountLayout from '@/Layouts/AccountLayout.vue';
export default {
    components:{
        AccountLayout
    }
}
</script>