@component('mail::message')
# {{ $full_name }}, добро пожаловать в интернет-магазин {{ config('app.name') }}!

В каталоге нашего интернет-магазина Вы найдете<br>
множество интересных и оригинальных подарков.

Перейти в
@component('mail::button', ['color' => 'blue', 'url' => $profile_url])
Профиль
@endcomponent

Спасибо!<br>
С уважением команда интернет-магазина {{ config('app.name') }}
@endcomponent
