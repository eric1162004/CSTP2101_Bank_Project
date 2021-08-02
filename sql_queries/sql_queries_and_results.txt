-- Question 1
-- First name and last name of customers 
-- whose income is over $80,000, 
-- order by last name, then first name.

SELECT firstName, lastName FROM Customer
where income > 80000
ORDER BY lastName, firstName;

Result:
+-----------+-----------+
| firstName | lastName  |
+-----------+-----------+
| Diana     | ;nzales   |
| Joe       | ;nzalez   |
| Ruby      | Barnes    |
| Ronald    | Bell      |
| Philip    | Brooks    |
| Clarence  | Brown     |
| Dennis    | Collins   |
| Sharon    | Collins   |
| Jerry     | Cook      |
| Victor    | Doom      |
| Phillip   | Edwards   |
| Dennis    | Flores    |
| Christine | Gray      |
| Sandra    | Hayes     |
| Antonio   | Henderson |
| Deborah   | Hernandez |
| Charles   | Hill      |
| Phyllis   | Lopez     |
| Helen     | Morgan    |
| Sean      | Nelson    |
| Victor    | Perez     |
| Joe       | Sanders   |
| Norma     | Simmons   |
| Susan     | Smith     |
| Roger     | Turner    |
| Juan      | Ward      |
| Ryan      | Williams  |
| Louise    | Wilson    |
+-----------+-----------+

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

Result:

+------------+-----------+-----------+
| branchName | accNumber | balance   |
+------------+-----------+-----------+
| London     |         1 | 118231.13 |
| London     |         8 | 121267.54 |
| London     |         9 | 132271.23 |
+------------+-----------+-----------+

-- Question 3
-- First name, last name, and income of customers 
-- whose income is at least twice the income of 
-- any customer named Charles Smith, 
-- order by last name then first name.

SELECT firstName, lastName, income
FROM Customer c
WHERE c.income > ANY (
    SELECT income * 2
    FROM Customer c
    WHERE firstName = "Charles" AND lastName = "Smith"
)
ORDER BY c.lastName, c.firstName;

Result:

+-----------+----------+--------+
| firstName | lastName | income |
+-----------+----------+--------+
| Diana     | ;nzales  |  94777 |
| Ronald    | Bell     |  91166 |
| Clarence  | Brown    |  95879 |
| Sharon    | Collins  |  99531 |
| Jerry     | Cook     |  91174 |
| Victor    | Doom     |  97412 |
| Phillip   | Edwards  |  99339 |
| Christine | Gray     |  95821 |
| Charles   | Hill     |  92397 |
| Phyllis   | Lopez    |  92919 |
| Helen     | Morgan   |  98442 |
| Sean      | Nelson   |  96216 |
| Joe       | Sanders  |  95144 |
| Norma     | Simmons  |  99902 |
| Ryan      | Williams |  95170 |
| Louise    | Wilson   |  96214 |
+-----------+----------+--------+

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

Result:

+------------+--------+-----------+--------------+
| customerID | income | accNumber | branchNumber |
+------------+--------+-----------+--------------+
|      13423 |  99902 |        87 |            1 |
|      13423 |  99902 |       246 |            4 |
|      13697 |  92397 |        38 |            1 |
|      13697 |  92397 |       147 |            3 |
|      13697 |  92397 |       251 |            4 |
|      27954 |  94777 |        10 |            1 |
|      27954 |  94777 |        68 |            3 |
|      27954 |  94777 |       239 |            2 |
|      32422 |  95821 |       254 |            4 |
|      32422 |  95821 |       282 |            4 |
|      33726 |  91174 |       132 |            1 |
|      33726 |  91174 |       243 |            4 |
|      33726 |  91174 |       287 |            4 |
|      33913 |  91166 |         7 |            1 |
|      33913 |  91166 |       260 |            5 |
|      50742 |  96214 |        76 |            3 |
|      50742 |  96214 |        77 |            3 |
|      50742 |  96214 |       107 |            1 |
|      50742 |  96214 |       272 |            5 |
|      51850 |  97412 |        35 |            1 |
|      51850 |  97412 |       129 |            1 |
|      51850 |  97412 |       161 |            3 |
|      51850 |  97412 |       182 |            2 |
|      55700 |  99339 |      NULL |         NULL |
|      61379 |  95170 |       151 |            3 |
|      62312 |  92919 |        61 |            3 |
|      62312 |  92919 |       116 |            1 |
|      62312 |  92919 |       219 |            2 |
|      62312 |  92919 |       261 |            5 |
|      72583 |  95879 |       130 |            1 |
|      79601 |  95144 |        26 |            1 |
|      79601 |  95144 |        52 |            3 |
|      79601 |  95144 |        75 |            3 |
|      79601 |  95144 |       110 |            1 |
|      79601 |  95144 |       165 |            3 |
|      85981 |  99531 |       209 |            2 |
|      90649 |  98442 |        14 |            1 |
|      90649 |  98442 |       247 |            4 |
|      90649 |  98442 |       258 |            5 |
|      96475 |  96216 |        25 |            1 |
|      99537 |  90211 |        11 |            1 |
|      99537 |  90211 |       100 |            4 |
|      99537 |  90211 |       243 |            4 |
|      99537 |  90211 |       274 |            5 |
|      99537 |  90211 |       281 |            4 |
+------------+--------+-----------+--------------+


-- Question 5
-- Customer ID, types, account numbers and balances 
-- of business (type bus) and savings (type sav) accounts 
-- owned by customers who own at least one business account 
-- and at least one savings account, 
-- order by customer ID, then type, then account number.

