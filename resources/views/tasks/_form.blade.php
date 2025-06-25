<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
        <div class="p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-6">
                {{ isset($task) ? 'تعديل المهمة' : 'إضافة مهمة جديدة' }}
            </h2>

            <form method="POST" action="{{ isset($task) ? route('tasks.update', $task) : route('tasks.store') }}">
                @csrf
                @if (isset($task))
                    @method('PUT')
                @endif


                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">عنوان المهمة</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $task->title ?? '') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>


                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">الوصف</label>
                    <textarea id="description" name="description" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">{{ old('description', $task->description ?? '') }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div class="mb-4">
                        <label for="tags" class="block text-sm font-medium text-gray-700 mb-1">الوسوم (مفصولة
                            بفواصل)</label>
                        <input type="text" id="tags" name="tags" value="{{ old('tags', $task->tags ?? '') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <p class="mt-1 text-xs text-gray-500">أمثلة: مهم, عاجل, مشروع</p>
                    </div>


                    <div class="mb-4">
                        <label for="due_date" class="block text-sm font-medium text-gray-700 mb-1">تاريخ التسليم</label>
                        <input type="date" id="due_date" name="due_date"
                            value="{{ old('due_date', isset($task) && $task->due_date ? $task->due_date->format('Y-m-d') : '') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>


                @if (isset($task))
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">حالة المهمة</label>
                        <div class="flex items-center">
                            <div class="flex items-center mr-4">
                                <input id="pending" name="status" type="radio" value="pending"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500"
                                    {{ old('status', $task->status) === 'pending' ? 'checked' : '' }}>
                                <label for="pending" class="mr-2 block text-sm text-gray-700">قيد التنفيذ</label>
                            </div>
                            <div class="flex items-center">
                                <input id="completed" name="status" type="radio" value="completed"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500"
                                    {{ old('status', $task->status) === 'completed' ? 'checked' : '' }}>
                                <label for="completed" class="mr-2 block text-sm text-gray-700">مكتملة</label>
                            </div>
                        </div>
                    </div>
                @endif


                <div class="flex justify-end space-x-3">
                    <a href="{{ route('tasks.index') }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                        إلغاء
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                        {{ isset($task) ? 'تحديث المهمة' : 'إضافة المهمة' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
