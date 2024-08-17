<style>
.p-tablist-prev-button {
    display: none !important;
}
.p-tablist-next-button {
    display: none !important;
}
</style>
<template>
    <AccountLayout title="edit deal" :backUrl="route('account.index')">
        <div class="flex flex-col items-center gap-1">
            <h2 class="text-3xl p-2">Edit deal</h2>
            <div class="w-dvw">
                <Tabs scrollable value="1" @update:value="tabs" ref="tabs">
                    <TabList class="bg-zinc-900">
                        <Tab value="1">Deal information</Tab>
                        <Tab value="2">Images</Tab>
                        <Tab value="3">Banner</Tab>
                        <Tab value="4">Description</Tab>
                        <Tab value="5">Specifications</Tab>
                    </TabList>
                    <TabPanels>
                        <TabPanel value="1">
                            <div class="flex flex-col items-center gap-2 w-full p-3">
                                <div class="flex flex-col w-full">
                                    <label for="title">Title</label>
                                    <input
                                        v-model="deal.title"
                                        type="text"
                                        class="w-full p-2 bg-zinc-950 rounded-md border border-zinc-700 transition focus:border-yellow-400 focus:outline-none"
                                        id="title"
                                    />
                                    <Message severity="error" class="mt-1" v-if="deal.errors.title">{{ deal.errors.title }}</Message>
                                </div>
                                <div class="flex flex-col w-full">
                                    <label for="price" class="w-full text-start">Price</label>
                                    <InputNumber v-model="deal.price" fluid input-id="price" mode="currency" currency="TRY" locale="tr"></InputNumber>
                                    <Message severity="error" class="mt-1" v-if="deal.errors.price">{{ deal.errors.price }}</Message>
                                </div>
                                <div class="flex flex-col w-full">
                                    <h5>Deal Category</h5>
                                    <TreeSelect v-model="selectedCategory" @node-select="selectCategory" :options="categories" placeholder="Select category" class="w-full" />
                                    <Message severity="error" class="mt-1" v-if="deal.errors.category">{{ deal.errors.category }}</Message>
                                </div>
                                <div class="flex flex-col w-full gap-1">
                                    <h5>Deal location</h5>
                                    <div class="w-full flex flex-col gap-1">
                                        <h5>City</h5>
                                        <Select @change="setLocation($event, 0)" v-model="selectedCity" :options="locations" option-label="name"></Select>
                                        <Message severity="error" class="mt-1" v-if="deal.errors.city">{{ deal.errors.city }}</Message>
                                    </div>
                                    <div class="w-full flex flex-col gap-1">
                                        <h5>District</h5>
                                        <Select @change="setLocation($event, 1)" v-model="selectedDistrict" :options="selectedCity.districts" option-label="name"></Select>
                                        <Message severity="error" class="mt-1" v-if="deal.errors.district">{{ deal.errors.district }}</Message>
                                    </div>
                                    <div class="w-full flex flex-col gap-1">
                                        <h5>Neighbouthood</h5>
                                        <Select @change="setLocation($event, 2)" v-model="selectedNH" :options="selectedDistrict.neighbourhoods" option-label="name"></Select>
                                        <Message severity="error" class="mt-1" v-if="deal.errors.nh">{{ deal.errors.nh }}</Message>
                                    </div>
                                    <div class="w-full flex flex-row gap-1">
                                        <ToggleSwitch v-model="deal.isActive" :trueValue="1" :falseValue="0"></ToggleSwitch> <span>Is deal active</span>
                                    </div>
                                    <div class="w-full flex flex-row gap-1">
                                        <ToggleSwitch v-model="deal.isSelled" :trueValue="1" :falseValue="0"></ToggleSwitch> <span>Is deal selled</span>
                                    </div>
                                </div>
                                <div class="w-full flex flex-col gap-1 md:flex-row">
                                    <Button class="basis-1/2 !border-none !outline-none !text-zinc-50 !bg-emerald-400 text-white p-2 rounded" @click="update()" label="Update" />
                                    <Button
                                        icon="pi pi-trash"
                                        class="!w-full basis-1/2 !border-none !outline-none !text-zinc-50 !bg-red-600 text-white p-2 rounded"
                                        @click="deleteDeal"
                                        label="Delete Deal"
                                    />
                                </div>
                            </div>
                        </TabPanel>
                        <TabPanel value="2">
                            <div class="flex flex-col items-center gap-2 w-full p-3">
                                <div class="w-full px-2">
                                    <h5>Deal images</h5>
                                    <FileUpload
                                        :show-cancel-button="false"
                                        name="images[]"
                                        :url="route('deal.image')"
                                        :show-upload-button="true"
                                        :multiple="true"
                                        ref="imageUpload"
                                        @select="onSelectedFiles"
                                    >
                                        <template #header="{ chooseCallback }">
                                            <div class="flex flex-row justify-start">
                                                <Button @click="chooseCallback()">Choose Files</Button>
                                            </div>
                                        </template>
                                        <template #content="{ files, removeFileCallback }">
                                            <div class="flex flex-col gap-8 pt-4">
                                                <div v-if="files.length > 0">
                                                    <div class="flex flex-wrap gap-4">
                                                        <div
                                                            v-for="(file, index) of files"
                                                            :key="file.name + file.type + file.size"
                                                            class="p-4 rounded border-yellow-400 flex flex-col border border-surface items-center gap-4"
                                                        >
                                                            <div class="relative">
                                                                <Button
                                                                    class="!absolute right-0"
                                                                    text
                                                                    icon="pi pi-times"
                                                                    @click="onRemoveTemplatingFile(files, removeFileCallback, index)"
                                                                    severity="danger"
                                                                />
                                                                <img role="presentation" :alt="file.name" :src="file.objectURL" class="w-full" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </FileUpload>
                                    <Message severity="error" class="mt-2" v-if="deal.errors.images">{{ deal.errors.images }}</Message>
                                    <div class="flex flex-col w-full">
                                        <div class="w-full relative" v-for="image in dealProp.images">
                                            <Button severity="danger" @click="deleteImage(image.id)" icon="pi pi-times" class="!absolute z-50 top-3 right-3"></Button>
                                            <Image alt="Image" preview>
                                                <template #previewicon>
                                                    <i class="pi pi-search"></i>
                                                </template>
                                                <template #image>
                                                    <img :src="image.image" class="w-dvw" alt="image" />
                                                </template>
                                                <template #preview="slotProps">
                                                    <img :src="image.image" alt="preview" :style="slotProps.style" @click="slotProps.onClick" />
                                                </template>
                                            </Image>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full flex flex-col gap-2">
                                    <button class="w-full bg-emerald-400 text-white p-2 rounded" @click="update()">Save</button>
                                </div>
                            </div>
                        </TabPanel>
                        <TabPanel value="3">
                            <div class="flex flex-col items-center gap-2 w-full p-3">
                                <div class="w-full px-2">
                                    <h5 class="mb-2">Banner</h5>
                                    <input
                                        type="file"
                                        class="file:bg-yellow-400 file:py-2 file:px-5 file:rounded file:border-none file:text-zinc-950"
                                        name="uploadBanner"
                                        @change="deal.banner = $event.target.files[0]"
                                        id="upload-banner"
                                    />
                                    <Message severity="error" class="mt-2 mb-2" v-if="deal.errors.banner">{{ deal.errors.banner }}</Message>
                                    <div class="flex flex-col w-full mt-3">
                                        <div class="w-full relative">
                                            <Image alt="Image" preview>
                                                <template #previewicon>
                                                    <i class="pi pi-search"></i>
                                                </template>
                                                <template #image>
                                                    <img :src="dealProp.banner" class="w-dvw" alt="image" />
                                                </template>
                                                <template #preview="slotProps">
                                                    <img :src="dealProp.banner" alt="preview" :style="slotProps.style" @click="slotProps.onClick" />
                                                </template>
                                            </Image>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full flex flex-col gap-2">
                                    <button class="w-full bg-emerald-400 text-white p-2 rounded" @click="update()">Save</button>
                                </div>
                            </div>
                        </TabPanel>
                        <TabPanel value="4">
                            <div class="flex flex-col items-center gap-2 w-full p-3">
                                <div class="flex flex-col w-full">
                                    <h5>Description</h5>
                                    <Editor v-model="deal.description" @load="setContent" editor-style="height:30rem;" />
                                    <Message severity="error" class="mt-2 mb-2" v-if="deal.errors.description">{{ deal.errors.description }}</Message>
                                </div>
                                <div class="w-full flex flex-col gap-2">
                                    <button class="w-full bg-emerald-400 text-white p-2 rounded" @click="update()">Save</button>
                                </div>
                            </div>
                        </TabPanel>
                        <TabPanel value="5">
                            <div class="flex flex-col items-center gap-2 w-full p-3">
                                <div class="flex flex-col w-full">
                                    <h2>Specs</h2>
                                    <div class="flex flex-col w-full" v-for="spec of specifications">
                                        <h5>{{ spec.specification }}</h5>
                                        <Select
                                            v-model="deal.specifications[spec.id]"
                                            :options="spec.values"
                                            option-label="value"
                                            :option-value="
                                                (event) => {
                                                    return {
                                                        id: deal.specifications[event.specification_id].id,
                                                        specification_id: event.specification_id,
                                                        value_id: event.id,
                                                    };
                                                }
                                            "
                                        ></Select>
                                    </div>
                                    <Message severity="error" class="mt-2 mb-2" v-if="deal.errors.specifications">{{ deal.errors.specifications }}</Message>
                                </div>
                                <div class="w-full flex flex-col gap-2">
                                    <button class="w-full bg-emerald-400 text-white p-2 rounded" @click="update()">Save</button>
                                </div>
                            </div>
                        </TabPanel>
                    </TabPanels>
                </Tabs>
            </div>
        </div>
        <Toast class="!w-80" />
        <ConfirmDialog :draggable="false"></ConfirmDialog>
    </AccountLayout>
