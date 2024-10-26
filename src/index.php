<?php

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/27/24
 * Time: 7:24 PM
 */

use ComBank\Bank\BankAccount;
use ComBank\OverdraftStrategy\SilverOverdraft;
use ComBank\OverdraftStrategy\BasicOverdraft;
use ComBank\OverdraftStrategy\GoldOverdraft;
use ComBank\Transactions\DepositTransaction;
use ComBank\Transactions\WithdrawTransaction;
use ComBank\Exceptions\BankAccountException;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\Exceptions\ZeroAmountException;

require_once 'bootstrap.php';


//---[Bank account 1]---/
// create a new account1 with balance 400
function showTransactionHistory(array $history): void {
  pl("---------- Transaction History ----------");
  foreach ($history as $key => $transaction) {
    pl("-----------------------------------------");
    pl("Transaction type: {$transaction["type"]}");
    pl("Amount: {$transaction["amount"]}");
    pl("Date: {$transaction["date"]}");
  }
}

$bankAccount1 = new BankAccount(400);
pl('--------- [Start testing bank account #1, No overdraft] --------');
try {
    // show balance account
    pl("My balance : {$bankAccount1->getBalance()}");
    // close account
    $bankAccount1->closeAccount();
    // reopen account
    $bankAccount1->reopenAccount();


    // deposit +150 
    pl('Doing transaction deposit (+150) with current balance ' . $bankAccount1->getBalance());
    $bankAccount1->transaction(new DepositTransaction(150));
    pl('My new balance after deposit (+150) : ' . $bankAccount1->getBalance());
    // withdrawal -25
    pl('Doing transaction withdrawal (-25) with current balance ' . $bankAccount1->getBalance());
    $bankAccount1->transaction(new WithdrawTransaction(25));

    pl('My new balance after withdrawal (-25) : ' . $bankAccount1->getBalance());

    // withdrawal -600
    pl('Doing transaction withdrawal (-600) with current balance ' . $bankAccount1->getBalance());
    $bankAccount1->transaction(new WithdrawTransaction(600));

} catch (ZeroAmountException $e) {
    pl($e->getMessage());
} catch (BankAccountException $e) {
    pl($e->getMessage());
} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());

} catch (InvalidOverdraftFundsException $e) {
    pl('Error transaction: ' . $e->getMessage());
}
pl('My balance after failed last transaction : ' . $bankAccount1->getBalance());
$bankAccount1->closeAccount();




$bankAccount2 = new BankAccount(200);
$bankAccount2->applyOverdraft(new SilverOverdraft());
//---[Bank account 2]---/
pl('--------- [Start testing bank account #2, Silver overdraft (100.0 funds)] --------');
try {
    
    // show balance account
    pl("My balance : {$bankAccount2->getBalance()}");
    // deposit +100
    pl('Doing transaction deposit (+100) with current balance ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new DepositTransaction(100));
    pl('My new balance after deposit (+100) : ' . $bankAccount2->getBalance());

    // withdrawal -300
    pl('Doing transaction deposit (-300) with current balance ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new WithdrawTransaction(300));
   
    pl('My new balance after withdrawal (-300) : ' . $bankAccount2->getBalance());

    // withdrawal -50
    pl('Doing transaction deposit (-50) with current balance ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new WithdrawTransaction(50));
    pl('My new balance after withdrawal (-50) with funds : ' . $bankAccount2->getBalance());

    // withdrawal -120
    pl('Doing transaction withdrawal (-120) with current balance ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new WithdrawTransaction(120));

} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());
}
pl('My balance after failed last transaction : ' . $bankAccount2->getBalance());

try {
    pl('Doing transaction withdrawal (-20) with current balance : ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new WithdrawTransaction(20));
    
} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());
}
pl('My new balance after withdrawal (-20) with funds : ' . $bankAccount2->getBalance());

try {
   $bankAccount2->closeAccount();
   $bankAccount2->closeAccount();
} catch (BankAccountException $e) {
    pl("Error: ".$e->getMessage());
}



//---[Bank account 3]---/
$bankAccount3 = new BankAccount(200);
$bankAccount3->applyOverdraft(new BasicOverdraft());
pl('--------- [Start testing bank account #3, Basic overdraft (50.0 funds)] --------');
try {
    
    // show balance account
    pl("My balance : {$bankAccount3->getBalance()}");
    
    // withdrawal -300
    pl('Doing transaction withdrawal (-225) with current balance ' . $bankAccount3->getBalance());
    $bankAccount3->transaction(new WithdrawTransaction(225));
   
    pl('My new balance after withdrawal (-225) : ' . $bankAccount3->getBalance());

    pl('Doing transaction withdrawal (-25) with current balance : ' . $bankAccount3->getBalance());
    $bankAccount3->transaction(new WithdrawTransaction(25));

    pl('My new balance after withdrawal (-25) : ' . $bankAccount3->getBalance());

} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());
}

try {
  pl('Doing transaction withdrawal (-20) with current balance ' . $bankAccount3->getBalance());
    $bankAccount3->transaction(new WithdrawTransaction(20));
   
    $interest_rate = $bankAccount3->getOverdraft()->getInterestRate() * 100;

    pl("My new balance after withdrawal (-20) with interest rate ($interest_rate%) : " . $bankAccount3->getBalance());
} catch (FailedTransactionException $e) {
  pl('Error transaction: ' . $e->getMessage());
}

  
pl('My new balance after withdrawal (-25) with funds : ' . $bankAccount3->getBalance());

showTransactionHistory($bankAccount3->getTransactionHistory());