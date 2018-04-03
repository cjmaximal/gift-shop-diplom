@component('mail::message')
#Изменение статуса заказа #{{ $id }} в интернет-магазине Gift-Shop!

Добрый день **{{ $full_name }}**, статус заказа изменен.

## Новый статус
@component('mail::panel')
{{ $status }}
@endcomponent

<br>
Для просмотра информации о заказе нажмите на кнопку
@component('mail::button', ['color' => 'blue', 'url' => $details_url])
Подробнее
@endcomponent

---

Спасбо за заказ!<br>
С уважением команда интернет-магазина {{ config('app.name') }}.
@endcomponent
