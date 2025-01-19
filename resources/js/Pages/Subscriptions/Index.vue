<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import SubscriptionList from './Partials/SubscriptionList.vue';
import CreateSubscriptionForm from './Partials/CreateSubscriptionForm.vue';
import SubscriptionFilters from './Partials/SubscriptionFilters.vue';

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
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Subscriptions
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <CreateSubscriptionForm 
                            :categories="categories" 
                            class="mb-6" 
                        />
                        
                        <SubscriptionFilters 
                            :filters="filters"
                            :categories="categories"
                            class="mb-6"
                        />

                        <SubscriptionList 
                            :subscriptions="subscriptions"
                            :categories="categories"
                        />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
