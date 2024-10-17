<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <section class="bg-gray-50">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <div class="w-full bg-white rounded-lg dark:border md:mt-0 sm:max-w-md xl:p-0 shadow-lg">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <div class="flex items-center justify-between">
                        <a href="{{ route('login') }}" class="text-gray-900 hover:text-[#E52B09]">
                            <i class='bx bx-chevron-left text-4xl bg-[#E52B09] text-white rounded-lg'></i> </a>
                        <h1 class="text-xl font-bold leading-tight tracking-tight text-black-900 md:text-2xl dark:text-black mx-auto">
                            Create Account 
                        </h1>
                        <div></div>
                    </div>
                    <form class="space-y-4 md:space-y-6" action="{{ route('register.post') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label for="username" class="block mb-2 text-sm font-medium text-black"><i class='bx bx-user text-[#E52B09] text-xl'></i> Username</label>
                            <input type="text" name="username" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-300 focus:border-red-300 block w-full p-2.5 " placeholder="please insert username" required>
                        </div>
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-black"><i class='bx bxs-envelope text-[#E52B09] text-xl'></i> Email Address</label>
                            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " placeholder="name@company.com" required>
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-black"><i class='bx bxs-lock-alt text-xl text-[#E52B09]'></i> Password</label>
                            <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " required>
                        </div>
                        <div>
                            <label for="password_confirmation" class="block mb-2 text-sm font-medium text-black"><i class='bx bxs-lock-alt text-xl text-[#E52B09]'></i> Confirm password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required>
                        </div>
                        <button type="submit" class="w-full text-white bg-[#E52B09] hover:bg-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Create an account</button>
                        <!-- Mengatur "One here" sejajar -->
                        <p class="text-sm text-black dark:text-black flex items-center">
                        Already have an account?
                            <a href="{{ route('login') }}" class="font-medium text-[#E52B09] text-primary-600 hover:underline dark:text-primary-500 ml-1">Sign in</a>
                            <span class="ml-1 text-black">here</span>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>

</html>