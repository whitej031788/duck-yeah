<?php

namespace App\Models;

class Duck_Alert
{
    /**
     * Create a new duck alert instance.
     *
     * @return void
     */
    public function __construct($alert)
    {
        $this->duckData = $alert;
    }
}
