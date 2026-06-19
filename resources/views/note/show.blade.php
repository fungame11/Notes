<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование</title>
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
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Редактирование</h1>
            <span id="save-status" class="text-sm text-green-500 hidden font-medium">✓ Сохранено</span>
        </div>
        
        <div class="space-y-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Название</label>
                <input type="text" id="name" class="w-full border border-gray-300 dark:border-gray-600 bg-transparent rounded-lg p-2.5 focus:ring-2 focus:ring-yellow-500 outline-none transition-colors">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Описание</label>
                <textarea id="description" rows="5" class="w-full border border-gray-300 dark:border-gray-600 bg-transparent rounded-lg p-2.5 focus:ring-2 focus:ring-yellow-500 outline-none transition-colors resize-y"></textarea>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 pt-4">
                <button id="save" class="flex-1 bg-yellow-500 text-white px-4 py-2.5 rounded-lg hover:bg-yellow-600 transition-colors font-medium">Обновить</button>
                <button id="delete" class="sm:flex-none bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white px-6 py-2.5 rounded-lg transition-colors font-medium border border-red-500">Удалить</button>
            </div>
            <a href="/notes" class="block text-center w-full bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-4 py-2.5 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors font-medium mt-2">← Вернуться к списку</a>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            const id = "{{ $id }}";

            // Загрузка
            $.ajax({
                url: `/api/notes/${id}`,
                method: 'get',
                dataType: 'json',
                success: function(data) {
                    const note = data.response.data;
                    $('#name').val(note.name);
                    $('#description').val(note.description);
                }
            });

            // Сохранение
            $('#save').click(function() {
                $.ajax({
                    url: `/api/notes/${id}`,
                    method: 'put',
                    dataType: 'json',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        "name": $("#name").val(),
                        "description": $('#description').val()
                    }),
                    success: function() {
                        const status = $('#save-status');
                        status.removeClass('hidden').fadeIn();
                        setTimeout(() => status.fadeOut(), 2000);
                    }
                });
            });

            // Удаление
            $('#delete').click(function() {
                if(confirm('Вы уверены, что хотите удалить эту заметку?')) {
                    $.ajax({
                        url: `/api/notes/${id}`,
                        method: 'delete',
                        success: function() {
                            window.location.href = '/notes';
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
