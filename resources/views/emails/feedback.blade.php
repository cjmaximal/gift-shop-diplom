@component('mail::message')
Новое сообщение
<hr>
Имя: **{{ $name }}**
E-mail: **{{ $email }}**

#### Сообщение
@component('mail::panel')
{{ $message }}
@endcomponent
@endcomponent
