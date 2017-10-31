<?php
namespace Framework\Session;

interface SessionInterface
{

    /**
     * Get an information from Session
     *
     * @param string $key
     * @param mixed $default
     * @return void
     */
    public function get(string $key, $default = null);

    /**
     * Add an information into Session
     *
     * @param string $key
     * @param $value
     * @return void
     */
    public function set(string $key, $value): void;

    /**
     * Delete an information into Session
     *
     * @param string $key
     * @return void
     */
    public function delete(string $key): void;
}
