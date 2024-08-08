<template>
    <AccountLayout title="Message box" :backUrl="route('account.index')">
        <ChatBox v-for="chat in chats" :chat="chat" v-if="chats.length>0"></ChatBox>
        
        <h5 class="text-center text-xl" v-else>You dont have any message</h5>
    </AccountLayout>
</template>

<script>
    import AccountLayout from '@/Layouts/AccountLayout.vue'
    import ChatBox from '@/Components/ChatBox.vue'
    export default{
        props:{
            chats:Object
        },
        components:{
            AccountLayout,
            ChatBox
        }
    }
</script>