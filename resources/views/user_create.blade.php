<x-app-layout class="items-center justify-center text-center">
    <div class="flex w-full justify-center items-center">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 items-center container justify-center">
            <div class="bg-white dark:bg-white mx-auto overflow-hidden  max-w-4xl shadow-2xl sm:rounded-lg ">
                <div class="p-1 text-gray-900 dark:text-gray-900 sm:p-8">
                    <h1 class="text-2xl text-center font-bold ">NUEVO USUARIO</h1>

                   @if($errors->any())
                        <div class="bg-red-100 dark:bg-red-700 border border-red-700 dark:border-red-700 text-white dark:text-white px-4 py-3 rounded relative mb-4" role="alert">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                       <!-- Formulario de usuario -->
                    <div class="flex items-center w-100 justify-center ">
                        <div class="mx-auto w-full container max-w-[550px]">
                            <form action="{{ route('users.store') }}" method="post" class="space-y-5">
                                @csrf
                                <div>
                                    <label for="name" class="mb-2 block text-base font-medium text-[#07074D] ">Nombre</label>
                                    <input type="text" value="{{ old('name') }}"  name="name" id="name"
                                           placeholder="Nombre"
                                           class="w-full user-input rounded-md border border-[#e0e0e0] dark:border-gray-600 bg-white  py-3 px-6 text-base font-medium text-gray-700  outline-none focus:border-[#6A64F1] focus:shadow-md" required/>
                                </div>

                                <div>
                                    <label for="email" class="mb-2 block text-base font-medium text-[#07074D] ">Correo</label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                                           placeholder="Correo"
                                           class="w-full rounded-md border border-[#e0e0e0] dark:border-gray-600 bg-white  py-3 px-6 text-base font-medium text-gray-700  outline-none focus:border-[#6A64F1] focus:shadow-md" required/>
                                </div>

                                <div>
                                    <label for="password" class="block text-gray-700  text-sm font-bold mb-2">Contraseña</label>
                                  <div class="password-container relative">
                                        <input 
                                        name="password"
                                        value="{{ old('password') }}"
                                            onfocus="document.getElementById('rules').classList.add('active')"
                                            onblur="document.getElementById('rules').classList.remove('active')"
                                            oninput="validatePassword()"
                                            type="password" 
                                            id="password" 
                                            class="password-input" 
                                            placeholder="Ingresa tu contraseña"
                                        >
                                         <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-600">
        <ion-icon id="toggle-icon" name="eye-off-outline" class="w-6 h-6 transition-all duration-500"></ion-icon>
    </button>
                                        <div id="rules" class="rules-bubble">
                                            <ul>
                                            <li data-rule="length">Mínimo 8 caracteres</li>
                                            <li data-rule="uppercase">Al menos una mayúscula</li>
                                            <li data-rule="lowercase">Al menos una minúscula</li>
                                            <li data-rule="number">Al menos un número</li>
                                            <li data-rule="special">Al menos un carácter especial</li>
                                             <li data-rule="consecutive">No contener 3 caracteres consecutivos del nombre o correo</li>
                                            </ul>
                                        </div>
                                        </div>
                                </div>

                                <div class="flex flex-col sm:flex-row items-center justify-center gap-3 text-center mt-6">
                                    <button type="submit" class="hover:shadow-form rounded-md bg-blue-500 hover:bg-blue-600 py-3 px-6 text-base font-semibold text-white outline-none transition">
                                        Guardar
                                    </button>
                                    <a href="{{ route('users.index') }}" class="bg-red-600 hover:bg-red-700 font-semibold py-3 px-6 rounded-md text-white transition">
                                        Cancelar
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
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
  bottom: 70%; /* la coloca encima del input */
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
  transition: opacity 0.3s ease, transform 0.3s ease;
  z-index: 9999; /* asegura que quede por encima */
}

/* Cuando se activa (al hacer focus en el input) */
.rules-bubble.active {
  opacity: 1;
  pointer-events: auto;
  transform: translateY(-5px);
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
    <!-- Scripts -->
    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.getElementById('toggle-icon');

            if (passwordField.type === 'password') {
                passwordField.type =  'text';
                  toggleIcon.setAttribute('name', 'eye-outline'); // ojo abierto
            } else {
                passwordField.type = 'password';
                toggleIcon.setAttribute('name', 'eye-off-outline'); // ojo cerrado
            }
        }
        
     const password = document.getElementById('password');
const username = document.getElementById('name');
const rulesBubble = document.getElementById('rules');

const rules = {
  length: val => val.length >= 8,
  uppercase: val => /[A-Z]/.test(val),
  lowercase: val => /[a-z]/.test(val),
  number: val => /\d/.test(val),
  special: val => /[!@#$%^&*(),.?":{}|<>]/.test(val),
  consecutive: val => {
    const userVal = username.value.toLowerCase();
    const passVal = val.toLowerCase();
    if (!userVal || userVal.length < 3) return true; // No evaluar si el usuario está vacío o muy corto
    for (let i = 0; i < userVal.length - 2; i++) {
      const sub = userVal.substring(i, i + 3);
      if (passVal.includes(sub)) return false;
    }
    return true;
  }
};

// Mostrar burbuja al hacer foco
password.addEventListener('focus', () => {
  rulesBubble.classList.add('active');
});

// Ocultar si todas las reglas se cumplen al perder el foco
password.addEventListener('blur', () => {
  const allValid = Object.keys(rules).every(rule => rules[rule](password.value));
  if (allValid) rulesBubble.classList.remove('active');
});

// Actualizar reglas en tiempo real
password.addEventListener('input', () => {
  let allValid = true;
  for (const [rule, test] of Object.entries(rules)) {
    const li = document.querySelector(`[data-rule="${rule}"]`);
    if (test(password.value)) {
      li.classList.add('valid');
    } else {
      li.classList.remove('valid');
      allValid = false;
    }
  }
  rulesBubble.style.opacity = allValid ? '0' : '1';
});
</script>

    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</x-app-layout>
