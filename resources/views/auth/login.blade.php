<!DOCTYPE html>
<html>
<head>
    <title>Login - Eliza Sheperdx</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        body {
            background: linear-gradient(-45deg, #e0f2fe, #93c5fd, #60a5fa, #3b82f6);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            height: 100vh;
        }
        
        .login-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
            color: #1e3a8a;
        }
        
        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        }
        
        .input-field {
            background: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(29, 78, 138, 0.3);
            transition: all 0.3s ease;
            color: #1e3a8a;
        }
        
        .input-field:focus {
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
            border-color: #3b82f6;
        }
        
        .btn-login {
            transition: all 0.3s ease;
            background: #1e3a8a;
            color: white;
        }
        
        .btn-login:hover {
            background: #1e40af;
            transform: translateY(-2px);
        }
        
        .text-label {
            color: #1e40af;
        }
        
        .error-card {
            background: rgba(239, 68, 68, 0.2);
            border-left: 4px solid rgba(239, 68, 68, 0.8);
        }
        
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 100;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }
        
        .modal-content {
            background-color: rgba(255, 255, 255, 0.95);
            margin: 15% auto;
            padding: 2rem;
            border-radius: 0.5rem;
            width: 80%;
            max-width: 400px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            animation: modalFadeIn 0.3s;
        }
        
        @keyframes modalFadeIn {
            from {opacity: 0; transform: translateY(-50px);}
            to {opacity: 1; transform: translateY(0);}
        }
        
        .close-modal {
            color: #aaa;
            float: right;
            font-size: 1.5rem;
            font-weight: bold;
            cursor: pointer;
        }
        
        .close-modal:hover {
            color: #555;
        }
    </style>
</head>
<body class="flex items-center justify-center">
    <div class="login-card p-8 rounded-2xl shadow-xl w-full max-w-md mx-4">
        <div class="text-center mb-8">
            <img src="/img/logo.png" alt="Company Logo" class="mx-auto h-20 w-auto mb-4">
            <h2 class="text-3xl font-bold">Welcome</h2>
            <p class="text-blue-700 opacity-80">Sign in to continue</p>
        </div>

        @if ($errors->any())
            <div class="error-card text-red-800 p-4 rounded mb-6" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <p class="font-medium">{{ $errors->first() }}</p>
                </div>
            </div>
        @endif

        <form id="loginForm" action="{{ route('login') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="id_akun" class="block text-sm font-medium text-label mb-2">
                    <i class="fas fa-user mr-2"></i>Account ID
                </label>
                <div class="relative rounded-md">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-id-card text-blue-600 opacity-70"></i>
                    </div>
                    <input type="text" name="id_akun" id="id_akun" 
                           class="input-field block w-full pl-10 pr-3 py-3 rounded-md placeholder-black-400 focus:outline-none" 
                           placeholder="Enter your ID" value="{{ old('id_akun') }}" required>
                </div>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-label mb-2">
                    <i class="fas fa-lock mr-2"></i>Password
                </label>
                <div class="relative rounded-md">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-key text-blue-600 opacity-70"></i>
                    </div>
                    <input type="password" name="password" id="password" 
                           class="input-field block w-full pl-10 pr-3 py-3 rounded-md placeholder-black-400 focus:outline-none" 
                           placeholder="••••••••" required>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <i class="far fa-eye-slash text-blue-600 opacity-70 cursor-pointer hover:opacity-100" id="togglePassword"></i>
                    </div>
                </div>
            </div>

            <div>
                <button type="submit" class="btn-login w-full flex justify-center py-3 px-4 rounded-md text-sm font-medium focus:outline-none">
                    <i class="fas fa-sign-in-alt mr-2"></i> Sign In
                </button>
            </div>
        </form>
    </div>

    <!-- Error Modal -->
    <div id="errorModal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <div class="text-center">
                <i class="fas fa-exclamation-triangle text-red-500 text-4xl mb-4"></i>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Login Failed</h3>
                <p class="text-gray-600" id="errorMessage">Account ID or password is incorrect</p>
                <button class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none" id="modalOkBtn">OK</button>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        
        togglePassword.addEventListener('click', function (e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
            this.classList.toggle('fa-eye');
        });

        // Modal functionality
        const modal = document.getElementById("errorModal");
        const modalOkBtn = document.getElementById("modalOkBtn");
        const closeModal = document.getElementsByClassName("close-modal")[0];
        
        function showErrorModal(message) {
            document.getElementById("errorMessage").textContent = message;
            modal.style.display = "block";
        }
        
        closeModal.onclick = function() {
            modal.style.display = "none";
        }
        
        modalOkBtn.onclick = function() {
            modal.style.display = "none";
        }
        
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Check for existing errors from server
        @if ($errors->any())
            showErrorModal("{{ $errors->first() }}");
        @endif
    </script>
</body>
</html>