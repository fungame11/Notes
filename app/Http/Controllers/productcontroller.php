<?php

namespace App\Http/Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // READ: Вывод списка всех товаров
    public function index()
    {
        $products = Product::latest()->get(); // Eloquent запрос: SELECT * FROM products ORDER BY created_at DESC
        return view('products.index', compact('products')); // Передаем данные в шаблон
    }

    // CREATE: Показ формы создания
    public function create()
    {
        return view('products.create');
    }

    // CREATE: Сохранение нового товара в БД
    public function store(Request $request)
    {
        // Валидация данных прямо «из коробки»
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
        ]);

        // Создание записи в БД одной строкой благодаря fillable в модели
        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Товар успешно создан!');
    }

    // UPDATE: Показ формы редактирования (Laravel сам найдет продукт по id благодаря Route Model Binding)
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    // UPDATE: Сохранение измененных данных
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Товар обновлен!');
    }

    // DELETE: Удаление товара
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Товар удален!');
    }
}
