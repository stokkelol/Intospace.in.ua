<div class="container">
    <div class="row">
        <div class="col-lg-offset-3 col-lg-6">
            <hr>
        </div>
        <div class="col-lg-12">
            <div>
                @if(!empty($review))
                    <p class="text-center">
                        <a href="" class="main-review-title">{!! $review->title !!}</a>
                    </p>
                    <p>
                        {!! str_limit($review->content, $limit = 740, $end = '') !!}
                        <br>
                        <a href="/monthlyreviews/">Читать далее...</a>
                    </p>
                @endif
            </div>
        </div>
        <div class="col-lg-offset-3 col-lg-6">
            <hr>
        </div>
    </div>
</div>
