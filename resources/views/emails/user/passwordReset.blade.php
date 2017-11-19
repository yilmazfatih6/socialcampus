@component('mail::message')
# Şifre Değiştirme Talebi

Merhaba,<br>
Az önce bu mail adresine ait hesap için şifre değişikliği talebi aldık. Eğer böyle bir istekte bulunmadıysan lütfen bu emaili görmezden gel. Eğer bu değişikliği sen talep ettiysen yeni şifreni aşağıdan belirleyebilirsin.

@component('mail::button', ['url' => url('/password/reset/'.$token)])
Şifreni Değiştir
@endcomponent

Saygılarımızla,<br>
Medeniyet Sosyal
@endcomponent
