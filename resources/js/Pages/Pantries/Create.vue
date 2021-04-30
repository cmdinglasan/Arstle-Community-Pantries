<template>
    <dashboard-layout>
        <template #header>
            Create Pantry
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
                                        <input type="text" placeholder="URL" class="w-full border-0 border-b-2 border-gray-300 px-0 focus:border-blue-500 focus:ring-0 transition" v-model="form.featured_image_url">
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
                <form @submit.prevent="createPantry" method="post" enctype="multipart/form-data">
                    <fieldset class="mb-4">
                        <div class="relative">
                            <div class="relative h-32 w-full bg-gray-50 rounded-md overflow-hidden">
                                <div class="flex items-center justify-center h-32 w-full">
                                    <div class="relative" v-if="!(form.featured_image_local || form.featured_image_url)">
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
                            <input type="text" id="name" class="w-full rounded-md border-0 shadow" v-model="form.name" required/>
                        </div>
                    </fieldset>
                    <fieldset class="mb-4">
                        <div class="relative">
                            <label for="address" class="block">
                                <span class="text-sm">Address</span>
                            </label>
                            <input type="text" id="address" class="w-full rounded-md border-0 shadow" v-model="form.address"/>
                            <span v-if="form.errors.name" class="text-xs text-red-500">{{ form.errors.name }}</span>
                        </div>
                    </fieldset>
                    <fieldset class="mb-4">
                        <div class="relative">
                            <label for="barangay" class="block">
                                <span class="text-sm">Barangay</span>
                            </label>
                            <input type="text" id="barangay" class="w-full rounded-md border-0 shadow" v-model="form.barangay" required/>
                            <span v-if="form.errors.name" class="text-xs text-red-500">{{ form.errors.name }}</span>
                        </div>
                    </fieldset>
                    <fieldset class="mb-4">
                        <div class="relative">
                            <label for="city" class="block">
                                <span class="text-sm">City</span>
                            </label>
                            <input type="text" id="city" class="w-full rounded-md border-0 shadow" v-model="form.city" required/>
                            <span v-if="form.errors.name" class="text-xs text-red-500">{{ form.errors.name }}</span>
                        </div>
                    </fieldset>
                    <fieldset class="mb-4">
                        <div class="relative">
                            <label for="province" class="block">
                                <span class="text-sm">Province</span>
                            </label>
                            <select id="province" class="w-full rounded-md border-0 shadow" v-model="form.province" required>
                                <option disabled>Choose a region</option>
                                <option v-for="(province, index) in provinces" :value="index" v-text="province" :selected="province === form.province"></option>
                            </select>
                        </div>
                    </fieldset>
                    <fieldset class="mb-4">
                        <div class="relative">
                            <label for="region" class="block">
                                <span class="text-sm">Region</span>
                            </label>
                            <select id="region" class="w-full rounded-md border-0 shadow" v-model="form.region" required>
                                <option disabled selected>Choose a region</option>
                                <option v-for="(region, index) in regions" :value="index" v-text="region"></option>
                            </select>
                            <span v-if="form.errors.name" class="text-xs text-red-500">{{ form.errors.name }}</span>
                        </div>
                    </fieldset>
                    <fieldset class="mb-4">
                        <div class="relative">
                            <label for="latitude" class="block">
                                <span class="text-sm">Latitude (optional)</span>
                            </label>
                            <input type="text" id="latitude" class="w-full rounded-md border-0 shadow" v-model="form.latitude" pattern="[0-9]*[.][0-9]*" title="Map Coordinate (Latitude) (Ex: 14.000)"/>
                        </div>
                    </fieldset>
                    <fieldset class="mb-4">
                        <div class="relative">
                            <label for="longitude" class="block">
                                <span class="text-sm">Longitude (optional)</span>
                            </label>
                            <input type="text" id="longitude" class="w-full rounded-md border-0 shadow" v-model="form.longitude" pattern="[0-9]*[.][0-9]*" title="Map Coordinate (Longitude) (Ex: 12.000)"/>
                        </div>
                    </fieldset>
                    <fieldset class="mb-4">
                        <div class="relative">
                            <label for="contact_person" class="block">
                                <span class="text-sm">Contact Person</span>
                            </label>
                            <input type="text" id="contact_person" class="w-full rounded-md border-0 shadow" v-model="form.contact.person" required/>
                            <span v-if="form.errors.name" class="text-xs text-red-500">{{ form.errors.name }}</span>
                        </div>
                    </fieldset>
                    <fieldset class="mb-4">
                        <div class="relative">
                            <label for="contact_num" class="block">
                                <span class="text-sm">Phone Number</span>
                            </label>
                            <input type="text" id="contact_num" class="w-full rounded-md border-0 shadow" v-model="form.contact.number" maxlength="12" pattern="^[+]*09[0-9]{9,10}" title="Enter a twelve digit phone number (Ex: 09123456789)"/>
                            <span v-if="form.errors.name" class="text-xs text-red-500">{{ form.errors.name }}</span>
                        </div>
                    </fieldset>
                    <fieldset class="mb-4">
                        <div class="relative">
                            <label for="facebook" class="block">
                                <span class="text-sm">Facebook</span>
                            </label>
                            <input type="text" id="facebook" class="w-full rounded-md border-0 shadow" v-model="form.accounts.facebook"/>
                            <span v-if="form.errors.name" class="text-xs text-red-500">{{ form.errors.name }}</span>
                        </div>
                    </fieldset>
                    <fieldset class="mb-4">
                        <div class="relative">
                            <label for="twitter" class="block">
                                <span class="text-sm">Twitter</span>
                            </label>
                            <input type="text" id="twitter" class="w-full rounded-md shadow" :class="form.errors.name ? 'border-2 border-red-500' : 'border-0'" v-model="form.accounts.twitter"/>
                            <span v-if="form.errors.name" class="text-xs text-red-500">{{ form.errors.name }}</span>
                        </div>
                    </fieldset>
                    <fieldset class="mb-4">
                        <div class="relative">
                            <label for="instagram" class="block">
                                <span class="text-sm">Instagram</span>
                            </label>
                            <input type="text" id="instagram" class="w-full rounded-md border-0 shadow" v-model="form.accounts.instagram"/>
                            <span v-if="form.errors.name" class="text-xs text-red-500">{{ form.errors.name }}</span>
                        </div>
                    </fieldset>
                    <fieldset class="mb-4">
                        <div class="relative">
                            <label for="source" class="block">
                                <span class="text-sm">Source</span>
                            </label>
                            <input type="text" id="source" class="w-full rounded-md border-0 shadow" v-model="form.source" required/>
                            <span v-if="form.errors.name" class="text-xs text-red-500">{{ form.errors.name }}</span>
                        </div>
                    </fieldset>
                    <fieldset class="mb-4">
                        <div class="relative">
                            <label for="contributor" class="block">
                                <span class="text-sm">Contributor</span>
                            </label>
                            <input type="text" id="contributor" class="w-full rounded-md border-0 shadow" :value="$inertia.page.props.auth.user.name + ' (' + $inertia.page.props.auth.user.email + ')'" disabled/>
                        </div>
                    </fieldset>
                    <fieldset class="mb-4">
                        <button type="submit" class="px-4 py-2 bg-blue-500 rounded-md shadow-md hover:shadow-lg transition">
                            <span class="text-white font-bold uppercase text-sm">Submit</span>
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
name: "Create",
    props: ['searchQuery','regions','provinces'],
    components: {
        DashboardLayout,
    },
    data() {
        return {
            form: this.$inertia.form({
                name: null,
                address: null,
                barangay: null,
                city: null,
                province: null,
                region: null,
                source: null,
                contact: {
                    person: null,
                    number: null,
                },
                accounts: {
                    facebook: null,
                    twitter: null,
                    instagram: null,
                },
                featured_image_local: null,
                featured_image_url: null,
                latitude: null,
                longitude: null,
            }, {
                resetOnSuccess: true,
            }),
            photoType: null,
            changePhotoModal: false,
            temporaryImage: null,
            originalImage: null,
            imageUrlModal: false,
        }
    },
    methods: {
        createPantry() {
            this.form.post(route('pantries.store'), {
                preserveScroll: true,
            });
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

            this.form.featured_image_local = file;
        },
        getImage() {
            let photo = null;
            if(this.temporaryImage) {
                photo = this.temporaryImage;
            } else if(this.form.featured_image_local) {
                photo = this.form.featured_image_local;
            } else {
                photo = this.form.featured_image_url;
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

</style>