select Customer.CustomerID, type, Account.accNumber,Account.balance
from Customer join Owns on Customer.CustomerID= Owns.CustomerID 
join Account on Account.accNumber=Owns.accNumber 
where (type='BUS' or type='SAV') 
order by Customer.CustomerID, type, Account.accNumber;

Result:

+------------+------+-----------+-----------+
| CustomerID | type | accNumber | balance   |
+------------+------+-----------+-----------+
|      11790 | BUS  |       150 |  77477.04 |
|      11790 | SAV  |         1 | 118231.13 |
|      11799 | BUS  |       174 |  23535.33 |
|      13230 | SAV  |       137 |  76535.96 |
|      13697 | SAV  |       251 |  33140.30 |
|      13874 | SAV  |        82 |  29525.31 |
|      14295 | BUS  |       106 | 102297.76 |
|      14295 | BUS  |       273 |  65213.27 |
|      14295 | SAV  |       245 |  95413.18 |
|      16837 | BUS  |       197 |  19495.50 |
|      16837 | BUS  |       212 |  54950.80 |
|      19308 | BUS  |       234 |  35041.68 |
|      19308 | SAV  |        82 |  29525.31 |
|      19308 | SAV  |       260 |  55607.43 |
|      19973 | SAV  |       140 |  99233.93 |
|      20287 | SAV  |       222 |  81498.87 |
|      22050 | BUS  |       221 | 105068.53 |
|      22050 | SAV  |        19 |  83432.52 |
|      23010 | SAV  |       250 |  28400.79 |
|      25052 | BUS  |       290 |  87236.94 |
|      25052 | BUS  |       297 |  77378.21 |
|      25052 | SAV  |       171 |  94194.62 |
|      25159 | BUS  |       242 |  31705.31 |
|      25159 | SAV  |       270 |  24148.47 |
|      27004 | BUS  |       271 |  43452.71 |
|      27004 | SAV  |        70 |  33716.29 |
|      27004 | SAV  |        96 |  37055.15 |
|      27954 | BUS  |        10 |  72667.44 |
|      27954 | SAV  |        68 |  37748.82 |
|      28453 | BUS  |       173 |  15923.34 |
|      28453 | SAV  |        89 |  97457.14 |
|      29474 | SAV  |        60 |  53485.04 |
|      29474 | SAV  |        85 |  69476.72 |
|      30525 | SAV  |       125 |  44498.65 |
|      30525 | SAV  |       270 |  24148.47 |
|      30807 | BUS  |        91 |  62531.41 |
|      30807 | SAV  |       156 |  41520.57 |
|      32422 | BUS  |       254 |  63839.93 |
|      32422 | SAV  |       282 | 101063.84 |
|      33133 | SAV  |       216 |  74211.19 |
|      33133 | SAV  |       263 |  22682.38 |
|      33726 | SAV  |       243 |  49766.04 |
|      33850 | SAV  |       256 |  72686.41 |
|      33913 | SAV  |       260 |  55607.43 |
|      34069 | BUS  |        27 |  81162.08 |
|      34069 | BUS  |       177 |  52032.61 |
|      34069 | BUS  |       218 | 103650.37 |
|      35059 | BUS  |       264 |  56998.05 |
|      35059 | SAV  |       213 |  41508.56 |
|      35780 | SAV  |       217 |  50874.79 |
|      36238 | BUS  |       240 |  96635.34 |
|      37716 | SAV  |       142 |  86931.71 |
|      37716 | SAV  |       186 |  46559.63 |
|      38351 | SAV  |        95 |  22741.92 |
|      38351 | SAV  |       189 |  67788.00 |
|      38602 | BUS  |        74 |  70301.55 |
|      38861 | BUS  |       294 |  36864.46 |
|      38861 | SAV  |       228 |  77031.07 |
|      38861 | SAV  |       248 |  65919.35 |
|      40351 | BUS  |       123 |  80993.90 |
|      40351 | BUS  |       139 | 101394.11 |
|      41545 | BUS  |        51 |  45793.34 |
|      41545 | SAV  |        32 |  83408.19 |
|      41648 | SAV  |       135 | 105420.87 |
|      42612 | BUS  |       225 |  18954.60 |
|      43705 | BUS  |       236 |  23084.55 |
|      43705 | SAV  |       192 |  19162.66 |
|      44065 | SAV  |       193 |  20098.57 |
|      44637 | SAV  |        69 |  18172.88 |
|      44922 | BUS  |       133 |  86457.17 |
|      44922 | BUS  |       279 |  88794.87 |
|      46058 | SAV  |       110 |  36235.58 |
|      46058 | SAV  |       245 |  95413.18 |
|      46630 | BUS  |       255 |  29913.60 |
|      46630 | SAV  |       160 |  87925.09 |
|      46937 | SAV  |         9 | 132271.23 |
|      47953 | BUS  |       115 | 102857.55 |
|      47953 | SAV  |        48 |  63416.35 |
|      49747 | SAV  |       142 |  86931.71 |
|      50742 | BUS  |       107 | 102366.95 |
|      51850 | BUS  |       129 |  35668.54 |
|      51850 | SAV  |        35 |  77214.48 |
|      52189 | BUS  |       249 |  83863.10 |
|      52189 | BUS  |       290 |  87236.94 |
|      52189 | SAV  |        53 |  49101.06 |
|      52622 | SAV  |        95 |  22741.92 |
|      52622 | SAV  |       257 |  69711.29 |
|      55194 | BUS  |        93 |  79642.98 |
|      57796 | SAV  |        99 |  17951.51 |
|      59366 | BUS  |        36 |  65482.68 |
|      59366 | SAV  |        26 | 112046.36 |
|      59366 | SAV  |        64 |  87815.69 |
|      59366 | SAV  |       152 |  31858.67 |
|      60959 | SAV  |       205 |  49952.82 |
|      61379 | BUS  |       151 |  82207.06 |
|      61976 | BUS  |       167 |  20965.26 |
|      61976 | SAV  |       235 |  44741.90 |
|      62312 | BUS  |       116 |  34798.47 |
|      62312 | BUS  |       219 |  29672.22 |
|      62312 | SAV  |       261 |  55402.81 |
|      63772 | SAV  |       134 |  37690.50 |
|      63859 | SAV  |       291 | 101504.47 |
|      64063 | BUS  |       167 |  20965.26 |
|      64063 | BUS  |       200 | 100035.01 |
|      65044 | BUS  |       179 |  42494.67 |
|      65044 | SAV  |       117 |  14203.10 |
|      65441 | BUS  |       124 |  11732.87 |
|      65441 | BUS  |       269 |  79912.41 |
|      65441 | SAV  |       181 |  24453.37 |
|      66418 | BUS  |         8 | 121267.54 |
|      66418 | SAV  |       278 |  48434.80 |
|      66744 | SAV  |        60 |  53485.04 |
|      67384 | BUS  |       234 |  35041.68 |
|      67384 | SAV  |        37 |   9421.53 |
|      67384 | SAV  |       223 |  41345.93 |
|      69101 | BUS  |        55 |  49713.83 |
|      69101 | BUS  |        63 |  57035.26 |
|      69101 | BUS  |       273 |  65213.27 |
|      69256 | BUS  |       123 |  80993.90 |
|      69256 | BUS  |       151 |  82207.06 |
|      73386 | SAV  |        94 |  74260.98 |
|      73386 | SAV  |       253 |  74761.19 |
|      73925 | BUS  |        63 |  57035.26 |
|      73925 | SAV  |       143 |  27480.19 |
|      75671 | BUS  |        63 |  57035.26 |
|      75671 | SAV  |       194 |  92152.03 |
|      76786 | SAV  |       170 |  69580.12 |
|      77100 | SAV  |       101 |  17004.14 |
|      77100 | SAV  |       230 |  63379.26 |
|      77100 | SAV  |       253 |  74761.19 |
|      78477 | SAV  |         9 | 132271.23 |
|      78477 | SAV  |        49 |  87557.84 |
|      79601 | SAV  |        26 | 112046.36 |
|      79601 | SAV  |       110 |  36235.58 |
|      80315 | BUS  |        16 |  75390.64 |
|      80315 | BUS  |       199 |  87161.89 |
|      80315 | SAV  |       128 |  73129.43 |
|      80321 | SAV  |       121 | 103512.78 |
|      80321 | SAV  |       146 |  95876.24 |
|      81108 | BUS  |        92 |  71552.54 |
|      81108 | SAV  |       121 | 103512.78 |
|      81263 | BUS  |         4 | 106503.60 |
|      81263 | SAV  |        98 |  69297.68 |
|      82333 | BUS  |       178 |  16105.24 |
|      82333 | SAV  |       103 |  90491.84 |
|      82464 | SAV  |        86 |  50837.08 |
|      83038 | BUS  |       237 |  91951.43 |
|      83620 | BUS  |       138 | 104044.22 |
|      84873 | BUS  |        18 | 103579.69 |
|      84873 | BUS  |       141 |  93073.14 |
|      85981 | BUS  |       209 |  88574.32 |
|      86357 | SAV  |        86 |  50837.08 |
|      86858 | SAV  |       284 |  85756.70 |
|      87013 | SAV  |       145 |  34588.13 |
|      87822 | BUS  |       175 |  70997.62 |
|      87822 | SAV  |       275 |  95955.98 |
|      88164 | SAV  |       120 |  27253.21 |
|      88375 | BUS  |        22 |  78928.42 |
|      88375 | BUS  |        43 |  82028.05 |
|      89902 | BUS  |         4 | 106503.60 |
|      89902 | SAV  |        48 |  63416.35 |
|      89902 | SAV  |        78 |  72742.21 |
|      90649 | BUS  |       247 |  72957.44 |
|      90667 | BUS  |       267 |  24588.13 |
|      90667 | SAV  |        97 |  11797.34 |
|      90798 | SAV  |       146 |  95876.24 |
|      91672 | BUS  |         8 | 121267.54 |
|      91672 | BUS  |       215 |  83349.17 |
|      92389 | SAV  |        72 |  59597.18 |
|      92389 | SAV  |       193 |  20098.57 |
|      92389 | SAV  |       268 |  91951.04 |
|      92389 | SAV  |       280 |  45824.72 |
|      93300 | BUS  |        80 |  13574.85 |
|      93300 | BUS  |       166 |  65453.56 |
|      93300 | SAV  |       224 |  61398.87 |
|      93300 | SAV  |       298 |  92525.41 |
|      93791 | BUS  |       238 |  46680.50 |
|      93791 | SAV  |        44 |  69658.25 |
|      93791 | SAV  |       155 |  55474.05 |
|      93995 | BUS  |       159 |  44147.62 |
|      93995 | BUS  |       180 |  40624.03 |
|      96475 | SAV  |        25 | 105997.07 |
|      97216 | BUS  |        88 |   4563.37 |
|      98826 | BUS  |       114 |  67973.27 |
|      98826 | SAV  |        12 |  77626.76 |
|      98923 | SAV  |        40 |  72419.68 |
|      99537 | SAV  |       243 |  49766.04 |
+------------+------+-----------+-----------+

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

