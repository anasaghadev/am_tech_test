@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8" dir="rtl">
        <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">تعديل المهمة: {{ $task->title }}</h2>
                    <a href="{{ route('tasks.index') }}" class="text-gray-500 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </a>
                </div>

                <form method="POST" action="{{ route('tasks.update', $task) }}">
                    @csrf
                    @method('PUT')


                    <div class="mb-6">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">عنوان المهمة</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $task->title) }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                            placeholder="أدخل عنوان المهمة" required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">الوصف</label>
                        <textarea id="description" name="description" rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                            placeholder="أدخل وصفاً مفصلاً للمهمة">{{ old('description', $task->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                        <div>
                            <label for="tags" class="block text-sm font-medium text-gray-700 mb-2">الوسوم</label>
                            <input type="text" id="tags" name="tags" value="{{ old('tags', $task->tags) }}">
                            <p class="mt-2 text-xs text-gray-500">أمثلة: مهم, عاجل, مشروع</p>
                            @error('tags')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>


                        <div>
                            <label for="due_date" class="block text-sm font-medium text-gray-700 mb-2">تاريخ التسليم</label>
                            <input type="date" id="due_date" name="due_date"
                                value="{{ old('due_date', optional($task->due_date)->format('Y-m-d')) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                            @error('due_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>


                    <div class="mb-8">
                        <label class="block text-sm font-medium text-gray-700 mb-2">حالة المهمة</label>
                        <div class="flex flex-col sm:flex-row items-start sm:items-center sm:space-x-8">
                            <div class="flex items-center mb-2 sm:mb-0">
                                <input id="pending" name="status" type="radio" value="pending"
                                    class="h-5 w-5 text-blue-600 focus:ring-blue-500"
                                    {{ old('status', $task->status) === 'pending' ? 'checked' : '' }}>
                                <label for="pending" class="mr-2 block text-base text-gray-700 font-medium">قيد
                                    التنفيذ</label>
                            </div>
                            <div class="flex items-center">
                                <input id="completed" name="status" type="radio" value="completed"
                                    class="h-5 w-5 text-blue-600 focus:ring-blue-500"
                                    {{ old('status', $task->status) === 'completed' ? 'checked' : '' }}>
                                <label for="completed" class="mr-2 block text-base text-gray-700 font-medium">مكتملة</label>
                            </div>
                        </div>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200">
                        <a href="{{ route('tasks.index') }}"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-3 rounded-lg font-medium transition duration-150 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                            إلغاء
                        </a>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium flex items-center transition duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20"
                                fill="CurrentColor">
                                <path
                                    d="M7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l6-6a1 1 0 10-1.414-1.414L10 12.586l-2.293-2.293z" />
                            </svg>
                            تحديث المهمة
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- Tagify --}}
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" />

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.querySelector('#tags');
            if (input) {
                new Tagify(input, {
                    originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join(','),
                    dropdown: {
                        enabled: 0
                    }
                });

                // Add Tailwind-like styles to Tagify input
                input.classList.add(
                    'w-full', 'px-4', 'py-3', 'border', 'border-gray-300', 'rounded-lg',
                    'focus:ring-2', 'focus:ring-blue-500', 'focus:border-blue-500', 'transition', 'duration-150'
                );
            }
        });
    </script>
@endsection
