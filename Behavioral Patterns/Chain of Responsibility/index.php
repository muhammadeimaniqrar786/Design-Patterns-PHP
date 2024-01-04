<?php

// Handler interface
interface Approver
{
    public function setNext(Approver $nextApprover): Approver;
    public function processRequest(int $amount): void;
}

// Concrete Handler 1
class Manager implements Approver
{
    private $nextApprover;

    public function setNext(Approver $nextApprover): Approver
    {
        $this->nextApprover = $nextApprover;
        return $nextApprover;
    }

    public function processRequest(int $amount): void
    {
        if ($amount <= 1000) {
            echo "Manager approves the purchase request of $amount\n";
        } else if ($this->nextApprover !== null) {
            $this->nextApprover->processRequest($amount);
        }
    }
}

// Concrete Handler 2
class Director implements Approver
{
    private $nextApprover;

    public function setNext(Approver $nextApprover): Approver
    {
        $this->nextApprover = $nextApprover;
        return $nextApprover;
    }

    public function processRequest(int $amount): void
    {
        if ($amount <= 5000) {
            echo "Director approves the purchase request of $amount\n";
        } else if ($this->nextApprover !== null) {
            $this->nextApprover->processRequest($amount);
        }
    }
}

// Concrete Handler 3
class VicePresident implements Approver
{
    private $nextApprover;

    public function setNext(Approver $nextApprover): Approver
    {
        $this->nextApprover = $nextApprover;
        return $nextApprover;
    }

    public function processRequest(int $amount): void
    {
        if ($amount <= 10000) {
            echo "Vice President approves the purchase request of $amount\n";
        } else if ($this->nextApprover !== null) {
            $this->nextApprover->processRequest($amount);
        }
    }
}

// Client code
$manager = new Manager();
$director = new Director();
$vicePresident = new VicePresident();

// Creating the chain of responsibility
$manager->setNext($director)->setNext($vicePresident);

// Test the chain
$manager->processRequest(800);   // Manager approves the purchase request of 800
$manager->processRequest(4500);  // Director approves the purchase request of 4500
$manager->processRequest(12000); // Vice President approves the purchase request of 12000

// * let's break down the problem and how the Chain of Responsibility pattern provides a solution:

// * Problem:
// Imagine a scenario where a system needs to process purchase requests, and the approval process depends on the amount of the request. Different managers have different approval limits, and requests should be approved by the first manager whose limit is not exceeded. The system needs a flexible way to handle these requests without hardcoding the logic for each manager in the client code.

// * Solution:
// The Chain of Responsibility pattern addresses this problem by creating a chain of handler objects, where each handler is responsible for a specific range or condition. The handlers are connected in a chain, and a request is passed along the chain until it is handled or reaches the end of the chain.

// * In the provided PHP example:

// * Problem Addressed:

// The problem is to process purchase requests with different approval limits based on the amount.
// We want to avoid coupling the client code to specific managers and their approval logic.
// * Solution with Chain of Responsibility:

// The Approver interface declares the common methods (setNext and processRequest) that every handler in the chain should implement.
// Concrete handlers (Manager, Director, and VicePresident) are created, each responsible for handling requests within a specific range. They are connected in a chain using the setNext method.
// The client code only needs to interact with the first handler in the chain (Manager). It initiates the request by calling processRequest, and the request is then automatically passed through the chain.
// Each handler in the chain decides whether it can handle the request based on its criteria. If it can handle the request, it does so; otherwise, it passes the request to the next handler in the chain.
// This way, the client code doesn't need to know the details of the approval logic for each manager. It simply triggers the request, and the appropriate manager in the chain handles it.
// * Benefits of the Chain of Responsibility Pattern:
// * Flexibility:

// The pattern allows you to add or remove handlers without modifying the client code, providing flexibility in the approval process.
// * Decoupling:

// The client code is decoupled from the specific implementation details of each handler. It only interacts with the first handler in the chain.
// * Responsibility Chain:

// The pattern establishes a clear responsibility chain, where each handler focuses on a specific aspect of the request.
// * Reusability:

// Handlers can be reused in different chains or scenarios, promoting code reuse.
// By applying the Chain of Responsibility pattern, the code becomes more modular, maintainable, and adaptable to changes in the approval process.