Result:

+-------+------------+--------+--------------------------------+
| sin   | branchName | salary | salary_difference_from_manager |
+-------+------------+--------+--------------------------------+
| 95246 | Latveria   |  98773 |                          11531 |
| 23528 | New York   |  94974 |                           4491 |
| 11285 | New York   |  93779 |                           3296 |
| 99537 | Berlin     |  90211 |                              0 |
| 31964 | New York   |  90483 |                              0 |
| 51850 | Latveria   |  87242 |                              0 |
| 55700 | London     |  99289 |                              0 |
| 63963 | Moscow     |  71284 |                              0 |
| 81126 | Moscow     |  71185 |                            -99 |
| 86213 | Latveria   |  85853 |                          -1389 |
| 38351 | New York   |  86093 |                          -4390 |
| 97216 | London     |  89746 |                          -9543 |
| 40900 | New York   |  77533 |                         -12950 |
| 63772 | Latveria   |  74194 |                         -13048 |
| 58707 | London     |  85934 |                         -13355 |
| 57796 | New York   |  75896 |                         -14587 |
| 79510 | London     |  84199 |                         -15090 |
| 44459 | Moscow     |  55740 |                         -15544 |
| 33743 | Berlin     |  70396 |                         -19815 |
| 98119 | Latveria   |  66863 |                         -20379 |
| 30513 | London     |  78839 |                         -20450 |
| 27004 | New York   |  69842 |                         -20641 |
| 81263 | New York   |  67275 |                         -23208 |
| 28453 | London     |  75146 |                         -24143 |
| 68383 | Berlin     |  65722 |                         -24489 |
| 81108 | Latveria   |  61312 |                         -25930 |
| 68006 | London     |  73264 |                         -26025 |
| 17301 | Moscow     |  45103 |                         -26181 |
| 14295 | Moscow     |  44495 |                         -26789 |
| 60822 | Latveria   |  59709 |                         -27533 |
| 52020 | Moscow     |  43128 |                         -28156 |
| 73386 | Latveria   |  57935 |                         -29307 |
| 42182 | New York   |  60059 |                         -30424 |
| 95429 | Berlin     |  51003 |                         -39208 |
| 29474 | London     |  59360 |                         -39929 |
| 59653 | New York   |  49066 |                         -41417 |
| 82333 | Berlin     |  45443 |                         -44768 |
| 92400 | New York   |  44853 |                         -45630 |
| 30807 | Latveria   |  40753 |                         -46489 |
| 48264 | London     |  52031 |                         -47258 |
| 55194 | Latveria   |  38549 |                         -48693 |
| 34532 | Latveria   |  35173 |                         -52069 |
| 14209 | New York   |  36784 |                         -53699 |
| 55146 | London     |  42893 |                         -56396 |
| 86032 | London     |  42301 |                         -56988 |
| 15153 | Berlin     |  32204 |                         -58007 |
| 24901 | New York   |  32470 |                         -58013 |
| 45676 | London     |  41201 |                         -58088 |
| 92389 | Moscow     |  12525 |                         -58759 |
| 58844 | Berlin     |  30403 |                         -59808 |
| 11185 | London     |  39466 |                         -59823 |
| 81302 | Berlin     |  29426 |                         -60785 |
| 85587 | London     |  38385 |                         -60904 |
| 11499 | Berlin     |  27769 |                         -62442 |
| 79162 | New York   |  27531 |                         -62952 |
| 82495 | London     |  35868 |                         -63421 |
| 70163 | Berlin     |  25389 |                         -64822 |
| 82076 | New York   |  25328 |                         -65155 |
| 76576 | Berlin     |  23540 |                         -66671 |
| 77100 | Berlin     |  23477 |                         -66734 |
| 97976 | London     |  32400 |                         -66889 |
| 96443 | Berlin     |  19971 |                         -70240 |
| 82244 | London     |  29009 |                         -70280 |
| 82464 | London     |  28953 |                         -70336 |
| 90667 | New York   |  19534 |                         -70949 |
| 90368 | New York   |  19403 |                         -71080 |
| 17323 | Latveria   |  14018 |                         -73224 |
| 24065 | London     |  25870 |                         -73419 |
| 25902 | New York   |  14334 |                         -76149 |
| 37490 | London     |  23082 |                         -76207 |
| 71076 | New York   |  13393 |                         -77090 |
| 91712 | Latveria   |   9491 |                         -77751 |
| 93942 | New York   |  12065 |                         -78418 |
| 78993 | New York   |  10953 |                         -79530 |
| 41545 | Berlin     |   9534 |                         -80677 |
| 49069 | Berlin     |   7600 |                         -82611 |
| 85925 | London     |  15370 |                         -83919 |
| 24469 | London     |  13950 |                         -85339 |
| 49024 | Berlin     |   3349 |                         -86862 |
+-------+------------+--------+--------------------------------+


