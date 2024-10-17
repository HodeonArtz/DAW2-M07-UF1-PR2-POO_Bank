<?php namespace ComBank\Transactions;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 1:22 PM
 */

use ComBank\Bank\Contracts\BackAccountInterface;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\Transactions\Contracts\BankTransactionInterface;

class WithdrawTransaction extends BaseTransaction implements BankTransactionInterface 
{
  public function __construct(float $amount) {
    $this->validateAmount($amount);
    $this->amount = $amount;
  } 
  public function applyTransaction(BackAccountInterface $account): float{
   
  }

    public function getTransactionInfo(): string{
      
    }

    public function getAmount(): float{
      
    }
}