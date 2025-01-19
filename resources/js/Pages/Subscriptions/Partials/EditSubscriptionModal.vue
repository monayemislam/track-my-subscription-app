<script setup>
import { useForm } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { useToast } from '@/Composables/useToast';

const props = defineProps({
    show: Boolean,
    subscription: Object,
    categories: Array,
});

const emit = defineEmits(['close']);
const { showToast } = useToast();

const form = useForm({
    name: props.subscription.name,
    cost: props.subscription.cost,
    category_id: props.subscription.category_id,
    renewal_frequency: props.subscription.renewal_frequency,
    website_url: props.subscription.website_url,
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
        <form @submit.prevent="submit" class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Edit Subscription
            </h2>

            <div class="mt-6 space-y-6">
                <!-- Form fields -->
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
                    <InputLabel for="renewal_frequency" value="Renewal Frequency" />
                    <select
                        id="renewal_frequency"
                        v-model="form.renewal_frequency"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        required
                    >
                        <option value="daily">Daily</option>
                        <option value="weekly">Weekly</option>
                        <option value="monthly">Monthly</option>
                        <option value="yearly">Yearly</option>
                    </select>
                    <InputError :message="form.errors.renewal_frequency" class="mt-2" />
                </div>

                <div>
                    <InputLabel for="website_url" value="Website URL" />
                    <TextInput
                        id="website_url"
                        v-model="form.website_url"
                        type="url"
                        class="mt-1 block w-full"
                    />
                    <InputError :message="form.errors.website_url" class="mt-2" />
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button
                    type="button"
                    class="mr-3 inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                    @click="$emit('close')"
                >
                    Cancel
                </button>
                <button
                    type="submit"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    :disabled="form.processing"
                >
                    Save Changes
                </button>
            </div>
        </form>
    </Modal>
</template>
