<?php 


function checkEmail($clientEmail) {
    $valEmail = filter_var($clientEmail, FILTER_SANITIZE_EMAIL);
    return $valEmail;
}

// Check the password for a minimum of 8 characters,
// at least one 1 capital letter, at least 1 number and
// at least 1 special character
function checkPassword($clientPassword){
    $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]])(?=.*[A-Z])(?=.*[a-z])([^\s]){8,}$/';
    return preg_match($pattern, $clientPassword);
}

// Build the Navigation list using the classification information
function buildNav($classifications) {
    // Create the navigation bar
    $navList = '<ul>';
    $navList .= "<li><a href='/phpmotors/' title='View the PHP Motors home page'>Home</a></li>";

    foreach ($classifications as $classification) {
        $navList .= "<li><a href='/phpmotors/vehicles/?action=classification&classificationName=" . urlencode($classification['classificationName']) . "' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
    }
    $navList .= '</ul>';

    return $navList;
}

// Build the classifications select list 
function buildClassificationList($classifications){ 
    $classificationList = '<select name="classificationId" id="classificationList">'; 
    $classificationList .= "<option>Choose a Classification</option>"; 
    foreach ($classifications as $classification) { 
        $classificationList .= "<option value='$classification[classificationId]'>$classification[classificationName]</option>"; 
    } 
    $classificationList .= '</select>'; 
    return $classificationList; 
}


// Get vehicles by classificationId 
function getInventoryByClassification($classificationId){ 
    $db = phpmotorsConnect(); 
    $sql = ' SELECT * FROM inventory WHERE classificationId = :classificationId'; 
    $stmt = $db->prepare($sql); 
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT); 
    $stmt->execute(); 
    $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    $stmt->closeCursor(); 
    return $inventory; 
}

function buildVehicleDisplay($vehicles, $class) {
    $dv = '<ul id="inv-display">';
    
    foreach ($vehicles as $vehicle) {
        $price = number_format($vehicle['invPrice'], 2, '.',',');
        $dv .= '<li>';
        $dv .= "<div class='thumbContainer'>
                <a href='/phpmotors/vehicles?action=inv-display&invId=$vehicle[invId]'>
                <img class='carThumb' src='$vehicle[imgPath]' alt='Image of $vehicle[invMake] $vehicle[invModel] on phpmotors.com'>
                </a>
                </div>";
        $dv .= '<hr>';
        $dv .= "<span><a href='/phpmotors/vehicles?action=inv-display&invId=$vehicle[invId]'>$vehicle[invMake] $vehicle[invModel]</a></span>";
        $dv .= "<span>$$price</span>";
        $dv .= '</li>';
    }
    $dv .= '</ul>';
    return $dv;
}

