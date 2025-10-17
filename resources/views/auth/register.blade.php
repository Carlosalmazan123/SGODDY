<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nombre')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div   class="password-container relative mt-4">
            <x-input-label  for="password" :value="__('Contraseña')" />

            <x-text-input id="password" class="block mt-1 w-full"
            class="password-container relative"
                            type="password"
                            name="password"
                                            class="password-input" 
                            required autocomplete="new-password" />
     <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 px-3 mt-4 flex items-center text-gray-600">
        <ion-icon id="toggle-icon" name="eye-off-outline" class="w-6 h-6 transition-all duration-500"></ion-icon>
    </button>
                                        <div id="rules" class="rules-bubble">
                                            <ul>
                                            <li data-rule="length">Mínimo 8 caracteres</li>
                                            <li data-rule="uppercase">Al menos una mayúscula</li>
                                            <li data-rule="lowercase">Al menos una minúscula</li>
                                            <li data-rule="number">Al menos un número</li>
                                            <li data-rule="special">Al menos un carácter especial</li>
                                             
                                            </ul>
                                        </div>
        </div>

        <!-- Confirm Password -->
        <div class=" relative mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
  <button type="button" onclick="togglePasswordVisibility2()" class="absolute inset-y-0 right-0 px-3 mt-4 flex items-center text-gray-600">
        <ion-icon id="toggle-icon2" name="eye-off-outline" class="w-6 h-6 transition-all duration-500"></ion-icon>
    </button>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            

            <x-primary-button class="ms-4">
                {{ __('Registrar') }}
            </x-primary-button>
        </div>
    </form>
<style>
.password-container {
  position: relative;
  display: inline-block;
  width: 100%;
}

.password-input {
  display: block;
  width: 100%;
  position: relative;
  padding: 10px;
  padding-right: 40px; /* espacio a la derecha */
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

/* Burbuja flotante */
.rules-bubble {
  position: absolute;
  bottom: 70%; /* encima del input */
  right: 0;
  width: 260px;
  background: #fff;
  border: 1px solid #ccc;
  border-radius: 8px;
  padding: 10px;
  font-size: 14px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
  opacity: 0;
  pointer-events: none;
  transform: translateY(5px);
  transition: opacity 0.4s ease, transform 0.4s ease;
  z-index: 9999;
}

/* Estado visible */
.rules-bubble.active {
  opacity: 1;
  pointer-events: auto;
  transform: translateY(0);
}

/* Lista de reglas */
.rules-bubble ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.rules-bubble li {
  margin-bottom: 5px;
  color: #d9534f;
  transition: color 0.3s ease, text-decoration 0.3s ease;
}

/* Regla cumplida */
.rules-bubble li.valid {
  color: #28a745;
  text-decoration: line-through;
}
</style>
<script>
function togglePasswordVisibility() {
    const passwordField = document.getElementById('password');
    const toggleIcon = document.getElementById('toggle-icon');

    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleIcon.setAttribute('name', 'eye-outline');
    } else {
        passwordField.type = 'password';
        toggleIcon.setAttribute('name', 'eye-off-outline');
    }
}

function togglePasswordVisibility2() {
    const passwordField = document.getElementById('password_confirmation');
    const toggleIcon = document.getElementById('toggle-icon2');

    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleIcon.setAttribute('name', 'eye-outline');
    } else {
        passwordField.type = 'password';
        toggleIcon.setAttribute('name', 'eye-off-outline');
    }
}

const password = document.getElementById('password');
const rulesBubble = document.getElementById('rules');
const username = document.getElementById('name');
const email = document.getElementById('email'); // si existe campo email

const rules = {
  length: val => val.length >= 8,
  uppercase: val => /[A-Z]/.test(val),
  lowercase: val => /[a-z]/.test(val),
  number: val => /\d/.test(val),
  special: val => /[!@#$%^&*(),.?":{}|<>]/.test(val),
  noSequence: val => {
    const user = username?.value?.toLowerCase() || '';
    const mail = email?.value?.toLowerCase().split('@')[0] || '';
    const lowerVal = val.toLowerCase();
    return !(user.length >= 3 && user.split('').some((_, i) => lowerVal.includes(user.slice(i, i+3)))) &&
           !(mail.length >= 3 && mail.split('').some((_, i) => lowerVal.includes(mail.slice(i, i+3))));
  }
};

// Mostrar burbuja al enfocar
password.addEventListener('focus', () => {
  rulesBubble.classList.add('active');
  rulesBubble.style.opacity = '1';
});

// Ocultar burbuja al salir del input, de forma suave
password.addEventListener('blur', () => {
  rulesBubble.style.opacity = '0';
  setTimeout(() => {
    rulesBubble.classList.remove('active');
  }, 300); // coincide con el transition del CSS
});

// Actualizar reglas en tiempo real
password.addEventListener('input', () => {
  let allValid = true;
  for (const [rule, test] of Object.entries(rules)) {
    const li = document.querySelector(`[data-rule="${rule}"]`);
    if (li) {
      if (test(password.value)) {
        li.classList.add('valid');
      } else {
        li.classList.remove('valid');
        allValid = false;
      }
    }
  }

  // Si todas las reglas se cumplen, la burbuja se desvanece suavemente
  if (allValid) {
    rulesBubble.style.opacity = '0';
    setTimeout(() => rulesBubble.classList.remove('active'), 300);
  } else {
    // Solo mostrar si el input está enfocado
    if (document.activeElement === password) {
      rulesBubble.classList.add('active');
      rulesBubble.style.opacity = '1';
    }
  }
});
</script>

</x-guest-layout>
