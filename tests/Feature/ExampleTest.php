<?php

test('homepage displays successfully', function () {
    $response = $this->get(route('home'));

    $response->assertOk();
});