</template>

<script>
import { router, useForm } from "@inertiajs/vue3";
import MainLayout from "../../Layouts/MainLayout.vue";
import AccountLayout from "../../Layouts/AccountLayout.vue";
import Editor from "primevue/editor";
import FileUpload from "primevue/fileupload";
import TreeSelect from "primevue/treeselect";
import InputNumber from "primevue/inputnumber";
import Button from "primevue/button";
import RadioButton from "primevue/radiobutton";
import Select from "primevue/select";
import Message from "primevue/message";
import Image from "primevue/image";

import Tabs from "primevue/tabs";
import TabList from "primevue/tablist";
import Tab from "primevue/tab";
import TabPanels from "primevue/tabpanels";
import TabPanel from "primevue/tabpanel";
import ToggleSwitch from "primevue/toggleswitch";
import Toast from "primevue/toast";
import ConfirmDialog from "primevue/confirmdialog";
export default {
    props: {
        categories: Object,
        locations: Object,
        dealProp: Object,
    },
    components: {
        ToggleSwitch,
        MainLayout,
        Editor,
        FileUpload,
        TreeSelect,
        InputNumber,
        Button,
        RadioButton,
        Select,
        Tabs,
        TabList,
        Tab,
        TabPanels,
        TabPanel,
        Message,
        Image,
        Toast,
        AccountLayout,
        ConfirmDialog,
    },
    data() {
        return {
            val: "asdasdasd",
            deal: null,
            specifications: [],
            selectedCity: this.dealProp.city,
            selectedDistrict: [],
            selectedNH: [],
            banner: null,
            selectedCategory: {},
        };
    },
    beforeMount() {
        this.deal = useForm({
            title: this.dealProp.title,
            price: parseFloat(this.dealProp.price),
            description: this.dealProp.description,
            category: this.dealProp.category_id,
            city: this.dealProp.city_id,
            district: this.dealProp.district_id,
            nh: this.dealProp.neighbourhood_id,
            images: [],
            banner: null,
            specifications: {},
            isActive: this.dealProp.is_active,
            isSelled: this.dealProp.isSelled,
            _method: "PATCH",
        });
        this.setCategory(this.categories);
        this.setCity();
        this.setSpecs();
    },
    methods: {
        deleteDeal() {
            this.$confirm.require({
                message: "This proccess can't be undone!",
                header: "Warning!",
                icon: "pi pi-info-circle",
                
                rejectProps: {
                    label: "Cancel",
                    severity: "secondary",
                    outlined: true,
                },
                acceptProps: {
                    label: "Delete",
                    severity: "danger",
                },
                accept: () => {
                    router.delete(route("deal.destroy", { deal: this.dealProp.id }));
                },
            });
        },
        update() {
            if (this.checkErrors()) {
                this.deal.post(route("deal.update", { deal: this.dealProp.id }), {
                    onSuccess: () => {
                        this.deal.images = [];
                        this.deal.banner = null;
                        this.$toast.add({ severity: "success", summary: "Deal updated", life: 3000 });
                    },
                });
            } else {
                this.$toast.add({ severity: "error", summary: "Please check your forms" });
            }
        },
        checkErrors() {
            if (this.checkStep1() && this.checkStep4() && this.checkStep5()) {
                return true;
            }
            return false;
        },
        checkStep1() {
            this.deal.clearErrors();
            if (this.deal.title == null || this.deal.title.trim() == "") {
                this.deal.setError("title", "Title field is required");
                return false;
            }
            if (this.deal.price == 0 || this.deal.price < 1 || this.deal.price == null) {
                this.deal.setError("price", "Price field needs to be bigger than 1");
                return false;
            }
            if (this.deal.category == null) {
                this.deal.setError("category", "Category field is required");
                return false;
            }
            if (this.deal.city == null) {
                this.deal.setError("city", "City field is required");
                return false;
            }
            if (this.deal.district == null) {
                this.deal.setError("district", "District field is required");
                return false;
            }
            if (this.deal.nh == null) {
                this.deal.setError("nh", "Neighbourhood field is required");
                return false;
            }
            return true;
        },
        checkStep4() {
            this.deal.clearErrors();
            if (this.deal.description == null || this.deal.description.trim() == "") {
                this.deal.setError("description", "Description field is required");
                return false;
            }
            return true;
        },
        checkStep5() {
            this.deal.clearErrors();
            if (this.deal.specifications.lenght == 0) {
                this.deal.setError("specifications", "Specification fields are required");
                return false;
            }
            return true;
        },
        tabs(value) {
            if (value == 5) {
                window.axios.get(route("category.specs", { id: this.deal.category })).then((res) => {
                    this.specifications = res.data;
                });
            }
        },
        selectCategory(node) {
            this.deal.category = node.id;
        },
        setLocation(event, type) {
            if (type == 0) {
                this.deal.city = event.value.id;
            } else if (type == 1) {
                this.deal.district = event.value.id;
            } else {
                this.deal.nh = event.value.id;
            }
        },
        setBanner(image, files) {
            this.deal.images = files.filter((file) => {
                return file != image;
            });
            this.deal.banner = image;
        },
        onRemoveTemplatingFile(files, removeFileCallback, index) {
            let isBanner = files[index] == this.deal.banner;
            removeFileCallback(index);
            if (isBanner) {
                this.deal.banner = null;
            } else {
                this.deal.images = files;
            }
        },
        onSelectedFiles(event) {
            this.deal.images = event.files;
        },
        onSelectBanner(event) {
            event.originalEvent.preventDefault();
            console.log(event);
            console.log(event.originalEvent);
            this.deal.banner = event.files[0];
        },
        setContent(editor) {
            editor.instance.setContents(editor.instance.clipboard.convertHTML(this.deal.description));
        },
        setCategory(category) {
            category.forEach((cat) => {
                if (cat.id == this.deal.category) {
                    this.selectedCategory[cat.key] = true;
                }
                if (cat.children != undefined) {
                    this.setCategory(cat.children);
                }
            });
        },
        setCity() {
            this.locations.forEach((city) => {
                if (city.id == this.deal.city) {
                    this.selectedCity = city;
                    this.setDistrict(city.districts);
                }
            });
        },
        setDistrict(districts) {
            districts.forEach((district) => {
                if (district.id == this.deal.district) {
                    this.selectedDistrict = district;
                    this.setNH(district.neighbourhoods);
                }
            });
        },
        setNH(nhs) {
            nhs.forEach((nh) => {
                if (nh.id == this.deal.nh) {
                    this.selectedNH = nh;
                }
            });
        },
        setSpecs() {
            this.dealProp.specifications.forEach((spec) => {
                this.deal.specifications[spec.specification_id] = {
                    id: spec.id,
                    specification_id: spec.specification_id,
                    value_id: spec.value_id,
                };
            });
        },
        deleteImage(imageID) {
            if (this.dealProp.images.length > 1) {
                router.post(route("deal.deleteimage", { id: imageID }), {
                    _method: "delete",
                });
            } else {
                this.deal.setError("images", "You cant delete this image! Deal has to have an 1 image at least!");
            }
        },
    },
};
</script>
