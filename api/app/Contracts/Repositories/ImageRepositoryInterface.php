<?php

namespace App\Contracts\Repositories;

/**
 * Interface for any image provider CRUD actions.
 */
interface ImageRepositoryInterface
{
    /**
     * @return array Expects an array with keys 'url', 'alt', 'color' and 'credit'
     */
    public function getRandom();
}
