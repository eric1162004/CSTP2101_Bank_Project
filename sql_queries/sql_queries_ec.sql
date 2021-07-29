-- Question 1
-- First name and last name of customers 
-- whose income is over $80,000, 
-- order by last name, then first name.

SELECT firstName, lastName FROM Customer
where income > 80000
ORDER BY lastName, firstName;

-- Question 2
-- Branch name, account number and balance of accounts 
-- with balances over $115,000 held at branches 
-- with budgets greater than $2,000,000, 
-- order by branch name, then account number.

SELECT branchName, accNumber, balance
FROM Account a
JOIN Branch b
ON a.branchNumber = b.branchNumber
WHERE a.balance > 115000
AND b.budget  > 2000000
ORDER BY branchName, accNumber; 

-- Question 3
-- First name, last name, and income of customers 
-- whose income is at least twice the income of 
-- any customer named Charles Smith, 
-- order by last name then first name.

SELECT firstName, lastName, income
FROM Customer c
WHERE c.income > ANY (
    SELECT income * 2
    FROM Customer cs
    WHERE firstName = "Charles" AND lastName = "Smith"
)
ORDER BY c.lastName, c.firstName;

-- Question 4
-- Customer ID, income, account numbers and branch numbers of customers 
-- with income greater than 90,000 
-- who own an account at either the London or Latveria branches, 
-- order by customer ID then account number. 
-- The result should contain all the account numbers of customers 
-- who meet the criteria, even if the account itself is not held at London or Latveria.

SELECT c.customerID, c.income, a.accNumber, b.branchNumber
FROM Customer c
LEFT JOIN Owns o ON c.customerID = o.customerID
LEFT JOIN Account a ON o.accNumber = a.accNumber
LEFT JOIN Branch b ON a.branchNumber = b.branchNumber
WHERE c.income > 90000
OR ((c.income > 90000) and (b.branchName = "London" OR b.branchName = "Latveria"))
ORDER BY c.customerID, a.accNumber;

-- Question 5
-- Customer ID, types, account numbers and balances 
-- of business (type bus) and savings (type sav) accounts 
-- owned by customers who own at least one business account 
-- and at least one savings account, 
-- order by customer ID, then type, then account number.

SELECT c.customerID, a.type, a.accNumber, a.balance
FROM Customer c
JOIN Owns o
ON c.customerID = o.customerID
JOIN Account a
ON o.accNumber = a.accNumber
WHERE c.customerID in (
    SELECT c.customerID
    FROM Customer c
    JOIN Owns o
    ON c.customerID = o.customerID
    JOIN Account a
    ON o.accNumber = a.accNumber
    WHERE a.type = "saving" 
) AND c.customerID in (
    SELECT c.customerID
    FROM Customer c
    JOIN Owns o
    ON c.customerID = o.customerID
    JOIN Account a
    ON o.accNumber = a.accNumber
    WHERE a.type = "business"
)
ORDER BY c.customerID, a.accNumber;

-- Question 6
-- SIN, branch name, salary and salary � manager�s salary 
-- (that is, salary of the employee minus the salary of the employee�s manager) 
-- of all employees, order by descending (salary � manager salary).

SELECT e.sin, b.branchName, e.salary, e.salary - m.salary as salary_difference_from_manager
FROM Employee e
JOIN Employee m
On e.branchNumber = m.branchNumber AND 
m.sin in (
    SELECT managerSIN 
    FROM Branch
)
JOIN Branch b
On b.branchNumber = e.branchNumber
ORDER BY salary_difference_from_manager DESC;

-- Question 7
-- Customer ID of customers who have an account at the Berlin branch, 
-- who do not own an account at the London branch 
-- and who do not co-own an account with another customer 
-- who owns an account at the London branch, 
-- order by customer ID. 
-- The result should not contain duplicate customer IDs.

SELECT DISTINCT c.customerID, a.accNumber
FROM Customer c
JOIN Owns o
ON c.customerID = o.customerID
JOIN Account a
ON a.accNumber = o.accNumber
JOIN Branch b
ON b.branchNumber = a.branchNumber
WHERE c.customerID NOT IN
(
    SELECT cc.customerID
    FROM Customer cc
    JOIN Owns oo
    ON cc.customerID = oo.customerID
    JOIN Account aa
    ON aa.accNumber = oo.accNumber
    JOIN Branch bb
    ON bb.branchNumber = aa.branchNumber
    WHERE bb.branchName = "London"
)
AND b.branchName = "Berlin"
ORDER BY c.customerID;

