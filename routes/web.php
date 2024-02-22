<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RabbitMQController;
use App\Http\Controllers\RabbitMQNewController;

Route::get('/send', [RabbitMQController::class, 'send']);
Route::get('/consumer', [RabbitMQController::class, 'consumer']);

/** Uma versão melhorada */
Route::get('/new/send', [RabbitMQNewController::class, 'send']);
Route::get('/new/consumer/create', [RabbitMQNewController::class, 'consumerCreatePDF']);
Route::get('/new/consumer/log', [RabbitMQNewController::class, 'consumerLogPDF']);
