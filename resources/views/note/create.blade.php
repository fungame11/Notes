<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Создание заметки</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-md mx-auto bg-white p-6 rounded-xl shadow">
        <h1 class="text-xl font-bold mb-4">Создание заметки</h1>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Название заметки</label>
                <input type="text" id="name" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Описание заметки</label>
                <textarea id="description" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md p-2"></textarea>
            </div>
            <div class="flex gap-2 pt-2">
                <button id="save" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Сохранить</button>
                <a href="/notes" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">Назад</a>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#save').click(function() {
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
                        alert("Заметка создана");
                        window.location.href = '/notes';
                    },
                    error: function() {
                        alert("Ошибка валидации данных!");
                    }
                });
            });
        });
    </script>
</body>
</html>
