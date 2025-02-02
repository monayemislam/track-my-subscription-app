<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});

const isScrolled = ref(false);
const isMobileMenuOpen = ref(false);

const stats = [
    { value: '10k+', label: 'Active Users', trend: '+25% from last month' },
    { value: '$2M+', label: 'Tracked Monthly', trend: '+40% growth rate' },
    { value: '98%', label: 'Satisfaction Rate', trend: 'Based on 1000+ reviews' },
];

onMounted(() => {
    window.addEventListener('scroll', () => {
        isScrolled.value = window.scrollY > 20;
    });
});
</script>

<template>
    <Head title="SubTracker - Smart Subscription Management" />

    <div class="relative min-h-screen bg-[#0A0F1C]">
        <!-- Animated Gradient Background -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -left-40 w-[600px] h-[600px] bg-gradient-to-r from-violet-500/20 to-transparent rounded-full blur-3xl animate-blob"></div>
            <div class="absolute -top-48 -right-40 w-[600px] h-[600px] bg-gradient-to-l from-indigo-500/20 to-transparent rounded-full blur-3xl animate-blob animation-delay-2000"></div>
        </div>

        <!-- Navigation -->
        <header 
            :class="[
                'fixed w-full z-50 transition-all duration-300',
                isScrolled ? 'py-4 bg-[#0A0F1C]/80 backdrop-blur-xl' : 'py-6'
            ]"
        >
            <nav class="container mx-auto px-6">
                <div class="flex items-center justify-between">
                    <!-- Logo -->
                    <Link href="/" class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-[#1A1F2C] rounded-xl flex items-center justify-center border border-indigo-500/20">
                            <span class="text-white font-bold text-xl">S</span>
                        </div>
                        <span class="text-xl font-semibold text-white">
                            SubTracker
                        </span>
                    </Link>

                    <!-- Desktop Menu -->
                    <div class="hidden md:flex items-center gap-8">
                        <a href="#features" class="text-white/80 hover:text-white transition-colors">Features</a>
                        <a href="#pricing" class="text-white/80 hover:text-white transition-colors">Pricing</a>
                        <a href="#about" class="text-white/80 hover:text-white transition-colors">About</a>
                        
                        <template v-if="$page.props.auth.user">
                            <Link 
                                :href="route('dashboard')"
                                class="text-white/80 hover:text-white transition-colors"
                            >
                                Dashboard
                            </Link>
                        </template>
                        <template v-else>
                            <Link 
                                :href="route('login')"
                                class="text-white/80 hover:text-white transition-colors"
                            >
                                Sign in
                            </Link>
                            <Link 
                                v-if="canRegister" 
                                :href="route('register')"
                                class="px-4 py-2 bg-[#1A1F2C] text-white rounded-lg border border-indigo-500/20 hover:bg-[#1A1F2C]/80 transition-all duration-200"
                            >
                                Get Started
                            </Link>
                        </template>
                    </div>

                    <!-- Mobile Menu Button -->
                    <button 
                        @click="isMobileMenuOpen = !isMobileMenuOpen"
                        class="md:hidden p-2 text-white/80 hover:text-white transition-colors"
                    >
                        <svg 
                            class="w-6 h-6" 
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24"
                        >
                            <path 
                                v-if="!isMobileMenuOpen"
                                stroke-linecap="round" 
                                stroke-linejoin="round" 
                                stroke-width="2" 
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                            <path 
                                v-else
                                stroke-linecap="round" 
                                stroke-linejoin="round" 
                                stroke-width="2" 
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>

                <!-- Mobile Menu -->
                <div 
                    v-show="isMobileMenuOpen"
                    class="md:hidden py-4 space-y-4 mt-4 bg-[#1A1F2C] rounded-lg border border-indigo-500/20 px-4"
                >
                    <a href="#features" class="block text-white/80 hover:text-white transition-colors">Features</a>
                    <a href="#pricing" class="block text-white/80 hover:text-white transition-colors">Pricing</a>
                    <a href="#about" class="block text-white/80 hover:text-white transition-colors">About</a>
                    <template v-if="$page.props.auth.user">
                        <Link 
                            :href="route('dashboard')"
                            class="block text-white/80 hover:text-white transition-colors"
                        >
                            Dashboard
                        </Link>
                    </template>
                    <template v-else>
                        <Link 
                            :href="route('login')"
                            class="block text-white/80 hover:text-white transition-colors"
                        >
                            Sign in
                        </Link>
                        <Link 
                            v-if="canRegister" 
                            :href="route('register')"
                            class="inline-block mt-2 px-4 py-2 bg-[#0A0F1C] text-white rounded-lg border border-indigo-500/20 hover:bg-[#0A0F1C]/80 transition-all duration-200"
                        >
                            Get Started
                        </Link>
                    </template>
                </div>
            </nav>
        </header>

        <!-- Hero Section -->
        <section class="relative pt-32 pb-20 overflow-hidden">
            <!-- Decorative elements -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <!-- Gradient Spheres -->
                <div class="absolute top-1/4 left-1/4 w-[500px] h-[500px] bg-gradient-to-r from-violet-500/30 to-fuchsia-500/30 rounded-full blur-3xl animate-blob"></div>
                <div class="absolute top-1/3 right-1/4 w-[400px] h-[400px] bg-gradient-to-l from-indigo-500/20 to-blue-500/20 rounded-full blur-3xl animate-blob animation-delay-2000"></div>
                
                <!-- Grid Pattern -->
                <div class="absolute inset-0" 
                    style="background-image: radial-gradient(circle at center, rgba(255, 255, 255, 0.1) 2px, transparent 2px); 
                           background-size: 48px 48px;
                           opacity: 0.3;
                           transform: rotate(-2deg) scale(1.5);">
                </div>
            </div>

            <!-- Main Content -->
            <div class="container relative mx-auto px-6">
                <div class="max-w-5xl mx-auto">
                    <!-- Hero Header -->
                    <div class="text-center mb-16">
                        <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/5 border border-white/10 backdrop-blur-sm mb-8">
                            <span class="text-white/70 text-sm">🚀 Launching our new AI-powered insights</span>
                        </div>
                        
                        <h1 class="text-5xl md:text-7xl font-bold mb-8 bg-clip-text text-transparent bg-gradient-to-r from-white to-white/80">
                            Control Your Digital
                            <span class="relative inline-block mt-2">
                                <span class="relative z-10 bg-gradient-to-r from-indigo-500 to-violet-500 bg-clip-text text-transparent">
                                    Subscriptions
                                </span>
                                <svg class="absolute -bottom-2 left-0 w-full scale-110" viewBox="0 0 300 12" fill="none">
                                    <path d="M2 8.5C75 3.5 150 3.5 298 8.5" stroke="url(#gradient)" stroke-width="3" stroke-linecap="round"/>
                                    <defs>
                                        <linearGradient id="gradient" x1="0" y1="0" x2="1" y2="0">
                                            <stop offset="0%" stop-color="#818CF8"/>
                                            <stop offset="100%" stop-color="#C084FC"/>
                                        </linearGradient>
                                    </defs>
                                </svg>
                            </span>
                        </h1>
                        
                        <p class="text-xl text-white/70 mb-12 max-w-2xl mx-auto leading-relaxed">
                            Your all-in-one platform for managing subscriptions. Track expenses, 
                            get smart reminders, and optimize spending with AI-powered insights.
                        </p>

                        <!-- CTA Buttons -->
                        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-16">
                            <Link 
                                v-if="canRegister"
                                :href="route('register')"
                                class="group relative px-8 py-4 bg-gradient-to-r from-indigo-500 to-violet-500 rounded-xl w-full sm:w-auto overflow-hidden"
                            >
                                <div class="absolute inset-0 bg-gradient-to-r from-violet-500 to-indigo-500 transition-opacity opacity-0 group-hover:opacity-100"></div>
                                <span class="relative flex items-center justify-center gap-2 text-white font-medium">
                                    Start Free Trial
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </span>
                            </Link>

                            <a 
                                href="#features"
                                class="group px-8 py-4 rounded-xl bg-white/5 border border-white/10 backdrop-blur-sm w-full sm:w-auto hover:bg-white/10 transition-all duration-200"
                            >
                                <span class="text-white/80 font-medium group-hover:text-white transition-colors">Watch Demo</span>
                            </a>
                        </div>

                        <!-- Stats -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                            <div 
                                v-for="(stat, index) in stats" 
                                :key="index"
                                class="group p-6 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm hover:bg-white/[0.07] transition-all duration-200"
                            >
                                <div class="text-3xl font-bold text-white mb-1">{{ stat.value }}</div>
                                <div class="text-sm text-white/60 mb-2">{{ stat.label }}</div>
                                <div class="text-xs text-indigo-400">{{ stat.trend }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<style>
.backdrop-blur-xl {
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
}

@keyframes blob {
    0% { transform: translate(0px, 0px) scale(1); }
    33% { transform: translate(30px, -50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
    100% { transform: translate(0px, 0px) scale(1); }
}

.animate-blob {
    animation: blob 7s infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.backdrop-blur-sm {
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
}
</style>
