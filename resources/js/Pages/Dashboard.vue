<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import SubscriptionStats from './Dashboard/Partials/SubscriptionStats.vue';
import CategoryBreakdown from './Dashboard/Partials/CategoryBreakdown.vue';
import UpcomingRenewals from './Dashboard/Partials/UpcomingRenewals.vue';

defineProps({
    stats: Object,
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <SubscriptionStats :stats="stats" />
                    
                    <div class="lg:col-span-2">
                        <CategoryBreakdown 
                            :category-breakdown="stats.categoryBreakdown" 
                        />
                    </div>
                    
                    <div class="md:col-span-2 lg:col-span-3">
                        <UpcomingRenewals 
                            :upcoming-renewals="stats.upcomingRenewals" 
                        />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
