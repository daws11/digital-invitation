@extends('layouts.app')

@section('title', 'Edit Tamu')

@section('content')
<div class="bg-primary-light min-h-screen py-8">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-primary-dark mb-6">Edit Tamu</h2>
        
        <form action="{{ route('guests.update', $guest->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow">
            @csrf
            @method('PUT')
            
            <!-- Input Nama -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-primary-dark">Nama Tamu</label>
                <input type="text" name="name" id="name" class="w-full mt-1 p-2 border border-gray-300 rounded focus:ring-primary-light focus:border-primary-dark" value="{{ $guest->name }}" required>
            </div>
            
            <!-- Input Ucapan -->
            <div class="mb-4">
                <label for="greeting_message" class="block text-sm font-medium text-primary-dark">Ucapan</label>
                <textarea name="greeting_message" id="greeting_message" class="w-full mt-1 p-2 border border-gray-300 rounded focus:ring-primary-light focus:border-primary-dark">{{ $guest->greeting_message }}</textarea>
            </div>
            
            <!-- Tombol Perbarui -->
            <button type="submit" class="px-4 py-2 bg-primary-dark text-white rounded shadow hover:bg-primary focus:ring-2 focus:ring-primary-light">
                Perbarui
            </button>
        </form>
    </div>
</div>
@endsection
