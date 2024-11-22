<?php

if (! function_exists('isAdmin')) {
    function isAdmin() {
        return auth()->check() && auth()->user()->rol === 'administrador';
    }
}