<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ConferenceSignUpPage;


Route::get('/conference-sign-up/{conferenceId}', ConferenceSignUpPage::class);

