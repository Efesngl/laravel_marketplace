<style>
.p-tab {
    background-color: #18181b !important;
}
</style>
<template>
    <AccountLayout title="Account Details" :backUrl="route('account')">
        <div class="h-auto">
            <Tabs value="0" scrollable>
                <TabList>
                    <Tab value="0">Profile</Tab>
                    <Tab value="1">Email</Tab>
                    <Tab value="2">Phone number</Tab>
                    <Tab value="3">Password</Tab>
                </TabList>
                <TabPanels>
                    <TabPanel value="0">
                        <div class="pt-3">
                            <h2 class="text-center text-3xl">Profile Information</h2>
                            <form @submit.prevent="updateProfile">
                                <div class="flex flex-col gap-4 p-2">
                                    <div class="flex flex-col" id="account-detail-name">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" v-model="account.name" />
                                    </div>
                                    <div class="flex flex-col">
                                        <label for="birth-date">Birth date</label>
                                        <input type="date" name="birth-date" class="w-full" id="birth-date" v-model="account.birthDate" :max="maxDate()" />
                                    </div>
                                    <div class="flex flex-col">
                                        <h4 for="birth-date">Cinsiyet</h4>
                                        <div class="flex flex-row items-center justify-start gap-1">
                                            <input type="radio" name="gender" :value="0" id="gender_male" v-model="account.gender" />
                                            <label for="gender_male">Male</label>
                                            <input type="radio" name="gender" :value="1" id="gender_female" v-model="account.gender" />
                                            <label for="gender_female">Female</label>
                                        </div>
                                    </div>
                                    <div class="flex justify-center">
                                        <button class="text-center bg-yellow-400 text-c-white p-2">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </TabPanel>
                    <TabPanel value="1">
                        <div class="pt-3">
                            <h2 class="text-center text-3xl">Change email</h2>
                            <form action="" @submit.prevent="updateEmail">
                                <div class="flex flex-col gap-4 p-2" id="account-detail-email">
                                    <div class="flex flex-col">
                                        <label for="email">Email</label>
                                        <span v-if="email.errors.email" class="text-red-500">{{ email.errors.email }}</span>
                                        <input @keypress="clearErrors(email)" type="text" name="email" id="email" v-model="email.email" />
                                    </div>
                                    <div class="flex justify-center">
                                        <button class="text-center bg-yellow-400 text-c-white p-2 disabled:opacity-50" :disabled="email.email == user.email">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </TabPanel>
                    <TabPanel value="2">
                        <div class="pt-3">
                            <h2 class="text-center text-3xl">Change Phone Number</h2>
                            <form action="" @submit.prevent="updatePhone">
                                <div class="flex flex-col gap-4 p-2" id="account-detail-phone">
                                    <div class="flex flex-col">
                                        <label for="phoneNumber">Phone number</label>
                                        <small>Without the 0 at the start !</small>
                                        <input type="number" @keypress="checkLenght" name="phoneNumber" id="phoneNumber" v-model="phoneNumber.phoneNumber" />
                                    </div>
                                    <div class="flex justify-center">
                                        <button class="text-center bg-yellow-400 text-c-white p-2">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </TabPanel>
                    <TabPanel value="3">
                        <div class="pt-3">
                            <h2 class="text-center text-3xl">Change password</h2>
                            <form @submit.prevent="updatePassword">
                                <div class="flex flex-col gap-4 p-2" id="account-detail-password">
                                    <div class="flex flex-col">
                                        <label for="name">Old Password</label>
                                        <small class="text-red-500" v-if="password.errors.oldPassword">{{ password.errors.oldPassword }}</small>
                                        <input type="text" name="old-password" id="old-password" v-model="password.oldPassword" />
                                        <label for="name">New Password</label>
                                        <small class="text-red-500" v-if="password.errors.newPassword">{{ password.errors.newPassword }}</small>
                                        <input type="text" name="new-password" id="new-password" v-model="password.newPassword" />
                                        <label for="name">New Password</label>
                                        <input type="text" name="new-password-confirmation" id="new-password-confirmation" v-model="password.newPassword_confirmation" />
                                    </div>
                                    <div class="flex justify-center">
                                        <button type="submit" class="text-center bg-yellow-400 text-c-white p-2">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </TabPanel>
                </TabPanels>
            </Tabs>
        </div>
    </AccountLayout>
</template>

<script>
import AccountLayout from "@/Layouts/AccountLayout.vue";
import { Link, useForm } from "@inertiajs/vue3";
import Tabs from "primevue/tabs";
import TabList from "primevue/tablist";
import Tab from "primevue/tab";
import TabPanels from "primevue/tabpanels";
import TabPanel from "primevue/tabpanel";
export default {
    components: {
        AccountLayout,
        Link,
        Tabs,
        TabList,
        TabPanel,
        TabPanels,
        Tab,
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
        updateProfile() {
            this.account.post(route("account.update.profile"), {
                onSuccess: () => this.$swal(this.swalOptions),
            });
        },
        updateEmail() {
            this.email.post(route("account.update.email"), {
                onSuccess: () => this.$swal(this.swalOptions),
            });
        },
        updatePhone() {
            this.phoneNumber.post(route("account.update.phone"), {
                onSuccess: () => this.$swal(this.swalOptions),
            });
        },
        checkLenght(event) {
            if (event.target.value.length == 10) {
                event.preventDefault();
            }
        },
        updatePassword() {
            this.password.post(route("account.update.password"), {
                onSuccess: () => this.$swal(this.swalOptions),
            });
        },
    },
    data() {
        return {
            user: this.$page.props.auth.user,
            account: useForm({
                name: null,
                birthDate: null,
                gender: null,
            }),
            email: useForm({
                email: null,
            }),
            password: useForm({
                oldPassword: null,
                newPassword: null,
                newPassword_confirmation: null,
            }),
            phoneNumber: useForm({
                phoneNumber: null,
            }),
            selectedTab: 0,
            tabs: [
                {
                    id: 0,
                    title: "Profil Informations",
                },
                {
                    id: 1,
                    title: "Change email",
                },
                {
                    id: 2,
                    title: "Change phone number",
                },
                {
                    id: 3,
                    title: "Change password",
                },
            ],
            swalOptions: {
                toast: "true",
                position: "top-right",
                icon: "success",
                title: "Başarıyla güncellendi",
                showConfirmButton: false,
                timer: "2000",
                timerProgressBar: true,
            },
        };
    },
    mounted() {
        this.account.name = this.user.name;
        this.email.email = this.user.email;
        this.account.birthDate = this.user.birth_date;
        this.account.gender = this.user.gender;
        this.phoneNumber.phoneNumber = this.user.phone_number;
    },
};
</script>
