<template>
    <AccountLayout title="Login" :backUrl="route('home')">
        <div class="flex justify-center h-[calc(100dvh-3.5rem)]">
            <form class="flex flex-col p-5 gap-4" @submit.prevent="form.post(route('login'))">
                <div id="login-email">
                    <label for="email">Email</label>
                    <div v-if="$page.props.errors.email">
                        <span class="text-red-600">{{ $page.props.errors.email }}</span>
                    </div>
                    <InputText type="text" class="w-full p-3 focus:border-yellow-400 focus:border-2 focus:outline-none rounded-md" id="email" name="email" v-model="form.email" />
                </div>
                <div id="login-password">
                    <label for="password">Password</label>
                    <div v-if="$page.props.errors.password">
                        <span class="text-red-600">{{ $page.props.errors.password }}</span>
                    </div>
                    <InputText
                        type="password"
                        class="w-full p-3 focus:border-yellow-400 focus:border-2 focus:outline-none rounded-md"
                        id="password"
                        name="password"
                        v-model="form.password"
                    />
                    <Link :href="route('home')">Forgot your password ?</Link>
                </div>
                <div v-if="$page.props.errors.credentials">
                    <span class="text-red-600">{{ $page.props.errors.credentials }}</span>
                </div>
                <div id="remember-wrapper" class="flex flex-row justify-start gap-1 items-center">
                    <Checkbox input-id="login-remember" :binary="true" v-model="form.remmeber" :true-value="true" :false-value="false" />
                    <label for="login-remember">Remember me</label>
                </div>
                <button type="submit" class="bg-yellow-400 p-2 text-zinc-950 rounded">Login</button>
                <Link :href="route('register')" class="text-center">Don't have an account? Register now !</Link>
            </form>
        </div>
    </AccountLayout>
</template>

<script>
import AccountLayout from "@/Layouts/AccountLayout.vue";
import { useForm, Link } from "@inertiajs/vue3";
import Button from "primevue/button";
import Checkbox from "primevue/checkbox";
import InputText from "primevue/inputtext";
export default {
    components: {
        AccountLayout,
        Link,
        InputText,
        Button,
        Checkbox,
    },
    data() {
        return {
            form: useForm({
                email: null,
                password: null,
                remmeber: false,
            }),
        };
    },
};
</script>