-- Question 8
-- SIN, last name, and salary of employees who earn more than $80,000, 
-- if they are managers show the branch name of their branch in a fourth column 
-- (which should be NULL for most employees), order by salary in decreasing order. 
-- You must use an outer join in your solution (which is the easiest way to do it).

SELECT sin, lastName, salary, branchName
FROM Employee e
LEFT JOIN Branch b
ON b.managerSIN = e.sin
WHERE salary > 80000
ORDER BY salary DESC;

-- Question 9
-- Exactly as question eight, except that your query cannot include any join operation.

SELECT sin, lastName, salary, branchName
FROM Employee e, Branch b
WHERE e.sin = b.managerSIN
UNION
SELECT sin, lastName, salary, null
FROM Employee e, Branch b
WHERE e.sin != b.managerSIN
AND e.sin NOT IN (
    SELECT sin
    FROM Employee e, Branch b
    WHERE e.sin = b.managerSIN
)
WHERE salary > 80000
ORDER BY salary DESC;

-- Question 10
-- Customer ID, last name and birth dates of customers 
-- who own accounts in all of the branches 
-- that Adam Rivera owns accounts in, 
-- order by customer ID.

SELECT DISTINCT c.customerID, c.lastName, c.birthDate
FROM Customer c
JOIN Owns o
ON c.customerID = o.customerID
JOIN Account a
ON a.accNumber = o.accNumber
JOIN Branch b
On b.branchNumber in (
    SELECT bb.branchNumber
    From Branch bb
    JOIN Account aa
    ON aa.branchNumber = bb.branchNumber
    JOIN Owns oo
    ON oo.accNumber = aa.accNumber
    JOIN Customer cc
    ON oo.customerID = cc.customerID
    WHERE cc.firstName = "Adam" AND cc.lastName = "Rivera"
)
WHERE (c.firstName != "Adam") AND (c.lastName != "Rivera")
ORDER BY customerID;


-- Question 11
-- SIN, first name, last name and salary of the highest paid employee (or employees) 
-- of the Berlin branch, order by sin.

SELECT e.sin, firstName, lastName, salary
FROM Employee e
JOIN Branch b
ON e.branchNumber = b.branchNumber
WHERE b.branchName = "Berlin" 
AND e.salary = (
    SELECT MAX(salary)
    FROM Employee e
    JOIN Branch b
    ON e.branchNumber = b.branchNumber
    WHERE b.branchName = "Berlin" 
)
ORDER BY e.sin;

-- Question 12
-- Sum of the employee salaries (a single number) at the Latveria branch.

SELECT SUM(e.salary) as Sum_of_salaries_at_Latveria
FROM Employee e
JOIN Branch b
On e.branchNumber = b.branchNumber
WHERE b.branchName = "Latveria";

-- Question 13
-- Count of the number of different first names of employees 
-- working at the London branch 
-- and a count of the number of employees working at the London branch 
-- (two numbers in a single row).

SELECT count(distinct e.firstName) as count_of_unique_firstName, 
count(e.firstName) as count_of__firstName
FROM Employee e
JOIN Branch b
ON e.branchNumber = b.branchNumber
WHERE b.branchName = "London";

-- Question 14
-- Branch name, and minimum, maximum and average salary of the employees 
-- at each branch, order by branch name.

SELECT b.branchName, MIN(salary), MAX(salary), AVG(salary)
FROM Employee e
JOIN Branch b
WHERE e.branchNumber = b.branchNumber
GROUP BY b.branchName
ORDER BY b.branchName;

-- Question 15
-- Customer ID, first name and last name of customers 
-- who own accounts at a minimum of two different branches, order by customer ID.

SELECT c.customerID, c.firstName, c.lastName, count(DISTINCT a.branchNumber) AS branch_distinct_count
FROM Customer c
JOIN Owns o 
ON c.customerID = o.customerID
JOIN Account a
ON a.accNumber = o.accNumber
GROUP BY c.customerID
HAVING branch_distinct_count >=2
ORDER BY c.customerID;

-- Question 16
-- Average income of customers older than 50 and average income of customers younger than 50, 
-- the result must have two named columns, 
-- with one row, in one result set (hint: look up T-SQL time and date functions).

SELECT Older.income as income_from_50_older, Younger.income as income_from_50_younger
FROM (
    SELECT YEAR(CURRENT_TIMESTAMP) - YEAR(birthDate) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(birthDate, 5)) as age, AVG(income) as income
    FROM Customer 
    GROUP BY age
    HAVING age > 50
) Older
JOIN (
    SELECT YEAR(CURRENT_TIMESTAMP) - YEAR(birthDate) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(birthDate, 5)) as age, AVG(income) as income
    FROM Customer
    GROUP BY age
    HAVING age < 50
) Younger;

