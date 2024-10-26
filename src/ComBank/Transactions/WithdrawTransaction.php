<?php namespace ComBank\Transactions;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 1:22 PM
 */

use ComBank\Bank\Contracts\BackAccountInterface;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\Transactions\Contracts\BankTransactionInterface;

class WithdrawTransaction extends BaseTransaction implements BankTransactionInterface 
{
  public function __construct(float $amount) {
    $this->validateAmount($amount);
    $this->amount = $amount;
  } 

  public function applyTransaction(BackAccountInterface $account): float{
    $accountOverdraft = $account->getOverdraft(); 
    $finalBalance = $account->getBalance() - $this->amount;

    if($account->getBalance() < 0){
      $finalBalance -= $account->getBalance() * -$accountOverdraft->getInterestRate();
    }

    if(!$accountOverdraft->
          isGrantOverdraftFunds($finalBalance)){
            
      if($accountOverdraft->getOverdraftFundsAmount() > 0)
        throw new FailedTransactionException("Withdrawal exceeds overdraft limit.");

      if($accountOverdraft->getOverdraftFundsAmount() <= 0)
        throw new InvalidOverdraftFundsException("Insufficient balance to complete the withdrawal.");
    }
    
    $account->setBalance($finalBalance);
    return $account->getBalance();
  }

    public function getTransactionInfo(): string{
      return "WITHDRAW_TRANSACTION";
    }

    public function getAmount(): float{
      return $this->amount;
    }
}