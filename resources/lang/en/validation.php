<?php

return [

    'accepted' => 'The :attribute must be accepted.',
    'accepted_if' => 'The :attribute must be accepted when :other is :value.',
    'active_url' => 'The :attribute must be a valid URL.',
    'after' => 'The :attribute must be a date after :date.',
    'after_or_equal' => 'The :attribute must be a date after or equal to :date.',

    'alpha' => 'The :attribute may only contain letters.',
    'alpha_dash' => 'The :attribute may only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'The :attribute may only contain letters and numbers.',

    'array' => 'The :attribute must be an array.',

    'between' => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file' => 'The :attribute must be between :min and :max kilobytes.',
        'string' => 'The :attribute must be between :min and :max characters.',
        'array' => 'The :attribute must have between :min and :max items.',
    ],

    'boolean' => 'The :attribute field must be true or false.',

    'confirmed' => 'The :attribute confirmation does not match.',

    'date' => 'The :attribute must be a valid date.',

    'email' => 'The :attribute must be a valid email address.',

    'file' => 'The :attribute must be a file.',

    'image' => 'The :attribute must be an image.',

    'integer' => 'The :attribute must be an integer.',

    'max' => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'string' => 'The :attribute may not be greater than :max characters.',
        'array' => 'The :attribute may not have more than :max items.',
        'file' => 'The :attribute may not be greater than :max kilobytes.',
    ],

    'min' => [
        'numeric' => 'The :attribute must be at least :min.',
        'string' => 'The :attribute must be at least :min characters.',
        'array' => 'The :attribute must have at least :min items.',
        'file' => 'The :attribute must be at least :min kilobytes.',
    ],

    'numeric' => 'The :attribute must be a number.',

    'required' => 'The :attribute field is required.',

    'same' => 'The :attribute and :other must match.',

    'string' => 'The :attribute must be a string.',

    'unique' => 'The :attribute has already been taken.',

    'url' => 'The :attribute must be a valid URL.',

    'password' => [
        'letters' => 'The :attribute must contain at least one letter.',
        'mixed' => 'The :attribute must contain at least one uppercase and one lowercase letter.',
        'numbers' => 'The :attribute must contain at least one number.',
        'symbols' => 'The :attribute must contain at least one symbol.',
        'uncompromised' => 'The given :attribute has appeared in a data leak.',
    ],

    'custom' => [],

    'attributes' => [
        'name' => 'Name',
        'email' => 'Email Address',
        'password' => 'Password',
        'password_confirmation' => 'Password Confirmation',
    ],
];