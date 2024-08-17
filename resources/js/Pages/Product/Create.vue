<template>
    <MainLayout>
        <div class="flex flex-col items-center">
            <h2 class="text-3xl">Create Product</h2>
            <div class="w-dvw md:flex md:flex-col md:items-center">
                <Stepper value="1" linear @update:value="stepper" ref="stepper">
                    <StepList class="">
                        <Step value="1">Product information</Step>
                        <Step value="2">Images</Step>
                        <Step value="3">Description</Step>
                        <Step value="4">Specifications</Step>
                    </StepList>
                    <StepPanels>
                        <StepPanel v-slot="{ activateCallback }" class="rounded-md" value="1">
                            <div class="flex flex-col gap-2 w-full p-3">
                                <div class="flex flex-col w-full">
                                    <label for="title">Title</label>
                                    <InputText
                                        v-model="product.title"
                                        type="text"
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
                                    <h5>Product Category</h5>
                                    <TreeSelect v-model="selectedCategory" @node-select="selectCategory" :options="categories" placeholder="Select category" class="w-full" />
                                    <Message severity="error" class="mt-1" v-if="product.errors.category">{{ product.errors.category }}</Message>
                                </div>
                                <div class="w-full">
                                    <button class="w-full bg-yellow-400 text-white p-2 rounded" @click="checkStep1(activateCallback)">Next step</button>
                                </div>
                            </div>
                        </StepPanel>
                        <StepPanel class="rounded-md" v-slot="{ activateCallback }" value="2">
                            <div class="flex flex-col items-center gap-2 w-full p-3">
                                <div class="w-full px-2">
                                    <h5>Product images</h5>

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
                                                                <div class="flex flex-row justify-center items-center mt-1">
                                                                    <RadioButton
                                                                        v-model="product.banner"
                                                                        :value="file"
                                                                        @change="setBanner(file, files)"
                                                                        name="banner"
                                                                        :input-id="`Product${index}`"
                                                                    ></RadioButton
                                                                    ><label for="banner">Banner</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </FileUpload>
                                    <Message severity="error" class="mt-2" v-if="product.errors.images">{{ product.errors.images }}</Message>
                                    <Message severity="error" class="mt-2 mb-2" v-if="product.errors.banner">{{ product.errors.banner }}</Message>
                                </div>
                                <div class="w-full flex flex-col gap-2">
                                    <button class="w-full bg-yellow-400 text-white p-2 rounded" @click="checkStep2(activateCallback)">Next step</button>
                                    <button class="w-full bg-red-600 text-white p-2 rounded" @click="activateCallback('1')">Previous step</button>
                                </div>
                            </div>
                        </StepPanel>
                        <StepPanel class="rounded-md" v-slot="{ activateCallback }" value="3">
                            <div class="flex flex-col items-center gap-2 w-full p-3">
                                <div class="flex flex-col w-full">
                                    <h5>Description</h5>
                                    <Editor v-model="product.description" editor-style="height:30rem;"></Editor>
                                    <Message severity="error" class="mt-2 mb-2" v-if="product.errors.description">{{ product.errors.description }}</Message>
                                </div>
                                <div class="w-full flex flex-col gap-2">
                                    <button class="w-full bg-yellow-400 text-white p-2 rounded" @click="checkStep3(activateCallback)">Next step</button>
                                    <button class="w-full bg-red-600 text-white p-2 rounded" @click="activateCallback('2')">Previous step</button>
                                </div>
                            </div>
                        </StepPanel>
                        <StepPanel class="rounded-md" v-slot="{ activateCallback }" value="4">
                            <div class="flex flex-col items-center gap-2 w-full p-3">
                                <div class="flex flex-col w-full">
                                    <h2>Specs</h2>
                                    <div class="flex flex-col w-full" v-for="spec of specifications">
                                        <h5>{{ spec.specification }}</h5>
                                        <h5>{{ spec.id }}</h5>
                                        <Select v-model="product.specifications[spec.id]" :options="spec.values" option-label="value"></Select>
                                    </div>
                                    <Message severity="error" class="mt-2 mb-2" v-if="product.errors.specifications">{{ product.errors.specifications }}</Message>
                                </div>
                                <div class="w-full flex flex-col gap-2">
                                    <button class="w-full bg-emerald-600 text-white p-2 rounded" @click="checkStep4()">Create</button>
                                    <button class="w-full bg-red-600 text-white p-2 rounded" @click="activateCallback('3')">Previous step</button>
                                </div>
                            </div>
                        </StepPanel>
                    </StepPanels>
                </Stepper>
            </div>
        </div>
    </MainLayout>
