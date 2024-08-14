<style>
.p-tab {
    background-color: #18181b !important;
}
</style>
<template>
    <AccountLayout title="Account Details" :backUrl="route('account.index')">
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
                                        <InputText type="text" name="name" id="name" v-model="account.name" />
                                        <Message severity="error" class="mt-1" v-if="account.errors.name">{{ account.errors.name }}</Message>
                                    </div>
                                    <div class="flex flex-col">
                                        <label for="birth-date">Birth date</label>
                                        <DatePicker name="birth-date" showIcon date-format="yy-mm-dd" class="w-full" id="birth-date" v-model="account.birthDate" :maxDate="maxDate()" />
                                        <Message severity="error" class="mt-1" v-if="account.errors.birthDate">{{ account.errors.birthDate }}</Message>
                                    </div>
                                    <div class="flex flex-col">
                                        <label for="iban">Iban</label>
                                        <InputText name="iban" class="w-full" id="iban" v-model="account.iban" />
                                        <Message severity="error" class="mt-1" v-if="account.errors.iban">{{ account.errors.iban }}</Message>
                                    </div>
                                    <div class="flex flex-col">
                                        <label for="address">Address</label>
                                        <InputText name="address" class="w-full" id="address" v-model="account.address" />
                                        <Message severity="error" class="mt-1" v-if="account.errors.address">{{ account.errors.address }}</Message>
                                    </div>
                                    
                                    <div class="flex flex-col">
                                        <h4 for="birth-date">Gender</h4>
                                        <div class="flex flex-row items-center justify-start gap-1">
                                            <RadioButton type="radio" name="gender" :value="0" inputId="gender_male" v-model="account.gender" />
                                            <label for="gender_male">Male</label>
                                            <RadioButton type="radio" name="gender" :value="1" inputId="gender_female" v-model="account.gender" />
                                            <label for="gender_female">Female</label>
                                        </div>
                                        <Message severity="error" class="mt-1" v-if="account.errors.gender">{{ account.errors.gender }}</Message>
                                    </div>
                                    <div class="flex justify-center">
                                        <Button type="submit" class="text-center p-2" label="Update"></Button>
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
                                        <InputText @keypress.enter.prevent="updateEmail" type="text" name="email" id="email" v-model="email.email" />
                                        <Message severity="error" class="mt-1" v-if="email.errors.email">{{ email.errors.email }}</Message>
                                    </div>
                                    <div class="flex justify-center">
                                        <Button type="submit" class="text-center p-2 disabled:opacity-50" :disabled="email.email == this.$page.props.auth.user.email" label="Update"></Button>
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
                                        <InputText type="text" name="phoneNumber" id="phoneNumber" v-model="phoneNumber.phoneNumber" />
                                        <Message severity="error" class="mt-1" v-if="phoneNumber.errors.phoneNumber">{{ phoneNumber.errors.phoneNumber }}</Message>
                                    </div>
                                    <div class="flex justify-center">
                                        <Button type="submit" class="text-center p-2" label="Update"></Button>
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
                                        <InputText type="text" name="old-password" id="old-password" v-model="password.oldPassword" />
                                        <Message severity="error" class="mt-1" v-if="password.errors.oldPassword">{{ password.errors.oldPassword }}</Message>
                                        <label for="name">New Password</label>
                                        <InputText type="text" name="new-password" id="new-password" v-model="password.newPassword" />
                                        <Message severity="error" class="mt-1" v-if="password.errors.newPassword">{{ password.errors.newPassword }}</Message>
                                        <label for="name">New Password again</label>
                                        <InputText type="text" name="new-password-confirmation" id="new-password-confirmation" v-model="password.newPassword_confirmation" />
                                    </div>
                                    <div class="flex justify-center">
                                        <Button type="submit" class="text-center p-2" label="Update"></Button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </TabPanel>
                </TabPanels>
            </Tabs>
        </div>
        <Toast class="!w-80"></Toast>
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
import InputText from "primevue/inputtext";
import DatePicker from "primevue/datepicker";
import RadioButton from "primevue/radiobutton";
import Message from "primevue/message";
import Toast from "primevue/toast";
import Button from "primevue/button";
export default {
    components: {
        AccountLayout,
        Link,
        Tabs,
        TabList,
        TabPanel,
        TabPanels,
        Tab,
        InputText,
        DatePicker,
        RadioButton,
        Message,
        Toast,
        Button
    },
    methods: {
        maxDate() {
            let date = new Date();
            date.setFullYear(date.getFullYear() - 18);
            let month = date.getMonth();
            if (month < 10) {
                month = `0${month}`;
            }
            date.setMonth(month)
            return date;
        },
        updateProfile() {
            this.account.post(route("account.update.profile"), {
                onSuccess: () =>this.$toast.add({ severity: 'success', summary: 'Profile updated', life: 3000 })
            });
        },
        updateEmail() {
            this.email.post(route("account.update.email"), {
                onSuccess: () => this.$toast.add({ severity: 'success', summary: 'Email updated', life: 3000 })
            });
        },
        updatePhone() {
            this.phoneNumber.post(route("account.update.phone"), {
                onSuccess: () => this.$toast.add({ severity: 'success', summary: 'Phone number updated', life: 3000 }),
            });
        },
        checkLenght(event) {
            if (event.target.value.length == 10) {
                event.preventDefault();
            }
        },
        updatePassword() {
            this.password.post(route("account.update.password"), {
                onSuccess: () => {
                    this.$toast.add({ severity: 'success', summary: 'Password updated', life: 3000 });
                    this.password.reset()
                },
            });
        },
    },
    data() {
        return {
            account: useForm({
                name: this.$page.props.auth.user.name,
                birthDate: this.$page.props.auth.user.birth_date,
                gender: this.$page.props.auth.user.gender,
                iban:this.$page.props.auth.user.iban,
                address:this.$page.props.auth.user.address
            }),
            email: useForm({
                email: this.$page.props.auth.user.email,
            }),
            password: useForm({
                oldPassword: null,
                newPassword: null,
                newPassword_confirmation: null,
            }),
            phoneNumber: useForm({
                phoneNumber: this.$page.props.auth.user.phone_number,
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
};
</script>
