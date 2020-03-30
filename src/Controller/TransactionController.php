<?php

namespace App\Controller;

use App\Builders\TransactionBuilder;
use App\Message\TransactionNotification;
use http\Client\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class TransactionController extends AbstractController
{
    /**
     * @Route("/transaction", name="index", methods={"POST"})
     * @param Request $request
     * @param MessageBusInterface $bus
     * @return JsonResponse
     */
    public function index(Request $request, MessageBusInterface $bus)
    {
        $json_request = $request->getContent();

        /*$json_request = '{
          "account_from_id": 1,
          "account_to_id": 2,
          "value": 100
        }';*/

        $data_builder = json_decode($json_request,true);

        $transactionBuilder = new TransactionBuilder($this->getDoctrine(), $data_builder);
        $transaction_result = $transactionBuilder->check();

        if($transaction_result === false)
        {
            $result = array(
                "status" => "error",
                "text" => $transactionBuilder->getError()
            );
            $status = 400;
        }
        else
        {
            $result = array(
                "status" => "success",
                "text" => "Транзакция добавлена в очередь"
            );
            $status = 201;
            $bus->dispatch(new TransactionNotification($json_request));
        }

        return $this->json($result, $status);
    }

}
