<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nickname' => 'required|string|max:50',
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:2000',
            'rating_overall' => 'required|integer|min:1|max:5',
            'rating_service' => 'required|integer|min:1|max:5',
            'rating_atmosphere' => 'required|integer|min:1|max:5',
            'rating_cost_performance' => 'required|integer|min:1|max:5',
            'visit_date' => 'nullable|date|before_or_equal:today',
        ];
    }

    public function attributes(): array
    {
        return [
            'nickname' => 'ニックネーム',
            'title' => 'タイトル',
            'content' => '口コミ内容',
            'rating_overall' => '総合評価',
            'rating_service' => '接客評価',
            'rating_atmosphere' => '雰囲気評価',
            'rating_cost_performance' => 'コスパ評価',
            'visit_date' => '来店日',
        ];
    }
}
