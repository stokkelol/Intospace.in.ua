<hr>
<div id="sticky-bottom-anchor"></div>
<footer>
    <div class="container">
        <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <blockquote><p><a href="https://intospace.rocks">Intospace</a> - это попытка вернуться во времена когда обзоры читали, а жесткие диски не ломились от гигабайт mp3.</p>
                    </blockquote>
                    <div class="footer-column">
                        <ul class="list-unstyled list-inline footer-social-links">
                            <li><a href="http://www.last.fm/ru/user/redwhite1"><i class="fa fa-lastfm-square" aria-hidden="true"></i></a></li>
                            <li><a href="https://twitter.com/_redwhite_"><i class="fa fa-twitter-square" aria-hidden="true"></i></a></li>
                            <li><a href="https://www.facebook.com/redwhiteua"><i class="fa fa-facebook-official" aria-hidden="true"></i></a></li>
                            <li><a href="/feed"><i class="fa fa-rss-square" aria-hidden="true"></i></a></li>
                            <li><a href="mailto:redwhitepwnz@gmail.com"><i class="fa fa-envelope" aria-hidden="true"></i></a></li>
                        </ul>
                        <!--<p class="text-center"><a href="/sitemap">Карта сайта</a></p>-->
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <p class="footer-column-title">Навигация:</p>
                    <div class="footer-column cl-effect-1">
                        <ul class="list-unstyled">
                            <li><a href="/">На главную</a></li>
                            <li><a href="/#tagscloud">Облако тегов</a></li>
                            <li><a href="/bands">Все группы</a></li>
                            <li><a href="/register">Регистрация</a></li>
                            <li><a href="/login">Вход</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <p class="footer-column-title">Материалы:</p>
                    <div class="footer-column">
                        <ul class="list-unstyled cl-effect-1">
                            <li><a href="/posts">Последние обзоры</a></li>
                            <li><a href="/videos">Последние видео</a></li>
                            <li><a href="/pages/top-2015">Ежегодные топ-50</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <p class="footer-column-title">Разделы:</p>
                    <div class="footer-column">
                        <ul class="list-unstyled cl-effect-1">
                            <li><a href="/categories/new-reviews">Новые обзоры</a></li>
                            <li><a href="/categories/old-reviews">Старые обзоры</a></li>
                            <li><a href="/categories/short-reviews">Мини-обзоры</a></li>
                            <li><a href="/posts/{{ $randompost->slug }}">Случайный обзор</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                    <p class="footer-column-title">Друзья:</p>
                    <div class="footer-column">
                        <ul class="list-unstyled cl-effect-1">
                            <li><a href="http://www.neformat.com.ua">www.neformat.com.ua</a></li>
                            <li><a href="http://vk.com/expcore">e<sup>x</sup></a></li>
                        </ul>
                    </div>
                </div>
        </div>
    </div>
    <div>
        <hr>
    </div>
    <div class="container">
        <div class="row">
            <div class="text-left">
                <div class="footer-copyright">
                    <blockquote>
                        <br>
                        <i class="fa fa-copyright" aria-hidden="true"></i> 2014-2022 intospace.rocks. Большая просьба, при использовании материалов с сайта добавьте активную гиперссылку на <a href="https://intospace.rocks">intospace.rocks</a>
                    </blockquote>
                    <p>Powered by <a href="https://laravel.com/">Laravel</a>.</p>
                    <p class="load-timer">This page took {{ round((microtime(true) - LARAVEL_START), 3) }} seconds to render</p>
                </div>
            </div>
        </div>
    </div>
</footer>
