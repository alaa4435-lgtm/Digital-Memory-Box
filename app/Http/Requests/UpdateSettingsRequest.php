<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        // التحقق من أن فورم الإشعارات تم إرساله بالفعل
        if ($this->has('notification_settings_submitted')) {
            $this->merge([
                // تحويل الحالة صراحة إلى true أو false لكي تقبلها قاعدة البيانات والـ validation بسلاسة
                'email_notifications' => $this->boolean('email_notifications'),
                'push_notifications'  => $this->boolean('push_notifications'),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'language'        => 'nullable|string|in:en,ar',
            'theme'           => 'nullable|string|in:light,dark,system',
            'notifications'   => 'nullable|boolean',
            'typography_size' => 'sometimes|integer|between:1,3',
            'reduce_motion'   => 'sometimes|boolean',
            'email_notifications' => 'nullable|boolean',
            'push_notifications'  => 'nullable|boolean',
            'notification_settings_submitted' => 'nullable',
        ];
    }
}