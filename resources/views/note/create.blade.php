<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Создать заметку</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' }
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else { document.documentElement.classList.remove('dark') }
    </script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-200 min-h-screen p-4 sm:p-8">
    <div class="max-w-xl mx-auto">
        
        <div class="flex justify-between items-center mb-6 bg-white dark:bg-gray-800 p-4 sm:p-6 rounded-xl shadow transition-colors duration-200">
            <h1 class="text-xl sm:text-2xl font-bold">Новая заметка</h1>
            <a href="/notes" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">
                ← Назад к списку
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 sm:p-6 transition-colors duration-200">
            <form id="create-note-form" class="space-y-4">
                
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Название заметки
                    </label>
                    <input type="text" id="name" name="name" required max="255"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-colors"
                        placeholder="Введите название...">
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Описание
                    </label>
                    <textarea id="description" name="description" required rows="4"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-colors resize-y"
                        placeholder="Напишите текст заметки..."></textarea>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" id="submit-btn"
                        class="w-full sm:w-auto bg-blue-600 text-white px-6 py-2.5 rounded-lg hover:bg-blue-700 transition-colors font-medium shadow-sm">
                        Сохранить заметку
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $('#create-note-form').on('submit', function(e) {
                e.preventDefault(); 
				
                $('#submit-btn').prop('disabled', true).text('Сохранение...');

                const noteData = {
                    name: $('#name').val(),
                    description: $('#description').val()
                };

                $.ajax({
                    url: '/api/notes',
                    method: 'POST',
                    data: noteData, 
                    dataType: 'json',
                    success: function(response) {
                        window.location.href = '/notes';
                    },
                    error: function(xhr) {
                        alert('Произошла ошибка при сохранении. Проверьте введенные данные.');
                        $('#submit-btn').prop('disabled', false).text('Сохранить заметку');
                    }
                });
            });
        });
    </script>
</body>
</html>
