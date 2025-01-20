<script setup>
import { onMounted, ref } from 'vue';
import { Chart } from 'chart.js/auto';

const props = defineProps({
    categoryBreakdown: {
        type: Object,
        required: true,
    },
});

const chartCanvas = ref(null);

onMounted(() => {
    const ctx = chartCanvas.value.getContext('2d');
    
    const labels = Object.keys(props.categoryBreakdown);
    const data = Object.values(props.categoryBreakdown);
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                borderColor: '#6366F1',
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#6366F1',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                },
                title: {
                    display: true,
                    text: 'Spending by Category',
                    font: {
                        size: 16,
                        family: "'Inter', sans-serif",
                        weight: '500',
                    },
                    padding: {
                        bottom: 30,
                    },
                    color: '#374151',
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                    },
                    ticks: {
                        font: {
                            family: "'Inter', sans-serif",
                        },
                    },
                },
                x: {
                    grid: {
                        display: false,
                    },
                    ticks: {
                        font: {
                            family: "'Inter', sans-serif",
                        },
                    },
                },
            },
        },
    });
});
</script>

<template>
    <div class="rounded-lg bg-white p-6 shadow-sm">
        <div class="h-[400px]">
            <canvas ref="chartCanvas"></canvas>
        </div>
    </div>
</template>
