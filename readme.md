# Eloquent Hashid [![Build Status](https://travis-ci.org/erashdan/hashid.svg?branch=master)](https://travis-ci.org/erashdan/hashid)

* [Installation](#installation)
* [Usage](#usage)
* [Testing](#testing)
* [Credits](#credits)
* [Todo](#todo)

This package hashes the primary key of an eloquent record.

```php
// Get Hash ID
$user = \App\User::first();
$user->hashed_id;   //x7LR5oQJleJX60yPpNWV
```

## Installation
This package can be used in Laravel 5.5 or higher.

You can install the package via composer:

``` bash
composer require erashdan/hashid
```

Laravel's package auto discovery will automatically register the service provider for you.

Then you need to publish the configuration to your project:

```bash
php artisan vendor:publish --provider="Erashdan\Hashid\HashidServiceProvider" --tag="config"
``` 

And add the key used for the hashing in .env file
```dotenv
HASHID_KEY=SET_YOUR_KEY
```

**OR**

Use Laravel's own app key, change the _key_ parameter in `config/hashid.php` to Laravel's application key
```php
'key' => env('APP_KEY'),
```

You can also change the length of the resulted hash from `.env` file.

```dotenv
HASHID_LENGTH=6
```

## Usage

Eloquent by default doesn't implement hashid, so you should use the trait provided from the package.

```php
use Illuminate\Database\Eloquent\Model;
use Erashdan\Hashid\Traits\Hashid;

class Post extends Model
{
    use Hashid;
```

You can then use the hashed_id attribute on the eloquent object itself.

```php
$post = \App\Models\Post::first();
$post->hashed_id; //x7LR5oQJleJX60yPpNWV
```

Or find a resource by hash
```php
$post = \App\Models\Post::FindOrFailHashed('x7LR5oQJleJX60yPpNWV');
$post->id; //1
```

## Validation
You can validate if hashed id is existed in model or not
```php
    request()->validate([
        'post_id' => 'hashed_exists:' . \App\Post::class
    ]);
```

### Testing

``` bash
composer test
```

## Credits
- [Emad Rashdan](https://github.com/erashdan)
