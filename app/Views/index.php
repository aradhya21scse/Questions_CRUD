<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <style>
        /* General page styling */
body {
    font-family: 'Arial', sans-serif;
    margin: 20px;
    background-color: #f8f9fa; /* Lighter background for better contrast */
    color: #333;
}

h1, h2 {
    text-align: center;
    color: #343a40; /* Darker heading color */
    margin-bottom: 20px;
}

form {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}

input[type="text"], select {
    padding: 10px;
    margin-right: 10px;
    border: 1px solid #ced4da; /* Softer border */
    border-radius: 4px;
    width: 220px; /* Slightly wider for easier input */
    background-color: #fff;
}

button {
    padding: 10px 15px;
    background-color: #007BFF;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #0056b3;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background-color: #fff;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1); /* Slightly deeper shadow */
    border-radius: 8px; /* Softer edges */
    overflow: hidden;
}

th, td {
    padding: 12px;
    text-align: left;
    border: 1px solid #e9ecef;
}

th {
    background-color: #007BFF;
    color: white;
    font-weight: bold;
}

tr:nth-child(even) {
    background-color: #f8f9fa; /* Softer alternating color */
}

tr:hover {
    background-color: #e9ecef; /* Light gray on hover */
}

a {
    text-decoration: none;
    color: #007BFF;
    transition: color 0.2s, text-decoration 0.2s;
}

a:hover {
    text-decoration: underline;
    color: #0056b3;
}

td a {
    margin-right: 10px;
}

/* Pagination styling */
.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 20px;
    gap: 10px;
    padding: 10px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.pagination a {
    color: #007BFF;
    padding: 10px 16px;
    margin: 0 4px;
    text-decoration: none;
    border: 1px solid #ddd;
    border-radius: 4px;
    transition: background-color 0.3s, color 0.3s;
    font-size: 14px;
}

.pagination a:hover {
    background-color: #007BFF;
    color: white;
    border-color: #007BFF;
}

.pagination a.active {
    background-color: #007BFF;
    color: white;
    border: 1px solid #007BFF;
}

.pagination a.disabled {
    color: #ccc;
    cursor: not-allowed;
    border: 1px solid #ddd;
}

a[href="/questions/create"] {
    display: inline-block;
    margin-top: 20px;
    background-color: #28a745;
    color: white;
    padding: 10px 20px;
    border-radius: 4px;
    text-align: center;
    transition: background-color 0.3s;
}

a[href="/questions/create"]:hover {
    background-color: #218838;
}

@media (max-width: 768px) {
    form {
        flex-direction: column;
        align-items: center;
    }

    input[type="text"], select, button {
        width: 100%;
        margin-bottom: 10px;
    }

    table {
        font-size: 14px;
    }

    .pagination a {
        padding: 6px 12px;
        font-size: 12px;
    }
}


        
    </style>
</head>
<body>
<h2>All Questions</h2>
<form method="post" action="/questions">
    <input type="text" name="search" placeholder="Search..." value="<?= isset($search) ?$search : ''; ?>">
    <select name="category_id">
        <option value="">All Categories</option>
        <?php foreach ($categories as $category): ?>
            <option value="<?= $category['id']; ?>" <?= isset($category_id) && $category_id == $category['id'] ? 'selected' : ''; ?>>
                <?= $category['name']; ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Filter</button>
</form>
    <table border="1">
        <thead>
            <tr>
                <th>Title</th>
                <th>Question</th>
                <th>Answer</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
    <?php foreach ($questions as $question): ?>
        <tr>
            <td><?= $question['title']; ?></td>
            <td><?= $question['question']; ?></td>
            <td><?= $question['answer']; ?></td>
            <td>
                <?php
                $category_name = '';
                foreach ($categories as $category) {
                    if ($category['id'] == $question['category_id']) {
                        $category_name = $category['name'];
                        break; 
                    }
                }
                echo $category_name; 
                
                ?>
            </td>
            <td>
                <a href="/questions/edit/<?= $question['id']; ?>">Edit</a>
                <a href="/questions/delete/<?= $question['id']; ?>">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>

    </table>
    <a href="/questions/create">Add New Question</a>
    <div class="pagination">
        
    <?php if ($page > 1): ?>
        <a href="/questions?page=<?= $page - 1 ?>" class="prev">Previous</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="/questions?page=<?= $i ?>" class="<?= $page == $i ? 'active' : ''; ?>">
            <?= $i ?>
        </a>
    <?php endfor; ?>

    <?php if ($page < $totalPages): ?>
        <a href="/questions?page=<?= $page + 1 ?>" class="next">Next</a>
    <?php endif; ?>
    
</div>

</body>
</html>
