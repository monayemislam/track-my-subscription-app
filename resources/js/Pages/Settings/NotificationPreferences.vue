<script setup>
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    defaultReminderDays: Number,
    emailNotificationsEnabled: Boolean,
});

const form = useForm({
    default_reminder_days: props.defaultReminderDays,
    email_notifications_enabled: props.emailNotificationsEnabled,
});

const submit = () => {
    form.patch(route('notification-settings.update-defaults'));
};
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Notification Preferences
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="submit" class="space-y-6">
                            <div>
                                <InputLabel for="default_reminder_days" value="Default Reminder Days" />
                                <input
                                    id="default_reminder_days"
                                    v-model="form.default_reminder_days"
                                    type="number"
                                    min="1"
                                    max="90"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required
                                />
                                <p class="mt-1 text-sm text-gray-500">
                                    Number of days before renewal to receive notifications
                                </p>
                                <InputError :message="form.errors.default_reminder_days" class="mt-2" />
                            </div>

                            <div>
                                <label class="flex items-center">
                                    <input
                                        type="checkbox"
                                        v-model="form.email_notifications_enabled"
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    />
                                    <span class="ml-2">Enable email notifications</span>
                                </label>
                                <InputError :message="form.errors.email_notifications_enabled" class="mt-2" />
                            </div>

                            <div class="flex justify-end">
                                <PrimaryButton :disabled="form.processing">
                                    Save Preferences
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
