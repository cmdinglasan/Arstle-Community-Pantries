<template>
    <dashboard-layout>
        <template #header>
<!--            Edit Pantry -->
            {{ changePhotoModal }} {{ imageUrlModal }}
        </template>
        <template #content>
            <section class="relative">
                <transition name="fade">
                    <div class="fixed top-0 left-0 z-50 h-full w-full flex items-center justify-center" v-if="changePhotoModal">
                        <div class="absolute top-0 left-0 bg-black h-full w-full bg-opacity-50"></div>
                        <div class="relative m-4 bg-white rounded-md w-11/12 md:w-[320px]">
                            <div class="relative">
                                <header class="relative">
                                    <h1 class="font-semibold px-4 pt-4">Change photo</h1>
                                </header>
                                <div class="relative pt-2">
                                    <button type="button" class="w-full" disabled>
                                        <label for="featured_image" class="block text-left px-4 py-2 w-full active:bg-gray-100">
                                            <span class="text-sm text-gray-200">Upload a photo</span>
                                        </label>
                                    </button>
                                    <button type="button" @click="toggleImageURLModal" class="text-left px-4 py-2 w-full active:bg-gray-100">
                                        <span class="text-sm">Enter an image URL</span>
                                    </button>
                                </div>
                                <div class="relative px-2 pb-2 flex items-center justify-end gap-2">
                                    <button type="button" class="text-left px-4 py-2 active:bg-blue-100 focus:outline-none" @click="toggleChangePhotoModal">
                                        <span class="text-sm text-blue-700">Cancel</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </transition>
                <transition name="fade">
                    <div class="fixed top-0 left-0 z-50 h-full w-full flex items-center justify-center" v-if="imageUrlModal">
                        <div class="absolute top-0 left-0 bg-black h-full w-full bg-opacity-50"></div>
                        <div class="relative m-4 bg-white rounded-md w-11/12 md:w-[320px]">
                            <div class="relative">
                                <header class="relative">
                                    <h1 class="font-semibold px-4 pt-4">Enter image URL</h1>
                                </header>
                                <div class="relative pt-2">
                                    <div class="relative px-4 py-4">
                                        <input type="text" placeholder="URL" class="w-full border-0 border-b-2 border-gray-300 px-0 focus:border-blue-500 focus:ring-0 transition" v-model="pantry.featured_image_url">
                                    </div>
                                </div>
                                <div class="relative px-2 pb-2 flex items-center justify-end gap-2">
                                    <button type="button" class="text-left px-4 py-2 active:bg-blue-100 focus:outline-none" @click="toggleImageURLModal">
                                        <span class="text-sm text-blue-700">Cancel</span>
                                    </button>
                                    <button type="button" class="text-left px-4 py-2 active:bg-blue-100 focus:outline-none" @click="toggleImageURLModal">
                                        <span class="text-sm text-blue-700 font-bold">Submit</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </transition>
                <form @submit.prevent="updatedPantry" method="post" enctype="multipart/form-data">
                    <fieldset class="mb-4">
                        <div class="relative">
                            <div class="relative h-32 w-full bg-gray-50 rounded-md overflow-hidden">
                                <div class="flex items-center justify-center h-32 w-full">
                                    <div class="relative" v-if="!(pantry.featured_image_local || pantry.featured_image_url)">
                                        <button type="button" class="group focus:outline-none select-none" @click="toggleChangePhotoModal">
                                            <div class="block w-16 h-16 rounded-full overflow-hidden bg-blue-500 group-active:bg-blue-700 flex items-center justify-center">
                                                <span class="material-icons-outlined text-white text-2xl">add_photo_alternate</span>
                                            </div>
                                        </button>
                                    </div>
                                    <div class="relative h-32 w-full" v-else>
                                        <div class="absolute z-10 top-0 left-0 h-32 w-full bg-black bg-opacity-30 group group-active-within:bg-opacity-50">
                                            <button type="button" class="h-32 w-full focus:outline-none select-none" @click="toggleChangePhotoModal">
                                                <div class="relative h-32 w-full flex items-center justify-center">
                                                    <span class="material-icons-outlined text-white text-2xl">add_photo_alternate</span>
                                                </div>
                                            </button>
                                        </div>
                                        <div class="relative h-0">
                                            <img :src="getImage()" class="h-32 w-full object-cover" ref="featuredImage"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="file" id="featured_image" class="hidden" @change="uploadImage" disabled aria-disabled="true"/>
                        </div>
                    </fieldset>
                    <fieldset class="mb-4">
                        <div class="relative">
                            <label for="name" class="block">
                                <span class="text-sm">Name</span>
                            </label>
                            <input type="text" id="name" class="w-full rounded-md border-0 shadow" v-model="pantry.name" required/>
                        </div>
                    </fieldset>
                    <fieldset class="mb-4">
                        <div class="relative">
                            <label for="address" class="block">
                                <span class="text-sm">Address</span>
                            </label>
                            <input type="text" id="address" class="w-full rounded-md border-0 shadow" v-model="pantry.address"/>
                        </div>
                    </fieldset>
                    <fieldset class="mb-4">
                        <div class="relative">
                            <label for="barangay" class="block">
                                <span class="text-sm">Barangay</span>
                            </label>
                            <input type="text" id="barangay" class="w-full rounded-md border-0 shadow" v-model="pantry.barangay" required/>
                        </div>
                    </fieldset>
                    <fieldset class="mb-4">
                        <div class="relative">
                            <label for="city" class="block">
                                <span class="text-sm">City</span>
                            </label>
                            <input type="text" id="city" class="w-full rounded-md border-0 shadow" v-model="pantry.city" required/>
                        </div>
                    </fieldset>
                    <fieldset class="mb-4">
                        <div class="relative">
                            <label for="province" class="block">
                                <span class="text-sm">Province</span>
                            </label>
                            <input type="text" id="province" class="w-full rounded-md border-0 shadow" v-model="pantry.province" required/>
                        </div>
                    </fieldset>
                    <fieldset class="mb-4">
                        <div class="relative">
                            <label for="region" class="block">
                                <span class="text-sm">Region</span>
                            </label>
                            <input type="text" id="region" class="w-full rounded-md border-0 shadow" v-model="pantry.region" required/>
                        </div>
                    </fieldset>
                    <fieldset class="mb-4">
                        <div class="relative">
                            <label for="contact_person" class="block">
                                <span class="text-sm">Contact Person</span>
                            </label>
                            <input type="text" id="contact_person" class="w-full rounded-md border-0 shadow" v-model="pantry.contacts[0].name" required/>
                        </div>
                    </fieldset>
                    <fieldset class="mb-4">
                        <div class="relative">
                            <label for="contact_num" class="block">
                                <span class="text-sm">Phone Number</span>
                            </label>
                            <input type="text" id="contact_num" class="w-full rounded-md border-0 shadow" v-model="pantry.contacts[0].contact_num" maxlength="12"/>
                        </div>
                    </fieldset>
                    <fieldset class="mb-4">
                        <div class="relative">
                            <label for="facebook" class="block">
                                <span class="text-sm">Facebook</span>
                            </label>
                            <input type="text" id="facebook" class="w-full rounded-md border-0 shadow" v-model="pantry.accounts[0].facebook"/>
                        </div>
                    </fieldset>
                    <fieldset class="mb-4">
                        <div class="relative">
                            <label for="twitter" class="block">
                                <span class="text-sm">Twitter</span>
                            </label>
                            <input type="text" id="twitter" class="w-full rounded-md border-0 shadow" v-model="pantry.accounts[0].twitter"/>
                        </div>
                    </fieldset>
                    <fieldset class="mb-4">
                        <div class="relative">
                            <label for="instagram" class="block">
                                <span class="text-sm">Instagram</span>
                            </label>
                            <input type="text" id="instagram" class="w-full rounded-md border-0 shadow" v-model="pantry.accounts[0].instagram"/>
                        </div>
                    </fieldset>
                    <fieldset class="mb-4">
                        <div class="relative">
                            <label for="source" class="block">
                                <span class="text-sm">Source</span>
                            </label>
                            <input type="text" id="source" class="w-full rounded-md border-0 shadow" v-model="pantry.source" required/>
                        </div>
                    </fieldset>
                    <fieldset class="mb-4">
                        <button type="submit" class="px-4 py-2 bg-blue-500 rounded-md shadow-md hover:shadow-lg transition">
                            <span class="text-white font-bold uppercase text-sm">Update</span>
                        </button>
                    </fieldset>
                </form>
            </section>

            <section class="relative mt-4">

            </section>
        </template>
    </dashboard-layout>
