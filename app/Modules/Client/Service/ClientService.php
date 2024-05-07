<?php

namespace App\Modules\Client\Service;

use App\Models\Client;
use App\Modules\Client\Dto\CreateClientDto;
use Illuminate\Support\Facades\Hash;
use Nette\Utils\Random;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ClientService
{
    public function getClientByPhone($phone)
    {
        $client = Client::query()->where(['phone' => $phone])->first();
        if ($client) {
            return $client->makeHidden(['password', 'username'])->toArray();
        }
        throw new NotFoundHttpException('client not found');
    }

    public function create(CreateClientDto $dto)
    {
        $client = new Client();
        $client->email = $dto->email;
        $client->username = $dto->email;
        $client->full_name = $dto->name;
        $client->password = Hash::make(Random::generate(10));
        $client->save();
        return $client;
    }
}
