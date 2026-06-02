@component('mail::message')
# Nowa wiadomość z sielata.com.pl

**Od:** {{ $name }} ({{ $email }})
@if(!empty($phone))
**Telefon:** {{ $phone }}
@endif
@if(!empty($subject))
**Temat:** {{ $subject }}
@endif

---

{{ $message }}

@component('mail::button', ['url' => 'mailto:' . $email])
Odpowiedz
@endcomponent

@endcomponent