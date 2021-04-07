<?php

namespace Combindma\Newsletter\Tests\Features;

use Combindma\Newsletter\Models\NewsletterSubscription;
use Combindma\Newsletter\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NewsletterTest extends TestCase
{
    use RefreshDatabase;

    protected function setData($data = [])
    {
        return array_merge([
            'nom' => strtolower($this->faker->name()),
            'prenom' => strtolower($this->faker->name()),
            'email' => strtolower($this->faker->email),
            'phone' => $this->faker->phoneNumber,
            'list' => strtolower($this->faker->word()),
        ], $data);
    }

    /** @test */
    public function user_can_create_a_newsletter_subscription()
    {
        $data = $this->setData();
        $response = $this->from(route('newsletter::newsletter.index'))->post(route('newsletter::newsletter.store'), $data);
        $response->assertRedirect(route('newsletter::newsletter.index'));
        $response->assertSessionHasNoErrors();
        $this->assertCount(1, $newsletter_subscriptions = NewsletterSubscription::all());
        $subscriber = $newsletter_subscriptions->first();
        $this->assertEquals($data['nom'], $subscriber->nom);
        $this->assertEquals($data['prenom'], $subscriber->prenom);
        $this->assertEquals($data['email'], $subscriber->email);
        $this->assertEquals($data['phone'], $subscriber->phone);
        $this->assertEquals($data['list'], $subscriber->list);
    }

    /** @test */
    public function user_can_update_a_newsletter_subscription()
    {
        $subscriber = NewsletterSubscription::factory()->create();
        $data = $this->setData();
        $response = $this->from(route('newsletter::newsletter.edit', $subscriber))->put(route('newsletter::newsletter.update', $subscriber), $data);
        $response->assertRedirect(route('newsletter::newsletter.edit', $subscriber));
        $response->assertSessionHasNoErrors();
        $this->assertEquals($data['nom'], $subscriber->fresh()->nom);
        $this->assertEquals($data['prenom'], $subscriber->fresh()->prenom);
        $this->assertEquals($data['email'], $subscriber->fresh()->email);
        $this->assertEquals($data['phone'], $subscriber->fresh()->phone);
        $this->assertEquals($data['list'], $subscriber->fresh()->list);
    }

    /** @test */
    public function user_can_delete_a_newsletter_subscription()
    {
        $subscriber = NewsletterSubscription::factory()->create();
        $response = $this->from(route('newsletter::newsletter.index'))->delete(route('newsletter::newsletter.destroy', $subscriber));
        $response->assertRedirect(route('newsletter::newsletter.index'));
        $this->assertCount(0, NewsletterSubscription::all());
    }

    /** @test */
    public function user_can_restore_a_newsletter_subscription()
    {
        $subscriber = NewsletterSubscription::factory()->create();
        $subscriber->delete();
        $this->assertCount(0, NewsletterSubscription::all());
        $response = $this->from(route('newsletter::newsletter.index'))->post(route('newsletter::newsletter.restore', $subscriber->id));
        $response->assertRedirect(route('newsletter::newsletter.index'));
        $this->assertCount(1, NewsletterSubscription::all());
    }

    /**
     * @test
     * @dataProvider postFormValidationProvider
     */
    public function user_cannot_create_a_newsletter_subscription_with_invalid_data($formInput, $formInputValue)
    {
        NewsletterSubscription::factory()->create([
            'email' => 'unique@email.com',
        ]);

        $data = $this->setData([
            $formInput => $formInputValue,
        ]);
        $response = $this->from(route('newsletter::newsletter.index'))->post(route('newsletter::newsletter.store'), $data);
        $response->assertRedirect(route('newsletter::newsletter.index'));
        $response->assertSessionHasErrors($formInput);
        $this->assertCount(1, NewsletterSubscription::all());
    }

    /**
     * @test
     * @dataProvider postFormValidationProvider
     */
    public function user_cannot_update_a_newsletter_subscription_with_invalid_data($formInput, $formInputValue)
    {
        NewsletterSubscription::factory()->create([
            'email' => 'unique@email.com',
        ]);
        $subscriber = NewsletterSubscription::factory()->create();
        $data = $this->setData([
            $formInput => $formInputValue,
        ]);
        $response = $this->from(route('newsletter::newsletter.edit', $subscriber))->put(route('newsletter::newsletter.update', $subscriber), $data);
        $response->assertRedirect(route('newsletter::newsletter.edit', $subscriber));
        $response->assertSessionHasErrors($formInput);
        $this->assertNotEquals($data['nom'], $subscriber->fresh()->nom);
        $this->assertNotEquals($data['prenom'], $subscriber->fresh()->prenom);
        $this->assertNotEquals($data['email'], $subscriber->fresh()->email);
        $this->assertNotEquals($data['phone'], $subscriber->fresh()->phone);
        $this->assertNotEquals($data['list'], $subscriber->fresh()->list);
    }

    public function postFormValidationProvider()
    {
        return[
            'email_is_required' => ['email', ''],
            'email_must_be_a_valid_email' => ['email', 'invalid'],
            'email_is_unique_on_create_or_update' => ['email', 'unique@email.com'],
        ];
    }
}