-- Question 7
-- Customer ID of customers who have an account at the Berlin branch, 
-- who do not own an account at the London branch 
-- and who do not co-own an account with another customer 
-- who owns an account at the London branch, 
-- order by customer ID. 
-- The result should not contain duplicate customer IDs.

SELECT DISTINCT c.customerID
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

Result:

+------------+
| customerID |
+------------+
|      14295 |
|      23010 |
|      25052 |
|      25159 |
|      30622 |
|      32422 |
|      33133 |
|      33850 |
|      35780 |
|      38003 |
|      46630 |
|      64055 |
|      77100 |
|      82333 |
|      86858 |
|      92389 |
|      93300 |
|      93995 |
+------------+

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

Result:

+-------+-----------+--------+------------+
| sin   | lastName  | salary | branchName |
+-------+-----------+--------+------------+
| 55700 | Edwards   |  99289 | London     |
| 95246 | Garcia    |  98773 | NULL       |
| 23528 | Russell   |  94974 | NULL       |
| 11285 | Simmons   |  93779 | NULL       |
| 31964 | Doom      |  90483 | New York   |
| 99537 | Hernandez |  90211 | Berlin     |
| 97216 | Collins   |  89746 | NULL       |
| 51850 | Doom      |  87242 | Latveria   |
| 38351 | Perez     |  86093 | NULL       |
| 58707 | Watson    |  85934 | NULL       |
| 86213 | Martinez  |  85853 | NULL       |
| 79510 | Hernandez |  84199 | NULL       |
+-------+-----------+--------+------------+

