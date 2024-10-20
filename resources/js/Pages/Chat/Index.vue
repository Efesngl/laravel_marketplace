<template>
    <AccountLayout title="Message box" :backUrl="route('account.index')">
        <tempalte v-slot:content>
            <div id="chats-wrapper" class="mt-2 mx-auto h-dvh md:w-1/2 flex flex-col items-center">
                <ChatBox v-for="chat in chats" :chat="chat" v-if="chats.length > 0"></ChatBox>
                <h5 class="text-center text-xl" v-else>You dont have any message</h5>
            </div>
        </tempalte>
    </AccountLayout>
</template>

<script>
import AccountLayout from "@/Layouts/AccountLayout.vue";
import ChatBox from "@/Components/ChatBox.vue";
export default {
    props: {
        chats: Object,
    },
    components: {
        AccountLayout,
        ChatBox,
    },
};
</script>
