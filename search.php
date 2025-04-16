<!DOCTYPE html>
<html lang="en">
   <?php include 'includes/header.php'; ?> 
<body>
	<?php include 'includes/navbar.php'; ?>
    <h2>Search</h2>
    <form action="search.php" method="POST">
        <label for="search">Search by:</label>
        <br><br>
        <div>
            <button type="button">Name</button>
            <button type="button">Region</button>
            <button type="button">Style</button>
        </div>
        <br>
        <div>
            <input type="text" id="search" name="search" placeholder="Enter search...">
            <button type="submit">Search</button>
        </div>
    </form>
    <br>
    <div id="results" style="border: 1px solid #000; padding: 10px; min-height: 50px; 
        max-height: 200px; overflow-y: auto;"> 
        <!-- Search results will appear here -->
    </div>
	
	 <?php include 'includes/footer.php'; ?>
</body>
</html>