function buildVehicleDetails($carId, $class, $thumbnails, $reviews, $screenNames) {
    $price = number_format($carId['invPrice'], 2, '.',',');
    $dv = "<div class='form'><h2>$carId[invMake] $carId[invModel] </h2><a href='#reviewsContainer' id='reviewLink' title='Go to customer reviews'>Customer Reviews</a>";
    $dv .= "<div class='imgContainer'>
            <ul class='thumbnailList'>";
    
    // Build the vehicle thumbnails to left of main image for views larger than mobile
    foreach ($thumbnails as $thumbImage) {
        $dv .= '<li>';
        $dv .= "<img class='thumbCarList' src='$thumbImage[imgPath]' alt='Image of $thumbImage[imgName] on phpmotors.com'>"; 
        $dv .= '</li>'; 
    }

    // Build the main vehicle information
    $dv .= "</ul>
            <img class='carImg' src='$carId[invImage]' alt='image of $carId[invMake] $carId[invModel] on phpmotors.com'>
            </div>";
    $dv .= "<h3 class='price'>Price: $$price </h3>";
    $dv .= "<hr>";
    $dv .= "<div class='description'><p><b>Car Type:</b> $class </p>";
    if ($carId['invDescription']) {
        $dv .= "<p><b>Description:</b> $carId[invDescription] </p>";
    }
    $dv .= "<p><b>Stock:</b> $carId[invStock] </p>";
    $dv .= "<p><b>Color:</b> $carId[invColor] </p></div></div><hr>";

    // Build the thumbnail gallery for the bottom. If mobile view, then this will be displayed, otherwise, will not.
    $dv .= "<div id='thumbGallery'><h3 id='thumbHeading'>Gallery</h3><br><br>
            <ul class='thumbnailList-bottom'>";

    foreach ($thumbnails as $thumbImage) {
        $dv .= '<li>';
        $dv .= "<img class='thumbCarList' src='$thumbImage[imgPath]' alt='Image of $thumbImage[imgName] on phpmotors.com'>"; 
        $dv .= '</li>'; 
    }
    $dv .= "</ul></div>";
    $dv .= "<br><div id='reviewsContainer'><h3 class='reviewsHeader'>Customer Reviews</h3><br>";

    // Build the review container, if logged in, 
    if($_SESSION['loggedin']) {
        $screenName = substr($_SESSION['clientData']['clientFirstname'], 0,1) . $_SESSION['clientData']['clientLastname'];
        $dv .= '<br>
                <h3> Review the ' . $carId['invMake'] . ' ' . $carId['invModel'] . '</h3>
                <br>
                <form action="/phpmotors/reviews/index.php" method="POST">
                    <label for="screenName">Screen Name:</label><br>
                    <input type="text" name="screenName" id="screenName" value="' . $screenName . '" readonly><br>
                    <label for="reviewText">Review:</label><br>
                    <textarea name="reviewText" id="reviewText" cols="100" rows="8" required></textarea><br><br>
                    <input type="submit" name="submit" value="Post Review">
                    <input type="hidden" name="invId" value="' . $carId['invId'] . '">
                    <input type="hidden" name="clientId" value="' . $_SESSION["clientData"]["clientId"] . '">
                    <!-- Add the action name - value pair -->
                    <input type="hidden" name="action" value="addReview">
                </form>
                <br>';
        
    } else {
        $dv .= '<br>
                    <h3> Review the ' . $carId['invMake'] . ' ' . $carId['invModel'] . '</h3>
                    <br><p>You must <a href="/phpmotors/accounts?action=login" title="Login or Register with PHP Motors">login</a> to write a review.</p><br>';
    }

    if (!count($reviews)) {
        $dv .= '<br><h4>Be the first to write a review.</h4>';
    }
    else {
        
        $dv .= '<br><div class="oldReview"><hr><h3>What others had to say..</h3>';
        $reverse = array_reverse($reviews);
        $i = count($reviews) -1;
        foreach($reverse as $review) { 
            $date = $review['reviewDate'];
            $date = date("j F\, Y");
            $oldScreenName = $screenNames[$i];
            $i --;
            $dv .= '<div class="reviewPost marginal"><b><i>' . $oldScreenName . '</i> wrote on ' . $date . ':</b> <br><p class="reviewText">' . $review["reviewText"] . '</p></div>'; 
        }            
        $dv .= '</div>'; 
    }
    
    $dv .= "</div><span id='bottomShortcut'><a href='#backToTop' title='Jump to top of page'>Back to top</a></span>";
    return $dv;

}
    
/* * ********************************
*  Functions for working with images
* ********************************* */

// Adds "-tn" designation to file name
/*function makeThumbnailName($image) {
    $i = strrpos($image, '.');
    $image_name = substr($image, 0, $i);
    $ext = substr($image, $i);
    $image = $image_name . '-tn' . $ext;
    return $image;
}*/

// Add "-tn" using a built-in function: pathInfo()
function makeThumbnailName($image) {
    $path_parts = pathInfo($image);
    $newpath = $path_parts["dirname"] .'/' . $path_parts["filename"] . '-tn.' . $path_parts["extension"];
    return $newpath;
}

// Build images display for image management view
function buildImageDisplay($imageArray) {
    $id = '<ul id="image-display">';
    foreach ($imageArray as $image) {
        $id .= '<li>';
        $id .= "<img src='$image[imgPath]' title='$image[invMake] $image[invModel] image on PHP Motors.com' alt='$image[invMake] $image[invModel] image on PHP Motors.com'>";
        $id .= "<p><a href='/phpmotors/uploads?action=delete&imgId=$image[imgId]&filename=$image[imgName]' title='Delete the image'>Delete $image[imgName]</a></p>";
        $id .= '</li>';
    }
    $id .= '</ul>';
    return $id;
}

// Build the vehicles select list
function buildVehiclesSelect($vehicles) {
    $prodList = '<select name="invId" id="invId">';
    $prodList .= "<option>Choose a Vehicle</option>";
    foreach ($vehicles as $vehicle) {
        $prodList .= "<option value='$vehicle[invId]'>$vehicle[invMake] $vehicle[invModel]</option>";
    }
    $prodList .= '</select>';
    return $prodList;
}

