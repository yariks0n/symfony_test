<?php


namespace App\Builders;

use App\Entity\Account;
use App\Entity\Transaction;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;

class TransactionBuilder
{
    private $data_builder;
    private $manager;
    private $error;

    public function __construct(ManagerRegistry $manager, $data_builder)
    {
        if(empty($data_builder["account_from_id"]))
        {
            $this->setError("account_from_id обязательно для заполнения");
        }
        else if(empty($data_builder["account_to_id"]))
        {
            $this->setError("account_to_id обязательно для заполнения");
        }
        else if(empty($data_builder["value"]))
        {
            $this->setError("value обязательно для заполнения");
        }

        $this->manager = $manager;
        $this->data_builder = $data_builder;

        $this->data_builder["account_from"] = $this->manager
            ->getRepository(Account::class)
            ->find($data_builder["account_from_id"]);

        $this->data_builder["account_to"] = $this->manager
            ->getRepository(Account::class)
            ->find($data_builder["account_to_id"]);

    }

    public function check()
    {
        $data_builder = $this->getDataBuilder();
        $entityManager = $this->manager->getManager();
        $value = (int)$data_builder["value"];

        if (!$data_builder["account_from"])
        {
            $this->setError('No account_from found for id '.$data_builder["account_from_id"]);
        }
        else if (!$data_builder["account_to"])
        {
            $this->setError('No account_to found for id '.$data_builder["account_to_id"]);
        }
        else if (empty($data_builder["value"]))
        {
            $this->setError('No value found');
        }
        else if($data_builder["account_from"]->getValue() < $value)
        {
            $this->setError("Недостаточно средств на счёте");
        }

        if(!empty($this->getError()))
        {
            return false;
        }
        else
        {
            return compact("data_builder", "entityManager", "value");
        }
    }

    public function start()
    {
        $extract = $this->check();
        if($extract !== false)
        {
            extract($extract);

            $error = false;

            $transaction = new Transaction();
            $transaction->setValue($value);
            $transaction->setAccountFrom($data_builder["account_from"]);
            $transaction->setAccountTo($data_builder["account_to"]);
            $transaction->setDateCreate(date("d.m.Y H:i:s"));

            if($data_builder["account_from"]->getValue() < $value)
            {
                $transaction->setError("Недостаточно средств на счёте");
                $error = true;
            }

            $entityManager->persist($transaction);
            $entityManager->flush();

            if(!$error)
            {
                $data_builder["account_from"]->setValue($data_builder["account_from"]->getValue() - $value);
                $entityManager->persist($data_builder["account_from"]);
                $entityManager->flush();

                $data_builder["account_to"]->setValue($data_builder["account_to"]->getValue() + $value);
                $entityManager->persist($data_builder["account_to"]);
                $entityManager->flush();
            }

            return json_encode(
                array(
                    "status" => "success",
                    "text" => "Транзакция успешно создана"
                ), JSON_UNESCAPED_UNICODE
            );
        }
        else
        {
            return json_encode(
                array(
                    "status" => "error",
                    "text" => $this->getError()
                ), JSON_UNESCAPED_UNICODE
            );
        }
    }

    /**
     * @param mixed $error
     */
    public function setError($error): void
    {
        $this->error = $error;
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @return mixed
     */
    public function getDataBuilder()
    {
        return $this->data_builder;
    }
}