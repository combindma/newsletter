<?php

namespace Combindma\Newsletter\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsletterSubscription extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = ['lname', 'fname', 'email', 'phone', 'list'];

    protected static function newFactory()
    {
        return \Combindma\Newsletter\Database\Factories\NewsletterSubscriptionFactory::new();
    }
}
