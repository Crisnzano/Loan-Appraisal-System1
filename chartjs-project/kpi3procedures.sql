-- KPI1a: Top 5 selling products of the year

DROP PROCEDURE IF EXISTS `LoanPlanbyRepaymentAmount`;
DELIMITER $$
CREATE PROCEDURE `LoanPlanbyRepaymentAmount`(IN currentYear INT)
BEGIN
SELECT 
    ROW_NUMBER() OVER (
          -- PARTITION BY `products`.`productLine`
          ORDER BY SUM(`monthly_repayment_amount`) DESC) row_num,
    `loan_repayment`.`planID`,
    `loan_plan`.`interest_percentage`,
    `loan_plan`.`loan_tenure`,
    `loan_plan`.`penalty_rate`,
    `loan_repayment`.`monthly_repayment_amount`,
    COUNT(`loan_plan`.`planID`) AS countPlanID,
    SUM(`monthly_repayment_amount`) AS sumRepaymentAmount,
    CONCAT(
            `loan_plan`.`planID`, ": ", `loan_plan`.`interest_percentage`,": ",`loan_repayment`.`monthly_repayment_amount`) AS fullPlanDetails,
    SUM(`monthly_repayment_amount`) AS sumRepaymentEach
FROM
    `loan_plan`
        INNER JOIN
    `loan_repayment` ON `loan_repayment`.`planID` = `loan_plan`.`planID`
WHERE
    YEAR(`loan_repayment`.`repayment_start_date`) = 2022
        AND (`loan_repayment`.`penalty_amount` = '0')
    
GROUP BY `loan_plan`.`planID`
ORDER BY SUM(`monthly_repayment_amount`) DESC
LIMIT 0 , 5;
END$$
DELIMITER ;

-- Execute as: 
CALL `LoanPlanbyRepaymentAmount`(2022);


-- KPI 1b: Year-on-Year Sales Revenue per Month

DROP PROCEDURE IF EXISTS `DepositVsGoal`;

DELIMITER $$
CREATE PROCEDURE `DepositVsGoal`(IN currentYear INT)
BEGIN
SELECT 
    YEAR(`loans`.`application_date`) AS 'applicationYear',
    MONTHNAME(`loans`.`application_date`) AS 'applicationMonth',
    SUM(`loan_repayment`.`monthly_repayment_amount`) AS 'expenseRevenue'
FROM
    `loans`
    INNER JOIN
    `loan_repayment` ON `loans`.`planID` = `loan_repayment`.`planID`
WHERE
    YEAR(`loan_repayment`.`repayment_start_date`) = 2022
        AND (`loans`.`loan_status` = '0'
        OR `loans`.`loan_status` = '2')

GROUP BY MONTHNAME(`loan_repayment`.`repayment_start_date`) , YEAR(`loan_repayment`.`repayment_start_date`)
ORDER BY YEAR(`loan_repayment`.`repayment_start_date`) , MONTH(`loan_repayment`.`repayment_start_date`);
END$$
DELIMITER ;

-- Execute as: 
 CALL `DepositVsGoal`(2022);