<style>
.p-tablist-prev-button {
    display: none !important;
}
.p-tablist-next-button {
    display: none !important;
}
</style>
<template>
    <AccountLayout title="edit product" :backUrl="route('account.index')">
        <div class="flex flex-col items-center gap-1">
            <h2 class="text-3xl p-2">Edit product</h2>
            <div class="w-dvw">
                <Tabs scrollable value="1" @update:value="tabs" ref="tabs">
                    <TabList class="bg-zinc-900">
                        <Tab value="1">product information</Tab>
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
                                        v-model="product.title"
                                        type="text"
                                        class="w-full p-2 bg-zinc-950 rounded-md border border-zinc-700 transition focus:border-yellow-400 focus:outline-none"
                                        id="title"
                                    />
                                    <Message severity="error" class="mt-1" v-if="product.errors.title">{{ product.errors.title }}</Message>
                                </div>
                                <div class="flex flex-col w-full">
                                    <label for="price" class="w-full text-start">Price</label>
                                    <InputNumber v-model="product.price" fluid input-id="price" mode="currency" currency="TRY" locale="tr"></InputNumber>
                                    <Message severity="error" class="mt-1" v-if="product.errors.price">{{ product.errors.price }}</Message>
                                </div>
                                <div class="flex flex-col md:flex-row w-full gap-2">
                                    <div class="flex flex-col w-full md:basis-1/2">
                                        <label for="product-stock">Stock</label>
                                        <InputNumber v-model="product.stock" id="product-stock"/>
                                        <Message severity="error" class="mt-1" v-if="product.errors.stock">{{ product.errors.stock }}</Message>
                                    </div>
                                    <div class="flex flex-col md:basis-1/2 w-full">
                                        <label for="quantity-per-user">Quantity per user</label>
                                        <InputNumber placeholder="0 for users to buy all" v-model="product.quantityPerUser" id="quantity-per-user"/>
                                        <Message severity="error" class="mt-1" v-if="product.errors.quantityPerUser">{{ product.errors.quantityPerUser }}</Message>
                                    </div>
                                </div>
                                <div class="flex flex-col w-full">
                                    <h5>product Category</h5>
                                    <TreeSelect v-model="selectedCategory" @node-select="selectCategory" :options="categories" placeholder="Select category" class="w-full" />
                                    <Message severity="error" class="mt-1" v-if="product.errors.category">{{ product.errors.category }}</Message>
                                </div>

                                <div class="w-full flex flex-col gap-1 md:flex-row">
                                    <Button class="basis-1/2 !border-none !outline-none !text-zinc-50 !bg-emerald-400 text-white p-2 rounded" @click="update()" label="Update" />
                                    <Button
                                        icon="pi pi-trash"
                                        class="!w-full basis-1/2 !border-none !outline-none !text-zinc-50 !bg-red-600 text-white p-2 rounded"
                                        @click="deleteproduct"
                                        label="Delete product"
                                    />
                                </div>
                            </div>
                        </TabPanel>
                        <TabPanel value="2">
                            <div class="flex flex-col items-center gap-2 w-full p-3">
                                <div class="w-full px-2">
                                    <h5>product images</h5>
                                    <FileUpload
                                        :show-cancel-button="false"
                                        name="images[]"
                                        :url="route('product.image')"
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
                                    <Message severity="error" class="mt-2" v-if="product.errors.images">{{ product.errors.images }}</Message>
                                    <div class="flex flex-col w-full">
                                        <div class="w-full relative" v-for="image in productProp.images">
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
                                        @change="product.banner = $event.target.files[0]"
                                        id="upload-banner"
                                    />
                                    <Message severity="error" class="mt-2 mb-2" v-if="product.errors.banner">{{ product.errors.banner }}</Message>
                                    <div class="flex flex-col w-full mt-3">
                                        <div class="w-full relative">
                                            <Image alt="Image" preview>
                                                <template #previewicon>
                                                    <i class="pi pi-search"></i>
                                                </template>
                                                <template #image>
                                                    <img :src="productProp.banner" class="w-dvw" alt="image" />
                                                </template>
                                                <template #preview="slotProps">
                                                    <img :src="productProp.banner" alt="preview" :style="slotProps.style" @click="slotProps.onClick" />
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
                                    <Editor v-model="product.description" @load="setContent" editor-style="height:30rem;" />
                                    <Message severity="error" class="mt-2 mb-2" v-if="product.errors.description">{{ product.errors.description }}</Message>
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
                                            v-model="product.specifications[spec.id]"
                                            :options="spec.values"
                                            option-label="value"
                                            :option-value="
                                                (event) => {
                                                    return {
                                                        id: product.specifications[event.specification_id].id,
                                                        specification_id: event.specification_id,
                                                        value_id: event.id,
                                                    };
                                                }
                                            "
                                        ></Select>
                                    </div>
                                    <Message severity="error" class="mt-2 mb-2" v-if="product.errors.specifications">{{ product.errors.specifications }}</Message>
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
        productProp: Object,
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
            product: null,
            specifications: [],
            banner: null,
            selectedCategory: {},
        };
    },
    beforeMount() {
        this.product = useForm({
            title: this.productProp.title,
            price: parseFloat(this.productProp.price),
            description: this.productProp.description,
            category: this.productProp.category_id,
            images: [],
            banner: null,
            stock:this.productProp.stock,
            quantityPerUser:this.productProp.quantity_per_user,
            specifications: {},
            isActive: this.productProp.is_active,
            isSelled: this.productProp.isSelled,
            _method: "PATCH",
        });
        this.setCategory(this.categories);
        this.setSpecs();
    },
    methods: {
        deleteproduct() {
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
                    router.delete(route("product.destroy", { product: this.productProp.id }));
                },
            });
        },
        update() {
            if (this.checkErrors()) {
                this.product.post(route("product.update", { product: this.productProp.id }), {
                    onSuccess: () => {
                        this.product.images = [];
                        this.product.banner = null;
                        this.$toast.add({ severity: "success", summary: "product updated", life: 3000 });
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
            this.product.clearErrors();
            if (this.product.title == null || this.product.title.trim() == "") {
                this.product.setError("title", "Title field is required");
                return false;
            }
            if (this.product.price == 0 || this.product.price < 1 || this.product.price == null) {
                this.product.setError("price", "Price field needs to be bigger than 1");
                return false;
            }
            if (this.product.category == null) {
                this.product.setError("category", "Category field is required");
                return false;
            }
            return true;
        },
        checkStep4() {
            this.product.clearErrors();
            if (this.product.description == null || this.product.description.trim() == "") {
                this.product.setError("description", "Description field is required");
                return false;
            }
            return true;
        },
        checkStep5() {
            this.product.clearErrors();
            if (this.product.specifications.lenght == 0) {
                this.product.setError("specifications", "Specification fields are required");
                return false;
            }
            return true;
        },
        tabs(value) {
            if (value == 5) {
                window.axios.get(route("category.specs", { id: this.product.category })).then((res) => {
                    this.specifications = res.data;
                });
            }
        },
        selectCategory(node) {
            this.product.category = node.id;
        },
        setBanner(image, files) {
            this.product.images = files.filter((file) => {
                return file != image;
            });
            this.product.banner = image;
        },
        onRemoveTemplatingFile(files, removeFileCallback, index) {
            let isBanner = files[index] == this.product.banner;
            removeFileCallback(index);
            if (isBanner) {
                this.product.banner = null;
            } else {
                this.product.images = files;
            }
        },
        onSelectedFiles(event) {
            this.product.images = event.files;
        },
        onSelectBanner(event) {
            event.originalEvent.preventDefault();
            console.log(event);
            console.log(event.originalEvent);
            this.product.banner = event.files[0];
        },
        setContent(editor) {
            editor.instance.setContents(editor.instance.clipboard.convertHTML(this.product.description));
        },
        setCategory(category) {
            category.forEach((cat) => {
                if (cat.id == this.product.category) {
                    this.selectedCategory[cat.key] = true;
                }
                if (cat.children != undefined) {
                    this.setCategory(cat.children);
                }
            });
        },
        setSpecs() {
            this.productProp.specifications.forEach((spec) => {
                this.product.specifications[spec.specification_id] = {
                    id: spec.id,
                    specification_id: spec.specification_id,
                    value_id: spec.value_id,
                };
            });
        },
        deleteImage(imageID) {
            if (this.productProp.images.length > 1) {
                router.post(route("product.deleteimage", { id: imageID }), {
                    _method: "delete",
                });
            } else {
                this.product.setError("images", "You cant delete this image! product has to have an 1 image at least!");
            }
        },
    },
};
</script>
