# Helpers Laravel

[![Packagist](https://img.shields.io/packagist/dt/langleyfoxall/helpers-laravel.svg)](https://packagist.org/packages/langleyfoxall/helpers-laravel/stats)

A repository of Laravel specific helper classes to help standardise work. API helpers, converters etc.

## Installation

The Langley Foxall Helpers Laravel package can be easily installed using Composer. Just run the following command from the root of your project.

```bash
composer require langleyfoxall/helpers-laravel
```

If you have never used the Composer dependency manager before, head to the [Composer website](https://getcomposer.org/) for more information on how to get started.

## Helpers
- [`Models`](#models)
- [`IsRelatedTo`](#isrelatedto)
- [`ApiResponse`](#apiresponse)
- [`Response`](#response)
- [`ResponseCache`](#responsecache)


### `Models`
The [Models helper](src/LangleyFoxall/Helpers/Models.php) offers helpful functions to do with [Eloquent Models](https://laravel.com/docs/eloquent).

#### Methods
All methods can be called statically.

- [`all`](#all)
- [`utf8EncodeModel`](#utf8encodemodel)
- [`getColumns`](#getcolumns)
- [`getNextId`](#getnextid)
- [`areRelated`](#arerelated)
- [`randomByWeightedValue`](#randombyweightedvalue)


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

##### `randomByWeightedValue`
Takes a collection of `Model`'s and returns one based upon a weighted column. It can also take a maxCap to simulate higher odds.

It should be noted when passing a `maxCap` you should pass in a desired return value if none of the items in the models list were hit.

###### Example Usage
```
$prizes = Prizes::all();
$selectedPrize = Models::randomByWeightedValue($models, 'chance');
```

```
//returns a prize as if the 'chance' column related to {$chance}/10,000,000 - if none are hit it will return null.
$selectedPrize = Models::randomByWeightedValue('App\Models\Prize', 'chance', 10000000, null);
```

| Key | Details |
| --- | ------- |
| Parameters | A [Collection](https://laravel.com/docs/collections) of [Models](https://laravel.com/docs/eloquent) or a string representation of a [Model](https://laravel.com/docs/eloquent), `column`, `maxCap` = null, `ifLose` = null |
| Throws| None |
| Returns | [Model](https://laravel.com/docs/eloquent) or an `object` |


---

### `IsRelatedTo`
The [IsRelatedTo helper](src/LangleyFoxall/Helpers/Traits/IsRelatedTo.php) is a trait that allows quick and easy access to the [`areRelated`](#arerelated) method in the [Models helper](src/LangleyFoxall/Helpers/Models.php).

#### Methods

- [`isRelatedTo`](#isrelatedto-1)

##### `isRelatedTo`
Check if a single model is related to the parent model.

###### Example usage
```
class User extends Model {
    use IsRelatedTo;
}

$related = $user->isRelatedTo($post)
```

| Key | Details |
| --- | ------- |
| Parameters | [Model](https://laravel.com/docs/eloquent) or [Array](http://php.net/manual/en/language.types.array.php) |
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
- [`cache`](#cache)


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

##### `cache`
Cache the current `ApiResponse` data for use in a later request. By default if the cache currently has data in it the data will not be overwritten. Using `forceOverwrite` it can be overwritten, this defaults to false.

###### Example Usage
`lifspan` accepts an [Integer](http://php.net/manual/en/language.types.integer.php) value for the lifespan in minutes or a [Carbon](https://carbon.nesbot.com/docs/) time when the cache will be cleared. `cache` must be an instansiated [ResponseCache](src/LangleyFoxall/Helpers/ResponseCache.php).

```
ApiResponse::success($data)->cache(1, $cache)->json();
```

| Key | Details |
| --- | ------- |
| Parameters | `lifespan`, `cache`, `forceOverwrite` *(Optional)* |
| Returns | [ApiResponse](src/LangleyFoxall/Helpers/ApiResponse.php) |

---

### `Response`
The [Response helper](src/LangleyFoxall/Helpers/Response.php) should only be used if, for whatever reason, API endpoints use the same [Controller](https://laravel.com/docs/controllers) methods as web URIs. This helper will check to see if the request is [expecting JSON](https://laravel.com/api/5.6/Illuminate/Http/Request.html#method_expectsJson) or not and return the right response.

| Key | Type | Description |
| --- | ---- | ----------- |
| `request` | [Request](https://laravel.com/api/5.6/Illuminate/Http/Request.html) | `request` is used when it comes to deciding which response to return to the client | 
| `type` | [String](http://php.net/manual/en/language.types.string.php) | `type` is a string, "success" or "error", which will determine which [API Response](src/LangleyFoxall/Helpers/ApiResponse.php) is returned |
| `message` | [NULL](http://php.net/manual/en/language.types.null.php), [String](http://php.net/manual/en/language.types.string.php) or [String](http://php.net/manual/en/language.types.string.php) | `message` is used for a [redirect back](https://laravel.com/docs/helpers#method-back) with a [session variable](https://laravel.com/docs/helpers#method-session) (web) or an error message (API) |
| `data` | [NULL](http://php.net/manual/en/language.types.null.php) or [Array](http://php.net/manual/en/language.types.array.php) | `data` should contain the main resource information |
| `meta` | [NULL](http://php.net/manual/en/language.types.null.php) or [Array](http://php.net/manual/en/language.types.array.php) | `meta` should contain extra resource information, such as other endpoints that can be used with the current resource |
| `status` | [Integer](http://php.net/manual/en/language.types.integer.php) | `status` is used for accessibility when the response cannot access the HTTP client, such as axios |
| `uri` | [String](http://php.net/manual/en/language.types.string.php) | `uri` is used when wanting to [redirect](https://laravel.com/docs/helpers#method-redirect) rather than [back](https://laravel.com/docs/helpers#method-back) with a web response |

#### Methods
None of the following methods can be called statically. When instansiating a new instance of Response a [Request](https://laravel.com/api/5.6/Illuminate/Http/Request.html) object is required.

- [`success`](#success-1)
- [`error`](#error-1)
- [`type`](#type)
- [`message`](#type)
- [`data`](#data-1)
- [`meta`](#meta-1)
- [`status`](#status-1)
- [`redirect`](#redirect)
- [`end`](#end)


##### `success`
Create a successful response.

###### Example Usage
None of the parameters are required.

```
$response = (new Response($request)->success($message, $data, $meta, $status)
```

| Key | Details |
| --- | ------- |
| Parameters | `message`, `data`, `meta`, `status` |
| Returns | [Response](src/LangleyFoxall/Helpers/Response.php) |


##### `error`
Create a unsuccessful response.

###### Example Usage
None of the parameters are required.

```
$response = (new Response($request)->success($message, $status)
```

| Key | Details |
| --- | ------- |
| Parameters | `message`, `status` |
| Returns | [Response](src/LangleyFoxall/Helpers/Response.php) |


##### `type`
Set the response type. While error and success are not aggressively checked the type will default to success if not error.

###### Example Usage
```
$response = (new Response($request)->success($type)
```

| Key | Details |
| --- | ------- |
| Parameters | `type` |
| Returns | [Response](src/LangleyFoxall/Helpers/Response.php) |


##### `message`
Set the message to be displayed if an error occurs or a [back](https://laravel.com/docs/helpers#method-back) is triggered.

###### Example Usage
```
$response = (new Response($request)->message($message)
```

| Key | Details |
| --- | ------- |
| Parameters | `message` |
| Returns | [Response](src/LangleyFoxall/Helpers/Response.php) |


##### `data`
Set the data to be returned in an successful [ApiResponse](src/LangleyFoxall/Helpers/ApiResponse.php).

###### Example Usage
None of the parameters are required.

```
$response = (new Response($request)->data($data)
```

| Key | Details |
| --- | ------- |
| Parameters | `data` |
| Returns | [Response](src/LangleyFoxall/Helpers/Response.php) |


##### `meta`
Set the meta to be returned in an successful [ApiResponse](src/LangleyFoxall/Helpers/ApiResponse.php).

###### Example Usage
None of the parameters are required.

```
$response = (new Response($request)->meta($meta)
```

| Key | Details |
| --- | ------- |
| Parameters | `meta` |
| Returns | [Response](src/LangleyFoxall/Helpers/Response.php) |


##### `status`
Set the status to be returned in an [ApiResponse](src/LangleyFoxall/Helpers/ApiResponse.php). This will be overwritten if called before `success` or `error`.

###### Example Usage
```
$response = (new Response($request)->status($status)
```

| Key | Details |
| --- | ------- |
| Parameters | `status` |
| Returns | [Response](src/LangleyFoxall/Helpers/Response.php) |


##### `redirect`
Set the [redirect](https://laravel.com/docs/helpers#method-redirect) URI to be called rather than redirecting [back](https://laravel.com/docs/helpers#method-back).

###### Example Usage
None of the parameters are required.

```
$response = (new Response($request)->redirect($uri)
```

| Key | Details |
| --- | ------- |
| Parameters | `uri` |
| Returns | [Response](src/LangleyFoxall/Helpers/Response.php) |


##### `end`
Return the expected response.

###### Example Usage
```
$expected_response = (new Response($request)->end()
```

| Key | Details |
| --- | ------- |
| Parameters | None |
| Returns | [RedirectResponse](https://laravel.com/api/5.6/Illuminate/Http/RedirectResponse.html) or [JsonResponse](https://laravel.com/api/5.6/Illuminate/Http/JsonResponse.html) |

---

### `ResponseCache`
The `ResponseCache` helper simplifies caching API Responses taking into account differing request parameters and user accounts. Unique caches are generated based on the request route, method, parameters and user.

| Key | Type | Description |
| --- | ---- | ----------- |
| `userSpecific` | [Boolean](http://php.net/manual/en/language.types.boolean.php) | `userSpecific` specifies if the response is cached for individual users or if all users share one cache. **Important:** Misuse of `userSpecific` can lead to massive inefficiencies and security flaws. If a response is the same for any user `userSpecific` should be set to false so that a new cache is not created for every user. If a response contains data pertaining to that user `userSpecific` should be set to true so that users do not receive someone else's cached data. |
| `excludeParams` | *(Optional)* [NULL](http://php.net/manual/en/language.types.null.php) or [Array](http://php.net/manual/en/language.types.array.php) | Since request parameters are likely to change the data generated a seperate cache is generated for different sets of parameters so that the correct data is returned. However some parameters do not change the data generated so a new cache does not need to be generated when they change. Adding these parameters to `excludeParams` will mean that they are ignored. |

#### Methods
None of the following methods can be called statically.

- [`hasData`](#hasdata)
- [`getData`](#getdata)
- [`cacheData`](#cachedata)
- [`getKey`](#getkey)
- [`clear`](#clear)


##### `hasData `
Returns if the current cache has any data.

###### Example Usage

```
if($cache->hasData()){...
```

| Key | Details |
| --- | ------- |
| Parameters | None |
| Returns | [Boolean](http://php.net/manual/en/language.types.boolean.php) |

##### `getData `
Returns the data currently in the cache, returns `null` if empty.

###### Example Usage

```
$data = $cache->getData();
```

| Key | Details |
| --- | ------- |
| Parameters | None |
| Returns | Mixed |

##### `cacheData `
Saves data to the cache. Any data currently in the cache will be overwritten/

###### Example Usage
`data` can be any serializable data, `lifespan` can be minutes as an [Integer](http://php.net/manual/en/language.types.integer.php) or a [Carbon](https://carbon.nesbot.com/docs/) time that the cache will expire at.

```
$cache->cacheData(["Hello" => "World"], Carbon:now()->addSeconds(4404));
```

| Key | Details |
| --- | ------- |
| Parameters |`data`, `lifespan` |
| Returns | None |

##### `getKey `
Returns the unique key for the cache generated based on the request path, method, parameters and user.

###### Example Usage

```
$key = $cache->getKey();
```

| Key | Details |
| --- | ------- |
| Parameters | None |
| Returns | [String](http://php.net/manual/en/language.types.string.php) |

##### `clear `
Clears the data for the given cache.

###### Example Usage

```
$cache->clear();
```

| Key | Details |
| --- | ------- |
| Parameters | None |
| Returns | None |

#### Usage with ApiResponse

A cache can be created from an`ApiResponse` automatically by using the`cache` function on it. It will only cache does not contain data. [See documentation here](#cache).

###### Example Usage
```
$cache = new ResponseCache(false);

if($cache->hasData()){
    $data = $cache->getData();
}else{
    $data = computationallyExpensiveFunction();
}

return ApiResponse::success($data)->cache(1, $cache)->json();
```