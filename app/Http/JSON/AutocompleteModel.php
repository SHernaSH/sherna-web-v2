<?php


namespace App\Http\JSON;


/**
 * Class AutocompleteModel for storing data for the Tags autocomplete
 * Data needed as JSON are label and value
 * Label how the autocomplete suggestion is dispalyed,
 * value how it is inserted into request form
 * @package App\Http\JSON
 */
class AutocompleteModel
{


    public function __construct($label, $value)
    {
        $this->label = $label;
        $this->value = $value;
    }


    /**
     * Get the data as JSON
     *
     * @return false|string data as json
     */
    public function getJSON()
    {
        return json_encode($this);
    }
}
