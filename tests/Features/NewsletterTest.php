<?php

use Combindma\Newsletter\Http\Controllers\NewsletterController;
use Combindma\Newsletter\Models\NewsletterSubscription;
use function Pest\Faker\faker;
use function Pest\Laravel\from;
use function PHPUnit\Framework\assertCount;

function setData(array $data = [])
{
    return array_merge([
        'lname' => strtolower(faker()->name()),
        'fname' => strtolower(faker()->name()),
        'email' => strtolower(faker()->email),
        'phone' => faker()->phoneNumber,
        'list' => strtolower(faker()->word()),
    ], $data);
}

test('user can create a newsletter subscription', function () {
    $data = setData();
    from(action([NewsletterController::class, 'index']))
        ->post(action([NewsletterController::class, 'store']), $data)
        ->assertRedirect(action([NewsletterController::class, 'index']))
        ->assertSessionHasNoErrors();
    assertCount(1, $newsletter_subscriptions = NewsletterSubscription::all());
    $subscriber = $newsletter_subscriptions->first();
    expect($subscriber->lname)->toBe($data['lname']);
    expect($subscriber->fname)->toBe($data['fname']);
    expect($subscriber->email)->toBe($data['email']);
    expect($subscriber->phone)->toBe($data['phone']);
    expect($subscriber->list)->toBe($data['list']);
});

test('user can update a newsletter subscription', function () {
    $subscriber = NewsletterSubscription::factory()->create();
    $data = setData();
    from(action([NewsletterController::class, 'edit'], ['subscriber' => $subscriber]))
        ->put(action([NewsletterController::class, 'update'], ['subscriber' => $subscriber]), $data)
        ->assertRedirect(action([NewsletterController::class, 'edit'], ['subscriber' => $subscriber]))
        ->assertSessionHasNoErrors();
    $subscriber->refresh();
    expect($subscriber->lname)->toBe($data['lname']);
    expect($subscriber->fname)->toBe($data['fname']);
    expect($subscriber->email)->toBe($data['email']);
    expect($subscriber->phone)->toBe($data['phone']);
    expect($subscriber->list)->toBe($data['list']);
});

test('user can delete a newsletter subscription', function () {
    $subscriber = NewsletterSubscription::factory()->create();
    from(action([NewsletterController::class, 'index']))
        ->delete(action([NewsletterController::class, 'destroy'], ['subscriber' => $subscriber]))
        ->assertRedirect(action([NewsletterController::class, 'index']));
    assertCount(0, NewsletterSubscription::all());
});

test('user can restore a newsletter subscription', function () {
    $subscriber = NewsletterSubscription::factory()->create();
    $subscriber->delete();
    assertCount(0, NewsletterSubscription::all());
    from(action([NewsletterController::class, 'index']))
        ->post(action([NewsletterController::class, 'restore'], ['id' => $subscriber->id]))
        ->assertRedirect(action([NewsletterController::class, 'index']));
    assertCount(1, NewsletterSubscription::all());
});
