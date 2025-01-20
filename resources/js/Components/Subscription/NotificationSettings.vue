<script setup>
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { useToast } from '@/Composables/useToast';

const props = defineProps({
    subscription: Object,
});

const { showToast } = useToast();

const form = useForm({
    reminder_days: props.subscription.notification_setting?.reminder_days || 7,
    email_enabled: props.subscription.notification_setting?.email_enabled ?? true,
});

const updateSettings = () => {
    form.patch(route('notification-settings.update', props.subscription.id), {
        preserveScroll: true,
        onSuccess: () => {
            showToast('Notification settings updated successfully');
        },
        onError: () => {
            showToast('Failed to update notification settings', 'error');
        },
    });
};
</script>

<template>
    <div class="border-t mt-6 pt-6">
        <h3 class="text-lg font-medium text-gray-900">
            Notification Settings
        </h3>

        <div class="mt-4 space-y-4">
            <div>
                <InputLabel for="reminder_days" value="Reminder Days" />
                <input
                    id="reminder_days"
                    v-model="form.reminder_days"
                    type="number"
                    min="1"
                    max="90"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    @change="updateSettings"
                />
                <p class="mt-1 text-sm text-gray-500">
                    Number of days before renewal to receive notifications
                </p>
                <InputError :message="form.errors.reminder_days" class="mt-2" />
            </div>

            <div>
                <label class="flex items-center">
                    <input
                        type="checkbox"
                        v-model="form.email_enabled"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        @change="updateSettings"
                    />
                    <span class="ml-2 text-sm text-gray-600">
                        Enable email notifications
                    </span>
                </label>
                <InputError :message="form.errors.email_enabled" class="mt-2" />
            </div>
        </div>
    </div>
</template> 