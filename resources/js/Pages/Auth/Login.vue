<template>
    <MainLayout>
        <div class="flex flex-col justify-center align-middle content-center mt-5">
            <h3 class="text-3xl text-center">Giriş yap</h3>
            <form class="flex flex-col p-5 gap-4" @submit.prevent="form.post(route('login'))">
                <div id="login-email">
                    <label for="email">E-posta</label>
                    <div v-if="$page.props.errors.email">
                        <span class="text-red-600">{{ $page.props.errors.email }}</span>
                    </div>
                    <input type="text" class="w-full" placeholder="email" id="email" name="email" v-model="form.email" />
                </div>
                <div id="login-password">
                    <label for="password">Şifre</label>
                    <div v-if="$page.props.errors.password">
                        <span class="text-red-600">{{ $page.props.errors.password }}</span>
                    </div>
                    <input type="password" class="w-full" placeholder="password" id="password" name="password" v-model="form.password" />
                </div>
                <div v-if="$page.props.errors.credentials">
                    <span class="text-red-600">{{ $page.props.errors.credentials }}</span>
                </div>
                <div id="remember-wrapper" class="flex flex-row justify-start align-middle content-center">
                    <input type="checkbox" name="remember" class="mt-1 me-1" id="remember" v-model="form.remmeber" />
                    <label for="remember">Beni hatırla</label>
                </div>
                <button type="submit" class="bg-c-pr p-2 text-c-white">Giriş yap</button>
                <Link :href="route('register')" class="text-center text-blue-500">Hesabınız yok mu? Hemen kayıt olun!</Link>
            </form>
        </div>
    </MainLayout>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout.vue";
import { useForm, Link } from "@inertiajs/vue3";
export default {
    components: {
        MainLayout,
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
