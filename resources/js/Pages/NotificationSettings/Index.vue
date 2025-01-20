<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useToast } from '@/Composables/useToast';

const props = defineProps({
    defaults: Object,
    user: Object,
});

const { showToast } = useToast();

const form = useForm({
    reminder_days: parseInt(props.defaults.reminder_days) || 7,
    email_enabled: props.defaults.email_enabled,
    notification_email: props.user.notification_email || props.user.email,
    notify_before_days: props.defaults.notify_before_days || [1, 3, 7],
    daily_digest_enabled: props.defaults.daily_digest_enabled || false,
    weekly_summary_enabled: props.defaults.weekly_summary_enabled || false,
    notification_time: props.defaults.notification_time || '09:00',
});

const updateDefaults = () => {
    form.patch(route('notification-settings.update-defaults'), {
        preserveScroll: true,
        onSuccess: () => showToast('Notification settings updated successfully'),
        onError: () => showToast('Failed to update settings', 'error'),
    });
};
</script>

<template>
    <Head title="Notification Settings" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Notification Settings
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="updateDefaults">
                            <!-- Email Settings Section -->
                            <div class="mb-8">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">
                                    Email Notification Settings
                                </h3>
                                
                                <div class="space-y-6">
                                    <div>
                                        <InputLabel for="notification_email" value="Notification Email Address" />
                                        <TextInput
                                            id="notification_email"
                                            v-model="form.notification_email"
                                            type="email"
                                            class="mt-1 block w-full"
                                        />
                                        <p class="mt-1 text-sm text-gray-500">
                                            Email address where you want to receive notifications
                                        </p>
                                        <InputError :message="form.errors.notification_email" class="mt-2" />
                                    </div>

                                    <div>
                                        <label class="flex items-center">
                                            <input
                                                type="checkbox"
                                                v-model="form.email_enabled"
                                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            />
                                            <span class="ml-2 text-sm text-gray-600">
                                                Enable email notifications
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Reminder Settings Section -->
                            <div class="mb-8">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">
                                    Reminder Settings
                                </h3>
                                
                                <div class="space-y-6">
                                    <div>
                                        <InputLabel for="reminder_days" value="Default Reminder Days" />
                                        <input
                                            id="reminder_days"
                                            v-model="form.reminder_days"
                                            type="number"
                                            min="1"
                                            max="90"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        />
                                        <p class="mt-1 text-sm text-gray-500">
                                            Default number of days before renewal to receive notifications
                                        </p>
                                        <InputError :message="form.errors.reminder_days" class="mt-2" />
                                    </div>

                                    <div>
                                        <InputLabel for="notification_time" value="Notification Time" />
                                        <input
                                            id="notification_time"
                                            v-model="form.notification_time"
                                            type="time"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        />
                                        <p class="mt-1 text-sm text-gray-500">
                                            Time of day to receive notifications (in your local timezone)
                                        </p>
                                        <InputError :message="form.errors.notification_time" class="mt-2" />
                                    </div>
                                </div>
                            </div>

                            <!-- Summary Settings Section -->
                            <div class="mb-8">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">
                                    Summary Reports
                                </h3>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label class="flex items-center">
                                            <input
                                                type="checkbox"
                                                v-model="form.daily_digest_enabled"
                                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            />
                                            <span class="ml-2 text-sm text-gray-600">
                                                Receive daily digest of upcoming renewals
                                            </span>
                                        </label>
                                    </div>

                                    <div>
                                        <label class="flex items-center">
                                            <input
                                                type="checkbox"
                                                v-model="form.weekly_summary_enabled"
                                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                            />
                                            <span class="ml-2 text-sm text-gray-600">
                                                Receive weekly spending summary
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <PrimaryButton :disabled="form.processing">
                                    Save Settings
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template> 