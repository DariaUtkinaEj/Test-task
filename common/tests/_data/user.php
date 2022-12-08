<?php

return [
    [
        'username' => 'kuritsa',
        'auth_key' => 'valid_auth_token',
        'password_hash' => '$2y$13$7/C53Jmh9U/HNu7Qho16ce/EfOZz8vT/ef9j4giFxIAOQw/yT7mx.', //  kuritsa
        'password_reset_token' => '1',
        'created_at' => 1670394729,
        'updated_at' => 1670394729,
        'status' => 10,
        'auth_expires_at' => 1920395396
    ],
    [
        'username' => 'kuritsa_expired',
        'auth_key' => 'expired_auth_token',
        'password_hash' => '$2y$13$7/C53Jmh9U/HNu7Qho16ce/EfOZz8vT/ef9j4giFxIAOQw/yT7mx.',
        'password_reset_token' => '2',
        'created_at' => 1670394729,
        'updated_at' => 1670394729,
        'status' => 10,
        'auth_expires_at' => 0 // test expired key
    ],
];