<template>
    <AccountLayout title="Login">
        <div class="flex flex-col justify-start h-content-bboff">
            <h3 class="text-3xl text-center">Login</h3>
            <form class="flex flex-col p-5 gap-4" @submit.prevent="form.post(route('login'))">
                <div id="login-email">
                    <label for="email">Email</label>
                    <div v-if="$page.props.errors.email">
                        <span class="text-red-600">{{ $page.props.errors.email }}</span>
                    </div>
                    <input type="text" class="w-full p-3 focus:border-yellow-400 focus:border-2 focus:outline-none rounded-md" id="email" name="email" v-model="form.email" />
                </div>
                <div id="login-password">
                    <label for="password">Password</label>
                    <div v-if="$page.props.errors.password">
                        <span class="text-red-600">{{ $page.props.errors.password }}</span>
                    </div>
                    <input type="password" class="w-full p-3 focus:border-yellow-400 focus:border-2 focus:outline-none rounded-md" id="password" name="password" v-model="form.password" />
                </div>
                <div v-if="$page.props.errors.credentials">
                    <span class="text-red-600">{{ $page.props.errors.credentials }}</span>
                </div>
                <div id="remember-wrapper" class="flex flex-row justify- gap-1 start items-center">
                    <input type="checkbox" name="remember" id="remember" v-model="form.remmeber" />
                    <label for="remember">Remember me</label>
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
export default {
    components: {
        AccountLayout,
        Link,
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
