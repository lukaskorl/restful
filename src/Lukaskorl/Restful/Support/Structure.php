<?php namespace Lukaskorl\Restful\Support;


class Structure
{

    // Name for the payload tag in the structure template
    const TAG_PAYLOAD = 'payload';

    /**
     * Store the represented structure
     *
     * @var null
     */
    protected $structure = null;

    /**
     * Protected constructor. Use static make method to instantiate a new structure.
     *
     * @param $structure
     */
    protected function __construct($structure)
    {
        $this->structure = $structure;
    }

    /**
     * Factory method for setting up structures
     *
     * @param mixed $structure
     * @return static
     */
    public static function make($structure)
    {
        return new static($structure);
    }

    /**
     * Apply value to a given key in the structure. Template keys are written in parantheses {key_name}.
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function apply($key, $value)
    {
        if (is_array($this->structure)) {
            array_walk_recursive($this->structure, function(&$v, $k) use ($key, $value)
            {
                if (preg_match('/{'.$key.'}/', $v)) {
                    if (! is_null($value) or is_array($value)) {
                        $v = $value;
                    }
                    else {
                        $v = preg_replace('/{'.$key.'}\|?/', '', $v);
                    }
                }
            });
        } else {
            if (preg_match('/{'.$key.'}/', $this->structure)) {
                $this->structure = $value;
            }
        }

        return $this;
    }

    /**
     * Convenience method for setting the payload. Cleans up unused tags and sets the payload.
     *
     * @param $data
     * @return mixed
     */
    public function payload($data)
    {
        return $this->clean()->apply(self::TAG_PAYLOAD, $data);
    }

    /**
     * Clean structure from unused tags
     *
     * @return $this
     */
    public function clean()
    {
        /**
         * Helper function to recursively remove elements from an array
         *
         * @param array $array
         * @param callable $callback
         * @return array
         */
        function array_walk_remove ($array, callable $callback)
        {
            if (is_array($array)) {
                foreach ($array as $k => $v) {
                    if (is_array($v)) {
                        $array[$k] = array_walk_remove($v, $callback);

                    }

                    if ($callback($k, $array[$k])) {
                        unset($array[$k]);
                    }
                }
            } else {
                if ($callback($array, $array)) {
                    return null;
                }
            }

            return $array;
        }

        // Walk over the array and remove all template keys
        $this->structure = array_walk_remove($this->structure, function($k, $v)
        {
            return (is_array($v) && count($v) < 1) || (!is_array($v) && $v !== '{'.self::TAG_PAYLOAD.'}' && preg_match('/{*}/', $v));
        });

        return $this;
    }

    /**
     * Return structure data
     *
     * @return array
     */
    public function get()
    {
        return $this->structure;
    }

} 