<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import SubscriptionStats from './Dashboard/Partials/SubscriptionStats.vue';
import CategoryBreakdown from './Dashboard/Partials/CategoryBreakdown.vue';
import UpcomingRenewals from './Dashboard/Partials/UpcomingRenewals.vue';

defineProps({
    stats: Object,
});

const getGreeting = () => {
    const hour = new Date().getHours();
    if (hour < 12) return 'Good morning';
    if (hour < 18) return 'Good afternoon';
    return 'Good evening';
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="space-y-2">
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ getGreeting() }}, {{ $page.props.auth.user.name }}
                </h2>
                <p class="text-sm text-gray-600">
                    Here's an overview of your subscription management
                </p>
            </div>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-7xl space-y-8 sm:px-6 lg:px-8">
                <SubscriptionStats :stats="stats" />
                
                <div class="grid gap-8 md:grid-cols-2">
                    <CategoryBreakdown 
                        :category-breakdown="stats.categoryBreakdown" 
                    />
                    
                    <UpcomingRenewals 
                        :upcoming-renewals="stats.upcomingRenewals" 
                    />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
