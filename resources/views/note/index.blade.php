<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Список заметок</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Список заметок</h1>
            <a href="/notes/create" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Добавить</a>
        </div>

        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-gray-200 bg-gray-50 text-gray-700 font-semibold">
                    <th class="p-3">Заметка</th>
                    <th class="p-3 text-right">Удалить</th>
                </tr>
            </thead>
            <tbody id="wrapper_note_table">
                </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $.ajax({
                url: '/api/notes',
                method: 'get',
                dataType: 'json',
                success: function(data) {
                    const notes = data.response.data;
                    notes.forEach(note => {
                        $('#wrapper_note_table').append(`
                            <tr class="border-b border-gray-100 hover:bg-gray-50 note_wrapper" id="${note.id}">
                                <td class="p-3">
                                    <a href="/notes/${note.id}/edit" class="text-blue-600 font-medium hover:underline">
                                        ${note.name}
                                    </a>
                                </td>
                                <td class="p-3 text-right">
                                    <button class="delete-btn bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm" data-id="${note.id}">
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
                            alert('Заметка удалена');
                            $(`.note_wrapper#${id}`).remove();
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
