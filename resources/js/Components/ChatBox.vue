<template>
    <Link :href="route('account.chats.show', { chatID: chat.id })" class="flex flex-row w-full gap-1 mb-1 transition-all border rounded border-zinc-900 hover:border-yellow-400">
        <Avatar label="L" class="basis-2/12" size="xlarge"></Avatar>
        <div class="flex flex-col w-full basis-10/12 px-2">
            <div class="flex flex-row justify-between">
                <h5>{{ chat.users[0].name }}</h5>
                <h5>{{ chat.messages[chat.messages.length - 1].created_at }}</h5>
            </div>
            <small>{{ chat.deal.title }}</small>
            <p class="opacity-50">{{ chat.messages[chat.messages.length - 1].message }}</p>
        </div>
    </Link>
</template>

<script>
import Avatar from "primevue/avatar";
import { Link } from "@inertiajs/vue3";
export default {
    props: {
        chat: Object,
    },
    components: {
        Avatar,
        Link,
    },
};
</script>
