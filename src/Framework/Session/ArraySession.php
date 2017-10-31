<?php
namespace Framework\Session;

class ArraySession implements SessionInterface
{
    
    private $session = [];

    /**
     * Get an information from Session
     *
     * @param string $key
     * @param mixed $default
     * @return void
     */
    public function get(string $key, $default = null)
    {
        if (array_key_exists($key, $this->session)) {
            return $this->session[$key];
        }
        return $default;
    }
    
    /**
     * Add an information into Session
     *
     * @param string $key
     * @param $value
     * @return void
     */
    public function set(string $key, $value): void
    {
        $this->session[$key] = $value;
    }

    /**
     * Delete an information into Session
     *
     * @param string $key
     * @return void
     */
    public function delete(string $key): void
    {
        unset($this->session[$key]);
    }
}
