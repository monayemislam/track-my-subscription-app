<script setup>
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const form = useForm({
    name: '',
    color: '#4F46E5',
});

const submit = () => {
    form.post(route('categories.store'), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <form @submit.prevent="submit" class="space-y-6">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div>
                <InputLabel for="name" value="Category Name" />
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
                <InputLabel for="color" value="Color" />
                <input
                    id="color"
                    v-model="form.color"
                    type="color"
                    class="mt-1 block w-full h-10 p-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    required
                />
                <InputError :message="form.errors.color" class="mt-2" />
            </div>
        </div>

        <div class="flex justify-end">
            <PrimaryButton :disabled="form.processing">
                Create Category
            </PrimaryButton>
        </div>
    </form>
</template> 