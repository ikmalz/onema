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
            <div class="w-full bg-white rounded-lg dark:border md:mt-0 sm:max-w-md xl:p-0 shadow-xl">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <div class="relative">
                        <h1 class="text-xl font-bold leading-tight tracking-tight text-black-900 md:text-2xl dark:text-black text-center">
                            Sign in
                        </h1>
                    </div>


                    <form class="space-y-4 md:space-y-6" action="{{ route('postLogin') }}" method="post">
                        @csrf
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">
                                <i class='bx bx-user text-[#E52B09] text-xl'></i> Email Address / Username
                            </label>
                            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="name@company.com" required="">

                            @if ($errors->has('email'))
                            <p class="text-red-500 text-sm mt-1">{{ $errors->first('email') }}</p>
                            @endif
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">
                                <i class='bx bxs-lock-alt text-xl text-[#E52B09]'></i> Password
                            </label>
                            <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required="">

                            @if ($errors->has('password'))
                            <p class="text-red-500 text-sm mt-1">{{ $errors->first('password') }}</p>
                            @endif
                        </div>
                        <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-[#E52B09] hover:bg-red-500">Sign in</button>

                        <p class="text-sm text-black dark:text-black flex items-center">
                            Don’t have an account?
                            <a href="{{ route('register') }}" class="font-medium text-[#E52B09] text-primary-600 hover:underline dark:text-primary-500 ml-1">Create</a>
                            <span class="ml-1 text-black">one here</span>
                        </p>
                    </form>

                </div>
            </div>
        </div>
    </section>
</body>

</html>