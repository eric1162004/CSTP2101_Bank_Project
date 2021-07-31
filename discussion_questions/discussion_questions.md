# Question 5:

## From Customer Table
Trivial functional dependency
- customerID -> customerID

Non-trivial functional dependency
- customerID -> firstName, lastName, income, birthDate
- customerID -> firstName, lastName, income
- customerID -> firstName, lastName, birthDate
- customerID -> firstName, lastName
- customerID -> firstName, income, birthDate
- customerID -> firstName, income 
- customerID -> firstName, birthDate
- customerID -> firstName
- customerID -> lastName, income, birthDate
- customerID -> lastName, birthDate
- customerID -> lastName, income
- customerID -> lastName
- customerID -> income, birthDate
- customerID -> birthDate
- customerID -> income

## From Account Table
Trivial functional dependency
- accNumber -> accNumber

Non-trivial functional dependency
- accNumber -> type
- accNumber -> balance
- accNumber -> branchNumber

## From Owns Table
Trivial functional dependency
- customerID, accNumber -> customerID, accNumber 
- customerID, accNumber -> customerID
- customerID, accNumber -> accNumber 
- customerID -> customerID
- accNumber -> accNumber 

## From Transactions Table
Trivial functional dependency
- transNumber, accNumber -> transNumber, accNumber 
- transNumber, accNumber -> transNumber
- transNumber, accNumber -> accNumber 
- transNumber -> transNumber 
- accNumber -> accNumber 

Non-trivial functional dependency
- transNumber, accNumber -> amount

## From Employee Table
Trivial functional dependency
- sin -> sin

Non-trivial functional dependency
- sin -> firstName, lastName, salary, branchNumber
- sin -> firstName, lastName, salary
- sin -> firstName, lastName
- sin -> firstName
- sin -> firstName, salary, branchNumber
- sin -> firstName, branchNumber
- sin -> firstName, salary
- sin -> firstName, lastName, branchNumber
- sin -> firstName, branchNumber
- sin -> lastName, salary, branchNumber
- sin -> lastName, salary
- sin -> lastName, branchNumber
- sin -> lastName
- sin -> salary, branchNumber
- sin -> salary
- sin -> branchNumber

## From Branch Table
Trivial functional dependency
- branchNumber -> branchNumber

Non-trivial functional dependency
- branchNumber -> branchNumber, managerSIN, budget
- branchNumber -> branchNumber, budget
- branchNumber -> branchNumber, managerSIN
- branchNumber -> branchNumber
- branchNumber -> managerSIN, budget
- branchNumber -> managerSIN
- branchNumber -> budget

# Question 6:

- The Customer table is in 3NF because it is in 1NF and 2NF, and it does not contain any transitive partial dependecy. All the the non-prime attributes, ie. firstName, lastName, income and birthDate, are fully functional dependent on the primary key (customerID). There were no transitive dependency among the non-prime attributes. 

- The Account table is in 3NF because it is in 1NF and 2NF, and it does not contain any transitive partial dependecy. All the the non-prime attributes, ie. type, balance and branchNumber, are fully functional dependent on the primary key (accNumber). There were no transitive dependency among the non-prime attributes. 

- There are no non-prime attributes in the Owns table since it only contains a composite key (customerID, accNumber). By definition, the Owns table is in 3NF because it is in 1NF and 2NF, and it does not contain any transitive partial dependecy.  

- The Tranactions table is in 3NF because it is in 1NF and 2NF, and it does not contain any transitive partial dependecy. All the the non-prime attributes, ie. accNumber and amount, are fully functional dependent on the primary key (transNumber). There were no transitive dependency among the non-prime attributes. 

- The Employee table is in 3NF because it is in 1NF and 2NF, and it does not contain any transitive partial dependecy. All the the non-prime attributes, ie. firstName, lastName, salary and branchNumber, are fully functional dependent on the primary key (sin). There were no transitive dependency among the non-prime attributes. 

- The Branch table is in 3NF because it is in 1NF and 2NF, and it does not contain any transitive partial dependecy. All the the non-prime attributes, ie. branchName, managerSIN, and budget, are fully functional dependent on the primary key (branchNumber). There were no transitive dependency among the non-prime attributes. 