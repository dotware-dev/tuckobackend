<?php
    namespace Config;

class Config
{
    /**
     * database host
     * @var string
     */
    const DB_HOST = 'localhost';
    /**
     * database name
     * @var string
     */
    const DB_NAME = 'vhypy';
    /**
     * database user
     * @var string
     */
    const DB_USER = 'root';
    /**
     * database password
     * @var string
     */
    const DB_PASSWORD = 'root';
    /**
     * show or hide error messages on screen
     * @var boolean
    */
    const SHOW_ERRORS = false;
    /**
     *Generate cache files
     * @var boolean
     */
    const CACHE = false;
}
