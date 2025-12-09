<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
class GeneralImport implements ToModel {

    /**
     * @param Collection $collection
     */
    protected $model, $keys;

    function __construct($model, $keys) {
        $this->model = $model;
        $this->keys = $keys;
    }

    public function model(array $row) {
        $array = array();
        foreach ($this->keys as $key => $value) {
            $array[$value] = $row[$key];
        }
        return new $this->model($array);
    }

}
