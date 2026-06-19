<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель Администратора</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' }
        
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else { document.documentElement.classList.remove('dark') }
    </script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-200 min-h-screen p-4 sm:p-8">
    <div class="max-w-4xl mx-auto">
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 bg-white dark:bg-gray-800 p-4 sm:p-6 rounded-xl shadow transition-colors duration-200">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold">Управление пользователями</h1>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">Всего зарегистрировано пользователей: {{ $users->count() }}</p>
            </div>
            <a href="/notes" class="w-full sm:w-auto text-center bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium shadow-sm">
                ← К заметкам
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden transition-colors duration-200">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[600px]">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 font-semibold text-sm sm:text-base">
                            <th class="p-4">Имя / Логин</th>
                            <th class="p-4">Email</th>
                            <th class="p-4">Статус</th>
                            <th class="p-4 text-right">Действие</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="border-b border-gray-100 dark:border-gray-700/50 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors text-sm sm:text-base">
                            <td class="p-4 font-medium break-all max-w-[180px]">
                                {{ $user->name }}
                            </td>
                            <td class="p-4 text-gray-600 dark:text-gray-300 break-all max-w-[200px]">
                                {{ $user->email }}
                            </td>
                            <td class="p-4">
                                @if($user->is_blocked)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                        Заблокирован
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                        Активен
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-right">
                                <form action="/admin/block/{{ $user->id }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите изменить статус этого пользователя?');">
                                    @csrf
                                    <button type="submit" class="w-28 text-center px-3 py-1.5 rounded-lg text-xs sm:text-sm font-medium transition-colors border shadow-sm
                                        {{ $user->is_blocked 
                                            ? 'bg-green-600 text-white border-green-600 hover:bg-green-700' 
                                            : 'bg-red-500/10 text-red-500 border-transparent hover:bg-red-500 hover:text-white' 
                                        }}">
                                        {{ $user->is_blocked ? 'Разблочить' : 'Блокировать' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>
</html>
