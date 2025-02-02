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

const features = [
    {
        title: 'Smart Tracking',
        description: 'Automatically detect and track all your subscriptions in one unified dashboard.',
        icon: 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2',
        gradient: 'from-blue-500 to-indigo-500'
    },
    {
        title: 'AI-Powered Insights',
        description: 'Get personalized recommendations to optimize your subscription spending.',
        icon: 'M13 10V3L4 14h7v7l9-11h-7z',
        gradient: 'from-violet-500 to-purple-500'
    },
    {
        title: 'Smart Reminders',
        description: 'Never miss a payment with customizable notifications and renewal alerts.',
        icon: 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9',
        gradient: 'from-fuchsia-500 to-pink-500'
    }
];

const plans = [
    {
        name: 'Basic',
        price: '$9',
        period: 'per month',
        description: 'Perfect for individuals and small teams getting started.',
        gradient: 'from-blue-500 to-indigo-500',
        features: [
            'Up to 10 subscriptions',
            'Basic analytics',
            'Email notifications',
            'Mobile app access',
            '24/7 support'
        ]
    },
    {
        name: 'Pro',
        price: '$29',
        period: 'per month',
        description: 'Advanced features for growing businesses.',
        gradient: 'from-violet-500 to-purple-500',
        popular: true,
        features: [
            'Unlimited subscriptions',
            'Advanced analytics & insights',
            'Custom notifications',
            'Team collaboration',
            'Priority support',
            'API access'
        ]
    },
    {
        name: 'Enterprise',
        price: '$99',
        period: 'per month',
        description: 'Custom solutions for large organizations.',
        gradient: 'from-fuchsia-500 to-pink-500',
        features: [
            'Everything in Pro',
            'Custom integrations',
            'Dedicated account manager',
            'SLA guarantees',
            'Custom reporting',
            'SSO & advanced security'
        ]
    }
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

        <!-- Features Section -->
        <section class="relative py-32 overflow-hidden">
            <!-- Background Elements -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute top-1/3 right-0 w-[900px] h-[900px] bg-gradient-to-l from-indigo-500/10 to-transparent rounded-full blur-3xl animate-blob animation-delay-4000"></div>
                <div class="absolute bottom-0 left-0 w-[900px] h-[900px] bg-gradient-to-r from-violet-500/10 to-transparent rounded-full blur-3xl animate-blob"></div>
            </div>

            <div class="container relative mx-auto px-6">
                <!-- Section Header -->
                <div class="text-center mb-24">
                    <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/5 border border-white/10 backdrop-blur-sm mb-8">
                        <span class="text-white/70 text-sm">⚡️ Powerful Features</span>
                    </div>
                    <h2 class="text-5xl md:text-6xl font-bold text-white mb-6">
                        Designed for
                        <span class="bg-gradient-to-r from-indigo-500 to-violet-500 bg-clip-text text-transparent">
                            Modern Teams
                        </span>
                    </h2>
                    <p class="text-xl text-white/60 max-w-2xl mx-auto leading-relaxed">
                        Everything you need to take control of your subscriptions and optimize your spending
                    </p>
                </div>

                <!-- Features Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                    <div 
                        v-for="(feature, index) in features" 
                        :key="index"
                        class="group relative"
                    >
                        <!-- Card -->
                        <div class="relative h-full p-8 rounded-2xl bg-white/[0.03] border border-white/10 backdrop-blur-sm 
                                    hover:bg-white/[0.05] transition-all duration-500">
                            <!-- Icon -->
                            <div class="mb-8 relative">
                                <div class="w-14 h-14 rounded-xl bg-gradient-to-r border border-white/10 backdrop-blur-sm
                                          flex items-center justify-center relative z-10"
                                     :class="feature.gradient">
                                    <svg 
                                        class="w-7 h-7 text-white" 
                                        fill="none" 
                                        stroke="currentColor" 
                                        viewBox="0 0 24 24"
                                    >
                                        <path 
                                            :d="feature.icon" 
                                            stroke-linecap="round" 
                                            stroke-linejoin="round" 
                                            stroke-width="2"
                                        />
                                    </svg>
                                </div>
                                <!-- Glow Effect -->
                                <div 
                                    class="absolute -inset-2 rounded-xl bg-gradient-to-r opacity-0 group-hover:opacity-20 blur-xl transition-all duration-500"
                                    :class="feature.gradient"
                                ></div>
                            </div>

                            <!-- Content -->
                            <h3 class="text-2xl font-semibold text-white mb-4">
                                {{ feature.title }}
                            </h3>
                            <p class="text-lg text-white/60 leading-relaxed">
                                {{ feature.description }}
                            </p>

                            <!-- Hover Line -->
                            <div class="absolute bottom-0 left-0 h-[2px] w-0 bg-gradient-to-r group-hover:w-full transition-all duration-500"
                                 :class="feature.gradient">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom CTA -->
                <div class="text-center mt-24">
                    <Link 
                        v-if="canRegister"
                        :href="route('register')"
                        class="inline-flex items-center gap-3 px-8 py-4 rounded-xl bg-white/5 border border-white/10 
                               hover:bg-white/[0.07] transition-all duration-300 group"
                    >
                        <span class="text-lg text-white/90 group-hover:text-white transition-colors">
                            Explore All Features
                        </span>
                        <svg 
                            class="w-5 h-5 text-white/70 group-hover:text-white transition-colors transform group-hover:translate-x-1 duration-200" 
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24"
                        >
                            <path 
                                stroke-linecap="round" 
                                stroke-linejoin="round" 
                                stroke-width="2" 
                                d="M17 8l4 4m0 0l-4 4m4-4H3"
                            />
                        </svg>
                    </Link>
                </div>
            </div>
        </section>

        <!-- Pricing Section -->
        <section id="pricing" class="relative py-32 overflow-hidden">
            <!-- Background Elements -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute top-1/4 left-0 w-[800px] h-[800px] bg-gradient-to-r from-violet-500/10 to-transparent rounded-full blur-3xl animate-blob"></div>
                <div class="absolute bottom-0 right-0 w-[600px] h-[600px] bg-gradient-to-l from-indigo-500/10 to-transparent rounded-full blur-3xl animate-blob animation-delay-2000"></div>
            </div>

            <div class="container relative mx-auto px-6">
                <!-- Section Header -->
                <div class="text-center mb-20">
                    <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/5 border border-white/10 backdrop-blur-sm mb-8">
                        <span class="text-white/70 text-sm">🎁 Free Forever</span>
                    </div>
                    <h2 class="text-5xl md:text-6xl font-bold text-white mb-6">
                        Start Using
                        <span class="bg-gradient-to-r from-indigo-500 to-violet-500 bg-clip-text text-transparent">
                            SubTracker Free
                        </span>
                    </h2>
                    <p class="text-xl text-white/60 max-w-2xl mx-auto leading-relaxed">
                        All features included. No credit card required.
                    </p>
                </div>

                <!-- Free Plan Card -->
                <div class="max-w-4xl mx-auto">
                    <div class="group relative">
                        <!-- Card -->
                        <div class="relative px-16 py-10 rounded-2xl bg-white/[0.03] border border-white/10 backdrop-blur-sm 
                                    hover:bg-white/[0.05] transition-all duration-500">
                            <!-- Price Badge -->
                            <div class="absolute -top-5 left-1/2 -translate-x-1/2 px-8 py-2 rounded-full 
                                        bg-gradient-to-r from-violet-500 to-indigo-500 text-white text-lg font-medium">
                                Free Forever
                            </div>

                            <!-- Content -->
                            <div class="text-center mb-12 mt-4">
                                <h3 class="text-3xl font-bold text-white mb-4">Everything You Need</h3>
                                <p class="text-lg text-white/60 max-w-2xl mx-auto">
                                    Track all your subscriptions, get insights, and never miss a payment - completely free.
                                </p>
                            </div>

                            <!-- Features Grid - Centered Two Columns -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-16 gap-y-8 mb-12 max-w-3xl mx-auto">
                                <div class="flex items-center gap-4">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-gradient-to-r from-indigo-500/20 to-violet-500/20 
                                                border border-white/5 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                    </div>
                                    <span class="text-lg text-white/80">Unlimited Subscriptions</span>
                                </div>

                                <div class="flex items-center gap-4">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-gradient-to-r from-indigo-500/20 to-violet-500/20 
                                                border border-white/5 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <span class="text-lg text-white/80">Smart Tracking System</span>
                                </div>

                                <div class="flex items-center gap-4">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-gradient-to-r from-indigo-500/20 to-violet-500/20 
                                                border border-white/5 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                        </svg>
                                    </div>
                                    <span class="text-lg text-white/80">AI-Powered Insights</span>
                                </div>

                                <div class="flex items-center gap-4">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-gradient-to-r from-indigo-500/20 to-violet-500/20 
                                                border border-white/5 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <span class="text-lg text-white/80">Email Notifications</span>
                                </div>

                                <div class="flex items-center gap-4">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-gradient-to-r from-indigo-500/20 to-violet-500/20 
                                                border border-white/5 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <span class="text-lg text-white/80">Mobile App Access</span>
                                </div>

                                <div class="flex items-center gap-4">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-gradient-to-r from-indigo-500/20 to-violet-500/20 
                                                border border-white/5 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                    </div>
                                    <span class="text-lg text-white/80">Custom Categories</span>
                                </div>

                                <div class="flex items-center gap-4">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-gradient-to-r from-indigo-500/20 to-violet-500/20 
                                                border border-white/5 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                        </svg>
                                    </div>
                                    <span class="text-lg text-white/80">Spending Analytics</span>
                                </div>

                                <div class="flex items-center gap-4">
                                    <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-gradient-to-r from-indigo-500/20 to-violet-500/20 
                                                border border-white/5 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <span class="text-lg text-white/80">Smart Reminders</span>
                                </div>
                            </div>

                            <!-- CTA Button -->
                            <div class="text-center">
                                <Link 
                                    v-if="canRegister"
                                    :href="route('register')"
                                    class="group relative inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r 
                                           from-violet-500 to-indigo-500 rounded-xl text-white text-lg font-medium
                                           hover:from-violet-600 hover:to-indigo-600 transition-all duration-200"
                                >
                                    Get Started Now
                                    <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform duration-200" 
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </Link>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Text -->
                    <p class="text-center mt-6 text-white/60">
                        No credit card required. No hidden fees. Start tracking your subscriptions today.
                    </p>
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
