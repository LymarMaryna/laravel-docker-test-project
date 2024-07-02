<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return '
<div>
    <h1>Coin Exchange API</h1>
    <ul>
        <li><a href="/api/currencies">GET All Currencies</a></li>
        <li><a href="/api/currencies/bitcoin">GET Bitcoin Price in USD</a></li>
        <li><a href="/api/currencies/tether">GET Tether Price in USD</a></li>
    </ul>
</div>
';

});
