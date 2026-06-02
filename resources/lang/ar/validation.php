<?php

return [

    'accepted' => 'يجب قبول :attribute.',
    'accepted_if' => 'يجب قبول :attribute عندما يكون :other هو :value.',
    'active_url' => ':attribute يجب أن يكون رابط صحيح.',
    'after' => ':attribute يجب أن يكون تاريخ بعد :date.',
    'after_or_equal' => ':attribute يجب أن يكون تاريخ بعد أو يساوي :date.',

    'alpha' => ':attribute يجب أن يحتوي على حروف فقط.',
    'alpha_dash' => ':attribute يجب أن يحتوي على حروف وأرقام وشرطات وشرطات سفلية فقط.',
    'alpha_num' => ':attribute يجب أن يحتوي على حروف وأرقام فقط.',

    'array' => ':attribute يجب أن يكون مصفوفة.',

    'between' => [
        'numeric' => ':attribute يجب أن يكون بين :min و :max.',
        'file' => ':attribute يجب أن يكون بين :min و :max كيلوبايت.',
        'string' => ':attribute يجب أن يكون بين :min و :max أحرف.',
        'array' => ':attribute يجب أن يحتوي بين :min و :max عناصر.',
    ],

    'boolean' => ':attribute يجب أن يكون true أو false.',

    'confirmed' => 'تأكيد :attribute غير متطابق.',

    'date' => ':attribute يجب أن يكون تاريخ صحيح.',

    'email' => ':attribute يجب أن يكون بريد إلكتروني صحيح.',

    'file' => ':attribute يجب أن يكون ملف.',

    'image' => ':attribute يجب أن يكون صورة.',

    'integer' => ':attribute يجب أن يكون رقم صحيح.',

    'max' => [
        'numeric' => ':attribute يجب ألا يكون أكبر من :max.',
        'string' => ':attribute يجب ألا يزيد عن :max أحرف.',
        'array' => ':attribute يجب ألا يحتوي أكثر من :max عناصر.',
        'file' => ':attribute يجب ألا يزيد عن :max كيلوبايت.',
    ],

    'min' => [
        'numeric' => ':attribute يجب أن يكون على الأقل :min.',
        'string' => ':attribute يجب أن يحتوي على الأقل :min أحرف.',
        'array' => ':attribute يجب أن يحتوي على الأقل :min عناصر.',
        'file' => ':attribute يجب أن يكون على الأقل :min كيلوبايت.',
    ],

    'numeric' => ':attribute يجب أن يكون رقم.',

    'required' => ':attribute مطلوب.',

    'same' => ':attribute و :other يجب أن يكونوا متطابقين.',

    'string' => ':attribute يجب أن يكون نص.',

    'unique' => ':attribute مستخدم مسبقاً.',

    'url' => ':attribute يجب أن يكون رابط صحيح.',

    'password' => [
        'letters' => ':attribute يجب أن يحتوي على حرف واحد على الأقل.',
        'mixed' => ':attribute يجب أن يحتوي على حرف كبير وصغير.',
        'numbers' => ':attribute يجب أن يحتوي على رقم.',
        'symbols' => ':attribute يجب أن يحتوي على رمز.',
        'uncompromised' => ':attribute ظهر في تسريب بيانات سابق.',
    ],

    'custom' => [],

    'attributes' => [
        'name' => 'الاسم',
        'email' => 'البريد الإلكتروني',
        'password' => 'كلمة المرور',
        'password_confirmation' => 'تأكيد كلمة المرور',
    ],
];