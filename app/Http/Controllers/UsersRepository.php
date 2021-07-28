<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class UsersRepository
{
    const TTL = 2;

    const API_URL = 'https://api.github.com';

    public function fetch(array $users = [])
    {
        $values = [];

        foreach ($users as $user) {
            $value = $this->getUser($user);
            if (is_array($value)) {
                $values[] = $value;
            }
        }

        return $values;
    }

    public function getUser(string $username)
    {
        $value = $this->getFromCache($username);

        if ($value) {
            return array_merge($value, ['from_cache' => true]);
        }

        $value = $this->getFromApi($username);

        if (is_null($value)) {
            return null;
        }

        return $this->saveToCache($username, $value);
    }

    public function getFromCache(string $username)
    {
        return Cache::get($username);
    }

    public function getFromApi(string $username)
    {
        try {
            $request = Http::get(static::API_URL . '/users/' . $username);

            $user = $request->json();

            return [
                'name' => $user['name'],
                'login' => $user['login'],
                'company' => $user['company'],
                'public_repos' => $user['public_repos'],
                'followers' => $user['followers'],
                'average_followers' => number_format($user['followers'] / $user['public_repos'], 2),
            ];
        } catch (\Exception $e) {
            return null;
        }
    }

    public function saveToCache(string $username, array $value = [])
    {
        Cache::put($username, $value, now()->addMinutes(static::TTL));

        return $value;
    }
}
