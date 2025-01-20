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
    <div class="flex gap-4 items-center">
        <!-- Search Input -->
        <div class="flex-1">
            <InputLabel value="Search" class="text-xs mb-1" />
            <TextInput
                v-model="form.search"
                type="text"
                class="w-full text-sm py-1.5 px-3"
                placeholder="Search subscriptions..."
            />
        </div>

        <!-- Category Select -->
        <div class="w-64">
            <InputLabel value="Category" class="text-xs mb-1" />
            <select
                v-model="form.category"
                class="w-full rounded-lg border-gray-200 text-sm py-1.5 px-3 focus:border-gray-300 focus:ring-0"
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

        <!-- Sort Select -->
        <div class="w-48">
            <InputLabel value="Sort By" class="text-xs mb-1" />
            <select
                v-model="form.sort"
                class="w-full rounded-lg border-gray-200 text-sm py-1.5 px-3 focus:border-gray-300 focus:ring-0"
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
