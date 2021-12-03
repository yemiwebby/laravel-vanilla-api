<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Jobs\SendMailToUser;
use App\Models\MailList;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiMailController extends BaseController
{
    protected $mailList;

    public function __construct(MailList $mailList)
    {
        $this->mailList = $mailList;
    }

    public function sendMail(Request $request): JsonResponse
    {
        $details = $request->all();

        if (is_array($details)) {
            foreach ($details as $detail) {
                SendMailToUser::dispatch($detail)->delay(now()->addSecond(10));
            }
        } else {
            return $this->sendError("Kindly check the format of the request");
        }

        return $this->successfulResponse($details, 'Mails sent successfully');
    }

    public function sentMailLists(): JsonResponse
    {
        $mailLists = $this->mailList->getList();

        return $this->successfulResponse($mailLists, "Retrieved successfully");
    }
}
