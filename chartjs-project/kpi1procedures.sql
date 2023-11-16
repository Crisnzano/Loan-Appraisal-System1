-- KPI1a: Top 5 selling products of the year

DROP PROCEDURE IF EXISTS `Top5LoanPlansofTheYear`;

DELIMITER $$
CREATE PROCEDURE `Top5LoanPlansofTheYear`(IN currentYear INT)
BEGIN
SELECT 
    ROW_NUMBER() OVER (
          -- PARTITION BY `products`.`productLine`
          ORDER BY SUM(`loan_amount`) DESC) row_num,
    `loans`.`planID`,
    `loan_plan`.`interest_percentage`,
    `loan_plan`.`loan_tenure`,
    `loan_plan`.`penalty_rate`,
    `loan_repayment`.`monthly_repayment_amount`,
    COUNT(`loans`.`planID`) AS countPlanID,
    SUM(`monthly_repayment_amount`) AS sumRepaymentAmount,
    CONCAT(
            `loans`.`planID`, ": ", `loan_plan`.`interest_percentage`) AS fullPlanDetails,
    SUM(`monthly_repayment_amount`) AS sumRepaymentEach
FROM
    `loans`
        INNER JOIN
    `loan_plan` ON `loans`.`planID` = `loan_plan`.`planID`
        INNER JOIN
    `loan_repayment` ON `loan_repayment`.`planID` = `loans`.`planID`
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
CALL `Top5LoanPlansofTheYear`(2022);


-- KPI 1b: Year-on-Year Sales Revenue per Month

DROP PROCEDURE IF EXISTS `ExpectedProfitPerMonth`;

DELIMITER $$
CREATE PROCEDURE `ExpectedProfitPerMonth`(IN currentYear INT)
BEGIN
SELECT 
    YEAR(`loan_repayment`.`repayment_start_date`) AS 'paymentYear',
    MONTHNAME(`loan_repayment`.`repayment_start_date`) AS 'paymentMonth',
    SUM(`loan_repayment`.`monthly_repayment_amount`) AS 'salesRevenue'
FROM
    `loan_repayment`
WHERE
    YEAR(`loan_repayment`.`repayment_start_date`) IN (currentYear , currentYear - 1)
GROUP BY MONTHNAME(`loan_repayment`.`repayment_start_date`) , YEAR(`loan_repayment`.`repayment_start_date`)
ORDER BY YEAR(`loan_repayment`.`repayment_start_date`) , MONTH(`loan_repayment`.`repayment_start_date`);
END$$
DELIMITER ;

-- Execute as: 
 CALL `ExpectedProfitPerMonth`(2022);