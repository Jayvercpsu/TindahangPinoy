<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DataTable extends Component
{
    public $headers;
    public $rows;
    public $actions;
    public $route;

    public function __construct($headers, $rows, $actions = [], $route = null)
    {
        $this->headers = $headers;
        $this->rows = $rows;
        $this->actions = $actions;
        $this->route = $route ?? url()->current();
    }

    public function render()
    {
        return view('components.data-table');
    }
}

