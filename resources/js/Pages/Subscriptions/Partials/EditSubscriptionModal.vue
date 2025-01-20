<script setup>
import { useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useToast } from '@/Composables/useToast';

const props = defineProps({
    show: {
        type: Boolean,
        required: true
    },
    subscription: {
        type: Object,
        required: true
    },
    categories: {
        type: Array,
        required: true
    }
});

console.log('Modal props:', props);

const emit = defineEmits(['close']);
const { showToast } = useToast();

// Format dates to YYYY-MM-DD for input type="date"
const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toISOString().split('T')[0];
};

const form = useForm({
    category_id: props.subscription.category_id,
    name: props.subscription.name,
    cost: props.subscription.cost,
    start_date: formatDate(props.subscription.start_date),
    renewal_date: formatDate(props.subscription.renewal_date),
    frequency: props.subscription.frequency,
    description: props.subscription.description || '',
    website_url: props.subscription.website_url || '',
    auto_renewal: props.subscription.auto_renewal,
});

const submit = () => {
    form.patch(route('subscriptions.update', props.subscription.id), {
        preserveScroll: true,
        onSuccess: () => {
            emit('close');
            showToast('Subscription updated successfully');
        },
        onError: () => {
            showToast('Failed to update subscription', 'error');
        },
    });
};
</script>

<template>
    <Modal :show="show" @close="$emit('close')" max-width="2xl">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Edit Subscription
            </h2>

            <form @submit.prevent="submit" class="mt-6">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <InputLabel for="name" value="Name" />
                        <TextInput
                            id="name"
                            v-model="form.name"
                            type="text"
                            class="mt-1 block w-full"
                            required
                        />
                        <InputError :message="form.errors.name" class="mt-2" />
                    </div>

                    <div>
                        <InputLabel for="category" value="Category" />
                        <select
                            id="category"
                            v-model="form.category_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required
                        >
                            <option v-for="category in categories" :key="category.id" :value="category.id">
                                {{ category.name }}
                            </option>
                        </select>
                        <InputError :message="form.errors.category_id" class="mt-2" />
                    </div>

                    <div>
                        <InputLabel for="cost" value="Cost" />
                        <TextInput
                            id="cost"
                            v-model="form.cost"
                            type="number"
                            step="0.01"
                            class="mt-1 block w-full"
                            required
                        />
                        <InputError :message="form.errors.cost" class="mt-2" />
                    </div>

                    <div>
                        <InputLabel for="frequency" value="Frequency" />
                        <select
                            id="frequency"
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
                        <InputLabel for="start_date" value="Start Date" />
                        <TextInput
                            id="start_date"
                            v-model="form.start_date"
                            type="date"
                            class="mt-1 block w-full"
                            required
                        />
                        <InputError :message="form.errors.start_date" class="mt-2" />
                    </div>

                    <div>
                        <InputLabel for="renewal_date" value="Next Renewal" />
                        <TextInput
                            id="renewal_date"
                            v-model="form.renewal_date"
                            type="date"
                            class="mt-1 block w-full"
                            required
                        />
                        <InputError :message="form.errors.renewal_date" class="mt-2" />
                    </div>

                    <div class="sm:col-span-2">
                        <InputLabel for="website_url" value="Website URL (Optional)" />
                        <TextInput
                            id="website_url"
                            v-model="form.website_url"
                            type="url"
                            class="mt-1 block w-full"
                        />
                        <InputError :message="form.errors.website_url" class="mt-2" />
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
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <SecondaryButton @click="$emit('close')">Cancel</SecondaryButton>
                    <PrimaryButton :disabled="form.processing">Save Changes</PrimaryButton>
                </div>
            </form>
        </div>
    </Modal>
</template>