</template>

<script>
import { useForm } from "@inertiajs/vue3";
import MainLayout from "../../Layouts/MainLayout.vue";
import Editor from "primevue/editor";
import FileUpload from "primevue/fileupload";
import TreeSelect from "primevue/treeselect";
import InputNumber from "primevue/inputnumber";
import Button from "primevue/button";
import RadioButton from "primevue/radiobutton";
import Select from "primevue/select";
import InputText from "primevue/inputtext";
import Stepper from "primevue/stepper";
import StepList from "primevue/steplist";
import StepPanels from "primevue/steppanels";
import Step from "primevue/step";
import StepPanel from "primevue/steppanel";
import Message from "primevue/message";

export default {
    props: {
        categories: Object,
    },
    components: {
        InputText,
        MainLayout,
        Editor,
        FileUpload,
        TreeSelect,
        InputNumber,
        Button,
        RadioButton,
        Select,
        Stepper,
        StepList,
        StepPanels,
        Step,
        StepPanel,
        Message,
    },
    data() {
        return {
            product: useForm({
                title: null,
                price: null,
                description: null,
                category: null,
                banner: null,
                images: null,
                specifications: {},
                stock:null,
                quantityPerUser:null
            }),
            specifications: [],
            banner: null,
            selectedCategory: null,
        };
    },
    methods: {
        create() {
            this.product.post(route("product.store"), {
                forceFormData: true,
                onSuccess: () => {
                    alert("created");
                },
            });
        },
        checkStep1(cb) {
            this.product.clearErrors();
            let error = false;
            if (this.product.title == null || this.product.title.trim() == "") {
                this.product.setError("title", "Title field is required");
                error = true;
            }
            if (this.product.price == 0 || this.product.price < 1 || this.product.price == null) {
                this.product.setError("price", "Price field needs to be bigger than 1");
                error = true;
            }
            if (this.product.category == null) {
                this.product.setError("category", "Category field is required");
                error = true;
            }
            if(this.product.stock == null || this.product.stock==0){
                this.product.setError("stock","Stock field is required");
                error=true
            }
            if(this.product.quantityPerUser == null ){
                this.product.setError("quantityPerUser","Quantity per user field is required");
                error=true
            }
            return error ? false : cb("2");
        },
        checkStep2(cb) {
            this.product.clearErrors();
            let error = false;
            if (this.product.images == null || this.product.images.length == 0) {
                this.product.setError("images", "Product Images is required");
                error = true;
            }
            if (this.product.banner == null) {
                this.product.setError("banner", "You need to select a banner");
                error = true;
            }
            return error ? false : cb("3");
        },
        checkStep3(cb) {
            this.product.clearErrors();
            let error = false;
            if (this.product.description == null || this.product.description.trim() == "") {
                this.product.setError("description", "Description field is required");
                error = true;
            }
            return error ? false : cb("4");
        },
        checkStep4() {
            this.product.clearErrors();
            let error = false;
            if (this.product.specifications.lenght == 0) {
                this.product.setError("specifications", "Specification fields are required");
                error = true;
            }
            return error ? false : this.create();
        },
        stepper(value) {
            if (value == 4) {
                window.axios.get(route("category.specs", { id: this.product.category })).then((res) => {
                    this.specifications = res.data;
                });
            }
        },
        selectCategory(node) {
            this.product.category = node.id;
        },
        setLocation(event, type) {
            if (type == 0) {
                this.product.city = event.value.id;
            } else if (type == 1) {
                this.product.district = event.value.id;
            } else {
                this.product.nh = event.value.id;
            }
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
    },
};
</script>
