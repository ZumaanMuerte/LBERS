{{-- resources/views/welcome.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>LBERS</title>

  {{-- Tailwind CSS (via Vite or Mix) --}}
  @vite('resources/css/app.css')

  {{-- Alpine.js (for slideshow & form toggling) --}}
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

  {{-- Prevent Alpine “flash” before JS loads --}}
  <style>
    [x-cloak] { display: none !important; }
  </style>
</head>
<body class="antialiased bg-gray-100">

  <div class="min-h-screen flex flex-col">
    {{-- Top Navbar --}}
    <header class="bg-white shadow">
      <div class="flex items-center max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 gap-4">
        <img src="{{ asset('imgs/logo.jpeg') }}" alt="logo" class="w-16 h-16" />
        <h1 class="text-lg font-semibold text-gray-900">LB ERS</h1>
      </div>
    </header>

    {{-- MAIN: fullscreen slideshow + centered overlay card --}}
    <main class="relative flex-1 flex overflow-hidden">
      {{-- SLIDESHOW --}}
      <div
        x-data="{
          current: 0,
          slides: [
            {
              image: '{{ asset('imgs/cloudy.jpg') }}',
              lines: [
                'WELCOME TO LB ERS',
                'LB ERS stands for Location-Based Emergency Response System',
                'Check your location to see its recent weather or earthquake report'
              ]
            },
            {
              image: '{{ asset('imgs/eyeofthestorm.jpg') }}',
              lines: [
                'DID YOU KNOW?',
                'Hurricanes rotate around a circular centre called the “eye” where it is generally calm with no clouds',
                'Surrounding the eye is the eye wall – the most dangerous part of the hurricane with the strongest winds, thickest clouds and heaviest rain'
              ]
            },
            {
              image: '{{ asset('imgs/ring-of-fire.jpg') }}',
              lines: [
                'DID YOU KNOW?',
                'The Philippines is located within the Ring of Fire',
                'causing volcanic eruptions and earthquakes'
              ]
            },
            {
              image: '{{ asset('imgs/skolcracks.jpg') }}',
              lines: [
                'EARTHQUAKE\'S CRACKS',
                'While this is alarming to everyone’s safety, it is also a sign of a building attempting to withstand its force',
                'Some cracks are even intentionally designed to absorb energy'
              ]
            }
          ],
          init() {
            setInterval(() => {
              this.current = (this.current + 1) % this.slides.length;
            }, 4000);
          }
        }"
        x-init="init()"
        class="absolute inset-0 h-full w-full"
      >
        {{-- Each slide covers the full area, fades in/out --}}
        <template x-for="(slide, index) in slides" :key="index">
          <div
            x-show="current === index"
            x-transition.opacity.duration.1000
            class="absolute inset-0 bg-cover bg-center bg-no-repeat flex items-center justify-center"
            :style="`background-image: url('${slide.image}');`"
          >
            {{-- Dark overlay so text is readable --}}
            <div class="absolute inset-0 bg-black/40"></div>

            {{-- Slide text (three lines) --}}
            <div class="relative z-10 text-center px-6 space-y-4 max-w-2xl bg-gray-500 bg-opacity-30 p-4 rounded">
              <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white uppercase">
                <span x-text="slide.lines[0]"></span>
              </h2>
              <p class="text-lg md:text-xl text-white">
                <span x-text="slide.lines[1]"></span>
              </p>
              <p class="text-lg md:text-xl text-white">
                <span x-text="slide.lines[2]"></span>
              </p>
            </div>
          </div>
        </template>
      </div>

      {{-- OVERLAY CARD (vertically centered, on the right side) --}}
      <div class="relative flex-1 flex items-center justify-end z-10 right-8 p-4">
        <div
          class="w-[600px] bg-white bg-opacity-75 backdrop-blur-sm rounded-xl shadow-xl mx-8 p-0"
          x-data="{ formView: 'signup' }"
        >
           {{-- Card Header --}}
          <div class="bg-indigo-600 px-6 py-4 rounded-t-xl">
            <h3 class="text-xl font-semibold text-black text-center justify-center">
              <span x-show="formView === 'signup'">Sign Up</span>
              <span x-show="formView === 'login'">Log In</span>
              <span x-show="formView === 'forgot'">Forgot Password</span>
            </h3>
          </div>

          {{-- Card Content --}}
          <div class="p-6 space-y-6">
            {{-- Sign Up Form --}}
            <div x-show="formView === 'signup'" x-cloak>
              @include('auth.partials._register-form')

              <div class="mt-4 text-center text-sm text-gray-700">
                Already registered?
                <button
                  type="button"
                  @click="formView = 'login'"
                  class="text-indigo-600 hover:text-indigo-800 font-medium"
                >Log in here</button>.
              </div>
            </div>

            {{-- Log In Form --}}
            <div x-show="formView === 'login'" x-cloak>
              @include('auth.partials._login-form')

              <div class="mt-4 text-center text-sm text-gray-700">
                <button
                  type="button"
                  @click="formView = 'signup'"
                  class="text-indigo-600 hover:text-indigo-800 font-medium"
                >Don't have an account? Sign up</button>.
              </div>

              <div class="mt-2 text-center text-sm text-gray-700">
                Forgot password?
                <button
                  type="button"
                  @click="formView = 'forgot'"
                  class="text-indigo-600 hover:text-indigo-800 font-medium"
                >Click here</button>.
              </div>
            </div>

            {{-- Forgot Password Form --}}
            <div x-show="formView === 'forgot'" x-cloak>
              <div class="flex items-center mb-4">
                <button
                  type="button"
                  @click="formView = 'login'"
                  class="text-gray-600 hover:text-gray-800 font-medium"
                >&larr; Back to Log In</button>
              </div>

              @include('auth.partials._forgot-form')
            </div>
          </div>
        </div>
      </div>
    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t">
      <div
        class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 text-sm text-gray-500 text-center"
      >
        © {{ date('Y') }} LBERS. All rights reserved.
      </div>
    </footer>
  </div>

</body>
</html>
