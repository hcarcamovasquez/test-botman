<?php
use App\Http\Controllers\BotManController;

$botman = resolve('botman');


/*$botman->hears('hola', function ($bot) {
    $bot->reply('hola!');
});

$botman->hears('call me {name}', function ($bot, $name) {
    $bot->typesAndWaits(2);
    $bot->reply('Your name is: '.$name);
});


$botman->hears('I want ([0-9]+)', function ($bot, $number) {
    $bot->reply('You will get: '.$number);
});


$botman->hears('I want ([0-9]+) portions of (Cheese|Cake)', function ($bot, $amount, $dish) {
    $bot->reply('You will get '.$amount.' portions of '.$dish.' served shortly.');
});

$botman->hears('.*hola.*', function ($bot) {
    $bot->reply('Nice to meet you!');
});

$botman->fallback(function($bot) {
    $bot->reply('Sorry, I did not understand these commands. Here is a list of commands I understand: ...');
});*/



$botman->hears('Start conversation', BotManController::class.'@startConversation');

$botman->hears('H', BotManController::class.'@onboardingConversation');

$botman->hears('Hola', BotManController::class.'@quotationConversation');



