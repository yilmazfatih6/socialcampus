@component('mail::message')
# Medeniyet Sosyal'e Hoşgeldin

Merhaba,<br>
Az önce bu mail ile siteye kayıt olumu gerçekleştirildiğini farkettik. Eğer kayıt olan kişi sen değilsen bu mesajı lütfen görmezden gel. Eğer kayıt olan sen isen lütfen aşağıdaki linke tıklayarak onayla.

@component('mail::button', ['url' => url('/verify/'.$token)])
Onayla
@endcomponent

Saygılarımızla,<br>
Medeniyet Sosyal
@endcomponent