-- Question 9
-- Exactly as question eight, except that your query cannot include any join operation.

SELECT sin, lastName, salary, branchName
FROM Employee e, Branch b
WHERE e.sin = b.managerSIN
AND salary > 80000
UNION
SELECT sin, lastName, salary, null
FROM Employee e, Branch b
WHERE e.sin NOT IN (
    SELECT sin
    FROM Employee e, Branch b
    WHERE e.sin = b.managerSIN
)
AND salary > 80000
ORDER BY salary DESC;

Result:

+-------+-----------+--------+------------+
| sin   | lastName  | salary | branchName |
+-------+-----------+--------+------------+
| 55700 | Edwards   |  99289 | London     |
| 95246 | Garcia    |  98773 | NULL       |
| 23528 | Russell   |  94974 | NULL       |
| 11285 | Simmons   |  93779 | NULL       |
| 31964 | Doom      |  90483 | New York   |
| 99537 | Hernandez |  90211 | Berlin     |
| 97216 | Collins   |  89746 | NULL       |
| 51850 | Doom      |  87242 | Latveria   |
| 38351 | Perez     |  86093 | NULL       |
| 58707 | Watson    |  85934 | NULL       |
| 86213 | Martinez  |  85853 | NULL       |
| 79510 | Hernandez |  84199 | NULL       |
+-------+-----------+--------+------------+

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

Result:
+------------+-----------+-----------+
| customerID | lastName  | birthDate |
+------------+-----------+-----------+
|      10839 | Hayes     | NULL      |
|      11696 | Lopez     | NULL      |
|      11790 | Green     | NULL      |
|      11799 | Martinez  | NULL      |
|      13230 | Brooks    | NULL      |
|      13423 | Simmons   | NULL      |
|      13697 | Hill      | NULL      |
|      13874 | Cooper    | NULL      |
|      14295 | Ramirez   | NULL      |
|      16837 | Hughes    | NULL      |
|      18166 | Barnes    | NULL      |
|      19308 | Reed      | NULL      |
|      19973 | Kelly     | NULL      |
|      20287 | Thomas    | NULL      |
|      22050 | Sanchez   | NULL      |
|      23010 | Young     | NULL      |
|      25052 | Anderson  | NULL      |
|      25159 | Brooks    | NULL      |
|      27004 | Johnson   | NULL      |
|      27954 | ;nzales   | NULL      |
|      28453 | White     | NULL      |
|      28505 | Cook      | NULL      |
|      29474 | White     | NULL      |
|      30525 | Carter    | NULL      |
|      30622 | Murphy    | NULL      |
|      30807 | Morris    | NULL      |
|      32422 | Gray      | NULL      |
|      33133 | Barnes    | NULL      |
|      33726 | Cook      | NULL      |
|      33850 | Ward      | NULL      |
|      33913 | Bell      | NULL      |
|      34069 | Lee       | NULL      |
|      35059 | Murphy    | NULL      |
|      35380 | Clark     | NULL      |
|      35780 | Young     | NULL      |
|      36238 | Morgan    | NULL      |
|      37716 | Scott     | NULL      |
|      38003 | Griffin   | NULL      |
|      38351 | Perez     | NULL      |
|      38602 | Jones     | NULL      |
|      38861 | James     | NULL      |
|      40351 | Hayes     | NULL      |
|      41545 | Bailey    | NULL      |
|      41648 | Clark     | NULL      |
|      42612 | Kelly     | NULL      |
|      43705 | Bell      | NULL      |
|      44065 | Ramirez   | NULL      |
|      44459 | Watson    | NULL      |
|      44637 | Carter    | NULL      |
|      44922 | Flores    | NULL      |
|      45960 | Long      | NULL      |
|      46630 | Coleman   | NULL      |
|      46937 | Ward      | NULL      |
|      47953 | Martinez  | NULL      |
|      49747 | Brooks    | NULL      |
|      50742 | Wilson    | NULL      |
|      51850 | Doom      | NULL      |
|      52189 | Sanders   | NULL      |
|      52622 | Morgan    | NULL      |
|      55146 | Jackson   | NULL      |
|      55194 | Morris    | NULL      |
|      57796 | Adams     | NULL      |
|      59366 | Smith     | NULL      |
|      60959 | Jones     | NULL      |
|      61379 | Williams  | NULL      |
|      61969 | Henderson | NULL      |
|      61976 | Parker    | NULL      |
|      62312 | Lopez     | NULL      |
|      63772 | Powell    | NULL      |
|      63859 | Young     | NULL      |
|      64055 | Barnes    | NULL      |
|      64063 | Coleman   | NULL      |
|      65044 | Hill      | NULL      |
|      65441 | Thompson  | NULL      |
|      66386 | Henderson | NULL      |
|      66418 | Adams     | NULL      |
|      66744 | Edwards   | NULL      |
|      67384 | Brooks    | NULL      |
|      69101 | Perez     | NULL      |
|      69256 | Thomas    | NULL      |
|      72583 | Brown     | NULL      |
|      73386 | Jones     | NULL      |
|      73562 | Stewart   | NULL      |
|      73925 | Powell    | NULL      |
|      75671 | Jones     | NULL      |
|      76786 | Hernandez | NULL      |
|      77100 | Alexander | NULL      |
|      78477 | Gray      | NULL      |
|      79601 | Sanders   | NULL      |
|      80315 | Turner    | NULL      |
|      80321 | Kelly     | NULL      |
|      81108 | Jones     | NULL      |
|      81263 | Cooper    | NULL      |
|      81495 | Wilson    | NULL      |
|      82244 | Wright    | NULL      |
|      82333 | Smith     | NULL      |
|      82464 | Hayes     | NULL      |
|      83038 | Taylor    | NULL      |
|      83620 | Clark     | NULL      |
|      84873 | Parker    | NULL      |
|      85587 | Mitchell  | NULL      |
|      85981 | Collins   | NULL      |
|      86357 | Evans     | NULL      |
|      86858 | Alexander | NULL      |
|      87013 | Peterson  | NULL      |
|      87416 | Griffin   | NULL      |
|      87822 | Long      | NULL      |
|      87978 | ;nzalez   | NULL      |
|      88164 | Parker    | NULL      |
|      88375 | Mitchell  | NULL      |
|      89197 | Anderson  | NULL      |
|      89902 | ;nzalez   | NULL      |
|      90534 | Murphy    | NULL      |
|      90649 | Morgan    | NULL      |
|      90667 | Murphy    | NULL      |
|      90798 | Wilson    | NULL      |
|      91349 | Sanders   | NULL      |
|      91672 | Green     | NULL      |
|      92389 | Ross      | NULL      |
|      93300 | Johnson   | NULL      |
|      93791 | Scott     | NULL      |
|      93995 | Morris    | NULL      |
|      96475 | Nelson    | NULL      |
|      96712 | Powell    | NULL      |
|      97121 | Martinez  | NULL      |
|      97216 | Collins   | NULL      |
|      98826 | Adams     | NULL      |
|      98923 | Reed      | NULL      |
|      99537 | Hernandez | NULL      |
+------------+-----------+-----------+

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

