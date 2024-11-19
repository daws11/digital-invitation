<!-- resources/views/guests/edit.blade.php -->
@extends('layouts.app')

@section('title', 'Edit Tamu')

@section('content')
<div class="container mx-auto py-8">
    <h2 class="text-2xl font-semibold mb-6">Edit Tamu</h2>
    
    <form action="{{ route('guests.update', $guest->id) }}" method="POST" class="bg-white p-6 rounded shadow-md">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Nama Tamu</label>
            <input type="text" name="name" id="name" class="w-full mt-1 p-2 border rounded" value="{{ $guest->name }}" required>
        </div>
        
        <div class="mb-4">
            <label for="greeting_message" class="block text-sm font-medium text-gray-700">Ucapan</label>
            <textarea name="greeting_message" id="greeting_message" class="w-full mt-1 p-2 border rounded">{{ $guest->greeting_message }}</textarea>
        </div>
        
        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Perbarui</button>
    </form>
</div>
@endsection
