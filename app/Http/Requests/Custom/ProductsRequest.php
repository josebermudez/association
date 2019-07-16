<?php
namespace App\Http\Requests\Custom;
use App\Http\Requests\Request;

class ProductsRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:100|min:10',
            'description' => 'required|max:600|min:60',
			'stock' => 'required|numeric|between:0,9999'
        ];
    }
}
