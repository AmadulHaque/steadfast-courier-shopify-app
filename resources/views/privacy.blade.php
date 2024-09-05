<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background: rgb(226, 226, 226)">
    <div class="max-w-5xl m-auto p-4">
        <div class="bg-white rounded-lg shadow-xl p-4">
            <h1 class="font-semibold text-xl mb-4">Privacy policy</h1>
            <p class="mb-4">At {{env('APP_NAME')}}, we respect your privacy and are committed to protecting your personal information. This Privacy Policy outlines how we collect, use, and safeguard your data when you use our Shopify app.</p>
            <ul>
                <li class="mb-4">
                    <span class="font-semibold">Information We Collect:</span>
                    <p>
                        When you use our app, we may collect certain information such as your name, email address, billing information, and Shopify store data.
                    </p>
                </li>
                <li class="mb-4">
                    <span class="font-semibold">How We Use Your Information:</span>
                    <p>
                        We use the information we collect to provide and improve our services, communicate with you, process transactions, and comply with legal obligations.
                    </p>
                </li>
                <li class="mb-4">
                    <span class="font-semibold">Data Sharing:</span>
                    <p>
                        We do not sell, trade, or otherwise transfer your personal information to third parties. However, we may share your data with trusted third-party service providers who assist us in operating our app and serving you.
                    </p>
                </li>
                <li class="mb-4">
                    <span class="font-semibold">Data Security:</span>
                    <p>
                        We implement security measures to protect your personal information from unauthorized access, alteration, disclosure, or destruction.
                    </p>
                </li>
                <li class="mb-4">
                    <span class="font-semibold">Changes to This Policy:</span>
                    <p>
                        We may update this Privacy Policy from time to time. Any changes will be effective immediately upon posting the revised policy on this page.
                    </p>
                </li>
                <li>
                    <span class="font-semibold">Contact Us:</span>
                    <p>
                        If you have any questions or concerns about our Privacy Policy or the use of your personal information, please contact us.
                    </p>
                </li>
            </ul>
        </div>
    </div>
</body>
</html>