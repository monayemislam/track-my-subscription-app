<script setup>
defineProps({
    links: Array
});
</script>

<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap -mb-1">
            <template v-for="(link, key) in links" :key="key">
                <div
                    v-if="link.url === null"
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                >
                    {{ link.label.replace(/&laquo;|&raquo;/g, '') }}
                </div>
                <Link
                    v-else
                    :href="link.url"
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-gray-100 focus:border-indigo-500 focus:text-indigo-500"
                    :class="{ 'bg-indigo-50': link.active }"
                >
                    {{ link.label.replace(/&laquo;|&raquo;/g, '') }}
                </Link>
            </template>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';

export default {
    components: {
        Link,
    },
};
</script> 