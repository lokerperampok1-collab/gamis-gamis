@extends('layouts.store')

@section('title', 'Profil Saya — Ranti')

@section('content')
<div class="page-header">
    <div class="container">
        <h1>Profil Saya</h1>
        <p>Kelola informasi akun dan kata sandi Anda</p>
    </div>
</div>

<section class="section" style="padding-top: 48px;">
    <div class="container">
        <div class="dash-layout">
            {{-- Sidebar --}}
            <aside class="dash-sidebar">
                <div class="card">
                    <div class="dash-sidebar-header">
                        <i class="fa-solid fa-circle-user"></i>
                        <h4>{{ auth()->user()->name }}</h4>
                        <p>{{ auth()->user()->email }}</p>
                    </div>
                    <ul class="dash-menu">
                        <li><a href="{{ route('dashboard') }}"><i class="fa-solid fa-gauge-high"></i> Dashboard</a></li>
                        <li><a href="#"><i class="fa-solid fa-box-open"></i> Pesanan Saya</a></li>
                        <li><a href="{{ route('wishlist.index') }}"><i class="fa-solid fa-heart"></i> Wishlist</a></li>
                        <li><a href="{{ route('profile.edit') }}" class="active"><i class="fa-solid fa-user-pen"></i> Profil</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-danger"><i class="fa-solid fa-right-from-bracket"></i> Keluar</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </aside>

            {{-- Main --}}
            <div class="space-y-6">
                <div class="card card-body" style="padding: 32px;">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="card card-body" style="padding: 32px;">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="card card-body" style="padding: 32px;">
                    <div class="max-w-xl text-danger-container">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

