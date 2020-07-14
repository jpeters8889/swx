<?php

namespace App\Http\Controllers;

use JPeters\PageViewBuilder\Page;

class HomeController
{
    public function get(Page $page)
    {
        return $page->render('welcome');
    }
}
