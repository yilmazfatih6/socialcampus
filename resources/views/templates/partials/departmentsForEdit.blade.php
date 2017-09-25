<!--Department-->
<div class="form-group{{ $errors->has('department') ? ' has-error' : '' }}">
    <label for="department" class="control-label">Departman</label>
    <select class="form-control" name="department" id="department" required>
        <option @if (Auth::user()->department == null) selected="selected" @endif  disabled >Bir Tür Seçin</option>
        <!--Edebiyat Fakültesi-->
        <optgroup label="Edebiyat Fakültesi">
            <option @if (Auth::user()->department == 'Batı Dilleri ve Edebiyatları') selected="selected" @endif>Batı Dilleri ve Edebiyatları</option>
            <option @if (Auth::user()->department == 'Bilgi ve Belge Yönetimi') selected="selected" @endif>Bilgi ve Belge Yönetimi</option>
            <option @if (Auth::user()->department == 'Bilim Tarihi') selected="selected" @endif>Bilim Tarihi</option>
            <option @if (Auth::user()->department == 'Dil Bilimi') selected="selected" @endif >Dil Bilimi</option>
            <option @if (Auth::user()->department == 'Doğu Dilleri ve Edebiyatları') selected="selected" @endif>Doğu Dilleri ve Edebiyatları</option>
            <option @if (Auth::user()->department == 'Felsefe') selected="selected" @endif >Felsefe</option>
            <option @if (Auth::user()->department == 'Psikoloji') selected="selected" @endif>Psikoloji</option>
            <option @if (Auth::user()->department == 'Sanat Tarihi') selected="selected" @endif>Sanat Tarihi</option>
            <option @if (Auth::user()->department == 'Slav Dilleri ve Edebiyatları') selected="selected" @endif >Slav Dilleri ve Edebiyatları</option>
            <option @if (Auth::user()->department == 'Sosyoloji') selected="selected" @endif>Sosyoloji</option>
            <option @if (Auth::user()->department == 'Tarih') selected="selected" @endif>Tarih</option>
            <option @if (Auth::user()->department == 'Türk Dili ve Edebiyatı') selected="selected" @endif>Türk Dili ve Edebiyatı</option>
        </optgroup>

        <optgroup label="Eğitim Bilimleri Fakültesi">
            <option @if (Auth::user()->department == 'Bilgisayar ve Öğretim Teknolojileri Eğitimi') selected="selected" @endif>Bilgisayar ve Öğretim Teknolojileri Eğitimi</option>
            <option @if (Auth::user()->department == 'Eğitim Bilimleri') selected="selected" @endif>Eğitim Bilimleri</option>
            <option @if (Auth::user()->department == 'Güzel Sanatlar Eğitimi') selected="selected" @endif>Güzel Sanatlar Eğitimi</option>
            <option @if (Auth::user()->department == 'Matematik ve Fen Bilimleri Eğitimi') selected="selected" @endif>Matematik ve Fen Bilimleri Eğitimi</option>
            <option @if (Auth::user()->department == 'Özel Eğitim') selected="selected" @endif>Özel Eğitim</option>
            <option @if (Auth::user()->department == 'Türkçe ve Sosyal Bilimler Eğitimi') selected="selected" @endif>Türkçe ve Sosyal Bilimler Eğitimi</option>
            <option @if (Auth::user()->department == 'Yabancı Diller Eğitimi') selected="selected" @endif>Yabancı Diller Eğitimi</option>
            <option @if (Auth::user()->department == 'Temel Eğitim') selected="selected" @endif>Temel Eğitim</option>
        </optgroup>

        <optgroup label="Hukuk Fakültesi">
            <option @if (Auth::user()->department == 'Hukuk') selected="selected" @endif>Hukuk</option>
        </optgroup>

        <optgroup label="Mühendislik ve Doğa Bilimleri Fakültesi">
            <option @if (Auth::user()->department == 'Bilgisayar Mühendisliği') selected="selected" @endif>Bilgisayar Mühendisliği</option>
            <option @if (Auth::user()->department == 'Biyomedikal Mühendisliği') selected="selected" @endif>Biyomedikal Mühendisliği</option>
            <option @if (Auth::user()->department == 'Biyomühendislik') selected="selected" @endif>Biyomühendislik</option>
            <option @if (Auth::user()->department == 'Elektrik-Elektronik Mühendisliği') selected="selected" @endif>Elektrik-Elektronik Mühendisliği</option>
            <option @if (Auth::user()->department == 'Endüstri Mühendisliği') selected="selected" @endif>Endüstri Mühendisliği</option>
            <option @if (Auth::user()->department == 'Fizik Mühendisliği') selected="selected" @endif>Fizik Mühendisliği</option>
            <option @if (Auth::user()->department == 'İnşaat Mühendisliği') selected="selected" @endif>İnşaat Mühendisliği</option>
            <option @if (Auth::user()->department == 'İstatistik') selected="selected" @endif>İstatistik</option>
            <option @if (Auth::user()->department == 'Kimya') selected="selected" @endif>Kimya</option>
            <option @if (Auth::user()->department == 'Makine Mühendisliği') selected="selected" @endif>Makine Mühendisliği</option>
            <option @if (Auth::user()->department == 'Matematik') selected="selected" @endif>Matematik</option>
            <option @if (Auth::user()->department == 'Moleküler Biyoloji ve Genetik') selected="selected" @endif>Moleküler Biyoloji ve Genetik</option>
        </optgroup>

        <optgroup label="Sağlık Bilimleri Fakültesi">
            <option @if (Auth::user()->department == 'Hemşirelik') selected="selected" @endif>Hemşirelik</option>
            <option @if (Auth::user()->department == 'Sağlık Yönetimi') selected="selected" @endif>Sağlık Yönetimi</option>
            <option @if (Auth::user()->department == 'Sosyal Hizmet') selected="selected" @endif>Sosyal HizmetSosyal Hizmet</option>
            <option @if (Auth::user()->department == 'Beslenme ve Diyetetik') selected="selected" @endif>Beslenme ve Diyetetik</option>
            <option @if (Auth::user()->department == 'Odyoloji') selected="selected" @endif>Odyoloji</option>
            <option @if (Auth::user()->department == 'Çocuk Gelişimi') selected="selected" @endif>Çocuk Gelişimi</option>
            <option @if (Auth::user()->department == 'Fizyoterapi Ve Rehabilitasyon') selected="selected" @endif>Fizyoterapi Ve Rehabilitasyon</option>
            <option @if (Auth::user()->department == 'Dil ve Konuşma Terapisi') selected="selected" @endif>Dil ve Konuşma Terapisi</option>
        </optgroup>

        <optgroup label="Sanat, Tasarım ve Mimarlık Fakültesi">
            <option @if (Auth::user()->department == 'Görsel İletişim Tasarımı') selected="selected" @endif>Görsel İletişim Tasarımı</option>
            <option @if (Auth::user()->department == 'Mimarlık') selected="selected" @endif>Mimarlık</option>
            <option @if (Auth::user()->department == 'Sahne Ve Görüntü Sanatları') selected="selected" @endif>Sahne Ve Görüntü Sanatları</option>
            <option @if (Auth::user()->department == 'Şehir Ve Bölge Planlama') selected="selected" @endif>Şehir Ve Bölge Planlama</option>
            <option @if (Auth::user()->department == 'Türk Musikisi') selected="selected" @endif>Türk Musikisi</option>
        </optgroup>

        <optgroup label="Siyasal Bilgiler Fakültesi">
            <option @if (Auth::user()->department == 'İşletme') selected="selected" @endif>İşletme</option>
            <option @if (Auth::user()->department == 'İktisat') selected="selected" @endif>İktisat</option>
            <option @if (Auth::user()->department == 'Siyaset Bilimi ve Kamu Yönetimi') selected="selected" @endif>Siyaset Bilimi ve Kamu Yönetimi</option>
            <option @if (Auth::user()->department == 'Uluslararası İlişkiler') selected="selected" @endif>Uluslararası İlişkiler</option>
            <option @if (Auth::user()->department == 'Maliye') selected="selected" @endif>Maliye</option>
        </optgroup>

        <optgroup label="Tıp Fakültesi">
            <option @if (Auth::user()->department == 'Tıp') selected="selected" @endif>Tıp</option>
        </optgroup>

        <optgroup label="Turizm Fakültesi">
            <option @if (Auth::user()->department == 'Rekreasyon Yönetimi') selected="selected" @endif>Rekreasyon Yönetimi</option>
            <option @if (Auth::user()->department == 'Turizm Rehberliği') selected="selected" @endif>Turizm Rehberliği</option>
            <option @if (Auth::user()->department == 'Turizm İşletmeciliği') selected="selected" @endif>Turizm İşletmeciliği</option>
            <option @if (Auth::user()->department == 'Gastronomi ve Mutfak Sanatları') selected="selected" @endif>Gastronomi ve Mutfak Sanatları</option>
        </optgroup>

     </select>
    @if ($errors->has('department'))
        <span class="help-block">{{ $errors->first('department') }}</span>
    @endif
</div> <!-- /Department-->
