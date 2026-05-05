<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

// валидация
class StoreArtworkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string|max:5000',
            'year'         => 'nullable|integer|min:1000|max:' . (date('Y') + 1),
            'size'         => 'nullable|string|max:100',
            'width'        => 'nullable|numeric|min:0|max:9999.99',
            'height'       => 'nullable|numeric|min:0|max:9999.99',
            'materials'    => 'nullable|string|max:255',
            'price'        => 'nullable|numeric|min:0|max:999999.99',
            'categories'   => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'images'       => 'nullable|array|max:10',
            'images.*'     => 'image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'is_published' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'    => 'Назва твору обов\'язкова.',
            'title.max'         => 'Назва не повинна перевищувати 255 символів.',
            'description.max'   => 'Опис не повинен перевищувати 5000 символів.',
            'year.integer'      => 'Рік повинен бути числом.',
            'year.min'          => 'Рік не може бути меншим за 1000.',
            'year.max'          => 'Рік не може бути більшим за ' . (date('Y') + 1) . '.',
            'width.numeric'     => 'Ширина повинна бути числом.',
            'height.numeric'    => 'Висота повинна бути числом.',
            'price.numeric'     => 'Ціна повинна бути числом.',
            'categories.*.exists' => 'Вибрана категорія не існує.',
            'images.*.image'    => 'Файл повинен бути зображенням.',
            'images.*.mimes'    => 'Підтримувані формати: JPEG, PNG, JPG, GIF, WEBP.',
            'images.*.max'      => 'Розмір зображення не повинен перевищувати 10 МБ.',
        ];
    }
}