-- Question 17
-- Customer ID, last name, first name, income, and average account balance of customers 
-- who have at least three accounts, 
-- and whose last names begin with Jo and contain an s (e.g. Johnson) 
-- or whose first names begin with A and have a vowel as the letter just before the last letter (e.g. Aaron), 
-- order by customer ID. 
-- Note that this will be much easier if you look up LIKE wildcards in the MSDN T-SQL documentation. 
-- Also note - to appear in the result customers must have at least three accounts 
-- and satisfy one (or both) of the name conditions.

SELECT cc.customerID, cc.lastName, cc.firstName, AI.averageIncome
FROM(
    SELECT cc.customerID, cc.lastName, cc.firstName
    From Customer cc
    WHERE cc.customerID in (
        SELECT c.customerID 
        FROM (
            SELECT customerID, count(customerID)
            From Owns
            GROUP BY customerID
        ) c
    ) AND ( cc.lastName REGEXP '^Jo*s*' OR cc.firstName REGEXP '^A[aeiou]')
) cc
JOIN 
(
    SELECT AVG(balance) as averageIncome, c.customerID
    FROM Account a
    JOIN Owns o
    ON a.accNumber = o.accNumber
    JOIN Customer c
    ON o.customerID = c.customerID
    GROUP BY c.customerID
) AI
ON cc.customerID = AI.customerID;

-- Question 18
-- Account number, balance, sum of transaction amounts, 
-- and (balance - transaction sum) for accounts in the New York branch 
-- that have at least ten transactions, order by account number.

SELECT 
    t.accNumber as accNumber, 
    a.balance,
    count(t.accNumber) as count, 
    sum(t.amount) as transaction_amounts,
    balance - sum(t.amount) as balance_transactions_difference
FROM Transactions t
JOIN Owns o
ON t.accNumber = o.accNumber
JOIN Account a
ON a.accNumber = o.accNumber
JOIN Branch b 
ON b.branchNumber = a.branchNumber
WHERE b.branchName = "New York"
GROUP BY t.accNumber
HAVING count >= 10
ORDER BY a.balance;

-- Question 19
-- Branch name, account type, 
-- and average transaction amount of each account type for each branch 
-- for branches that have at least 50 accounts of any type, 
-- order by branch name, then account type.

SELECT b.branchName, a.type, avg(t.amount)
FROM Branch b
JOIN Account a
On b.branchNumber = a.branchNumber
JOIN Transactions t
On a.accNumber = t.accNumber
WHERE b.branchName in (
    SELECT bb.branchName
    FROM (
        SELECT bbb.branchName, count(tt.transNumber) as transCount
        FROM Branch bbb
        JOIN Account aa
        On bbb.branchNumber = aa.branchNumber
        JOIN Transactions tt
        On aa.accNumber = tt.accNumber
        GROUP BY bbb.branchName
        HAVING transCount >= 50
    ) bb
)
GROUP BY b.branchName, a.type
ORDER BY b.branchName, a.type;

-- Question 20
-- Branch name, account type, account number, transaction number 
-- and amount of transactions of accounts 
-- where the average transaction amount is greater than three times 
-- the (overall) average transaction amount of accounts of that type. 
-- For example, if the average transaction amount of all business accounts is $2,000 
-- then return transactions from business accounts 
-- where the average transaction amount for that account is greater than $6,000. 
-- Order by branch name, then account type, account number and finally transaction number. 
-- Note that all transactions of qualifying accounts should be returned 
-- even if they are less than the average amount of the account type.

SELECT b.branchName, result.type, result.accNumber, t.transNumber, t.amount
FROM (
    SELECT iAmount.type, iAmount.accNumber, accountAVGAmount, overallAVGAmount
    From (
        SELECT a.type, avg(amount) AS overallAVGAmount
        FROM Transactions t
        JOIN Account a
        On t.accNumber = a.accNumber
        GROUP BY a.type
    ) oAmount
    JOIN (
        SELECT a.accNumber, a.type, avg(amount) AS accountAVGAmount
        FROM Transactions t
        JOIN Account a
        On t.accNumber = a.accNumber
        JOIN Branch b
        On a.branchNumber = b.branchNumber
        GROUP BY a.accNumber, a.type
    ) iAmount
    ON
    oAmount.type = iAmount.type
    WHERE overallAVGAmount * 3 < accountAVGAmount
    ORDER BY iAmount.type, iAmount.accNumber
) result
JOIN Account a
On result.accNumber = a.accNumber
JOIN Branch b
On a.branchNumber = b.branchNumber
JOIN Transactions t
On t.accNumber = result.accNumber;