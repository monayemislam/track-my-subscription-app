<script setup>
import { useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import NotificationSettings from '@/Components/Subscription/NotificationSettings.vue';

const props = defineProps({
    subscription: Object,
    categories: Array,
});

const emit = defineEmits(['close']);

const form = useForm({
    category_id: props.subscription.category_id,
    name: props.subscription.name,
    cost: props.subscription.cost,
    start_date: props.subscription.start_date,
    renewal_date: props.subscription.renewal_date,
    frequency: props.subscription.frequency,
    description: props.subscription.description,
    website_url: props.subscription.website_url,
    auto_renewal: props.subscription.auto_renewal,
});

const submit = () => {
    form.patch(route('subscriptions.update', props.subscription.id), {
        onSuccess: () => emit('close'),
    });
};
</script>

<template>
    <Modal :show="true" @close="$emit('close')" maxWidth="2xl">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Edit Subscription
            </h2>

            <form @submit.prevent="submit" class="mt-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <InputLabel for="edit-name" value="Subscription Name" />
                        <TextInput
                            id="edit-name"
                            v-model="form.name"
                            type="text"
                            class="mt-1 block w-full"
                            required
                        />
                        <InputError :message="form.errors.name" class="mt-2" />
                    </div>

                    <div>
                        <InputLabel for="edit-category" value="Category" />
                        <select
                            id="edit-category"
                            v-model="form.category_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required
                        >
                            <option
                                v-for="category in categories"
                                :key="category.id"
                                :value="category.id"
                            >
                                {{ category.name }}
                            </option>
                        </select>
                        <InputError :message="form.errors.category_id" class="mt-2" />
                    </div>

                    <div>
                        <InputLabel for="edit-cost" value="Cost" />
                        <TextInput
                            id="edit-cost"
                            v-model="form.cost"
                            type="number"
                            step="0.01"
                            class="mt-1 block w-full"
                            required
                        />
                        <InputError :message="form.errors.cost" class="mt-2" />
                    </div>

                    <div>
                        <InputLabel for="edit-frequency" value="Billing Frequency" />
                        <select
                            id="edit-frequency"
                            v-model="form.frequency"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required
                        >
                            <option value="daily">Daily</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                            <option value="quarterly">Quarterly</option>
                            <option value="yearly">Yearly</option>
                        </select>
                        <InputError :message="form.errors.frequency" class="mt-2" />
                    </div>

                    <div>
                        <InputLabel for="edit-start-date" value="Start Date" />
                        <TextInput
                            id="edit-start-date"
                            v-model="form.start_date"
                            type="date"
                            class="mt-1 block w-full"
                            required
                        />
                        <InputError :message="form.errors.start_date" class="mt-2" />
                    </div>

                    <div>
                        <InputLabel for="edit-renewal-date" value="Next Renewal Date" />
                        <TextInput
                            id="edit-renewal-date"
                            v-model="form.renewal_date"
                            type="date"
                            class="mt-1 block w-full"
                            required
                        />
                        <InputError :message="form.errors.renewal_date" class="mt-2" />
                    </div>

                    <div class="sm:col-span-2">
                        <InputLabel for="edit-website-url" value="Website URL (Optional)" />
                        <TextInput
                            id="edit-website-url"
                            v-model="form.website_url"
                            type="url"
                            class="mt-1 block w-full"
                        />
                        <InputError :message="form.errors.website_url" class="mt-2" />
                    </div>

                    <div class="sm:col-span-2">
                        <InputLabel for="edit-description" value="Description (Optional)" />
                        <textarea
                            id="edit-description"
                            v-model="form.description"
                            rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        ></textarea>
                        <InputError :message="form.errors.description" class="mt-2" />
                    </div>

                    <div class="sm:col-span-2">
                        <label class="flex items-center">
                            <input
                                type="checkbox"
                                v-model="form.auto_renewal"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            />
                            <span class="ml-2 text-sm text-gray-600">Auto-renewal enabled</span>
                        </label>
                        <InputError :message="form.errors.auto_renewal" class="mt-2" />
                    </div>
                </div>

                <!-- Notification Settings Component -->
                <NotificationSettings :subscription="subscription" />

                <div class="mt-6 flex justify-end space-x-2">
                    <SecondaryButton @click="$emit('close')">Cancel</SecondaryButton>
                    <PrimaryButton :disabled="form.processing">Save Changes</PrimaryButton>
                </div>
            </form>
        </div>
    </Modal>
</template>
