@extends('layouts.app')

@section('content')
<div class="bg-pink-50/30">
    <!-- Hero Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
        <div class="text-center max-w-3xl mx-auto">
            <div class="inline-flex items-center gap-2 bg-pink-100 px-4 py-2 rounded-full mb-6">
                <span class="w-2 h-2 bg-pink-500 rounded-full"></span>
                <span class="text-sm text-pink-600 font-medium">Trusted by 1,000+ users</span>
            </div>
            
            <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-6">
                Lost something? <br>
                <span class="bg-gradient-to-r from-pink-500 to-rose-500 bg-clip-text text-transparent">We'll find it.</span>
            </h1> 
            
            <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                UMFind connects lost items with their owners. 
               <br> Post what you've lost or found, and let our community help.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    <a href="{{ route('items.index') }}" class="btn-primary">
                        Explore Items →
                    </a>
                    
                     @if(!auth()->user()->isAdmin())
                        <a href="{{ route('items.create') }}" class="btn-secondary">
                            Post an Item
                        </a>
                    @endif
                @else
                    <a href="{{ route('register') }}" class="btn-primary">
                        Start Exploring →
                    </a>
                    <a href="{{ route('login') }}" class="btn-secondary">
                        Sign In
                    </a>

                    <br>
                    <a href="{{ route('items.index') }}" 
                        class="inline-block bg-white text-pink-600 border border-pink-500 px-6 py-3 rounded-xl font-semibold shadow-sm hover:bg-pink-50 transition">
                        Browse Posts
                    </a>


                @endauth
            </div>
        </div>
    </div>
    
    <!-- How It Works - 3 Simple Steps -->
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="text-pink-500 text-sm font-semibold uppercase tracking-wide">Simple Process</span>
                <h2 class="text-3xl font-bold text-gray-900 mt-2">How It Works</h2>
                <p class="text-gray-500 mt-2">Three steps to reunite with your belongings</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-pink-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">📝</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">1. Report</h3>
                    <p class="text-gray-500 text-sm">Post details about your lost or found item</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-pink-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">🔍</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">2. Match</h3>
                    <p class="text-gray-500 text-sm">Our system finds potential matches</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-pink-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">✅</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">3. Reunite</h3>
                    <p class="text-gray-500 text-sm">Claim your item and arrange pickup</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Stats -->
    <div class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-3xl font-bold text-pink-500">1,234+</div>
                    <div class="text-sm text-gray-500 mt-1">Items Found</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-pink-500">98%</div>
                    <div class="text-sm text-gray-500 mt-1">Success Rate</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-pink-500">500+</div>
                    <div class="text-sm text-gray-500 mt-1">Happy Users</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-pink-500">24/7</div>
                    <div class="text-sm text-gray-500 mt-1">Support</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- CTA -->
    <div class="bg-pink-500 py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl md:text-3xl font-bold text-white mb-3">Ready to find what's yours?</h2>
            <p class="text-pink-100 mb-6">Join our community today</p>
            @auth
                <a href="{{ route('items.index') }}" class="inline-block bg-white text-pink-600 px-8 py-3 rounded-xl font-semibold hover:bg-gray-100 transition">
                    Browse Items
                </a>
            @else
                <a href="{{ route('register') }}" class="inline-block bg-white text-pink-600 px-8 py-3 rounded-xl font-semibold hover:bg-gray-100 transition">
                    Create Free Account
                </a>
            @endauth
        </div>
    </div>
</div>
@endsection