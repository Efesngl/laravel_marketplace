<template>
    <AccountLayout :title="sender.name" :backUrl="route('account.chats.index')">
        <div class="flex flex-col max-h-dvh md:items-center h-[calc(100dvh-4rem)]">
            <div id="chat-product-detail" class="gap-2 flex flex-row justify-start p-1 md:w-1/2 items-center bg-zinc-950">
                <Avatar :image="chat.product.banner"></Avatar>
                <Link :href="route('product.show',{product:chat.product.id})" id="chat-product-deatil" class="flex flex-col transition hover:text-yellow-400">
                    <span class="text-xl">{{ chat.product.title }}</span>
                    <small>{{ chat.product.price }} TL</small>
                </Link>
            </div>
            <div id="messages" class="flex flex-col basis-11/12 p-3 gap-1 overflow-y-scroll md:w-1/2" ref="chatContainer">
                <MessageBubble v-for="message in messages" :received="message.user.id != this.$page.props.auth.user.id" :message="message"></MessageBubble>
            </div>
            <div id="message-form" class="flex flex-row gap-1 h-14 p-2 md:w-1/2">
                <InputText @keypress.enter.prevent="sendMessage" v-model="message" class="basis-10/12"></InputText>
                <Button @click.prevent="sendMessage" icon="pi pi-arrow-right" class="basis-2/12"></Button>
            </div>
        </div>
    </AccountLayout>
</template>

<script>
import AccountLayout from "@/Layouts/AccountLayout.vue";
import { Link, useForm } from "@inertiajs/vue3";
import InputText from "primevue/inputtext";
import Button from "primevue/button";
// import Sent from "@/Components/Message/Sent.vue";
// import Received from "@/Components/Message/Received.vue";
import MessageBubble from "@/Components/Message/MessageBubble.vue";
import Avatar from "primevue/avatar";
export default {
    props: {
        messages: Object,
        chat: Object,
        sender:Object
    },
    components: {
        AccountLayout,
        InputText,
        Button,
        MessageBubble,
        Avatar,
        Link
    },
    mounted() {
        this.scrollBottom();
        Echo.private(`chat.${this.chat.id}`).listen("MessageReceived", async (e) => {
            await this.messages.push(e.message);
            setTimeout(() => {
                this.scrollBottom();
            }, 100);
        });
    },
    data() {
        return {
            message: null,
        };
    },
    methods: {
        sendMessage() {
            axios
                .post(
                    route("message.store", { chatID: this.chat.id }),
                    { text: this.message },
                    {
                        headers: { "X-Socket-ID": window.Echo.socketId() },
                    }
                )
                .then((res) => {
                    this.message = null;
                    this.messages.push(res.data);
                    setTimeout(() => {
                        this.scrollBottom();
                    }, 100);
                });
        },
        scrollBottom() {
            this.$refs.chatContainer.scrollTop = this.$refs.chatContainer.scrollHeight;
        },
    },
};
</script>
