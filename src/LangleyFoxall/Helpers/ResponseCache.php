<?php

namespace LangleyFoxall\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;


class ResponseCache
{

    /**
     * @var string
     */
    protected $key;

    /**
     * ResponseCache constructor.
     * @param Request $request
     * @param bool $userSpecific
     * @param array $excludeParams
     */
    public function __construct(Request $request, bool $userSpecific, $excludeParams = [])
    {
        $this->key = self::hashRequest($request, $userSpecific, $excludeParams);
    }

    /**
     * @param Request $request
     * @param bool $userSpecific
     * @param array $excludeParams
     * @return string
     */
    private static function hashRequest(Request $request, bool $userSpecific, $excludeParams = []){
        $user = $request->user();

        $data = [
            $request->path(),
            $request->method(),
            $request->except($excludeParams),
            $userSpecific ? isset($user) ? $user[$user->getKeyName()] : null : null
        ];

        return sha1(serialize($data));
    }

    /**
     * @return bool
     */
    public function hasData(){
        return Cache::has($this->key);
    }

    /**
     * @return mixed
     */
    public function getData(){
        return unserialize(Cache::get($this->key));
    }

    /**
     * @param mixed $data
     * @param mixed $lifespan
     */
    public function cacheData($data, $lifespan){
        Cache::put($this->key, serialize($data), $lifespan);
    }

    /**
     * @return string
     */
    public function getKey(){
        return $this->key;
    }

    /**
     *
     */
    public function clear(){
        Cache::forget($this->key);
    }
}