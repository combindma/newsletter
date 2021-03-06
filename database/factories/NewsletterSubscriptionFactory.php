<?php

namespace Combindma\Newsletter\Database\Factories;

use Combindma\Newsletter\Models\NewsletterSubscription;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsletterSubscriptionFactory extends Factory
{
    protected $model = NewsletterSubscription::class;

    public function definition()
    {
        return [
            'lname' => $this->faker->lastName,
            'fname' => $this->faker->firstName,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'list' => 'Customer'
        ];
    }
}
