<?php

ini_set('session.gc_probability', 1);
use App\Card;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Contents;
use App\Fields;
use App\User;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;


foreach(glob("app/Functions/*.php") AS $file) {
   //all custom functions include here
    include($file);
}