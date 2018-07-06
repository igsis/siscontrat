<?php

namespace siscontrat\Http\Controllers;

use Request;
use siscontrat\Http\Controllers\Controller;

class MenuController extends Controller
{
  public function admin()
  {
    return view('layout.menu.admin');
  }
}
