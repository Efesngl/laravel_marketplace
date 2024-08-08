<template>
    <AccountLayout title="Username" :backUrl="route('account.chats.index')">
        <div class="flex flex-col max-h-dvh h-[calc(100dvh-4rem)]">
            <div id="messages" class="flex flex-col basis-11/12 p-3 gap-1 overflow-y-scroll" ref="chatContainer">
                <MessageBubble v-for="message in messages" :received="message.user.id != this.$page.props.auth.user.id" :message="message"></MessageBubble>
            </div>
            <div id="message-form" class="flex flex-row gap-1 h-14 p-2">
                <InputText @keypress.enter.prevent="sendMessage" v-model="message" class="basis-10/12"></InputText>
                <Button @click.prevent="sendMessage" icon="pi pi-arrow-right" class="basis-2/12"></Button>
            </div>
        </div>
    </AccountLayout>
</template>

<script>
import AccountLayout from "@/Layouts/AccountLayout.vue";
import { useForm } from "@inertiajs/vue3";
import InputText from "primevue/inputtext";
import Button from "primevue/button";
// import Sent from "@/Components/Message/Sent.vue";
// import Received from "@/Components/Message/Received.vue";
import MessageBubble from "@/Components/Message/MessageBubble.vue";
export default {
    props: {
        messages: Object,
        chat: Object,
    },
    components: {
        AccountLayout,
        InputText,
        Button,
        MessageBubble,
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
