<script setup>
import { router } from '@inertiajs/vue3';
import { watch, ref } from 'vue';
import { debounce } from 'lodash';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    filters: {
        type: Object,
        default: () => ({})
    },
    categories: {
        type: Array,
        default: () => []
    }
});

const form = ref({
    search: props.filters.search || '',
    category: props.filters.category || '',
    sort: props.filters.sort || 'renewal_date,asc'
});

// Create a debounced search function
const debouncedSearch = debounce(() => {
    router.get(route('subscriptions.index'), form.value, {
        preserveState: true,
        preserveScroll: true,
        replace: true
    });
}, 300);

// Watch each form field individually
watch(() => form.value.search, () => {
    debouncedSearch();
});

watch(() => form.value.category, () => {
    router.get(route('subscriptions.index'), form.value, {
        preserveState: true,
        preserveScroll: true,
        replace: true
    });
});

watch(() => form.value.sort, () => {
    router.get(route('subscriptions.index'), form.value, {
        preserveState: true,
        preserveScroll: true,
        replace: true
    });
});
</script>

<template>
    <div class="grid gap-4 sm:grid-cols-3">
        <div>
            <InputLabel value="Search" />
            <TextInput
                v-model="form.search"
                type="text"
                class="mt-1 block w-full"
                placeholder="Search subscriptions..."
            />
        </div>

        <div>
            <InputLabel value="Category" />
            <select
                v-model="form.category"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            >
                <option value="">All Categories</option>
                <option
                    v-for="category in categories"
                    :key="category.id"
                    :value="category.id"
                >
                    {{ category.name }}
                </option>
            </select>
        </div>

        <div>
            <InputLabel value="Sort By" />
            <select
                v-model="form.sort"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            >
                <option value="renewal_date,asc">Renewal Date (Ascending)</option>
                <option value="renewal_date,desc">Renewal Date (Descending)</option>
                <option value="cost,asc">Cost (Low to High)</option>
                <option value="cost,desc">Cost (High to Low)</option>
                <option value="name,asc">Name (A-Z)</option>
                <option value="name,desc">Name (Z-A)</option>
            </select>
        </div>
    </div>
</template>
