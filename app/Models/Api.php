<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Api extends Model
{
    use HasFactory;

    protected $host = "https://api.carbonintensity.org.uk/";
    protected $noData = "Data aren't avaivalble at the moment..";

    public function getHost()
    {
        return $this->host;
    }

    public function getNoData()
    {
        return $this->noData;
    }

}
