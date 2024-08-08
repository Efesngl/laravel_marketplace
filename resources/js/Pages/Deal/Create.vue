<template>
    <MainLayout>
        <div class="flex flex-col items-center">
            <h2 class="text-3xl">Create deal</h2>
            <div class="w-dvw">
                <Stepper value="1" linear @update:value="stepper" ref="stepper">
                    <StepList class="">
                        <Step value="1">Deal information</Step>
                        <Step value="2">Images</Step>
                        <Step value="3">Description</Step>
                        <Step value="4">Specifications</Step>
                    </StepList>
                    <StepPanels>
                        <StepPanel v-slot="{ activateCallback }" value="1">
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
                                </div>
                                <div class="w-full">
                                    <button class="w-full bg-yellow-400 text-white p-2 rounded" @click="checkStep1(activateCallback)">Next step</button>
                                </div>
                            </div>
                        </StepPanel>
                        <StepPanel v-slot="{ activateCallback }" value="2">
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
                                                                <div class="flex flex-row justify-center items-center mt-1">
                                                                    <RadioButton
                                                                        v-model="deal.banner"
                                                                        :value="file"
                                                                        @change="setBanner(file, files)"
                                                                        name="banner"
                                                                        :input-id="`deal${index}`"
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
                                    <Message severity="error" class="mt-2" v-if="deal.errors.images">{{ deal.errors.images }}</Message>
                                    <Message severity="error" class="mt-2 mb-2" v-if="deal.errors.banner">{{ deal.errors.banner }}</Message>
                                </div>
                                <div class="w-full flex flex-col gap-2">
                                    <button class="w-full bg-yellow-400 text-white p-2 rounded" @click="checkStep2(activateCallback)">Next step</button>
                                    <button class="w-full bg-red-600 text-white p-2 rounded" @click="activateCallback('1')">Previous step</button>
                                </div>
                            </div>
                        </StepPanel>
                        <StepPanel v-slot="{ activateCallback }" value="3">
                            <div class="flex flex-col items-center gap-2 w-full p-3">
                                <div class="flex flex-col w-full">
                                    <h5>Description</h5>
                                    <Editor v-model="deal.description" editor-style="height:30rem;"></Editor>
                                    <Message severity="error" class="mt-2 mb-2" v-if="deal.errors.description">{{ deal.errors.description }}</Message>
                                </div>
                                <div class="w-full flex flex-col gap-2">
                                    <button class="w-full bg-yellow-400 text-white p-2 rounded" @click="checkStep3(activateCallback)">Next step</button>
                                    <button class="w-full bg-red-600 text-white p-2 rounded" @click="activateCallback('2')">Previous step</button>
                                </div>
                            </div>
                        </StepPanel>
                        <StepPanel v-slot="{ activateCallback }" value="4">
                            <div class="flex flex-col items-center gap-2 w-full p-3">
                                <div class="flex flex-col w-full">
                                    <h2>Specs</h2>
                                    <div class="flex flex-col w-full" v-for="spec of specifications">
                                        <h5>{{ spec.specification }}</h5>
                                        <h5>{{ spec.id }}</h5>
                                        <Select v-model="deal.specifications[spec.id]" :options="spec.values" option-label="value"></Select>
                                    </div>
                                    <Message severity="error" class="mt-2 mb-2" v-if="deal.errors.specifications">{{ deal.errors.specifications }}</Message>
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

import Stepper from "primevue/stepper";
import StepList from "primevue/steplist";
import StepPanels from "primevue/steppanels";
import Step from "primevue/step";
import StepPanel from "primevue/steppanel";
import Message from "primevue/message";

export default {
    props: {
        categories: Object,
        locations: Object,
    },
    components: {
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
            deal: useForm({
                title: null,
                price: null,
                description: null,
                category: null,
                banner: null,
                images: null,
                city: null,
                district: null,
                nh: null,
                specifications: {},
            }),
            specifications: [],
            selectedCity: [],
            selectedDistrict: [],
            selectedNH: [],
            banner: null,
            selectedCategory: null,
        };
    },
    methods: {
        create() {
            this.deal.post(route("deal.store"), {
                forceFormData: true,
                onSuccess:()=>{
                    alert("created")
                }
            });
        },
        checkStep1(cb) {
            this.deal.clearErrors();
            let error = false;
            if (this.deal.title == null || this.deal.title.trim() == "") {
                this.deal.setError("title", "Title field is required");
                error = true;
            }
            if (this.deal.price == 0 || this.deal.price < 1 || this.deal.price == null) {
                this.deal.setError("price", "Price field needs to be bigger than 1");
                error = true;
            }
            if (this.deal.category == null) {
                this.deal.setError("category", "Category field is required");
                error = true;
            }
            if (this.deal.city == null) {
                this.deal.setError("city", "City field is required");
                error = true;
            }
            if (this.deal.district == null) {
                this.deal.setError("district", "District field is required");
                error = true;
            }
            if (this.deal.nh == null) {
                this.deal.setError("nh", "Neighbourhood field is required");
                error = true;
            }
            return error ? false : cb("2");
        },
        checkStep2(cb) {
            this.deal.clearErrors();
            let error = false;
            if (this.deal.images == null || this.deal.images.length == 0) {
                this.deal.setError("images", "Deal Images is required");
                error = true;
            }
            if (this.deal.banner == null) {
                this.deal.setError("banner", "You need to select a banner");
                error = true;
            }
            return error ? false : cb("3");
        },
        checkStep3(cb) {
            this.deal.clearErrors();
            let error = false;
            if (this.deal.description == null || this.deal.description.trim() == "") {
                this.deal.setError("description", "Description field is required");
                error = true;
            }
            return error ? false : cb("4");
        },
        checkStep4() {
            this.deal.clearErrors();
            let error = false;
            if (this.deal.specifications.lenght == 0) {
                this.deal.setError("specifications", "Specification fields are required");
                error = true;
            }
            return error ? false : this.create();
        },
        stepper(value) {
            if (value == 4) {
                window.axios.get(route("category.specs", { id: this.deal.category })).then((res) => {
                    this.specifications = res.data.specifications;
                    console.log(this.specifications);
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
    },
};
</script>
