<?php

use Core\Infrastructure\Database\Eloquent\EloquentDbRepository;

$repo = new EloquentDbRepository();
$repo->setSchema("User");

$repo->findAll();
$repo->findOne(["email" => "lucassahdo@gmail.com"]);
