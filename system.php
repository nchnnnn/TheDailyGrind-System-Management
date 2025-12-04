<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TheDailyGrind System Management</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        input[type="text"] {
            padding: 6px;
            width: 250px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <h2>Drink Inventory</h2>

    <!-- Search Bar -->
    <input type="text" id="search" placeholder="Search drinks...">

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Product Temp Type</th>
                <th>Subcategory</th>
                <th>Quantity Inventory</th>
                <th>Base Price</th>
                <th>Classification</th>
                <th>Size Value</th>
            </tr>
        </thead>
        <tbody id="table-body">
            <!-- Rows will appear here dynamically -->
        </tbody>
    </table>

    <script>
        const searchInput = document.getElementById('search');
        const tableBody = document.getElementById('table-body');

        function fetchDrinks(query = '') {
            fetch('search.php?search=' + encodeURIComponent(query))
                .then(response => response.text())
                .then(data => {
                    tableBody.innerHTML = data;
                });
        }

        // Load all drinks initially
        fetchDrinks();

        // Live search as user types
        searchInput.addEventListener('input', () => {
            fetchDrinks(searchInput.value);
        });
    </script>
</body>

</html>