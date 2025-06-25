@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800">إدارة المهام</h1>
            <a href="{{ route('tasks.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                        clip-rule="evenodd" />
                </svg>
                إضافة مهمة جديدة
            </a>
        </div>


        <div class="bg-white rounded-xl shadow-md p-4 mb-6">
            <div class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">البحث</label>
                    <input type="text" id="search-input" placeholder="ابحث في المهام..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>

                <div class="flex-1 min-w-[150px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">الحالة</label>
                    <select id="status-filter" class="w-full px-3 pr-8 py-2 border border-gray-300 rounded-lg">
                        <option value="all">جميع الحالات</option>
                        <option value="pending">قيد التنفيذ</option>
                        <option value="completed">مكتملة</option>
                    </select>
                </div>

                <div class="flex-1 min-w-[150px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">الوسوم</label>
                    <select id="tag-filter" class="w-full px-3 pr-8 py-2 border border-gray-300 rounded-lg">
                        <option value="all">جميع الوسوم</option>
                        @foreach ($tags as $tag)
                            <option value="{{ $tag }}">{{ $tag }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>


        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($tasks as $task)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 task-card"
                    data-status="{{ $task->status }}" data-tags="{{ $task->tags }}">
                    <div class="p-5">
                        <div class="flex justify-between items-start">
                            <div>
                                <div class="flex items-center">
                                    <span class="text-xl font-bold text-gray-800">{{ $task->title }}</span>
                                    <span
                                        class="ml-2 px-2 py-1 text-xs rounded-full {{ $task->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $task->status === 'completed' ? 'مكتملة' : 'قيد التنفيذ' }}
                                    </span>
                                </div>
                                <p class="mt-2 text-gray-600">{{ $task->description }}</p>
                            </div>


                            <form action="{{ route('taskstoggle', $task) }}" method="POST" class="task-status-form">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status"
                                    value="{{ $task->status === 'completed' ? 'pending' : 'completed' }}">
                                <button type="submit"
                                    class="relative inline-flex items-center h-6 rounded-full w-11 focus:outline-none task-toggle"
                                    aria-pressed="{{ $task->status === 'completed' ? 'true' : 'false' }}">
                                    <span class="sr-only">تبديل الحالة</span>
                                    <span
                                        class="inline-block h-4 w-4 transform transition ease-in-out duration-200 {{ $task->status === 'completed' ? ' bg-green-500' : 'bg-gray-200' }} rounded-full"></span>
                                </button>
                            </form>

                        </div>


                        @if ($task->tags)
                            <div class="mt-4 flex flex-wrap gap-1">
                                @foreach (explode(',', $task->tags) as $tag)
                                    <span
                                        class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">{{ trim($tag) }}</span>
                                @endforeach
                            </div>
                        @endif


                        <div class="mt-4 flex items-center text-sm text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>تاريخ التسليم:
                                {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') : 'غير محدد' }}</span>
                        </div>
                    </div>


                    <div class="bg-gray-50 px-5 py-3 flex justify-between">
                        <a href="{{ route('tasks.edit', $task) }}"
                            class="text-blue-600 hover:text-blue-800 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                            تعديل
                        </a>

                        <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 flex items-center confirm-delete">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                حذف
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>


        @if ($tasks->isEmpty())
            <div class="bg-white rounded-xl shadow-md p-8 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <h3 class="mt-4 text-xl font-medium text-gray-900">لا توجد مهام</h3>
                <p class="mt-1 text-gray-500">ابدأ بإضافة مهمة جديدة باستخدام الزر أعلاه</p>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        // document.addEventListener('DOMContentLoaded', () => {
        //     // Toggle button aria-pressed and styling on click
        //     document.querySelectorAll('.task-status-form').forEach(form => {
        //         form.addEventListener('submit', (e) => {
        //             // Allow default submit, no JS toggle needed, the page reload will show the new status
        //         });
        //     });

        //     // Filters and search code here (unchanged) ...
        // });
    </script>
@endsection
