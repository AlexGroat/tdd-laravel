<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Create a Project!</h1>

    <form method="POST" action="/projects">
        @csrf
        <label class="block mb-2 text-xs font-bold text-gray-700 uppercase" for="title">
            Title
        </label>
        <input class="w-full p-2 border border-gray-400 rounded" type="text" id="title" name="title" required>
        </div>

        <div class="mb-6">
            <label class="block mb-2 text-xs font-bold text-gray-700 uppercase" for="description">
                Description
            </label>
            <textarea class="w-full p-2 border border-gray-400 rounded" type="text" id="description" name="description" required></textarea>
        </div>
        <div class="field">
            <div class="control">
                <button type="submit" class="button">Create a Project</button>
            </div>
        </div>
    </form>
    
</body>

</html>