</template>

<script>
import DashboardLayout from '@/Layouts/Dashboard'

export default {
    name: "Edit",
    props: ['searchQuery','pantry'],
    data() {
        return {
            photoType: null,
            changePhotoModal: false,
            temporaryImage: null,
            originalImage: null,
            imageUrlModal: false,
        }
    },
    components: {
        DashboardLayout,
    },
    mounted() {
      this.originalImage = this.pantry.featured_image_local;
    },
    methods: {
        updatedPantry() {
            // const data = new FormData();
            // data.append('name', this.pantry.name);
            // data.append('address', this.pantry.address);
            // data.append('barangay', this.pantry.barangay);
            // data.append('city', this.pantry.city);
            // data.append('province', this.pantry.province);
            // data.append('region', this.pantry.region);
            // data.append('source', this.pantry.source);
            //
            // const contacts = JSON.stringify({
            //     person: this.pantry.contacts[0].person,
            //     number: this.pantry.contacts[0].contact_num,
            // })
            // data.append('contacts', contacts);
            //
            // const accounts = JSON.stringify({
            //     facebook: this.pantry.accounts[0].facebook,
            //     twitter: this.pantry.accounts[0].twitter,
            //     instagram: this.pantry.accounts[0].instagram,
            // })
            // data.append('accounts', accounts);
            //
            // data.append('featured_image_local', this.pantry.featured_image_local);
            // data.append('featured_image_url', this.pantry.featured_image_url);

            axios.put(route('pantries.update'), this.pantry)
                .then((response) => {
                    if(response.data.code == 200) {
                        location.href = route('pantries.show', this.pantry.id);
                        // console.log(response.data);
                    } else {
                        console.log(response.data);
                    }
                })
                .catch((error) => {
                    console.log(error);
                })
        },
        uploadImage(e) {
            this.toggleChangePhotoModal();
            let file = e.target.files[0];
            let reader = new FileReader();

            if(file['size'] < 2111775) {
                reader.onloadend = (file) => {
                    this.temporaryImage = reader.result;
                }
                reader.readAsDataURL(file);
            } else {
                alert('File size can not be bigger than 2 MB');
            }

            this.pantry.featured_image_local = file;
        },
        getImage() {
            let photo = null;
            if(this.temporaryImage) {
                photo = this.temporaryImage;
            } else if(this.pantry.featured_image_local) {
                photo = this.pantry.featured_image_local;
            } else {
                photo = this.pantry.featured_image_url;
            }
            return photo;
        },
        toggleChangePhotoModal() {
            this.changePhotoModal = !this.changePhotoModal;
        },
        toggleImageURLModal() {
            if(this.changePhotoModal) {
                this.imageUrlModal = true;
                this.changePhotoModal = false;
            } else if(!this.changePhotoModal && this.imageUrlModal) {
                this.imageUrlModal = false;
            }
        }
    }
}
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
    transition: opacity .2s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
    opacity: 0;
}
</style>
