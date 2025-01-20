<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import SubscriptionStats from './Dashboard/Partials/SubscriptionStats.vue';
import CategoryBreakdown from './Dashboard/Partials/CategoryBreakdown.vue';
import UpcomingRenewals from './Dashboard/Partials/UpcomingRenewals.vue';
import BreakdownChart from './Dashboard/Partials/BreakdownChart.vue';
import { computed } from 'vue';

defineProps({
    stats: Object,
});

const greeting = computed(() => {
    const now = new Date();
    const hour = now.getHours();
    const userTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
    const localTime = new Date(now.toLocaleString('en-US', { timeZone: userTimezone }));
    const localHour = localTime.getHours();

    if (localHour >= 5 && localHour < 12) return 'Good morning';
    if (localHour >= 12 && localHour < 17) return 'Good afternoon';
    if (localHour >= 17 && localHour < 22) return 'Good evening';
    return 'Good night';
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="space-y-2">
                <h2 class="text-2xl font-bold">
                    {{ greeting }}, 
                    <span class="bg-gradient-to-r from-violet-600 to-blue-500 bg-clip-text text-transparent">
                        {{ $page.props.auth.user.name }}
                    </span>
                </h2>
                <p class="text-sm text-gray-600">
                    Here's an overview of your subscription management
                </p>
            </div>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-7xl space-y-8 sm:px-6 lg:px-8">
                <div class="space-y-6">
                    <!-- First row: Subscription costs and Subscription breakdown -->
                    <div class="grid gap-6 md:grid-cols-2">
                        <!-- Left: Subscription costs -->
                        <div class="rounded-2xl bg-white p-6 shadow-lg">
                            <SubscriptionStats :stats="stats" />
                        </div>
                        
                        <!-- Right: Subscription breakdown -->
                        <BreakdownChart 
                            :breakdown-data="stats.subscriptionBreakdown"
                            title="Subscription Breakdown"
                        />
                    </div>

                    <!-- Second row: Category breakdown and Upcoming renewals -->
                    <div class="grid gap-6 md:grid-cols-2">
                        <CategoryBreakdown 
                            :category-breakdown="stats.categoryBreakdown"
                        />
                        <UpcomingRenewals :upcoming-renewals="stats.upcomingRenewals" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
