@extends('WebSC.misc.main')

@section('content')
  <style>
    .field.has-addons {
        display: flex;
        justify-content: flex-start;
    }
    .field.has-addons .control:not(:last-child) {
      margin-right: -1px;
    }
    .control {
      box-sizing: border-box;
      clear: both;
      font-size: 1rem;
      position: relative;
      text-align: left;
    }
    .button, .input {
      -moz-appearance: none;
      -webkit-appearance: none;
      align-items: center;
      border: 1px solid transparent;
      border-radius: 4px;
      box-shadow: none;
      display: inline-flex;
      font-size: 1rem;
      justify-content: flex-start;
      line-height: 1.5;
      padding-bottom: calc(.5em - 1px);
      padding-left: calc(.75em - 1px);
      padding-right: calc(.75em - 1px);
      padding-top: calc(.5em - 1px);
      position: relative;
      vertical-align: top;
    }

    .button {
      background-color: #fff;
      border-color: #dbdbdb;
      border-width: 1px;
      color: #363636;
      cursor: pointer;
      justify-content: center;
      padding-bottom: calc(.5em - 1px);
      padding-left: 1em;
      padding-right: 1em;
      padding-top: calc(.5em - 1px);
      text-align: center;
      white-space: nowrap;
    }

    .button.is-small, .input.is-small {
      border-radius: 2px;
      font-size: .75rem;
    }

    .input {
      background-color: #fff;
      border-color: #dbdbdb;
      border-radius: 4px;
      color: #363636;
    }

    .input {
      box-shadow: inset 0 0.0625em 0.125em rgba(10,10,10,.05);
      max-width: 100%;
      width: 100%;
    }
  </style>
  <div class="container">
    <div class="content">
      <div class="logo">
        <img src="{{ getImageLogo('logo/landscape.png') }}" width="100%">
      </div>
      <div class="title">segera hadir...</div>

      <hr style="margin-top:20px;">
      <div style="margin:0 10px;text-align:left;">
        @if (session('subscribed'))
          Alamat surel Anda sudah kami terima. Kami akan menginformasikan kembali melalui surel ketika situs sudah aktif. Terima kasih.
        @else
          Beri tahu saya melalui surel:
          <form action="{{ route('web.action.subscribe') }}" method="post">
            <div class="field has-addons">
              <div class="control">
                <input type="email" class="input is-small" name="email" placeholder="Masukkan surel anda..">
              </div>
              <div class="control">
                @csrf
                <button class="button is-small">
                  Kirim
                </button>
              </div>
            </div>
          </form>
        @endif
      </div>
    </div>
  </div>
@endsection