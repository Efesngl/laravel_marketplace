<template>
    <div class="flex flex-col rounded-lg p-3 w-3/4" :class="{'bg-yellow-400 text-zinc-950 self-end':!received,' bg-zinc-800 text-zinc-50 self-start':received}">
        <div id="header" class="w-full border-b border-zinc-900">
            <h5 class="text-lg" v-if="!received">You</h5>
            <h5 class="text-lg" v-else>{{ message.user.name }}</h5>
        </div>
        <div id="message" class="w-full">
            {{ message.message }}
        </div>
        <div class="w-full flex flex-row justify-end">
            <small>{{ message.created_at }}</small>
        </div>
    </div>
</template>

<script>
    export default{
        props:{
            message:Object,
            received:Boolean
        }
    }
</script>
