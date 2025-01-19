<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import SubscriptionList from './Partials/SubscriptionList.vue';
import CreateSubscriptionForm from './Partials/CreateSubscriptionForm.vue';
import SubscriptionFilters from './Partials/SubscriptionFilters.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    subscriptions: Object, // Paginated data
    categories: Array,
    filters: Object,
});
</script>

<template>
    <Head title="Subscriptions" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Subscriptions
                </h2>
                <Link
                    :href="route('subscriptions.create')"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-500"
                >
                    Create Subscription
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="mb-6">
                    <SubscriptionFilters 
                        :filters="filters"
                        :categories="categories"
                    />
                </div>

                <SubscriptionList 
                    :subscriptions="subscriptions"
                    :categories="categories"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
