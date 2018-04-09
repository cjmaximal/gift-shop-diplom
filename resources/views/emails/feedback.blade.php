@component('mail::message')
Новое сооюбщение
<hr>
Имя: **{{ $name }}**
E-mail: **{{ $email }}**

#### Сообщение
@component('mail::panel')
{{ $message }}
@endcomponent
@endcomponent
