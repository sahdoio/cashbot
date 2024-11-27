<?php

use Core\Infrastructure\Utils\AccessToken;

$userEntity = new UserEntity(
  id: "1",
  name: "Jon Doe",
  email: "test@test.com",
  password: "any_password"
);

$sut = new AccessToken();

$result = $sut->generate($userEntity);

dump($result);
