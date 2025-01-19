<script setup>
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    categories: Array
});

const form = useForm({
    category_id: '',
    name: '',
    cost: '',
    start_date: new Date().toISOString().split('T')[0],
    renewal_date: '',
    frequency: 'monthly',
    description: '',
    website_url: '',
    auto_renewal: false,
});

const submit = () => {
    form.post(route('subscriptions.store'), {
        onSuccess: () => {
            form.reset();
            form.start_date = new Date().toISOString().split('T')[0];
        }
    });
};
</script>

<template>
    <form @submit.prevent="submit" class="space-y-6 bg-white rounded-lg border p-6 shadow-sm">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div>
                <InputLabel for="name" value="Subscription Name" />
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
                    <option value="">Select a category</option>
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
                <InputLabel for="frequency" value="Billing Frequency" />
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
                <InputLabel for="renewal_date" value="Next Renewal Date" />
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
                <InputLabel for="description" value="Description (Optional)" />
                <textarea
                    id="description"
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

        <div class="flex justify-end">
            <PrimaryButton :disabled="form.processing">
                Create Subscription
            </PrimaryButton>
        </div>
    </form>
</template>
