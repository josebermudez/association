<?php
namespace App\Http\Requests\Custom;
use App\Http\Requests\Request;

class NotificationsRequest extends Request
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
            'name' => 'required|max:100|min:2',
            'message' => 'required|max:200|min:10',
            'from' => 'required'
        ];
    }
}
