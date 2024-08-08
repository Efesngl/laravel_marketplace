<template>
    <div class="flex flex-col bg-zinc-800 text-zinc-50 rounded-lg p-3">
        <div id="header" class="w-full border-b border-zinc-900">
            <h5 class="text-lg">{{ message.user.name }}</h5>
        </div>
        <div id="message" class="w-full">
            {{ message.message }}
        </div>
    </div>
</template>

<script>
export default {
    props: {
        message: Object,
    },
};
</script>
