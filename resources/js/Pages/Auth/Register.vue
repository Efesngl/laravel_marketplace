<template>
    <Head>
        <title>Register</title>
    </Head>
    <AccountLayout title="Register" :backUrl="route('home')">
        <template v-slot:content>
            <div class="flex justify-center">
                <form class="flex flex-col p-5 gap-4" @submit.prevent="form.post(route('register'))">
                    <div id="register-name">
                        <label for="email">Your name</label>
                        <div v-if="$page.props.errors.name">
                            <span class="text-red-600">{{ $page.props.errors.name }}</span>
                        </div>
                        <InputText type="text" class="w-full" id="name" name="name" v-model="form.name" />
                    </div>
                    <div id="birth-year" class="flex flex-col">
                        <label for="birth-year">Birth date</label>
                        <div v-if="$page.props.errors.birthDate">
                            <span class="text-red-600">{{ $page.props.errors.birthDate }}</span>
                        </div>
                        <DatePicker dateFormat="yy/mm/dd" showIcon :maxDate="maxDate()" name="birth-year" id="birth-year" v-model="form.birthDate" />
                    </div>
                    <div id="register-email">
                        <label for="email">Email</label>
                        <div v-if="$page.props.errors.email">
                            <span class="text-red-600">{{ $page.props.errors.email }}</span>
                        </div>
                        <InputText type="text" class="w-full" id="email" name="email" v-model="form.email" />
                    </div>
                    <div id="register-tcno">
                        <label for="tcno">Tcno</label>
                        <div v-if="$page.props.errors.tcno">
                            <span class="text-red-600">{{ $page.props.errors.tcno }}</span>
                        </div>
                        <InputText type="text" class="w-full" id="tcno" name="tcno" v-model="form.tcno" />
                    </div>
                    <div id="register-iban">
                        <label for="iban">Iban</label>
                        <div v-if="$page.props.errors.iban">
                            <span class="text-red-600">{{ $page.props.errors.iban }}</span>
                        </div>
                        <InputText type="text" class="w-full" id="iban" name="iban" v-model="form.iban" />
                    </div>
                    <div id="register-address">
                        <label for="address">Addres</label>
                        <div v-if="$page.props.errors.address">
                            <span class="text-red-600">{{ $page.props.errors.address }}</span>
                        </div>
                        <InputText type="text" class="w-full" id="address" name="address" v-model="form.address" />
                    </div>
                    <div id="register-password">
                        <label for="password">Password</label>
                        <div v-if="$page.props.errors.password">
                            <span class="text-red-600">{{ $page.props.errors.password }}</span>
                        </div>
                        <InputText type="password" class="w-full mb-4" id="password" name="password" v-model="form.password" />
                        <label for="password-confirmation">Password again</label>
                        <div v-if="$page.props.errors.password_confirmation">
                            <span class="text-red-600">{{ $page.props.errors.password_confirmation }}</span>
                        </div>
                        <InputText type="password" class="w-full" id="password_confirmation" name="password_confirmation" v-model="form.password_confirmation" />
                    </div>
                    <div id="gender-wrapper" class="flex flex-col justify-center items-start">
                        <h2 for="gender">Cinsiyetiniz</h2>
                        <div v-if="$page.props.errors.gender">
                            <span class="text-red-600">{{ $page.props.errors.gender }}</span>
                        </div>
                        <div class="flex flex-row gap-2">
                            <div class="flex flex-row items-center gap-1">
                                <RadioButton name="gender" value="0" id="gender_male" v-model="form.gender" />
                                <label for="gender_male">Male</label>
                            </div>
                            <div class="flex flex-row items-center gap-1">
                                <RadioButton name="gender" value="1" id="gender_female" v-model="form.gender" />
                                <label for="gender_female">Female</label>
                            </div>
                        </div>
                    </div>
                    <Button type="submit">Register</Button>
                    <Link :href="route('login')" class="text-center text-zinc-50">Already have an account ? Sign in now !</Link>
                </form>
            </div>
        </template>
    </AccountLayout>
</template>

<script>
import AccountLayout from "@/Layouts/AccountLayout.vue";
import { useForm, Link, Head } from "@inertiajs/vue3";
import InputText from "primevue/inputtext";
import DatePicker from "primevue/datepicker";
import RadioButton from "primevue/radiobutton";
import Button from "primevue/button";

export default {
    components: {
        AccountLayout,
        Link,
        Head,
        InputText,
        DatePicker,
        RadioButton,
        Button,
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
            date = new Date(`${date.getFullYear()}-${month}-${date.getDate()}`);
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
                tcno: null,
                address: null,
                iban: null,
            }),
        };
    },
};
</script>
