<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="Welcome" />

    <div class="relative min-h-screen bg-gray-100 dark:bg-gray-900">
        <div v-if="canLogin" class="p-6 text-right sm:fixed sm:right-0 sm:top-0">
            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
            >
                Dashboard
            </Link>

            <template v-else>
                <Link
                    :href="route('login')"
                    class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
                >
                    Log in
                </Link>

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
                >
                    Register
                </Link>
            </template>
        </div>

        <div class="flex min-h-screen items-center justify-center">
            <div class="max-w-4xl p-6 lg:p-8">
                <div class="flex justify-center">
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white">
                        Subscription Manager
                    </h1>
                </div>

                <div class="mt-8">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div class="scale-100 rounded-lg bg-white p-6 shadow-lg ring-1 ring-gray-900/10 transition-all hover:scale-105 dark:bg-gray-800/50 dark:ring-white/10">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Track Your Subscriptions
                                </h2>
                                <p class="mt-4 text-gray-500 dark:text-gray-400">
                                    Keep track of all your subscriptions in one place. Never miss a renewal or forget about an active subscription again.
                                </p>
                            </div>
                        </div>

                        <div class="scale-100 rounded-lg bg-white p-6 shadow-lg ring-1 ring-gray-900/10 transition-all hover:scale-105 dark:bg-gray-800/50 dark:ring-white/10">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Smart Notifications
                                </h2>
                                <p class="mt-4 text-gray-500 dark:text-gray-400">
                                    Get timely reminders before your subscriptions renew. Customize notification preferences for each subscription.
                                </p>
                            </div>
                        </div>

                        <div class="scale-100 rounded-lg bg-white p-6 shadow-lg ring-1 ring-gray-900/10 transition-all hover:scale-105 dark:bg-gray-800/50 dark:ring-white/10">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Cost Analytics
                                </h2>
                                <p class="mt-4 text-gray-500 dark:text-gray-400">
                                    Visualize your subscription spending with detailed analytics and category breakdowns.
                                </p>
                            </div>
                        </div>

                        <div class="scale-100 rounded-lg bg-white p-6 shadow-lg ring-1 ring-gray-900/10 transition-all hover:scale-105 dark:bg-gray-800/50 dark:ring-white/10">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Category Management
                                </h2>
                                <p class="mt-4 text-gray-500 dark:text-gray-400">
                                    Organize subscriptions into custom categories with color coding for better organization.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-16 flex justify-center">
                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="rounded-md bg-indigo-600 px-6 py-3 text-lg font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    >
                        Get Started
                    </Link>
                    <Link
                        v-else-if="!$page.props.auth.user"
                        :href="route('login')"
                        class="rounded-md bg-indigo-600 px-6 py-3 text-lg font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    >
                        Login to Start
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>
