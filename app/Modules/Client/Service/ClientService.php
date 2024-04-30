<?php

namespace App\Modules\Client\Service;

use App\Models\Client;
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
}
