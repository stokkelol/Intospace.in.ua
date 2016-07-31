<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> Intospace.in.ua</title>
    <!-- Styles -->
    <link rel="stylesheet" href="{{ elixir("css/all.css") }}">
    <link rel="stylesheet" href="{{ elixir("css/backend.css") }}">
    <link rel="stylesheet" href="{{ elixir('css/styles.css') }}">
</head>
<body>

@include('backend.partials.navbar')



<div class="container" style="height:50px;">
    @include('flash::message')
</div>
@yield('content')
@yield('partials.footer')


        <!-- JavaScripts -->
<script src="{{ elixir("js/all.js") }}"></script>
<script>
    $('#tagsselect').select2({
        placeholder: 'Choose a tag',
        tags: true,
        tokenSeparators: [",", " "],
        createTag: function (newTag) {
            return {
                id: 'new:' + newTag.term,
                text: newTag.term + ' (new)'
            };
        }
    });
</script>
<script>
    $('.alert-info').delay(3000).fadeOut("slow");
</script>
<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'ckeditor', {
        filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
        filebrowserBrowseUrl: '/laravel-filemanager?type=Files'
    });
    for (var i in CKEDITOR.instances) {

        CKEDITOR.instances[i].on('change', function() { CKEDITOR.instances[i].updateElement() });

    }
</script>
<script>
    new Vue({
        el: '#post-form-preview',
        data: {

        }
    });
</script>
</body>
</html>
