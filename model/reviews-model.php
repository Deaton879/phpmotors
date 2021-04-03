<?php 
    // reviews model


    // This function will insert a review
    
    function addNewReview($reviewText, $invId, $clientId) {
        // Create a connection object using the phpmotors connection function
        $db = phpmotorsConnect();
        // The SQL statement
        $sql = 'INSERT INTO reviews (reviewText, invId, clientId)
            VALUES (:reviewText, :invId, :clientId)';
        // Create the prepared statement using the phpmotors connection
        $stmt = $db->prepare($sql);
        // The next nine lines replace the placeholders in the SQL
        // statement with the actual values in the variables
        // and tells the database the type of data it is
        $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
        $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
        $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
        // Insert the data
        $stmt->execute();
        // Ask how many rows changed as a result of our insert
        $rowsChanged = $stmt->rowCount();
        // Close the database interaction
        $stmt->closeCursor();
        // Return the indication of success (rows changed)
        return $rowsChanged;
    }
    
    // This function will get reviews for a specific inventory item

    function getReviewsByInventoryId($invId) {
        $db = phpmotorsConnect();
        $sql = 'SELECT * FROM reviews 
                WHERE invId = :invId';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
        $stmt->execute();
        $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $reviews;
    }

    // This function will get reviews written by a specific client

    function getAllReviews($clientId){
        $db = phpmotorsConnect();
        $sql = 'SELECT * FROM reviews WHERE clientId = :clientId';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
        $stmt->execute();
        $oldReviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $oldReviews;
    }

    // This function will get the components to build a screen name
    
    function buildScreenName($clientId){
        $db = phpmotorsConnect();
        $sql = 'SELECT clientFirstname, clientLastname FROM clients WHERE clientId = :clientId';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':clientId', $clientId, PDO::PARAM_STR);
        $stmt->execute();
        $fullName = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $fullName;
    }

    // This function will get a specific review

    

    // This function will update a specific review

    function updateReview($reviewText, $reviewId) {
        // Create a connection object using the phpmotors connection function
        $db = phpmotorsConnect();
        // The SQL statement
        $sql = 'UPDATE reviews SET reviewText = :reviewText WHERE reviewId = :reviewId';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
        $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
        // Insert the data
        $stmt->execute();
        // Ask how many rows changed as a result of our insert
        $rowsChanged = $stmt->rowCount();
        // Close the database interaction
        $stmt->closeCursor();
        // Return the indication of success (rows changed)
        return $rowsChanged;
    }

    // This function will delete a specific review

    function deleteReview($reviewId) {
        $db = phpmotorsConnect();
        $sql = 'DELETE FROM reviews WHERE reviewId = :reviewId';
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
        $stmt->execute();
        $rowsChanged = $stmt->rowCount();
        $stmt->closeCursor();
        return $rowsChanged;
    }

?>