<?php

namespace LangleyFoxall\Traits\IdentifiedByUUID\Models;

use Illuminate\Database\Eloquent\Model;
use LangleyFoxall\Helpers\Traits\IdentifiedByUUID;

class Demo extends Model
{
    use IdentifiedByUUID;

    /**
     * @var string
     */
    protected $primaryKey = 'uuid';

    /**
     * @var array
     */
    protected $fillable = ['text'];
}
