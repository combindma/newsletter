<?php

namespace Combindma\Newsletter\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsletterSubscription extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = ['nom', 'prenom', 'email', 'phone', 'list'];
}
