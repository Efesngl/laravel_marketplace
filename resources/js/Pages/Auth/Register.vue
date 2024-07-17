<template>
    <Head>
        <title>Register</title>
    </Head>
    <AccountLayout title="Register">
        <div class="flex flex-col justify-start h-content pt-5">
            <h3 class="text-3xl text-center">Register</h3>
            <form class="flex flex-col p-5 gap-4" @submit.prevent="form.post(route('register'))">
                <div id="login-name">
                    <label for="email">Your name</label>
                    <div v-if="$page.props.errors.name">
                        <span class="text-red-600">{{ $page.props.errors.name }}</span>
                    </div>
                    <input type="text" class="w-full" id="name" name="name" v-model="form.name" />
                </div>
                <div id="birth-year" class="flex flex-col">
                    <label for="birth-year">Birth date</label>
                    <input :max="maxDate()" type="date" name="birth-year" id="birth-year" v-model="form.birthDate" />
                </div>
                <div id="login-email">
                    <label for="email">Email</label>
                    <div v-if="$page.props.errors.email">
                        <span class="text-red-600">{{ $page.props.errors.email }}</span>
                    </div>
                    <input type="text" class="w-full" id="email" name="email" v-model="form.email" />
                </div>
                <div id="login-password">
                    <label for="password">Password</label>
                    <div v-if="$page.props.errors.password">
                        <span class="text-red-600">{{ $page.props.errors.password }}</span>
                    </div>
                    <input type="password" class="w-full mb-4" id="password" name="password" v-model="form.password" />
                    <label for="password-confirmation">Password again</label>
                    <div v-if="$page.props.errors.password_confirmation">
                        <span class="text-red-600">{{ $page.props.errors.password_confirmation }}</span>
                    </div>
                    <input type="password" class="w-full" id="password_confirmation" name="password_confirmation" v-model="form.password_confirmation" />
                </div>
                <div id="gender-wrapper" class="flex flex-col justify-center items-start">
                    <h2 for="gender">Cinsiyetiniz</h2>
                    <div class="flex flex-row gap-2">
                        <div class="flex flex-row items-center gap-1">
                            <input type="radio" name="gender" value="0" id="gender_male" v-model="form.gender" />
                            <label for="gender_male">Erkek</label>
                        </div>
                        <div class="flex flex-row items-center gap-1">
                            <input type="radio" name="gender" value="1" id="gender_female" v-model="form.gender" />
                            <label for="gender_female">Kadın</label>
                        </div>
                    </div>
                </div>
                <button type="submit" class="bg-c-pr p-2 text-c-white">Giriş yap</button>
                <Link :href="route('login')" class="text-center text-blue-500">Zaten bir hesabınız var mı ? Hemen giriş yapın !</Link>
            </form>
        </div>
    </AccountLayout>
</template>

<script>
import AccountLayout from "@/Layouts/AccountLayout.vue";
import { useForm, Link, Head } from "@inertiajs/vue3";
export default {
    components: {
        AccountLayout,
        Link,
        Head,
    },
    methods: {
        maxDate() {
            let date = new Date();
            date.setFullYear(date.getFullYear() - 18);
            date.setMonth(date.getMonth() + 1);
            let month = date.getMonth();
            if (month < 10) {
                month = `0${month}`;
            }
            date = `${date.getFullYear()}-${month}-${date.getDate()}`;
            return date;
        },
    },
    data() {
        return {
            form: useForm({
                name: null,
                birthDate: null,
                gender: null,
                email: null,
                password: null,
                password_confirmation: null,
            }),
        };
    },
};
</script>
