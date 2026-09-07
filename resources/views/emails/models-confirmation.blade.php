@component('mail::message')
# Potwierdzamy rejestrację modeli na twoim koncie.

@if(count($ownModels) > 0)
@foreach($ownModels as $model)
- {{ $model }}
@endforeach
@endif

@foreach($learners as $learner)
**Zarejestrowałeś też modele dla {{ $learner['name'] }}:**
@foreach($learner['models'] as $model)
- {{ $model }}
@endforeach

@endforeach

Dziękujemy za zgłoszenie.
@endcomponent
