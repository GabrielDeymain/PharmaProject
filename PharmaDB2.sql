USE pharmacy_portal_db;
DELIMITER //

CREATE PROCEDURE AddOrUpdateUser(
    IN p_id INT,
    IN p_username VARCHAR(255),
    IN p_contactInfo VARCHAR(255),
    IN p_userType VARCHAR(50)
)
BEGIN
    DECLARE userExists INT;


    SELECT COUNT(*) INTO userExists FROM users WHERE id = p_id;

    IF userExists > 0 THEN
        
        UPDATE users 
        SET username = p_username, contactInfo = p_contactInfo, userType = p_userType 
        WHERE id = p_id;
    ELSE
        
        INSERT INTO Users (username, contactInfo, userType) 
        VALUES (p_username, p_contactInfo, p_userType);
    END IF;
END //

DELIMITER ;

DELIMITER //

DELIMITER //

CREATE PROCEDURE ProcessSale(
    IN p_prescriptionId INT,
    IN p_medicationId INT,
    IN p_quantitySold INT
)
BEGIN
    DECLARE available_quantity INT;
    DECLARE unit_price DECIMAL(10,2);
    DECLARE total_amount DECIMAL(10,2);

    
    SELECT quantity, price INTO available_quantity, unit_price
    FROM medications
    WHERE id = p_medicationId;

    
    IF available_quantity >= p_quantitySold THEN
        
        SET total_amount = unit_price * p_quantitySold;

        
        UPDATE medications
        SET quantity = quantity - p_quantitySold
        WHERE id = p_medicationId;

        
        INSERT INTO sales (prescriptionId, saleDate, quantitySold, saleAmount)
        VALUES (p_prescriptionId, NOW(), p_quantitySold, total_amount);
    ELSE
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Insufficient stock for sale!';
    END IF;
END //

DELIMITER ;