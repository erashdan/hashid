# Eloquent Hashid

* [Installation](#installation)
* [Usage](#usage)
* [Credits](#credits)

This package make the primary key in eloquent is hashed.

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

The service provider will automatically get registered package.

You should set configuration by publish it to your project:

```bash
php artisan vendor:publish --provider="Erashdan\Hashid\HashidServiceProvider" --tag="config"
``` 

Then add in .env file
```dotenv
HASHID_KEY=SET_YOUR_KEY
```
**OR**

Change in `config/hashid.php` key parameter to laravel application key
```php
'key' => env('APP_KEY'),
```

You can change hashing length from `.env` file .

```dotenv
HASHID_LENGTH=6
```

## Usage

The eloquent by default will not implement hashid, so you should use it as trait.

```php
use Illuminate\Database\Eloquent\Model;
use Erashdan\Hashid\Traits\Hashid;

class Post extends Model
{
    use Hashid;
```

After use trait in eloquent you can call hashed_id attribute.

```php
$post = \App\Post::first();
$post->hashed_id; //x7LR5oQJleJX60yPpNWV
```

To search for hashed element
```php
$post = \App\Post::FindOrFailHashed('x7LR5oQJleJX60yPpNWV');
$post->id; //1
```

## Credits
- [Emad Rashdan](https://github.com/erashdan)


```.todo
- [x] Build dev version.
- [] Create command for key generater.
- [] Can store hash id on database.
- [] Can be cached.
```