<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список заметок</title>
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
    <div class="max-w-3xl mx-auto">
        <div class="flex justify-between items-center mb-6 bg-white dark:bg-gray-800 p-4 sm:p-6 rounded-xl shadow transition-colors duration-200">
            <h1 class="text-xl sm:text-2xl font-bold">Мои заметки</h1>
            <div class="flex gap-2 sm:gap-4 items-center">
                <button id="theme-toggle" class="p-2 rounded-lg bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                    <span class="dark:hidden">🌙</span>
                    <span class="hidden dark:inline">☀️</span>
                </button>
                <a href="/notes/create" class="bg-blue-600 text-white px-3 sm:px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm sm:text-base">Добавить</a>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden transition-colors duration-200">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[300px]">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 font-semibold">
                            <th class="p-4">Заметка</th>
                            <th class="p-4 text-right">Действие</th>
                        </tr>
                    </thead>
                    <tbody id="wrapper_note_table">
                        </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#theme-toggle').click(function() {
                document.documentElement.classList.toggle('dark');
                localStorage.theme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
            });

            $.ajax({
                url: '/api/notes',
                method: 'get',
                dataType: 'json',
                success: function(data) {
                    const notes = data.response.data;
                    notes.forEach(note => {
                        $('#wrapper_note_table').append(`
                            <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors note_wrapper" id="${note.id}">
                                <td class="p-4">
                                    <a href="/notes/${note.id}/edit" class="text-blue-600 dark:text-blue-400 font-medium hover:underline block break-words">
                                        ${note.name}
                                    </a>
                                </td>
                                <td class="p-4 text-right">
                                    <button class="delete-btn bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white px-3 py-1.5 rounded-lg text-sm transition-colors" data-id="${note.id}">
                                        Удалить
                                    </button>
                                </td>
                            </tr>
                        `);
                    });
                }
            });

            $(document).on('click', '.delete-btn', function() {
                const id = $(this).data('id');
                if(confirm('Удалить эту заметку?')) {
                    $.ajax({
                        url: `/api/notes/${id}`,
                        method: 'delete',
                        success: function() {
                            $(`.note_wrapper#${id}`).fadeOut(300, function() { $(this).remove(); });
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
