<!DOCTYPE html>
<html lang="en" dir="ltr" class="h-full font-sans antialiased">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="ZJpba94MMK4uNSbaQr8swRC3BkLF3bjbsEL7H6Sn">
    <meta name="viewport" content="width=device-width" />
    <meta name="locale" content="en" />
   <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css" />

</head>
<body>
   <!-- component -->
   <div class="relative flex min-h-screen text-gray-800 antialiased flex-col justify-center overflow-hidden bg-gray-50 py-6 sm:py-12 bg-cover"
   style="background-image: url('{{ $bg_image }}') ">
       <div class="relative py-3 sm:w-96 mx-auto text-center">
           <span class="text-2xl font-light ">Login to your account</span>
           <div class="mt-4 bg-white shadow-md rounded-lg text-left">

               <div class="px-8 py-6 ">
                   <label class="block font-semibold"> Username or Email </label>
                   <input type="text" placeholder="Email" class="border w-full h-5 px-3 py-5 mt-2 hover:outline-none focus:outline-none focus:ring-indigo-500 focus:ring-1 rounded-md">
                   <label class="block mt-3 font-semibold"> Username or Email </label>
                   <input type="password" placeholder="Password" class="border w-full h-5 px-3 py-5 mt-2 hover:outline-none focus:outline-none focus:ring-indigo-500 focus:ring-1 rounded-md">
                   <div class="flex justify-between items-baseline">
                       <button type="submit" class="mt-4 bg-purple-500 text-white py-2 px-6 rounded-md hover:bg-purple-600 ">Unlock</button>
                       <a href="#" class="text-sm hover:underline">Logout</a>
                   </div>
               </div>

           </div>
       </div>

</body>
</html>

