<!-- Monthly review section -->
@if(!empty($review))
    <div class="container">
        <div class="row">
            <div class="monthly-review-container">
                <div class="text-center">
                    <a href="" class="review-title">{{ $review->title }}</a>
                </div>
                <div class="col-lg-10 col-lg-offset-1">

                </div>
                <div class="review-links">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <p>Обзоры за прошедший месяц:</p>
                        <ul class="list-unstyled">

                        </ul>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <p>Видео за прошедший месяц:</p>
                        <ul class="list-unstyled">

                        </ul>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <p>Популярные обзоры:</p>
                        <ul class="list-unstyled">

                        </ul>
                    </div>
                </div>
                <div class="col-lg-12">
                    <hr>
                </div>
            </div>
        </div>
    </div>
@endif
