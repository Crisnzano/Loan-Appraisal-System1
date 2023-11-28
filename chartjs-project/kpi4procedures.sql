-- KPI1a: Top 5 selling products of the year


DELIMITER $$
CREATE PROCEDURE `ExpensesVsRevenue`(IN currentYear INT)
BEGIN
SELECT 
    ROW_NUMBER() OVER (
          -- PARTITION BY `products`.`productLine`
          ORDER BY SUM(`loan_amount`) DESC) row_num,
    `loans`.`planID`,
    `loan_repayment`.`monthly_repayment_amount`,
    COUNT(`loans`.`planID`) AS countPlanID,
    SUM(`monthly_repayment_amount`) AS sumRepaymentAmount,
    CONCAT(
            `loans`.`loan_amount`, ": ", `loan_repayment`.`monthly_repayment_amount`) AS fullPlanDetails,
    SUM(`loan_amount`) AS sumExpenseEach
FROM
    `loans`
        INNER JOIN
    `loan_repayment` ON `loan_repayment`.`loanID` = `loans`.`loanID`
WHERE
    YEAR(`loan_repayment`.`repayment_start_date`) = currentYear
        AND (`loans`.`loan_status` = '0'
        OR `loans`.`loan_status` = '2')
GROUP BY `loans`.`loanID`
ORDER BY SUM(`loan_amount`) DESC
LIMIT 0 , 5;
END$$
DELIMITER ;

-- Execute as: 
CALL `ExpensesVsRevenue`(2023);


-- KPI 1b: Year-on-Year Sales Revenue per Month

DROP PROCEDURE IF EXISTS `ExpectedLossPerMonth`;

DELIMITER $$
CREATE PROCEDURE `ExpectedLossPerMonth`(IN currentYear INT)
BEGIN
SELECT 
    YEAR(`loans`.`application_date`) AS 'paymentYear',
    MONTHNAME(`loans`.`application_date`) AS 'paymentMonth',
    SUM(`loans`.`loan_amount`) AS 'salesRevenue'
FROM
    `loans`
WHERE
    YEAR(`loans`.`application_date`) IN (currentYear , currentYear - 1)
GROUP BY MONTHNAME(`loans`.`application_date`) , YEAR(`loans`.`application_date`)
ORDER BY YEAR(`loans`.`application_date`) , MONTH(`loans`.`application_date`);
END$$
DELIMITER ;

-- Execute as: 
 CALL `ExpectedLossPerMonth`(2023);