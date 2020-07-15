<?php

Route::get('/', function () {
    return view('welcome');
});

Route::view('/sms', 'sms');
