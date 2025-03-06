<?php
    require_once('actions/connection.php');
    $locationFilter = "";
    $searchQuery = "";
    if (isset($_GET['searchInput']) && !empty($_GET['searchInput'])) {
        $searchQuery = $_GET['searchInput'];
    }
    $limit = 5; 
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
    $page = max($page, 1);
    $offset = ($page - 1) * $limit; 

    $sql = "SELECT * FROM products WHERE 1";
    if ($searchQuery) {
        $sql .= " AND product_name LIKE '%" . $connection->real_escape_string($searchQuery) . "%'";
    }
        
    $totalResult = $connection->query($sql);
    $totalRows = $totalResult->num_rows;
    $totalPages = ceil($totalRows / $limit); 
        
    $sql .= " ORDER BY product_name ASC LIMIT $limit OFFSET $offset";
    $result = $connection->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Product List</title>
</head>
<style>
.center {
    text-align: center;
    margin-top: 50px;
}

.mid {
    margin-top: 35px;
}

body {
    background-color: #ccfbfb;
    background-repeat: repeat;
    background-size: 100%;
    text-align: center;
}

.containerIndex {
    margin: 20px auto;
    max-width: 900px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    padding: 20px;
}

.search-bar {
    margin-bottom: 20px;
    text-align: center;
}

.search-bar input, .search-bar select {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.search-bar input {
    width: 60%;
}

.search-bar select {
    width: 20%;
    margin-left: 10px;
}

.search-bar button {
    padding: 10px 15px;
    border: none;
    background-color: #3498db;
    color: white;
    cursor: pointer;
    border-radius: 4px;
    margin-left: 10px;
}

.search-bar button:hover {
    background-color: #216189;
}

h2 {
    color: #3498db;
    font-family: Verdana;
}

p {
    font-family: Verdana;
}

.product-list {
    list-style-type: none;
    padding: 0;
}

.product-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border: 1px solid #ddd;
    border-radius: 8px;
    margin-bottom: 15px;
    padding: 15px;
}

.product-item img {
    max-width: 100px;
    height: auto;
    margin-right: 15px;
    border-radius: 8px;
    transition: transform 0.3s ease; 
}

/* .school-item img {
max-width: 100px;
height: auto;
margin-right: 15px;
border-radius: 8px;
transition: transform 0.3s ease; 
} */

.product-item img:hover {
    transform: scale(1.2); 
}

.content-wrapper {
    display: flex;
    width: 100%;
    justify-content: space-between;
    align-items: center;
}

.school-details {
    text-align: left;
}

.admin-tools {
    display: flex;
    gap: 10px;
}

.admin-tools button {
    background-color: #4CAF50;
    color: white;
    padding: 8px 12px;
    border: none;
    cursor: pointer;
    border-radius: 4px;
    font-size: 14px;
}

.admin-tools button:hover {
    opacity: 0.8;
}

.admin-tools button[type="submit"] {
    background-color: #e74c3c;
}

h3 {
    color: #3498db;
    font-family: Verdana;
    font-size: 20px;
}

p {
    font-family: Verdana;
    font-size: 14px;
}

.pagination {
    text-align: center;
    font-family: century gothic;
    margin: 20px 0;
}
.pagination a {
    color: #3498db;
    text-decoration: none;
    margin: 0 5px;
    padding: 8px 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
}
.pagination a.active {
    background-color: #3498db;
    color: white;
    border: none;
}
.pagination a:hover {
    background-color: #216189;
    color: white;
}
h1{
    color:orange;
    font-family: "Century Gothic"; 
    font-size: 42px;
    Line-height: 50px;
}
</style>
<body class="product-list-page">
    <h1>Product List</h1>
    <div class="containerIndex">
        <div class="search-bar">
            <form method="GET" action="ramosProductList.php">
                <input type="text" id="searchInput" name="searchInput" placeholder="Search for a school..." value="<?php echo htmlspecialchars($searchQuery); ?>">
                <button type="submit">Search</button>
            </form>
        </div>

        <script>
            $('#searchInput').on('change', function() {
                $(this).closest('form').submit(); 
            });
        </script>

        <h2>List of Products</h2>
        <ul class="product-list">
        <?php
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<li class="product-item">';

                        if (!empty($row['product_image'])) {
                            echo '<img src="' . htmlspecialchars("uploads/" .$row['product_image']) . '" alt="Product Image">';
                        }
                        echo '<div class="content-wrapper">';

                        echo '<div class="school-details">';
                            echo '<h3>' . htmlspecialchars($row['product_name']) . '</h3>';
                            echo '<p><strong>Description:</strong> ' . htmlspecialchars($row['product_description']) . '</p>';
                            echo '<p><strong>Price:</strong> ' . htmlspecialchars($row['price']) . '</p>';
                            echo '<p><strong>Stocks:</strong> ' . htmlspecialchars($row['qty']) . '</p>';
                        echo '</div>';

                        echo '<div class="admin-tools">';
                            echo '<a href="adminProductUpdateView.php?id=' . urlencode($row['id']) . '">
                                <button>Update</button></a>';
                            echo '<form method="POST" action="" style="display:inline;" onsubmit="return confirm(\'Are you sure you want to delete this school?\');">';
                                echo '<input type="hidden" name="product_id" value="' . $row['id'] . '">';
                                echo '<button type="submit">Delete</button>';
                            echo '</form>';
                        echo '</div>';

                        echo '</div>'; 
                    echo '</li>';
                }
            } 
            else {
                echo '<p>No schools available. Add new schools using the "Add School" button.</p>';
            }
        ?>
        </ul>
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>&searchInput=<?php echo $searchQuery; ?>">Previous</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?php echo $i; ?>&searchInput=<?php echo $searchQuery; ?>" class="<?php echo $i == $page ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <a href="?page=<?php echo $page + 1; ?>&searchInput=<?php echo $searchQuery; ?>">Next</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
