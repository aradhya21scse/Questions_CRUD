<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <style>

        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            background-color: #f4f4f4; 
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff; 
            border-radius: 8px; 
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); 
        }

        h1, h2 {
            text-align: center;
            color: #007BFF;
            margin-bottom: 20px;
        }

        .export-link {
            text-align: right; 
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
            border: 1px solid #007BFF; 
            border-radius: 4px;
            width: 220px;
            background-color: #f9f9f9;
            font-size: 16px;
        }

        button {
            padding: 10px 15px;
            background-color: #007BFF; 
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3; 
        }

       
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff; 
            border-radius: 8px; 
            overflow: hidden; 
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #007BFF; 
        }

        th {
            background-color: #007BFF; 
            color: white; 
        }

        tr:nth-child(even) {
            background-color: #f9f9f9; 
        }

        tr:hover {
            background-color: #e0e0e0; 
        }

        a {
            text-decoration: none;
            color: #007BFF; 
            transition: color 0.2s;
        }

        a:hover {
            text-decoration: underline;
            color: #0056b3; 
        }

        td a {
            display: inline-block;
            margin-right: 10px;
            padding: 6px 10px; 
            border: 1px solid #007BFF; 
            border-radius: 4px; 
            color: #007BFF; 
            background-color: white; 
            transition: background-color 0.3s, color 0.3s; 
        }

        td a:hover {
            background-color: #007BFF; 
            color: white; 
        }

       
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
            padding: 12px;
            background-color: #fff;
            border: 1px solid #007BFF; 
            border-radius: 8px;
        }

        .pagination a {
            color: #007BFF;
            padding: 10px 16px;
            margin: 0 4px;
            text-decoration: none;
            border: 1px solid #007BFF;
            border-radius: 4px;
            transition: background-color 0.3s, color 0.3s;
            font-size: 14px;
        }

        .pagination a:hover {
            background-color: #007BFF; 
            color: white; 
        }

        .pagination a.active {
            background-color: #007BFF; 
            color: white; 
        }

        .pagination a.disabled {
            color: #ccc; 
            cursor: not-allowed;
            border-color: #007BFF; 
        }

      
        a[href="/questions/create"], a[href="/questions/export"] {
            display: inline-block;
            margin: 10px 0;
            background-color: #007BFF; 
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            text-align: center;
            transition: background-color 0.3s;
        }

        a[href="/questions/create"]:hover, a[href="/questions/export"]:hover {
            background-color: #0056b3; 
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
<div class="container">
    <h2>All Questions</h2>

   

    <form method="post" action="/questions">                 
        <input type="text" name="search" placeholder="Search..." value="<?= isset($search) ? $search : ''; ?>">
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
    <div class="export-link">
        <a href="/questions/export">Export to CSV</a>
    </div>
    
    <?php if (!empty($success)): ?>
        <div style="color: green;">
            <?= $success ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div style="color: red;">
            <?= $error ?>
        </div>
    <?php endif; ?>
    
    <table>
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
                        <a href="/questions/delete/<?= $question['id']; ?>" onclick="return confirm('Are you sure you want to delete this question?');">Delete</a>
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
</div>
</body>
</html>