Result:

+-------+-----------+-----------+--------+
| sin   | firstName | lastName  | salary |
+-------+-----------+-----------+--------+
| 99537 | Deborah   | Hernandez |  90211 |
+-------+-----------+-----------+--------+

-- Question 12
-- Sum of the employee salaries (a single number) at the Latveria branch.

SELECT SUM(e.salary) as Sum_of_salaries_at_Latveria
FROM Employee e
JOIN Branch b
On e.branchNumber = b.branchNumber
WHERE b.branchName = "Latveria";

Result:
+-----------------------------+
| Sum_of_salaries_at_Latveria |
+-----------------------------+
|                      729865 |
+-----------------------------+

-- Question 13
-- Count of the number of different first names of employees 
-- working at the London branch 
-- and a count of the number of employees working at the London branch 
-- (two numbers in a single row).

SELECT count(distinct e.firstName) as count_of_unique_employee_firstName, 
count(e.firstName) as count_of__employee_firstName
FROM Employee e
JOIN Branch b
ON e.branchNumber = b.branchNumber
WHERE b.branchName = "London";

Result:

+------------------------------------+------------------------------+
| count_of_unique_employee_firstName | count_of__employee_firstName |
+------------------------------------+------------------------------+
|                                 20 |                           22 |
+------------------------------------+------------------------------+


-- Question 14
-- Branch name, and minimum, maximum and average salary of the employees 
-- at each branch, order by branch name.

SELECT b.branchName, MIN(salary), MAX(salary), AVG(salary)
FROM Employee e
JOIN Branch b
WHERE e.branchNumber = b.branchNumber
GROUP BY b.branchName
ORDER BY b.branchName;

Result:

+------------+-------------+-------------+-------------+
| branchName | MIN(salary) | MAX(salary) | AVG(salary) |
+------------+-------------+-------------+-------------+
| Berlin     |        3349 |       90211 |  34714.8125 |
| Latveria   |        9491 |       98773 |  56143.4615 |
| London     |       13950 |       99289 |  50298.0000 |
| Moscow     |       12525 |       71284 |  49065.7143 |
| New York   |       10953 |       94974 |  48649.9048 |
+------------+-------------+-------------+-------------+

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

Result:

