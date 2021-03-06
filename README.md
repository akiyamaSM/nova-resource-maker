# nova-resource-maker
[![License](https://poser.pugx.org/inani/nova-resource-maker/license)](https://packagist.org/packages/inani/nova-resource-maker)
[![Total Downloads](https://poser.pugx.org/inani/nova-resource-maker/downloads)](https://packagist.org/packages/inani/nova-resource-maker)
![CI status](https://img.shields.io/badge/build-passing-brightgreen.svg)
[![Latest Stable Version](https://poser.pugx.org/inani/nova-resource-maker/v/stable)](https://packagist.org/packages/inani/nova-resource-maker)

A Nova tool that will help you to generate fields array for the resource.
<br>You can check this [medium post](https://medium.com/@InaniT0/generate-your-resource-fields-with-no-pain-108d7369489e) on how to use it

## Installation

### Requirements
* Laravel Nova

First, install the package through [Composer](https://getcomposer.org/).
```bash
composer require inani/nova-resource-maker
```
## Usage
Run the commande line

```bash
php artisan nova-resource-fields:generate
```
> if your model within `app` folder, you can just set Model Name only without full namespace

And then just answer to the questions and copy the result.
## Relationships
Now its possible to generate the relationships, all you have to do is to add the name of the relationship class in the Doc comment of the method
```php
/**
 * Get the posts
 *
 * @relation('HasMany')
 * @return \Illuminate\Database\Eloquent\Relations\HasMany
 */
public function posts()
{
    return $this->hasMany(Post::class);
}
```
    
## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)
