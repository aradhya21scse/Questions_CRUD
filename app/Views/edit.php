<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Question</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 20px auto;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF; /* Bootstrap Primary color */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        a {
            display: inline-block;
            margin-top: 10px;
            text-decoration: none;
            color: #007BFF; /* Link color */
            text-align: center;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<h1>Edit Question</h1>
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

    <form action="/questions/update/<?= $question['id']; ?>" method="post">
        <input type="text" name="title" value="<?= $question['title']; ?>" required>
        <textarea name="question" required><?= $question['question']; ?></textarea>
        <textarea name="answer" required><?= $question['answer']; ?></textarea>
        <select name="category_id" required>
            <option value="">Select Category</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id']; ?>" <?= ($category['id'] == $question['category_id']) ? 'selected' : ''; ?>>
                    <?= ($category['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Update</button>
        <a href="/questions">Back to Questions</a>
    </form>

   

</body>
</html>