+------------+-------------+-----------+-----------------------+
| customerID | firstName   | lastName  | branch_distinct_count |
+------------+-------------+-----------+-----------------------+
|      10839 | Amy         | Hayes     |                     2 |
|      11790 | Benjamin    | Green     |                     2 |
|      13230 | Marie       | Brooks    |                     2 |
|      13423 | Norma       | Simmons   |                     2 |
|      13697 | Charles     | Hill      |                     3 |
|      13874 | Jimmy       | Cooper    |                     3 |
|      14295 | Anne        | Ramirez   |                     2 |
|      16837 | Stephen     | Hughes    |                     2 |
|      18166 | Ruby        | Barnes    |                     2 |
|      19308 | Mildred     | Reed      |                     2 |
|      22050 | Helen       | Sanchez   |                     2 |
|      25052 | Jack        | Anderson  |                     3 |
|      25159 | Shirley     | Brooks    |                     2 |
|      27004 | Steven      | Johnson   |                     3 |
|      27954 | Diana       | ;nzales   |                     3 |
|      28453 | Margaret    | White     |                     2 |
|      29474 | Amanda      | White     |                     3 |
|      30525 | Helen       | Carter    |                     3 |
|      30622 | Harry       | Murphy    |                     2 |
|      30807 | Roy         | Morris    |                     3 |
|      33133 | Henry       | Barnes    |                     3 |
|      33726 | Jerry       | Cook      |                     2 |
|      33850 | Henry       | Ward      |                     2 |
|      33913 | Ronald      | Bell      |                     2 |
|      34069 | Earl        | Lee       |                     2 |
|      35059 | Larry       | Murphy    |                     3 |
|      35780 | Harold      | Young     |                     2 |
|      37716 | Annie       | Scott     |                     2 |
|      38351 | Victor      | Perez     |                     3 |
|      38861 | Gerald      | James     |                     3 |
|      41545 | Terry       | Bailey    |                     3 |
|      44065 | Benjamin    | Ramirez   |                     2 |
|      44459 | Gerald      | Watson    |                     2 |
|      44922 | Dennis      | Flores    |                     4 |
|      46058 | Adam        | Rivera    |                     2 |
|      46630 | Billy       | Coleman   |                     2 |
|      47953 | Frank       | Martinez  |                     3 |
|      49747 | Philip      | Brooks    |                     2 |
|      50742 | Louise      | Wilson    |                     3 |
|      51850 | Victor      | Doom      |                     3 |
|      52189 | Shawn       | Sanders   |                     3 |
|      52622 | Maria       | Morgan    |                     2 |
|      57796 | Ernest      | Adams     |                     2 |
|      59366 | Susan       | Smith     |                     2 |
|      61976 | Wanda       | Parker    |                     3 |
|      62312 | Phyllis     | Lopez     |                     4 |
|      63772 | Mary        | Powell    |                     2 |
|      63859 | Maria       | Young     |                     2 |
|      64063 | Mark        | Coleman   |                     2 |
|      65044 | Deborah     | Hill      |                     2 |
|      65441 | Arthur      | Thompson  |                     4 |
|      66386 | Chris       | Henderson |                     2 |
|      66418 | Stephanie   | Adams     |                     2 |
|      67384 | Lawrence    | Brooks    |                     3 |
|      69101 | Ernest      | Perez     |                     2 |
|      69256 | Jacqueline  | Thomas    |                     3 |
|      73386 | Arthur      | Jones     |                     4 |
|      73925 | Doris       | Powell    |                     3 |
|      75671 | Billy       | Jones     |                     2 |
|      77100 | Laura       | Alexander |                     2 |
|      78477 | Brian       | Gray      |                     2 |
|      79601 | Joe         | Sanders   |                     2 |
|      80315 | Roger       | Turner    |                     2 |
|      80321 | Kimberly    | Kelly     |                     2 |
|      81108 | Willie      | Jones     |                     3 |
|      81263 | Anna        | Cooper    |                     3 |
|      82244 | Douglas     | Wright    |                     2 |
|      82333 | Charles     | Smith     |                     3 |
|      83620 | Carlos      | Clark     |                     2 |
|      84873 | Cheryl      | Parker    |                     3 |
|      85587 | Justin      | Mitchell  |                     2 |
|      86357 | Andrew      | Evans     |                     2 |
|      87822 | Dennis      | Long      |                     3 |
|      87978 | Christopher | ;nzalez   |                     3 |
|      88164 | Jimmy       | Parker    |                     2 |
|      88375 | Randy       | Mitchell  |                     3 |
|      89197 | Lawrence    | Anderson  |                     3 |
|      89902 | Joe         | ;nzalez   |                     3 |
|      90649 | Helen       | Morgan    |                     3 |
|      90667 | Carl        | Murphy    |                     4 |
|      90798 | Aaron       | Wilson    |                     2 |
|      91520 | Keith       | Rivera    |                     2 |
|      91672 | Edward      | Green     |                     2 |
|      92389 | Amy         | Ross      |                     4 |
|      93300 | Bonnie      | Johnson   |                     3 |
|      93791 | Evelyn      | Scott     |                     2 |
|      93995 | Kevin       | Morris    |                     3 |
|      96712 | Kimberly    | Powell    |                     2 |
|      98923 | Dennis      | Reed      |                     2 |
|      99537 | Deborah     | Hernandez |                     3 |
+------------+-------------+-----------+-----------------------+

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

Result (please also see the not below the result):

+----------------------+------------------------+
| income_from_50_older | income_from_50_younger |
+----------------------+------------------------+
|                 1500 |      6.666666666666667 |
+----------------------+------------------------+

** Please note that in the original data, all customer's birth are null.
** This SQL is done with the following set of mock data:
+------------+-----------+-----------+--------+------------+
| customerID | firstName | lastName  | income | birthDate  |
+------------+-----------+-----------+--------+------------+
|          1 | Johnson   | Johnson   |   2000 | 1950-07-30 |
|          2 | Aaron     | something |   1000 | 1950-07-23 |
|          3 | Eggy      | Leung     |     10 | 2021-07-08 |
|          4 | abba      | alice     |     10 | 2021-07-07 |
|          8 | Adam      | Rivera    |      0 | 2021-08-06 |
+------------+-----------+-----------+--------+------------+

-- Question 17
-- Customer ID, last name, first name, income, and average account balance of customers 
-- who have at least three accounts, 
-- and whose last names begin with Jo and contain an s (e.g. Johnson) 
-- or whose first names begin with A and have a vowel as the letter just before the last letter (e.g. Aaron), 
-- order by customer ID. 
-- Note that this will be much easier if you look up LIKE wildcards in the MSDN T-SQL documentation. 
-- Also note - to appear in the result customers must have at least three accounts 
-- and satisfy one (or both) of the name conditions.

