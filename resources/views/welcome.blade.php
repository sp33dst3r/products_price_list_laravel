@extends('layouts.app')
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Тестовое задание
                </div>

                <div class="links">
                    <a href="/upload">Загрузить прайслист</a>
                    <a href="/results">Результаты</a>

                </div>
            </div>
        </div>
