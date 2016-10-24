<?php

interface ApiController {
    public static function get($id = null);
    public static function put($id);
    public static function post();
    public static function delete($id);
}