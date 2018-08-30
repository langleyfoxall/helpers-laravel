# Helpers Laravel
A repository of laravel specific helper classes to help standardise work. API helpers, converters etc.

## Helpers
- [`Models`](#models)
- [`ApiResponse`](#api-response)
- [`Response`](#response)


### `Models`
The [Models helper](src/LangleyFoxall/Helpers/Models.php) offers helpful functions to do with Eloquent Models.

#### Methods
All methods can be called statically.

- [`all`](#all)
- [`utf8EncodeModel`](#utf8-encode-model)
- [`getColumns`](#get-columns)
- [`getNextId`](#get-next-id)
- [`areRelated`](#are-related)


##### `all`
Get a [Collection](https://laravel.com/docs/5.6/collections) of all models.

| Key | Details |
| --- | ------- |
| Parameters | None |
| Throws| None |
| Returns | [Collection](https://laravel.com/docs/5.6/collections) |


##### `utf8EncodeModel`
Encodes attribute values of a single model to [UTF-8](https://tools.ietf.org/html/rfc3629), and returns the model.

###### Example Usage
```
$encoded_user = Models::utf8EncodeModels($user)
```

| Key | Details |
| --- | ------- |
| Parameters | [Model](https://laravel.com/docs/5.6/eloquent) |
| Throws| None |
| Returns | [Model](https://laravel.com/docs/5.6/eloquent) |


##### `utf8EncodeModels`
Encodes attribute values of mutliple models to [UTF-8](https://tools.ietf.org/html/rfc3629), and returns a collection of model.

###### Example Usage
```
$collection_of_encoded_users = Models::utf8EncodeModels($users)
```

| Key | Details |
| --- | ------- |
| Parameters | A [Collection](https://laravel.com/docs/5.6/collections) of [Models](https://laravel.com/docs/5.6/eloquent) |
| Throws| None |
| Returns | A [Collection](https://laravel.com/docs/5.6/collections) of [Models](https://laravel.com/docs/5.6/eloquent) |


##### `getColumns`
Get an [Array](http://php.net/manual/en/language.types.array.php) the database columns for a given model.

###### Example Usage
```
$columns = Models::getColumns($user)
```

| Key | Details |
| --- | ------- |
| Parameters | [Model](https://laravel.com/docs/5.6/eloquent) |
| Throws| None |
| Returns | [Array](http://php.net/manual/en/language.types.array.php) |


##### `getNextId`
Get the next [auto incremented ID](https://dev.mysql.com/doc/refman/8.0/en/example-auto-increment.html) for a model.

###### Example Usage
```
$next_id = Models::getNextId($user)
```

| Key | Details |
| --- | ------- |
| Parameters | [Model](https://laravel.com/docs/5.6/eloquent) |
| Throws| [Exception](http://php.net/manual/en/class.exception.php) |
| Returns | [Integer](http://php.net/manual/en/language.types.integer.php) |


##### `areRelated`
Check if an _unspecificed_ number of models are related to each other.

###### Example Usage
If an instance of [Model](https://laravel.com/docs/5.6/eloquent) is passed, then `areRelated` will attempt to get a [plural](https://laravel.com/api/5.6/Illuminate/Support/Str.html#method_plural) then [singular](https://laravel.com/api/5.6/Illuminate/Support/Str.html#method_singular) method from the model that can then be used by the previous model in the sequence to confirm that they are related. If an array is passed, it expects the first element to be an instance of [Model](https://laravel.com/docs/5.6/eloquent) and the second to be a string which is the relationship method

A [`NotRelatedException`](src/LangleyFoxall/Helpers/Exceptions/NotRelatedException.php) is also provided to be used in an application.

```
$related = Models::areRelated($user, $post, [$comment, 'comments'])
```

| Key | Details |
| --- | ------- |
| Parameters | Mutliple [Models](https://laravel.com/docs/5.6/eloquent) or Mutliple [Array](http://php.net/manual/en/language.types.array.php)|
| Throws| [Exception](http://php.net/manual/en/class.exception.php) or [InvalidArgumentException](http://php.net/manual/en/class.invalidargumentexception.php) |
| Returns | [Boolean](http://php.net/manual/en/language.types.boolean.php) |


### `ApiResponse`


### `Response`
