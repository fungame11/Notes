<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создание заметки</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' }
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else { document.documentElement.classList.remove('dark') }
    </script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-200 min-h-screen p-4 sm:p-8 flex items-center justify-center">
    <div class="w-full max-w-md bg-white dark:bg-gray-800 p-6 sm:p-8 rounded-xl shadow-lg transition-colors duration-200">
        <h1 class="text-2xl font-bold mb-6">Создание заметки</h1>
        
        <div class="space-y-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Название</label>
                <input type="text" id="name" class="w-full border border-gray-300 dark:border-gray-600 bg-transparent rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none transition-colors">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Описание</label>
                <textarea id="description" rows="5" class="w-full border border-gray-300 dark:border-gray-600 bg-transparent rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 outline-none transition-colors resize-y"></textarea>
            </div>
            <div class="flex gap-3 pt-4">
                <button id="save" class="flex-1 bg-blue-600 text-white px-4 py-2.5 rounded-lg hover:bg-blue-700 transition-colors font-medium">Сохранить</button>
                <a href="/notes" class="flex-1 text-center bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-4 py-2.5 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors font-medium">Назад</a>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#save').click(function() {
                const btn = $(this);
                btn.text('Сохранение...').prop('disabled', true);
                
                $.ajax({
                    url: '/api/notes',
                    method: 'post',
                    dataType: 'json',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        "name": $("#name").val(),
                        "description": $('#description').val()
                    }),
                    success: function() {
                        window.location.href = '/notes';
                    },
                    error: function() {
                        alert("Ошибка валидации данных! Проверьте заполнение полей.");
                        btn.text('Сохранить').prop('disabled', false);
                    }
                });
            });
        });
    </script>
</body>
</html>
