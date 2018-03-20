@component('mail::message')
# Новый заказ #{{ $id }} в интернет-магазине Gift-Shop!

Добрый день **{{ $full_name }}**, наши специалисты<br>
скоро свяжутся с Вами для уточнения деталей заказа.

<br>
### Состав заказа
@component('mail::panel')
@component('mail::table')
| #                      | Название                                | Количество        | Цена              | Сумма           |
|:----------------------:| ------------------------------------ |:-----------------:|:-----------------:|:---------------:|
@foreach($products as $p)
| {{ $loop->iteration }} | [{{ $p['name'] }}]({{ $p['link'] }}) | {{ $p['count'] }} | {{ $p['price'] }} | {{ $p['sum'] }} |
@endforeach
@endcomponent
@endcomponent
##### Итого: {{ $total }}

<br>
### Адрес доставки
@component('mail::panel')
{{ $address }}
@endcomponent

@if(!empty($comment))
### Комментарий к заказу
@component('mail::panel')
*{{ $comment }}*
@endcomponent
@endif

### Статус заказа
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
