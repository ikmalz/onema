<!DOCTYPE html>
<html lang="{{ session('locale', 'en') }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@lang('messages.settings')</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" href="../asset/foto/logoonema.png" type="image/png">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            transition: background-color 0.3s;
        }

        body.light {
            background: linear-gradient(135deg, #f9f9f9, #eaeaea);
            color: #333;
        }

        body.dark {
            background: linear-gradient(135deg, #2c2c2c, #1a1a1a);
            color: #f5f5f5;
        }

        .settings-container {
            max-width: 100%;
            width: 90%;
            margin: 30px auto;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            text-align: left;
            backdrop-filter: blur(15px);
            color: inherit;
        }


        .back-icon {
            display: inline-flex;
            align-items: center;
            font-size: 18px;
            color: inherit;
            cursor: pointer;
            text-decoration: none;
            margin-bottom: 30px;
            transition: color 0.3s ease;
        }

        .back-icon i {
            font-size: 26px;
            margin-right: 8px;
        }

        .back-icon:hover {
            color: red;
        }

        h1,
        h2 {
            font-weight: 600;
            color: inherit;
            margin: 10px 0;
        }

        h1 {
            font-size: 1.8em;
        }

        label {
            font-size: 16px;
            margin: 10px;
            cursor: pointer;
        }

        input[type="radio"] {
            margin-right: 8px;
            transform: scale(1.2);
        }

        button {
            padding: 12px 24px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            background-color: red;
            color: #fff;
            border-radius: 8px;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            margin-top: 20px;
            width: 100%;
            max-width: 200px;
        }

        button:hover {
            background-color: pink;
            transform: translateY(-2px);
        }

        button:active {
            transform: translateY(0);
        }

        @media (max-width: 600px) {
            .settings-container {
                padding: 20px;
            }

            h1 {
                font-size: 1.5em;
            }
        }
    </style>
</head>

<body class="{{ session('theme', 'light') }}">
    <div class="settings-container">
        <a onclick="goBack()" class="back-icon">
            <i class='bx bx-arrow-back'></i> <span id="back-text">@lang('messages.back')</span>
        </a>

        <h1 id="settings-title">@lang('messages.settings')</h1>

        <div>
            <h2 id="theme-title">@lang('messages.theme')</h2>
            <label>
                <input type="radio" name="theme" value="light" {{ session('theme') == 'light' ? 'checked' : '' }} onclick="applyTheme('light')">
                <span id="light-text">@lang('messages.light')</span>
            </label>
            <label>
                <input type="radio" name="theme" value="dark" {{ session('theme') == 'dark' ? 'checked' : '' }} onclick="applyTheme('dark')">
                <span id="dark-text">@lang('messages.dark')</span>
            </label>
        </div>

        <div>
            <h2 id="language-title">@lang('messages.languange')</h2>
            <label>
                <input type="radio" name="language" value="en" {{ session('locale') == 'en' ? 'checked' : '' }} onclick="changeLanguage('en')">
                <span id="english-text">@lang('messages.english')</span>
            </label>
            <label>
                <input type="radio" name="language" value="id" {{ session('locale') == 'id' ? 'checked' : '' }} onclick="changeLanguage('id')">
                <span id="indonesia-text">indonesia</span>
            </label>
        </div>

        <button onclick="saveSettings()">Save</button>
    </div>

    <script>
        const translations = {
            en: {
                settings: "Settings",
                theme: "Theme",
                light: "Light",
                dark: "Dark",
                language: "Language",
                english: "English",
                indonesia: "Indonesian",
                back: "Back"
            },
            id: {
                settings: "Pengaturan",
                theme: "Tema",
                light: "Terang",
                dark: "Gelap",
                language: "Bahasa",
                english: "Inggris",
                indonesia: "Indonesia",
                back: "Kembali"
            }
        };

        function applyTheme(theme) {
            document.body.className = theme;
        }

        function goBack() {
            window.history.back();
            setTimeout(() => {
                location.reload();
            }, 500);
        }

        function changeLanguage(lang) {
            document.getElementById("settings-title").innerText = translations[lang].settings;
            document.getElementById("theme-title").innerText = translations[lang].theme;
            document.getElementById("light-text").innerText = translations[lang].light;
            document.getElementById("dark-text").innerText = translations[lang].dark;
            document.getElementById("language-title").innerText = translations[lang].language;
            document.getElementById("english-text").innerText = translations[lang].english;
            document.getElementById("indonesia-text").innerText = translations[lang].indonesia;
            document.getElementById("back-text").innerText = translations[lang].back;
        }

        function saveSettings() {
            const selectedTheme = document.querySelector('input[name="theme"]:checked').value;
            const selectedLanguage = document.querySelector('input[name="language"]:checked').value;

            localStorage.setItem('theme', selectedTheme);

            fetch("{{ route('settings.save') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        theme: selectedTheme,
                        language: selectedLanguage
                    })
                })
                .then(response => {
                    if (response.ok) {
                        window.location.href = "{{ route('homepage') }}";
                    } else {
                        console.error('Failed to save settings:', response);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>
</body>

</html>