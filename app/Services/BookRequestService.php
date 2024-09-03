<?php

namespace App\Services;

use Illuminate\Http\Exceptions\HttpResponseException;

class BookRequestService
{
    /**
     *  get array of  BookRequestService attributes 
     *
     * @return array   of attributes
     */
    public function attributes()
    {
        return  [
            'title' => 'العنوان',
            'author' => 'المؤلف',
            'descripation' => 'الوصف',
            'published_at' => 'تاريخ النشر',
            'category' => 'التصنيف',
            'image' => 'الصورة'
        ];
    }
    /**
     *  
     * @param $validator
     *
     * throw a exception
     */
    public function failedValidation($validator)
    {
        throw new HttpResponseException(response()->json(
            [
                'status' => 'error',
                'message' => "فشل التحقق يرجى التأكد من صحة القيم مدخلة",
                'errors' => $validator->errors()
            ],
            422
        ));
    }
    /**
     *  get array of  BookRequestService messages 
     * @param $minDate  
     * @param  $maxDate
     * @return array   of messages
     */
    public function messages($minDate, $maxDate)
    {
        return  [
            'min' => 'حقل :attribute يجب ان  يكون على الاقل 3 محارف',
            'descripation.min' => 'حقل :attribute يجب ان  يكون على الاقل 20 حرف',
            'max' => 'حقل :attribute يجب ان  يكون على الاكثر 255 محرف',
            'unique' => 'حقل :attribute  مكرر ',
            'mimes' =>  "png  او jpg " . 'حقل :attribute  يجب ان تكون من لاحقة ',
            'integer' => 'حقل :attribute هو عدد صحيح   ',
            "gte" => "حقل :attribute يجب ان يكون اكبر او يساوي $minDate",
            "lte" => "حقل :attribute يجب ان يكون اصغر او يساوي $maxDate"
        ];
    }
}
