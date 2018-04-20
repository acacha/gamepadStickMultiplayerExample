<?php

namespace App\Http\Controllers;

use App\Events\NewBall;

class BallsController extends Controller
{
    public function store()
    {
        $ball = Ball::forceCreate();
        event(new NewBall($ball));
    }
}
