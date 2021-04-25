<template>
    <dashboard-layout>
        <template #header>
            Create Pantry
        </template>
        <template #content>
            <section class="relative">
                <form @submit.prevent="createPantry" method="post">
                    <fieldset class="mb-4">
                        <div class="relative">
                            <label for="name" class="block">
                                <span class="text-sm">Name</span>
                            </label>
                            <input type="text" id="name" class="w-full rounded-md border-0 shadow" v-model="form.name" required/>
                            <span v-if="form.errors.name" class="text-xs text-red-500">{{ form.errors.name }}</span>
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
                            <input type="text" id="province" class="w-full rounded-md border-0 shadow" v-model="form.province" required/>
                            <span v-if="form.errors.name" class="text-xs text-red-500">{{ form.errors.name }}</span>
                        </div>
                    </fieldset>
                    <fieldset class="mb-4">
                        <div class="relative">
                            <label for="region" class="block">
                                <span class="text-sm">Region</span>
                            </label>
                            <input type="text" id="region" class="w-full rounded-md border-0 shadow" v-model="form.region" required/>
                            <span v-if="form.errors.name" class="text-xs text-red-500">{{ form.errors.name }}</span>
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
                            <input type="text" id="contact_num" class="w-full rounded-md border-0 shadow" v-model="form.contact.number" maxlength="12"/>
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
    props: ['searchQuery'],
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
                }
            }, {
                resetOnSuccess: true,
            }),
        }
    },
    methods: {
        createPantry() {
            this.form.post(route('pantries.store'), {
                preserveScroll: true,
            });
        },
        checkForm() {

        },
    }
}
</script>

<style scoped>

</style>
