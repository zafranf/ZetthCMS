@extends('WebSC.layouts.main')

@section('content')
  {{-- <!-- START STATUS FEED --> --}}
  <section class="articles">
    <div class="column is-10 is-offset-1">
      {{-- <!-- START STATUS --> --}}
      <div class="card article">
        <div class="card-content">
          <div class="content article-body">
            <h4 class="title is-3">Edit Profil</i></h4>
            {{-- <p>Selamat datang di <b>{{ app('site')->name }} - {{ app('site')->tagline }}</b>. Silakan lengkapi profil untuk mulai menggunakan situs.</p> --}}
            @if (count($errors))
              <div class="notification is-warning has-text-left">
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif
            @if (session('success'))
              <div class="notification is-success has-text-left">
                Profil berhasil diperbarui.
              </div>
            @endif
  
            <form action="{{ route('web.profile.post') }}" enctype="multipart/form-data" method="post">
              {{ csrf_field() }}
              <div class="columns ">
                <div class="column">
                  <h5 class="title is-5">Profil Pengguna</h5>
  
                  <div class="field">
                    <label class="label">Foto
                      <span class="is-pulled-right is-small tooltip has-tooltip-multiline" data-tooltip="Ukuran foto minimal 128px x 128px dan maksimal 512px x 512px dengan rasio 1:1.">
                        <i class="far fa-question-circle"></i>
                      </span>
                    </label>
                    <div class="control">
                      <div class="file has-name is-boxed">
                        <label class="file-label">
                          <input class="file-input" id="image" type="file" name="image" accept="image/*">
                          <span class="file-cta">
                            <figure class="image is-128x128">
                              <img id="imagePreview" class="is-rounded" src="{{ getImageUser() }}">
                            </figure>
                          </span>
                          <span class="file-name"><button type="button" class="button is-small" onclick="document.getElementById('image').click()">Pilih Foto</button></span>
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="field">
                    <label class="label">Nama Lengkap</label>
                    <div class="control has-icons-left">
                      <input class="input" type="text" name="fullname" placeholder="Nama lengkap.." value="{{ Auth::user()->fullname }}" maxlength="100">
                      <span class="icon is-left">
                        <i class="fad fa-user"></i>
                      </span>
                    </div>
                  </div>
                  <div class="field">
                    <label class="label">Email</label>
                    <div class="control has-icons-left">
                      <input class="input" type="email" name="email" placeholder="Alamat email.." value="{{ Auth::user()->email }}" maxlength="100" disabled>
                      <span class="icon is-left">
                        <i class="fad fa-envelope"></i>
                      </span>
                    </div>
                  </div>
                  <div class="field">
                    <label class="label">Jenis Kelamin</label>
                    <div class="control has-icons-left">
                      <div class="select">
                        <select name="gender">
                          <option value="na">--Pilih--</option>
                          <option value="m" {{ (Auth::user()->gender == 'm') ? 'selected' : '' }}>Laki-laki</option>
                          <option value="f" {{ (Auth::user()->gender == 'f') ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        <span class="icon is-left">
                          <i class="fad fa-venus-mars"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="field">
                    <label class="label">Tanggal Lahir</label>
                    <div class="control has-icons-left">
                      <input class="input" type="date" name="birthdate" placeholder="Tanggal lahir.." value="{{ Auth::user()->birthdate }}">
                      <span class="icon is-left">
                        <i class="far fa-calendar-alt"></i>
                      </span>
                    </div>
                  </div>
                  <div class="field">
                    <label class="label">Alamat</label>
                    <div class="control">
                      <textarea class="textarea" name="address" placeholder="Alamat lengkap.." rows="3">{{ Auth::user()->address }}</textarea>
                    </div>
                  </div>
                  <div class="field">
                    <label class="label">Tentang Pengguna</label>
                    <div class="control">
                      <textarea class="textarea" name="about" placeholder="Sekilas tentang pengguna.." rows="3">{{ Auth::user()->about }}</textarea>
                    </div>
                  </div>
                  <div class="columns">
                    <div class="column is-center">
                        <div class="field is-grouped">
                          <div class="control">
                            <button class="button is-danger">Simpan</button>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="column">
                  <h5 class="title is-5">Akses Masuk</h5>

                  <div class="field">
                    <label class="label">Nama Profil 
                      <span class="is-pulled-right is-small tooltip has-tooltip-multiline" data-tooltip="Digunakan untuk nama akses masuk aplikasi (jika menggunakan sandi) dan juga sebagai tautan halaman profil.">
                        <i class="far fa-question-circle"></i>
                      </span>
                    </label>
                    <div class="control has-icons-left has-icons-right">
                      <input class="input" type="text" name="name" placeholder="Text input" value="{{ Auth::user()->name }}" maxlength="20" autofocus>
                      <span class="icon is-left">
                        <i class="fad fa-user"></i>
                      </span>
                      <span class="icon is-right is-hidden">
                        <i class="fad fa-check"></i>
                      </span>
                    </div>
                    <span class="help is-success is-hidden">Nama profil tersedia</span>
                  </div>
                  <div class="field">
                    <div class="control">
                      <input class="is-checkradio" type="checkbox" name="use_password" id="use_password" onclick="showPasswordFields()"> 
                      <label for="use_password" onclick="showPasswordFields()">{{ !Auth::user()->password ? 'Gunakan' : 'Ubah' }} sandi?</label>
                    </div>
                  </div>
                  <div class="field password is-hidden has-addons">
                    <div class="control has-icons-left is-expanded">
                      <input class="input" id="password" name="password" type="password" placeholder="Masukkan sandi..">
                      <span class="icon is-left">
                        <i class="fad fa-lock"></i>
                      </span>
                    </div>
                    <div class="control">
                      <a class="button is-primary tooltip has-tooltip-multiline" data-tooltip="Tampilkan sandi" onclick="showPasswordText()">
                        <i id="icon-eye" class="fad fa-eye"></i>
                      </a>
                    </div>
                  </div>
                  <div class="columns">
                    <div class="column is-center">
                        <div class="field is-grouped">
                          <div class="control">
                            <button class="button is-primary">Simpan</button>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      {{-- <!-- END STATUS --> --}}
    </div>
  </section>
  {{-- <!-- END STATUS FEED --> --}}
@endsection

@push('styles')
  <style>
    /* .calendar-selection-date {
      display: none!important
    } */
    .file-label {
      width: 100%;
      text-align: center;
    }
    .file-name {
      width: 100%;
      max-width: unset;
    }
    .datetimepicker-dummy.is-primary::before,
    .datetimepicker-dummy.is-primary:before {
      background-color: unset;
    }
    .datetimepicker-dummy.is-primary .datetimepicker-clear-button {
      color: unset;
    }
  </style>
@endpush

@push('scripts')
  <script>
    let today = new Date();
    let tomorrow = new Date();
    tomorrow.setTime(tomorrow.getTime() + 86400000);
    let minDate = new Date(today.getFullYear() - 100, today.getMonth(), today.getDate());
    
    let calendars = bulmaCalendar.attach('[type="date"]', {
      lang: 'id',
      /* displayMode: 'dialog', */
      dateFormat: 'YYYY-MM-DD',
      // showFooter: false,
      showHeader: false,
      // startDate: today,
      // minDate: minDate.toString(),
      maxDate: tomorrow,
      disabledDates: [tomorrow],
      // showClearButton: false,
      cancelLabel: 'Batal',
      showTodayButton: true,
      todayLabel: 'Hari ini',
      showClearButton: true,
      clearLabel: 'Hapus',
      onReady: function() {
        $('.datetimepicker-clear-button').attr('type','button').hide();
        /* $('.datetimepicker-clear-button').on('click', function() {
          event.preventDefault();
        }); */
      }
    });
    /* [].forEach.call(calendars, function(calendar) {
      calendar.on('show', function (datePicker) {
        $('.datetimepicker-clear-button').attr('type','button').show();
      });
    }); */

    // var bd1 = document.getElementsByName('birthdate');
    // bd1[0].value = '';
    // var bd2 = document.getElementsByName('loft_builddate');
    // bd2[0].value = '';

    var image = document.getElementById("image");
    var imagePreview = document.getElementById("imagePreview");
    image.onchange = function() {
      if (image.files.length > 0) {
        var filename = document.getElementsByClassName('file-name');
        filename[0].innerHTML = image.files[0].name;
        filename[0].classList.remove('is-hidden');

        const reader = new FileReader();
        reader.onload = (function(aImg) {
          return function(e) {
            aImg.src = e.target.result;
          };
        }) (imagePreview);
        reader.readAsDataURL(image.files[0]);
      }
    };

    function showPasswordFields() {
      var checkbox = document.getElementById("use_password");
      var pwd = document.querySelectorAll('.password');

      [].forEach.call(pwd, function (el) {
        if (checkbox.checked == true){
          el.classList.remove('is-hidden');
        } else {
          el.classList.add('is-hidden');
        }
      });
    }

    function showPasswordText() {
      var password = document.getElementById("password");
      var type = password.getAttribute('type');
      var eye = document.getElementById('icon-eye');
      
      if (type == 'password') {
        password.setAttribute('type', 'text');
        eye.classList.remove('fa-eye');
        eye.classList.add('fa-eye-slash');
        eye.parentElement.setAttribute('data-tooltip', 'Sembunyikan sandi');
      } else {
        password.setAttribute('type', 'password');
        eye.classList.add('fa-eye');
        eye.classList.remove('fa-eye-slash');
        eye.parentElement.setAttribute('data-tooltip', 'Tampilkan sandi');
      }
    }
  </script>
@endpush