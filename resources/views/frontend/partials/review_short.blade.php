<div class="container">
    <div class="row">
        @if (!empty($review))
            <div class="col-lg-offset-3 col-lg-6">
                <hr>
            </div>
            <div class="col-lg-12">
                <div>
                    <p class="text-center">
                        <a href="/monthlyreviews/" class="main-review-title">{!! $review->title !!}</a>
                    </p>
                    <p>
                        {!! str_limit($review->content, $limit = 780, $end = '...') !!}
                        <br>
                        <a href="/monthlyreviews/">Читать далее...</a>
                    </p>
                </div>
            </div>
            <div class="col-lg-offset-3 col-lg-6">
                <hr>
            </div>
        @endif
    </div>
</div>
