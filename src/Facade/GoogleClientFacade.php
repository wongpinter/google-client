<?php namespace Wongpinter\GoogleClient\Facade;
/**
 * Created By: Sugeng
 * Date: 1/26/17
 * Time: 16:40
 */
use Illuminate\Support\Facades\Facade;

class GoogleClientFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'google.client';
    }
}