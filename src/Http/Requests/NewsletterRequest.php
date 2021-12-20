<?php

namespace Combindma\Newsletter\Http\Requests;

use Combindma\Newsletter\Rules\EmailRule;
use Combindma\Newsletter\Rules\PhoneRule;
use Elegant\Sanitizer\Laravel\SanitizesInput;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewsletterRequest extends FormRequest
{
    use SanitizesInput;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->getMethod() === 'PATCH') {
            return $this->updateRules();
        }

        if ($this->getMethod() === 'PUT') {
            return $this->updateRules();
        }

        return $this->createRules();
    }

    public function filters()
    {
        return [
            'lname' => 'trim|lowercase',
            'fname' => 'trim|lowercase',
            'email' => 'trim|lowercase',
            'list' => 'trim|lowercase',
        ];
    }

    public function createRules()
    {
        return [
            'lname' => 'nullable|string',
            'fname' => 'nullable|string',
            'email' => ['required',new EmailRule(), 'email','unique:newsletter_subscriptions'],
            'phone' => ['nullable', new PhoneRule()],
            'list' => 'nullable|string',
        ];
    }

    public function updateRules()
    {
        return [
            'lname' => 'nullable|string',
            'fname' => 'nullable|string',
            'email' => ['required', new EmailRule(),'email', Rule::unique('newsletter_subscriptions')->ignore($this->subscriber)],
            'phone' => ['nullable', new PhoneRule()],
            'list' => 'nullable|string',
        ];
    }
}
