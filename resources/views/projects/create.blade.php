<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.css">
    <title>Document</title>
</head>
<body>

        <form method="POST" action="/projects" class="container" style="padding-top: 40px">
            @csrf
                <h1 class="heading is-1">Create a project</h1>
            <div class="field">
                <label class="lable" for="title">Title</label>
                <div class="control">
                    <input type="text" class="input" name="title" placeholder="title">
                </div>
            </div>

            <div class="field">
                    <label class="lable" for="description">Description</label>
                    <div class="control">
                        <textarea  class="textarea" name="description" placeholder="description"></textarea>
                    </div>
                </div>

            <div class="field">
                    <div class="control">
                        <button type="submit" class="button is-link">Create a project</button>
                    </div>
                </div>
        </form>

</body>

</html>