select Customer.CustomerID,firstName,lastName, income,avg(balance) Avgbalance from Customer
join Owns on Customer.CustomerID=Owns.CustomerID
join Account on Account.accNumber=Owns.accNumber 
join Branch on Branch.branchNumber=Account.branchNumber
where firstname like 'Jo%' or (firstname like 'A%' and firstname like '[aeiou]$')
group by Customer.CustomerID,firstName,lastName,income having count(Account.accNumber)>2
order by Customer.CustomerID;

Result:
+------------+-----------+----------+--------+--------------+
| CustomerID | firstName | lastName | income | Avgbalance   |
+------------+-----------+----------+--------+--------------+
|      79601 | Joe       | Sanders  |  95144 | 58843.438000 |
|      89902 | Joe       | ;nzalez  |  89692 | 84306.130000 |
+------------+-----------+----------+--------+--------------+

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

Result:
+-----------+-----------+-------+---------------------+---------------------------------+
| accNumber | balance   | count | transaction_amounts | balance_transactions_difference |
+-----------+-----------+-------+---------------------+---------------------------------+
|       167 |  20965.26 |    14 |            41930.52 |                       -20965.26 |
|        95 |  22741.92 |    18 |            45483.84 |                       -22741.92 |
|        46 |  30235.92 |    13 |            30235.92 |                            0.00 |
|       152 |  31858.67 |    10 |            31858.67 |                            0.00 |
|        70 |  33716.29 |    10 |            33716.29 |                            0.00 |
|        96 |  37055.15 |    12 |            37055.15 |                            0.00 |
|        53 |  49101.06 |    11 |            49101.06 |                            0.00 |
|       153 |  50791.28 |    10 |            50791.28 |                            0.00 |
|        60 |  53485.04 |    20 |           106970.08 |                       -53485.04 |
|        63 |  57035.26 |    18 |           171105.78 |                      -114070.52 |
|        72 |  59597.18 |    12 |            59597.18 |                            0.00 |
|        48 |  63416.35 |    18 |           126832.70 |                       -63416.35 |
|       154 |  66605.48 |    12 |            66605.48 |                            0.00 |
|        74 |  70301.55 |    12 |            70301.55 |                            0.00 |
|       157 |  73162.44 |    20 |           146324.88 |                       -73162.44 |
|       150 |  77477.04 |    19 |            77477.04 |                            0.00 |
|        57 |  82512.57 |    27 |           247537.71 |                      -165025.14 |
|       160 |  87925.09 |    11 |            87925.09 |                            0.00 |
|       146 |  95876.24 |    22 |           191752.48 |                       -95876.24 |
|        56 |  97555.21 |    14 |           195110.42 |                       -97555.21 |
|       148 | 100187.85 |    13 |           100187.85 |                            0.00 |
|       165 | 108042.83 |    10 |           108042.83 |                            0.00 |
|        59 | 112534.31 |    15 |           112534.31 |                            0.00 |
|       147 | 114094.94 |    13 |           114094.94 |                            0.00 |
+-----------+-----------+-------+---------------------+---------------------------------+


-- Question 19
-- Branch name, account type, 
-- and average transaction amount of each account type for each branch 
-- for branches that have at least 50 accounts of any type, 
-- order by branch name, then account type.

SELECT b.branchName,a.type, avg(t.amount)
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

Result:

+------------+------+---------------+
| branchName | type | avg(t.amount) |
+------------+------+---------------+
| Berlin     | BUS  |   6735.927765 |
| Berlin     | CHQ  |   7322.434752 |
| Berlin     | SAV  |   6501.198357 |
| Latveria   | BUS  |   6323.264077 |
| Latveria   | CHQ  |   6950.850577 |
| Latveria   | SAV  |   6925.273671 |
| London     | BUS  |   9334.790549 |
| London     | CHQ  |   8947.788655 |
| London     | SAV  |   8281.662727 |
| Moscow     | BUS  |   6534.426842 |
| Moscow     | CHQ  |   6754.225000 |
| Moscow     | SAV  |   5855.061974 |
| New York   | BUS  |   7533.197089 |
| New York   | CHQ  |   7541.038227 |
| New York   | SAV  |   5932.801875 |
+------------+------+---------------+


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

Result:

+------------+------+-----------+-------------+-----------+
| branchName | type | accNumber | transNumber | amount    |
+------------+------+-----------+-------------+-----------+
| London     | SAV  |       121 |           1 |  98101.36 |
| London     | SAV  |       121 |           2 |   -524.42 |
| London     | SAV  |       121 |           3 |   3372.65 |
| London     | SAV  |       121 |           4 |   3304.11 |
| London     | SAV  |       121 |           5 |   -740.92 |
| New York   | CHQ  |       158 |           1 |  84961.78 |
| New York   | CHQ  |       158 |           2 |    232.45 |
| New York   | CHQ  |       158 |           3 |  -1212.29 |
| Latveria   | CHQ  |       206 |           1 |  80371.46 |
| Latveria   | CHQ  |       206 |           2 |   3639.13 |
| Latveria   | CHQ  |       206 |           3 |   -196.50 |
| London     | CHQ  |        13 |           1 | 108440.20 |
| London     | CHQ  |        13 |           2 |   1770.56 |
| London     | CHQ  |        13 |           3 |   2587.99 |
| London     | CHQ  |        13 |           4 |   -292.91 |
| New York   | BUS  |       151 |           1 |  84601.10 |
| New York   | BUS  |       151 |           2 |  -1603.48 |
| New York   | BUS  |       151 |           3 |   -790.56 |
| London     | BUS  |        18 |           1 | 103802.18 |
| London     | BUS  |        18 |           2 |   1588.38 |
| London     | BUS  |        18 |           3 |  -1161.43 |
| London     | BUS  |        18 |           4 |   -649.44 |
+------------+------+-----------+-------------+-----------+