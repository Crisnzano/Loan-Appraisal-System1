-- KPI2a: Top 5 selling products of the year



DELIMITER $$
CREATE PROCEDURE `TopPerformingLoanType`(IN currentYear INT)
BEGIN
SELECT 
    ROW_NUMBER() OVER (
          -- PARTITION BY `products`.`productLine`
          ORDER BY SUM(`loan_typeID`) DESC) row_num,
    `loans`.`loan_status`,
    `loan_types`.`type_name`,
    `loans`.`loan_amount`,
    `loans`.`loan_type_id`,
    `loan_repayment`.`monthly_repayment_amount`,
    COUNT(`loan_types`.`loan_typeID`) AS countTypeID,
    SUM(`monthly_repayment_amount`) AS sumRepaymentAmount,
    CONCAT(
            `loans`.`loan_type_id`, ": ", `loan_types`.`type_name`) AS fullTypeDetails,
    SUM(`monthly_repayment_amount`) AS sumRepaymentEach
FROM
    `loans`
        INNER JOIN
    `loan_types` ON `loans`.`loan_type_id` = `loan_types`.`loan_typeID`
    INNER JOIN
    `loan_repayment` ON `loan_repayment`.`monthly_repayment_amount`

      
WHERE
    YEAR(`loans`.`application_date`) = currentYear
        AND (`loans`.`loan_status` = '0'
        OR `loans`.`loan_status` = '2')
GROUP BY `loans`.`loanID`
ORDER BY SUM(`loan_amount`) DESC
LIMIT 0 , 5;
END$$
DELIMITER ;

-- Execute as: 
CALL `TopPerformingLoanType`(2022);


-- KPI 2b: Year-on-Year Sales Revenue per Month

DROP PROCEDURE IF EXISTS `ProfitTrend`;

DELIMITER $$
CREATE PROCEDURE `ProfitTrend`(IN currentYear INT)
BEGIN
SELECT 
    COUNT(`loan_repayment`.`monthly_repayment_amount`) AS 'RepaymentID',
    YEAR(`loan_repayment`.`repayment_start_date`) AS 'paymentYear',
    MONTHNAME(`loan_repayment`.`repayment_start_date`) AS 'paymentMonth',
    SUM(`loan_repayment`.`monthly_repayment_amount`) AS 'salesRevenue'
FROM
    `loan_repayment`
WHERE
    YEAR(`loan_repayment`.`repayment_start_date`) IN (currentYear)

GROUP BY MONTHNAME(`loan_repayment`.`repayment_start_date`) , YEAR(`loan_repayment`.`repayment_start_date`)
ORDER BY YEAR(`loan_repayment`.`repayment_start_date`) , MONTH(`loan_repayment`.`repayment_start_date`);
END$$
DELIMITER ;

-- Execute as: 
 CALL `ProfitTrend`(2022);