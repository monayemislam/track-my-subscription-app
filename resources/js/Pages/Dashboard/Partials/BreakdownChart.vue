<script setup>
import { ref, onMounted, watch } from 'vue';
import Chart from 'chart.js/auto';

const props = defineProps({
    breakdownData: {
        type: Object,
        required: true
    },
    title: {
        type: String,
        default: 'Subscription Breakdown'
    }
});

const chartCanvas = ref(null);
let chart = null;

const formatCurrency = (value) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 2
    }).format(value);
};

const initChart = () => {
    if (chartCanvas.value && props.breakdownData) {
        const ctx = chartCanvas.value.getContext('2d');
        
        // Destroy existing chart if it exists
        if (chart) {
            chart.destroy();
        }

        const labels = Object.keys(props.breakdownData);
        const data = Object.values(props.breakdownData);

        chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Subscription Cost',
                    data: data,
                    borderColor: 'rgb(139, 92, 246)',
                    backgroundColor: 'rgba(139, 92, 246, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: 'rgb(139, 92, 246)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 1000,
                    easing: 'easeInOutQuart'
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            callback: value => formatCurrency(value)
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: context => formatCurrency(context.raw)
                        }
                    }
                }
            }
        });
    }
};

// Watch for changes in breakdown data
watch(() => props.breakdownData, () => {
    initChart();
}, { deep: true });

onMounted(() => {
    initChart();
});
</script>

<template>
    <div class="rounded-2xl bg-white p-6 shadow-lg">
        <h3 class="mb-6 text-lg font-semibold text-gray-900">{{ title }}</h3>
        <div class="relative h-[300px]">
            <canvas ref="chartCanvas"></canvas>
        </div>
    </div>
</template>