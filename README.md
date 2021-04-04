# Newsletter Subscription

[![Latest Version on Packagist](https://img.shields.io/packagist/v/combindma/newsletter.svg?style=flat-square)](https://packagist.org/packages/combindma/newsletter)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/combindma/newsletter/run-tests?label=tests)](https://github.com/combindma/newsletter/actions?query=workflow%3ATests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/combindma/newsletter/Check%20&%20fix%20styling?label=code%20style)](https://github.com/combindma/newsletter/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/combindma/newsletter.svg?style=flat-square)](https://packagist.org/packages/combindma/newsletter)

## Installation

You can install the package via composer:

```bash
composer require combindma/newsletter
```

You must publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Combindma\Newsletter\NewsletterServiceProvider" --tag="newsletter-migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Combindma\Newsletter\NewsletterServiceProvider" --tag="newsletter-config"
```

This is the contents of the published config file:

```php
return [
    'apiKey' => env('MAILCHIMP_APIKEY'),
    'listId' => env('MAILCHIMP_LIST_ID'),
];
```

## Usage

```php
$data = [  
    'email' => strtolower($this->email),
    'list' => 'clients'
];

\Combindma\Newsletter\Newsletter::create($data);
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Combind](https://github.com/combindma)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