// Handles the file upload process and returns the path
// The file path is stored into the database
function uploadFile($name) {

    // Gets the paths, full and local directory
    global $image_dir, $image_dir_path;

    if (isset($_FILES[$name])) {

        // Gets the actual file name
        $filename = $_FILES[$name]['name'];

        if (empty($filename)) {
            return;
        }

        // Get the file from the temp folder on the server
        $source = $_FILES[$name]['tmp_name'];
        // Sets the new path - images folder in this directory
        $target = $image_dir_path . '/' . $filename;

        // Moves the file to the target folder
        move_uploaded_file($source, $target);
        // Send file for further processing
        processImage($image_dir_path, $filename);

        // Sets the path for the image for Database storage
        $filepath = $image_dir . '/' . $filename;

        // Returns the path where the file is stored
        return $filepath;

    }
}

// Processes images by getting paths and 
// creating smaller versions of the image
function processImage($dir, $filename) {
    // Set up the variables
    $dir = $dir . '/';
   
    // Set up the image path
    $image_path = $dir . $filename;
   
    // Set up the thumbnail image path
    $image_path_tn = $dir.makeThumbnailName($filename);
   
    // Create a thumbnail image that's a maximum of 200 pixels square
    resizeImage($image_path, $image_path_tn, 200, 200);
   
    // Resize original to a maximum of 500 pixels square
    resizeImage($image_path, $image_path, 500, 500);
}

// Checks and Resizes image
function resizeImage($old_image_path, $new_image_path, $max_width, $max_height) {
     
    // Get image type
    $image_info = getimagesize($old_image_path);
    $image_type = $image_info[2];
   
    // Set up the function names
    switch ($image_type) {

        case IMAGETYPE_JPEG:
            $image_from_file = 'imagecreatefromjpeg';
            $image_to_file = 'imagejpeg';
        break;

        case IMAGETYPE_GIF:
            $image_from_file = 'imagecreatefromgif';
            $image_to_file = 'imagegif';
        break;

        case IMAGETYPE_PNG:
            $image_from_file = 'imagecreatefrompng';
            $image_to_file = 'imagepng';
        break;

        default:
        return;

    } // ends the swith
   
    // Get the old image and its height and width
    $old_image = $image_from_file($old_image_path);
    $old_width = imagesx($old_image);
    $old_height = imagesy($old_image);
   
    // Calculate height and width ratios
    $width_ratio = $old_width / $max_width;
    $height_ratio = $old_height / $max_height;
   
    // If image is larger than specified ratio, create the new image
    if ($width_ratio > 1 || $height_ratio > 1) {
   
        // Calculate height and width for the new image
        $ratio = max($width_ratio, $height_ratio);
        $new_height = round($old_height / $ratio);
        $new_width = round($old_width / $ratio);

        // Create the new image
        $new_image = imagecreatetruecolor($new_width, $new_height);

        // Set transparency according to image type
        if ($image_type == IMAGETYPE_GIF) {
            $alpha = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
            imagecolortransparent($new_image, $alpha);
        }

        if ($image_type == IMAGETYPE_PNG || $image_type == IMAGETYPE_GIF) {
            imagealphablending($new_image, false);
            imagesavealpha($new_image, true);
        }
   
        // Copy old image to new image - this resizes the image
        $new_x = 0;
        $new_y = 0;
        $old_x = 0;
        $old_y = 0;
        imagecopyresampled($new_image, $old_image, $new_x, $new_y, $old_x, $old_y, $new_width, $new_height, $old_width, $old_height);
    
        // Write the new image to a new file
        $image_to_file($new_image, $new_image_path);
        // Free any memory associated with the new image
        imagedestroy($new_image);

    } else {
        // Write the old image to a new file
        $image_to_file($old_image, $new_image_path);
    }

    // Free any memory associated with the old image
    imagedestroy($old_image);

} // ends resizeImage function

function buildPastReviews($oldReviews, $cars) {

    $i = 0;
    
    $dv = " ";
    
    foreach ($oldReviews as $review) {
        $date = $review['reviewDate'];
        $date = date("j F\, Y");
        $dv .= "<p><b>" . $cars[$i] . "</b> (<i>Reviewed on " . $date . "</i>) : </p><span>" .
            "<a href='/phpmotors/reviews/?action=editReview&text=" . urlencode($review['reviewText']) . 
            "&car=" . urlencode($cars[$i]) . "&reviewId=" . urlencode($review['reviewId']) . "' title='Click to edit this review'>Edit</a> | <a href='/phpmotors/reviews/?action=confirmDelete&text=" . 
            urlencode($review['reviewText']) . "&car=" . urlencode($cars[$i]) . "&reviewId=" . urlencode($review['reviewId']) . "' title='Click to delete this review'>Delete</a></span><br>";
        $i ++;
    }
    
    return $dv;
}
?>