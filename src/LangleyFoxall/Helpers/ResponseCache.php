<?php

namespace LangleyFoxall\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;


class ResponseCache
{

    /**
     * @var string
     */
    protected $key;

    /**
     * ResponseCache constructor.
     * @param bool $userSpecific
     * @param array $excludeParams
     */
    public function __construct(bool $userSpecific, $excludeParams = [])
    {
        $this->key = self::hashRequest($userSpecific, $excludeParams);
    }

    /**
     * @param bool $userSpecific
     * @param array $excludeParams
     * @return string
     */
    private static function hashRequest(bool $userSpecific, $excludeParams = []){
        $user = Request::user();

        $data = [
            Request::path(),
            Request::method(),
            Request::except($excludeParams),
            $userSpecific ? isset($user) ? $user[$user->getKeyName()] : null : null
        ];

        return md5(serialize($data));
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