<!DOCTYPE html>

<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Primary Meta Tags -->
    <title>QTimer - Smart CBT Exam System</title>
    <meta name="title" content="QTimer - Smart CBT Exam System">
    <meta name="description"
      content="QTimer is a modern Computer-Based Testing (CBT) system for efficient and secure E-Exams. Supports auto-grading, question banks, and real-time monitoring.">

    <!-- Keywords for SEO -->
    <meta name="keywords"
      content="CBT Software, Online Exams, E-Exams, QTimer, Computer-Based Test, Digital Education, Automated Grading">

    <!-- Author Information -->
    <meta name="author" content="Your Name or Your Company Name">

    <!-- Robots Control -->
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow">

    <!-- Open Graph Meta Tags (For Facebook, LinkedIn) -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="QTimer - Smart CBT Exam System">
    <meta property="og:description"
      content="QTimer is a modern CBT system for efficient and secure E-Exams. Supports auto-grading, question banks, and real-time monitoring.">
    <meta property="og:image" content="{{ asset('css/guest.css') }}">
    <meta property="og:url" content="https://almax.mn.co">

    <!-- Twitter Card (For Twitter Sharing) -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="QTimer - Smart CBT Exam System">
    <meta name="twitter:description"
      content="QTimer is a modern CBT system for efficient and secure E-Exams. Supports auto-grading, question banks, and real-time monitoring.">
    <meta name="twitter:image" content="{{ asset('css/guest.css') }}">

    <!-- Favicon -->
    <link type="image/x-icon" href="{{ asset('QTimer.png') }}" rel="icon">

    {{-- @if (Auth::user()) --}}
    @if (Auth::user())
      <link href="{{ asset('node_modules/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet" />
      <link href="{{ asset('node_modules/bootstrap-icons/font/bootstrap-icons.min.css') }}" rel="stylesheet" />
      @if (Auth::user()->is_staff || Auth::user()->is_set_master || Auth::user()->is_subject_master)
      @else
        <style>
          body {
            font-size: 15pt;
          }

          * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
          }

          body {
            height: 100vh;
            background-color: #01263a;
            display: flex;
            justify-content: center;
            align-items: center;
          }

          /*
          .container {
            width: 95vw;
            height: 90vh;
            position: relative;
            background: linear-gradient(to bottom, #01263a 0%, #4f94d4 70%, #c5d9ed 100%);
            border-radius: 80px;
            overflow: hidden;
          }

          .disc-1 {
            position: absolute;
            top: 24%;
            left: 1%;
            width: 359px;
            height: 358px;
            background: #72aee6;
            opacity: 0.2;
            border-radius: 50%;
            animation: glow infinite 2s;
            animation-fill-mode: both;
            animation-direction: alternate;
          }

          .disc-2 {
            position: absolute;
            top: 35%;
            left: 16%;
            width: 260px;
            height: 260px;
            background: #9ec2e6;
            opacity: 0.4;
            border-radius: 50%;
            animation: glow infinite 2s;
            animation-fill-mode: both;
            animation-direction: alternate;
          }

          .disc-3 {
            position: absolute;
            top: 43%;
            left: 27%;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: #f0f6fc;
            opacity: 0.6;
            animation: glow infinite 2s;
            animation-fill-mode: both;
            animation-direction: alternate;
          }

          .landscape-1 {
            position: absolute;
            bottom: 119px;
            left: -7px;
            width: 250px;
            height: 70px;
            background-color: #9ec2e6;
            transform: rotate(9deg);
          }

          .landscape-2 {
            position: absolute;
            bottom: 90px;
            right: -7px;
            width: 350px;
            height: 90px;
            background-color: #72aee6;
            transform: rotate(-6deg);
          }

          .landscape-3 {
            position: absolute;
            bottom: 65px;
            left: -4px;
            width: 390px;
            height: 80px;
            background-color: #4f94d4;
            transform: rotate(5deg);
          }

          .landscape-4 {
            position: absolute;
            bottom: 50px;
            left: -4px;
            width: 400px;
            height: 70px;
            background-color: #135e96;
            transform: rotate(-4deg);
          }

          .landscape-5 {
            position: absolute;
            bottom: -10px;
            left: -6px;
            width: 370px;
            height: 90px;
            background-color: #043959;
            transform: rotate(5deg);
          }

          .tree-1 {
            position: absolute;
            top: 63%;
            left: 30%;
            height: 15px;
            width: 20px;
            background-color: #59a5d8;
            clip-path: polygon(50% 0%, 22% 100%, 75% 100%);
            box-shadow: 2px 0 2px 4px rgba(0, 0, 0, .1);
          }

          .tree-2 {
            position: absolute;
            top: 65%;
            left: 80%;
            height: 20px;
            width: 13px;
            background-color: #4f94d4;
            clip-path: polygon(50% 0%, 22% 100%, 75% 100%);
            box-shadow: 2px 0 2px 4px rgba(0, 0, 0, .1);
          }

          .tree-3 {
            position: absolute;
            top: 65%;
            left: 5%;
            height: 20px;
            width: 18px;
            background-color: #386fa4;
            clip-path: polygon(50% 0%, 22% 100%, 75% 100%);
            box-shadow: 2px 0 2px 4px rgba(0, 0, 0, .1);
          }

          .tree-4 {
            position: absolute;
            top: 70%;
            left: 60%;
            height: 20px;
            width: 15px;
            background-color: #386fa4;
            clip-path: polygon(50% 0%, 22% 100%, 75% 100%);
            box-shadow: 2px 0 2px 4px rgba(0, 0, 0, .1);
          }

          .tree-5 {
            position: absolute;
            top: 69%;
            left: 80%;
            height: 30px;
            width: 25px;
            background-color: #133c55;
            clip-path: polygon(50% 0%, 22% 100%, 75% 100%);
            box-shadow: 2px 0 2px 4px rgba(0, 0, 0, .1);
          }

          .tree-6 {
            position: absolute;
            top: 74%;
            left: 11%;
            height: 45px;
            width: 35px;
            background-color: #133c55;
            clip-path: polygon(50% 0%, 22% 100%, 75% 100%);
            box-shadow: 2px 0 2px 4px rgba(0, 0, 0, .1);
          }

          .tree-7 {
            position: absolute;
            top: 72%;
            left: 40%;
            height: 35px;
            width: 25px;
            background-color: #133c55;
            clip-path: polygon(50% 0%, 22% 100%, 75% 100%);
            box-shadow: 2px 0 2px 4px rgba(0, 0, 0, .1);
          }

          .star {
            position: absolute;
            width: 2px;
            height: 2px;
            background-color: white;
          }

          .s1 {
            top: 50px;
            left: 17px;
          }

          .s2 {
            top: 80px;
            left: 150px;
          }

          .s3 {
            top: 100px;
            left: 30px;
          }

          .s4 {
            top: 200px;
            left: 250px;
          }

          .s5 {
            top: 160px;
            left: 140px;
          }

          .s6 {
            top: 38px;
            left: 300px;
          }

          .s7 {
            top: 180px;
            left: 355px;
          }

          .s8 {
            top: 270px;
            left: 10px;
          }

          .s9 {
            top: 130px;
            left: 200px;
          }

          .s10 {
            top: 10px;
            left: 250px;
          } */
        </style>
      @endif
    @else
      <style>
        * {
          margin: 0;
          padding: 0;
        }

        section {
          display: flex;
          justify-content: center;
          align-items: center;
          min-height: 100vh;
          width: 100%;
          background: url('background.png');
          background-position: center;
          background-size: cover;
        }

        .form-box {
          position: relative;
          width: 500px;
          height: 450px;
          background: transparent;
          border: 2px solid rgba(255, 255, 255, 0.5);
          border-radius: 20px;
          backdrop-filter: blur(15px);
          display: flex;
          justify-content: center;
          align-items: center;
        }

        h2 {
          font-size: 2em;
          color: #fff;
          text-align: center;
        }

        .inputbox {
          position: relative;
          margin: 30px 0;
          width: 310px;
          border-bottom: 2px solid #fff;
        }

        .inputbox label {
          position: absolute;
          top: 50%;
          left: 5px;
          transform: translateY(-50%);
          color: #fff;
          font-size: 1em;
          transition: .5s;
        }

        input:focus~label,
        input:valid~label {
          top: -5px;
        }

        .inputbox input {
          width: 100%;
          height: 50px;
          background: transparent;
          border: none;
          outline: none;
          font-size: 1em;
          padding: 0 35px 0 5px;
          color: #fff;
        }

        .inputbox ion-icon {
          position: absolute;
          right: 8px;
          color: #fff;
          font-size: 1.2em;
          top: 20px;
        }

        .forget {
          margin: -15px 0 15px;
          font-size: .9em;
          color: #fff;
          display: flex;
          justify-content: center;
        }

        .forget label input {
          margin-right: 3px;
        }

        .forget label a {
          color: #fff;
          text-decoration: none;
          font-weight: 600
        }

        .forget label a:hover {
          text-decoration: underline;
        }

        button {
          width: 100%;
          height: 40px;
          border-radius: 40px;
          background: #fff;
          border: none;
          outline: none;
          cursor: pointer;
          font-size: 1em;
          font-weight: 600;
        }

        .register {
          font-size: .9em;
          color: #fff;
          text-align: center;
          margin: 25px 0 10px;
        }

        .register p a {
          text-decoration: none;
          color: #fff;
          font-weight: 600;
        }

        .register p a:hover {
          text-decoration: underline;
        }
      </style>

    @endif
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @livewireStyles

  </head>

  <body
    class="{{ Auth::user() ? (Auth::user()->is_staff || Auth::user()->is_set_master || Auth::user()->is_subject_master ? 'bg-black' : '') : '' }}">
    @if (Auth::user())
      @if (Auth::user()->is_staff || Auth::user()->is_set_master || Auth::user()->is_subject_master)
        @yield('content')
      @else
        {{-- <div class="container">
          <div class="disc-1"></div>
          <div class="disc-2"></div>
          <div class="disc-3"></div>
          <div class="landscape-1"></div>
          <div class="landscape-2"></div>
          <div class="landscape-3"></div>
          <div class="landscape-4"></div>
          <div class="landscape-5"></div>

          <div class="tree-1"></div>
          <div class="tree-2"></div>
          <div class="tree-3"></div>
          <div class="tree-4"></div>
          <div class="tree-5"></div>
          <div class="tree-6"></div>
          <div class="tree-7"></div>
          <div class="star s1"></div>
          <div class="star s2"></div>
          <div class="star s3"></div>
          <div class="star s4"></div>
          <div class="star s5"></div>
          <div class="star s6"></div>
          <div class="star s7"></div>
          <div class="star s8"></div>
          <div class="star s9"></div>
          <div class="star s10"></div>
        </div> --}}
        <div
          style="position: absolute; background-color: #01263a; margin-top: 50px; margin: auto; width: 90%; height: 90%; padding: 10px; border-radius: 12px;">
          @yield('content')

        </div>
      @endif
    @else
      <section>
        <div class="form-box">
          <div class="form-value">
            @yield('content')
          </div>
        </div>
      </section>
      {{-- @livewireScripts --}}
    @endif

    <script src="{{ asset('node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    @livewireScripts
    <script src="{{ asset('node_modules/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
    <x-livewire-alert::scripts />

    <script src="{{ asset('node_modules/typed.js/typed.umd.js') }}"></script>

    <script>
      (function() {
        "use strict";


        /**
         * Init typed.js
         */
        const selectTyped = document.querySelector('.typed');
        if (selectTyped) {
          let typed_strings = selectTyped.getAttribute('data-typed-items');
          typed_strings = typed_strings.split(',');
          new Typed('.typed', {
            strings: typed_strings,
            loop: true,
            typeSpeed: 99,
            backSpeed: 100,
            // backDelay: 1000
          });
        }



      })();
    </script>
  </body>

</html>
