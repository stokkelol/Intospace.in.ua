<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{!! csrf_token() !!}">

    <title> Intospace.in.ua</title>
    <!-- Styles -->
    <link rel="stylesheet" href="{{ elixir("css/all.css") }}">
    <link rel="stylesheet" href="{{ elixir("css/backend.css") }}">
    <link rel="stylesheet" href="{{ elixir('css/styles.css') }}">
</head>
<body>

@include('backend.partials.navbar')

<div class="container">
    <div class="row backend-page">
        <div class="row">
            <div class="col-lg-8 col-md-7 col-sm-6">
                <h1>Intospace backend</h1>
            </div>
        </div>
        <div class="col-lg-2">
            @include('backend.partials.links')
        </div>
        <div class="col-lg-10">
            @include('flash::message')
            @yield('content')
        </div>
    </div>
</div>
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
<script>
    $('.delete-post').click(function(e) {
        e.preventDefault();

        var id = $(this).attr('data-id');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        $.ajax({
            type: 'get',
            url: 'posts/to-deleted/' + id,
            success: function(data) {
                console.log(data);
                $("#post-" + id).remove();
            },
            error: function(data) {
                console.log('Error:', data);
            }
        });
    });
</script>
</body>
</html>
