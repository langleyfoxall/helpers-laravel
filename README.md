# Helpers Laravel
A repository of laravel specific helper classes to help standardise work. API helpers, converters etc.

## Helpers
- [`Models`](#models)
- [`ApiResponse`](#apiresponse)
- [`Response`](#response)


### `Models`
The [Models helper](src/LangleyFoxall/Helpers/Models.php) offers helpful functions to do with [Eloquent Models](https://laravel.com/docs/eloquent).

#### Methods
All methods can be called statically.

- [`all`](#all)
- [`utf8EncodeModel`](#utf8-encode-model)
- [`getColumns`](#get-columns)
- [`getNextId`](#get-next-id)
- [`areRelated`](#are-related)


##### `all`
Get a [Collection](https://laravel.com/docs/collections) of all models.

###### Example Usage
```
$collection_of_models = Models::all()
```

| Key | Details |
| --- | ------- |
| Parameters | None |
| Throws| None |
| Returns | [Collection](https://laravel.com/docs/collections) |


##### `utf8EncodeModel`
Encodes attribute values of a single model to [UTF-8](https://tools.ietf.org/html/rfc3629), and returns the model.

###### Example Usage
```
$encoded_user = Models::utf8EncodeModels($user)
```

| Key | Details |
| --- | ------- |
| Parameters | [Model](https://laravel.com/docs/eloquent) |
| Throws| None |
| Returns | [Model](https://laravel.com/docs/eloquent) |


##### `utf8EncodeModels`
Encodes attribute values of mutliple models to [UTF-8](https://tools.ietf.org/html/rfc3629), and returns a collection of model.

###### Example Usage
```
$collection_of_encoded_users = Models::utf8EncodeModels($users)
```

| Key | Details |
| --- | ------- |
| Parameters | A [Collection](https://laravel.com/docs/collections) of [Models](https://laravel.com/docs/eloquent) |
| Throws| None |
| Returns | A [Collection](https://laravel.com/docs/collections) of [Models](https://laravel.com/docs/eloquent) |


##### `getColumns`
Get an [Array](http://php.net/manual/en/language.types.array.php) of the database columns for a given model.

###### Example Usage
```
$columns = Models::getColumns($user)
```

| Key | Details |
| --- | ------- |
| Parameters | [Model](https://laravel.com/docs/eloquent) |
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
| Parameters | [Model](https://laravel.com/docs/eloquent) |
| Throws| [Exception](http://php.net/manual/en/class.exception.php) |
| Returns | [Integer](http://php.net/manual/en/language.types.integer.php) |


##### `areRelated`
Check if an _unspecificed_ number of models are related to each other.

###### Example Usage
If an instance of [Model](https://laravel.com/docs/eloquent) is passed, then `areRelated` will attempt to get a [plural](https://laravel.com/api/5.6/Illuminate/Support/Str.html#method_plural) then [singular](https://laravel.com/api/5.6/Illuminate/Support/Str.html#method_singular) method from the model that can then be used by the previous model in the sequence to confirm that they are related. If an array is passed, it expects the first element to be an instance of [Model](https://laravel.com/docs/eloquent) and the second to be a string which is the relationship method

A [`NotRelatedException`](src/LangleyFoxall/Helpers/Exceptions/NotRelatedException.php) is also provided to be used in an application.

```
$related = Models::areRelated($user, $post, [$comment, 'comments'])
```

| Key | Details |
| --- | ------- |
| Parameters | Mutliple [Models](https://laravel.com/docs/eloquent) or Mutliple [Array](http://php.net/manual/en/language.types.array.php)|
| Throws| [Exception](http://php.net/manual/en/class.exception.php) or [InvalidArgumentException](http://php.net/manual/en/class.invalidargumentexception.php) |
| Returns | [Boolean](http://php.net/manual/en/language.types.boolean.php) |

---

### `ApiResponse`
The [ApiResponse helper](src/LangleyFoxall/Helpers/ApiResponse.php) standardizes an API response. Always containing the same fields:

| Key | Type | Description |
| --- | ---- | ----------- |
| `status` | [Integer](http://php.net/manual/en/language.types.integer.php) | `status` is used for accessibility when the response cannot access the HTTP client, such as axios | 
| `success` | [Boolean](http://php.net/manual/en/language.types.boolean.php) | `success` is a boolean to signify that an operation was successful or not |
| `error` | [NULL](http://php.net/manual/en/language.types.null.php), [String](http://php.net/manual/en/language.types.string.php) or [Array](http://php.net/manual/en/language.types.array.php) | `error` is used to describe errors or warnings that have happened during the operation |
| `data` | [NULL](http://php.net/manual/en/language.types.null.php) or [Array](http://php.net/manual/en/language.types.array.php) | `data` should contain the main resource information |
| `meta` | [NULL](http://php.net/manual/en/language.types.null.php) or [Array](http://php.net/manual/en/language.types.array.php) | `meta` should contain extra resource information, such as other endpoints that can be used with the current resource |

The [ApiResponse helper](src/LangleyFoxall/Helpers/ApiResponse.php) also implements [ArrayAccess](http://php.net/manual/en/class.arrayaccess.php) which can be used to transform `data` easily. Example usage can be found [here](https://github.com/langleyfoxall/helpers-laravel/issues/11#issuecomment-415787692).

After building up the response, before returning it from a [Controller](https://laravel.com/docs/controllers), you must call [`json`](#json).


#### Methods

- [`success`](#success)
- [`error`](#error)
- [`data`](#data)
- [`meta`](#meta)
- [`status`](#status)
- [`json`](#json)


##### `success`
Create a successful response instance.

###### Example Usage
None of the parameters are required.

```
$api_response = ApiResponse::success($data, $meta, $status)
```

| Key | Details |
| --- | ------- |
| Parameters | `data`, `meta`, `status` |
| Returns | [ApiResponse](src/LangleyFoxall/Helpers/ApiResponse.php) |


##### `error`
Create a unsuccessful response instance.

###### Example Usage
None of the parameters are required.

```
$api_response = ApiResponse::error($errors, $status)
```

| Key | Details |
| --- | ------- |
| Parameters | `error`, `status` |
| Returns | [ApiResponse](src/LangleyFoxall/Helpers/ApiResponse.php) |


##### `data`
Set the data to be returned in the response.

###### Example Usage
None of the parameters are required.

```
$api_response->data($data)
```

| Key | Details |
| --- | ------- |
| Parameters | [NULL](http://php.net/manual/en/language.types.null.php) or [Array](http://php.net/manual/en/language.types.array.php) |
| Returns | [ApiResponse](src/LangleyFoxall/Helpers/ApiResponse.php) |


##### `meta`
Set the meta to be returned in the response.

###### Example Usage
None of the parameters are required.

```
$api_response->meta($meta)
```

| Key | Details |
| --- | ------- |
| Parameters | [NULL](http://php.net/manual/en/language.types.null.php) or [Array](http://php.net/manual/en/language.types.array.php) |
| Returns | [ApiResponse](src/LangleyFoxall/Helpers/ApiResponse.php) |


##### `status`
Set the response status code.

###### Example Usage

```
$api_response->status($status)
```

| Key | Details |
| --- | ------- |
| Parameters | [Integer](http://php.net/manual/en/language.types.integer.php) |
| Returns | [ApiResponse](src/LangleyFoxall/Helpers/ApiResponse.php) |


##### `json`
Get the JSON response object

###### Example Usage

```
$json_response = $api_response->json()
```

| Key | Details |
| --- | ------- |
| Parameters | None |
| Returns | [JsonResponse](https://laravel.com/api/5.6/Illuminate/Http/JsonResponse.html) |

---

### `Response`
The [Response helper](src/LangleyFoxall/Helpers/Response.php) should only be used if, for whatever reason, API endpoints use the same [Controller](https://laravel.com/docs/controllers) methods as web URIs. This helper will check to see if the request is [expecting JSON](https://laravel.com/api/5.6/Illuminate/Http/Request.html#method_expectsJson) or not and return the right response.

| Key | Type | Description |
| --- | ---- | ----------- |
| `request` | [Request](https://laravel.com/api/5.6/Illuminate/Http/Request.html) | `request` is used when it comes to deciding which response to return to the client | 
| `type` | [String](http://php.net/manual/en/language.types.string.php) | `type` is a string, "success" or "error", which will determine which [API Response](src/LangleyFoxall/Helpers/ApiResponse.php) is returned |
| `message` | [NULL](http://php.net/manual/en/language.types.null.php), [String](http://php.net/manual/en/language.types.string.php) or [String](http://php.net/manual/en/language.types.string.php) | `message` is used for a [redirect back](https://laravel.com/docs/helpers#method-back) with a [session variable](https://laravel.com/docs/helpers#method-session) (web) or an error message (API) |
| `data` | [NULL](http://php.net/manual/en/language.types.null.php) or [Array](http://php.net/manual/en/language.types.array.php) | `data` should contain t tlanhe main resource information |
| `meta` | [NULL](http://php.net/manual/en/language.types.null.php) or [Array](http://php.net/manual/en/language.types.array.php) | `meta` should contain extra resource information, such as other endpoints that can be used with the current resource |
| `status` | [Integer](http://php.net/manual/en/language.types.integer.php) | `status` is used for accessibility when the response cannot access the HTTP client, such as axios |
| `uri` | [String](http://php.net/manual/en/language.types.string.php) | `uri` is used when wanting to [redirect](https://laravel.com/docs/helpers#method-redirect) rather than [back](https://laravel.com/docs/helpers#method-back) with a web response |

#### Methods
None of the following methods can be called statically. When instansiating a new instance of Response a [Request](https://laravel.com/api/5.6/Illuminate/Http/Request.html) object is required.

- `success`
- `error`
- `type`
- `message`
- `data`
- `meta`
- `status`
- `redirect`
- `end`
